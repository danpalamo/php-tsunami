<?php

////////////////
//XML parser functions - parse the collector output file

$bCollectedHostIsOpen	= false;	//whether a host profile open tag has been encountered
$aCollectedHosts	= array();	//array of hosts to be monitored

function XMLCollectedOpenElement($parser, $name, $attrs)
{
	global $bCollectedHostIsOpen;
	global $aCollectedHosts;

	//collected hosts

	//if we find a collected host open tag, make a new graph profile
	if(!strcasecmp($name, 'HOST'))
	{
		$bCollectedHostIsOpen = $attrs['ID'];

		$newCollectedHost = new CollectedHost();
		$newCollectedHost->m_id = $attrs['ID'];
		$aCollectedHosts[$attrs['ID']] = $newCollectedHost;
		return;
	}

	//if we find a subhost, add it to the open collected host
	if(!strcasecmp($name, 'SUBHOST') && $bCollectedHostIsOpen)
	{
		$aCollectedHosts[$bCollectedHostIsOpen]->m_subhosts[] = $attrs['ID'];
		return;
	}
}

function XMLCollectedCloseElement($parser, $name)
{
	global $bCollectedHostIsOpen;

	if(!strcasecmp($name, "HOST"))
	{
		$bCollectedHostIsOpen = false;
	}
}

function XMLCollectedCharacterData($parser, $data)
{
	//noop
}

//parse the collector output file

$xml_parser = xml_parser_create();
xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, true);
xml_set_element_handler($xml_parser, "XMLCollectedOpenElement", "XMLCollectedCloseElement");
xml_set_character_data_handler($xml_parser, "XMLCollectedCharacterData");
if(!xml_parse($xml_parser, file_get_contents($fileCollected)))
{
	echo date("Ymd H:i:s")." Error: problem parsing XML file \"$fileCollected\": ".sprintf("%s at line %d\n", xml_error_string(xml_get_error_code($xml_parser)), xml_get_current_line_number($xml_parser));
}
xml_parser_free($xml_parser);

?>
