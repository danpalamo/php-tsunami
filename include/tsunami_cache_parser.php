<?php

////////////////
//XML parser functions - parse the configuration files and populates the profiles/hosts/monitors arrays

$bHostProfilesIsOpen	= false;	//whether a host profile open tag has been encountered
$bWalkIsOpen		= false;	//whether a walk open tag has been encountered

$aHosts			= array();	//array of hosts to be monitored
$aHostProfiles		= array();	//array of host profiles
$aGraphProfiles		= array();	//array of graph profiles

function XMLOpenElement($parser, $name, $attrs)
{
	global $bHostProfileIsOpen;
	global $bWalkIsOpen;

	global $aHosts;
	global $aHostProfiles;
	global $aGraphProfiles;

	//graph profile config

	//if we find a graph profile open tag, make a new graph profile
	if(!strcasecmp($name, 'GRAPHPROFILE'))
	{
		$newGraphProfile = new GraphProfile();
		$newGraphProfile->m_name = $attrs['NAME'];
		$newGraphProfile->m_desc = $attrs['DESC'];
		$newGraphProfile->m_cmdLine = $attrs['CMDLINE'];
		$aGraphProfiles[] = $newGraphProfile;
		return;
	}

	//host profile config

	//if we find a host profile open tag, make a new host profile
	if(!strcasecmp($name, 'HOSTPROFILE') && !$bHostProfileIsOpen)
	{
		$bHostProfileIsOpen = true;

		$newHostProfile = new HostProfile();
		$newHostProfile->m_name = $attrs['NAME'];
		$newHostProfile->m_snmpversion = (array_key_exists('SNMPVERSION', $attrs) && trim($attrs['SNMPVERSION']) != "") ? $attrs['SNMPVERSION'] : 2;
		$aHostProfiles[] = $newHostProfile;
		return;
	}

	//found a walk open tag
	if(!strcasecmp($name, 'WALK') && $bHostProfileIsOpen)
	{
		$bWalkIsOpen = true;
	}

	//found a monitor
	if(!strcasecmp($name, 'MONITOR') && $bHostProfileIsOpen)
	{
		//create the new monitor
		$newMonitor = new Monitor();
		$newMonitor->m_desc = $attrs['DESC'];
		$newMonitor->m_id = $attrs['ID'];
		$newMonitor->m_oid = $attrs['OID'];

		if(!$bWalkIsOpen)
		{
			$aHostProfiles[count($aHostProfiles) - 1]->m_monitors[] = $newMonitor;
			$aHostProfiles[count($aHostProfiles) - 1]->m_queries[] = $newMonitor;
		}
		else
		{
			$aHostProfiles[count($aHostProfiles) - 1]->m_monitorsWalk[] = $newMonitor;
			$aHostProfiles[count($aHostProfiles) - 1]->m_queriesWalk[] = $newMonitor;
		}

		return;
	}

	//found a graph
	if(!strcasecmp($name, 'GRAPH') && $bHostProfileIsOpen)
	{
		//create the new graph
		$newGraph = new Graph();
		$newGraph->m_title = $attrs['TITLE'];
		if(isset($attrs['ARGS']))
			$newGraph->m_args = $attrs['ARGS'];
		if(isset($attrs['PREVIEW']))
			$newGraph->m_bPreview = $attrs['PREVIEW'];
		$profileName = $attrs['PROFILE'];

		//if the graph has a profile name, try to find the profile and copy its data over.
		if($profileName != "")
		{
			$profileFound = false;
			foreach($aGraphProfiles as $profile)
			{
				if(!strcasecmp($profileName, $profile->m_name))
				{
					$profileFound = true;

					$newGraph->m_name	= $profile->m_name;
					$newGraph->m_desc	= $profile->m_desc;
					$newGraph->m_cmdLine	= $profile->m_cmdLine;
				}
			}

			if(!$profileFound)
			{
				echo date("Ymd H:i:s")." Error: profile \"".$attrs['PROFILE']."\" for graph \"$newGraph->m_desc\" in host profile \"".$aHostProfiles[count($aHostProfiles) - 1]->m_name."\" not found.\n";
			}
		}

		if(!$bWalkIsOpen)
			$aHostProfiles[count($aHostProfiles) - 1]->m_graphs[] = $newGraph;
		else
			$aHostProfiles[count($aHostProfiles) - 1]->m_graphsWalk[] = $newGraph;

		return;
	}

	//found a query
	if(!strcasecmp($name, 'QUERY') && $bHostProfileIsOpen)
	{
		//create the new monitor
		$newQuery = new Monitor();
		$newQuery->m_desc = $attrs['DESC'];
		$newQuery->m_id = $attrs['ID'];
		$newQuery->m_oid = $attrs['OID'];

		if(!$bWalkIsOpen)
			$aHostProfiles[count($aHostProfiles) - 1]->m_queries[] = $newQuery;
		else
			$aHostProfiles[count($aHostProfiles) - 1]->m_queriesWalk[] = $newQuery;

		return;
	}

	//found a template
	if(!strcasecmp($name, 'TEMPLATE') && $bHostProfileIsOpen)
	{
		switch($attrs['TYPE'])
		{
			case "hostPreview":
				$aHostProfiles[count($aHostProfiles) - 1]->m_templateHostPreview= $attrs['SRC'];
				break;
			case "subhostPreview":
				$aHostProfiles[count($aHostProfiles) - 1]->m_templateSubhostPreview = $attrs['SRC'];
				break;
			case "hostPage":
				$aHostProfiles[count($aHostProfiles) - 1]->m_templateHostPage = $attrs['SRC'];
				break;
			case "subhostPage":
				$aHostProfiles[count($aHostProfiles) - 1]->m_templateSubhostPage = $attrs['SRC'];
				break;
		}
	}

	//host config

	//if we find a host open tag, make a new host
	if(!strcasecmp($name, 'HOST'))
	{
		$newHost = new Host();
		$newHost->m_desc = $attrs['DESC'];
		$newHost->m_id = $attrs['ID'];
		$newHost->m_community = $attrs['COMMUNITY'];
		$newHost->m_host = $attrs['HOST'];
		$profileName = $attrs['PROFILE'];

		//if the host has a profile name, try to find the profile and copy its monitors over.
		if($profileName != "")
		{
			$profileFound = false;
			foreach($aHostProfiles as $profile)
			{
				if(!strcasecmp($profileName, $profile->m_name))
				{
					$profileFound = true;

					$newHost->m_snmpversion = $profile->m_snmpversion;

					foreach($profile->m_monitors as $monitor)
						$newHost->m_monitors[] = clone $monitor;

					foreach($profile->m_monitorsWalk as $monitor)
						$newHost->m_monitorsWalk[] = clone $monitor;

					foreach($profile->m_queries as $query)
						$newHost->m_queries[] = clone $query;

					foreach($profile->m_queriesWalk as $query)
						$newHost->m_queriesWalk[] = clone $query;

					$newHost->m_graphs			= $profile->m_graphs;
					$newHost->m_graphsWalk		= $profile->m_graphsWalk;

					$newHost->m_templateHostPreview		= $profile->m_templateHostPreview;
					$newHost->m_templateSubhostPreview	= $profile->m_templateSubhostPreview;
					$newHost->m_templateHostPage		= $profile->m_templateHostPage;
					$newHost->m_templateSubhostPage		= $profile->m_templateSubhostPage;
				}
			}

			if(!$profileFound)
			{
				echo date("Ymd H:i:s")." Error: profile \"".$attrs['PROFILE']."\" for host \"$newHost->m_desc not found.\"\n";
			}
		}

		$aHosts[] = $newHost;
		return;
	}
}

function XMLCloseElement($parser, $name)
{
	global $bHostProfileIsOpen;
	global $bWalkIsOpen;

	if(!strcasecmp($name, "HOSTPROFILE"))
	{
		$bHostProfileIsOpen = false;
	}

	if(!strcasecmp($name, "WALK"))
	{
		$bWalkIsOpen = false;
	}
}

function XMLCharacterData($parser, $data)
{
	//noop
}

//parse the config files

$xml_parser = xml_parser_create();
xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, true);
xml_set_element_handler($xml_parser, "XMLOpenElement", "XMLCloseElement");
xml_set_character_data_handler($xml_parser, "XMLCharacterData");
if(!xml_parse($xml_parser, file_get_contents($fileGraphProfiles)))
{
	echo date("Ymd H:i:s")." Error: problem parsing XML file \"$fileGraphProfiles\": ".sprintf("%s at line %d\n", xml_error_string(xml_get_error_code($xml_parser)), xml_get_current_line_number($xml_parser));
}
xml_parser_free($xml_parser);

$xml_parser = xml_parser_create();
xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, true);
xml_set_element_handler($xml_parser, "XMLOpenElement", "XMLCloseElement");
xml_set_character_data_handler($xml_parser, "XMLCharacterData");
if(!xml_parse($xml_parser, file_get_contents($fileHostProfiles)))
{
	echo date("Ymd H:i:s")." Error: problem parsing XML file \"$fileHostProfiles\": ".sprintf("%s at line %d\n", xml_error_string(xml_get_error_code($xml_parser)), xml_get_current_line_number($xml_parser));
}
xml_parser_free($xml_parser);

$xml_parser = xml_parser_create();
xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, true);
xml_set_element_handler($xml_parser, "XMLOpenElement", "XMLCloseElement");
xml_set_character_data_handler($xml_parser, "XMLCharacterData");
if(!xml_parse($xml_parser, file_get_contents($fileHosts)))
{
	echo date("Ymd H:i:s")." Error: problem parsing XML file \"$fileHosts\": ".sprintf("%s at line %d\n", xml_error_string(xml_get_error_code($xml_parser)), xml_get_current_line_number($xml_parser));
}
xml_parser_free($xml_parser);

?>
