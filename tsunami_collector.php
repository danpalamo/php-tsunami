#!/usr/bin/php

<?php

//TCI SNMP NETWORK MONITOR (TSNM)

include 'include/tsunami_common.php';
include 'config/tsunami_config.php';

////////////////
//SNMP formatting functions

function ClassifySNMPResult($result)
{
	$ret = "UNKNOWN";

	//Integer / Timetick
	if(preg_match("/^INTEGER/", $result) or preg_match("/^Timeticks/", $result) or preg_match("/^Gauge32/", $result) or preg_match("/^STRING/", $result))
	{
		$ret = "GAUGE";
	}

	//Counter
	else if(preg_match("/^Counter[0-9]*/", $result))
	{
//		$ret = "COUNTER";
		$ret = "DERIVE";
	}

	return $ret;
}

function CleanSNMPSUIDResult($result)
{
	return str_replace(" ", ".", strtolower(CleanMACs(trim($result))));
}

function CleanMACs($result)
{
	$ret = "1";
	if(preg_match("/^Hex-STRING/", $result))
	{
		$ret = strtolower(trim(str_replace("Hex-STRING: ", "", $result)));
		if(
			preg_match("/([0-9a-fA-F][0-9a-fA-F][\. :-]){5}([0-9a-fA-F][0-9a-fA-F])/", $ret)
		)	{
				$ret = str_replace(":", ".", $ret);
				$ret = str_replace("-", ".", $ret);
				$ret = str_replace(" ", ".", $ret);
			}
	}
	elseif(preg_match("/([0-9a-fA-F][0-9a-fA-F][\. :-]){5}([0-9a-fA-F][0-9a-fA-F])/", $result))
	{
		$ret = str_replace(":", ".", $result);
		$ret = str_replace("-", ".", $ret);
		$ret = str_replace(" ", ".", $ret);
	}
	return $ret;
}

function CleanSNMPResult($result)
{
	$ret = "";

	//Integer
	if(preg_match("/^INTEGER/", $result))
	{
		$ret = str_replace("INTEGER: ", "", $result);
	}

	//Counter
	if(preg_match("/^Counter[0-9]*/", $result, $matches))
	{
		$ret = str_replace($matches[0], "", $result);
		preg_match("/[0-9]{1,}/", $ret, $matches);
		$ret = $matches[0];
	}

	//Timetick
	if(preg_match("/^Timeticks/", $result))
	{
		preg_match("/[0-9]{4,}/", $result, $matches);
		$ret = $matches[0];
	}

	//MAC
	if(preg_match("/^Hex-STRING/", $result))
	{
		$ret = strtolower(trim(str_replace("Hex-STRING: ", "", $result)));
		if(
			preg_match("/([0-9a-fA-F][0-9a-fA-F][\. :-]){5}([0-9a-fA-F][0-9a-fA-F])/", $ret)
		)	{
				$ret = str_replace(":", ".", $ret);
				$ret = str_replace("-", ".", $ret);
				$ret = str_replace(" ", ".", $ret);
			}
	}

	//IP
	if(preg_match("/^IpAddress/", $result))
	{
		$ret = str_replace("IpAddress: ", "", $result);
	}

	//STRING
	if(preg_match("/^STRING/", $result))
	{
		$ret = str_replace("STRING: ", "", $result);
		$ret = str_replace("\"", "", $ret);
		$ret = str_replace(":", ".", $ret);
		if(preg_match("/^[0-9]{4}\.[0-9]{2}\.[0-9]{2}\.[0-9]{2}$/", $ret))
		{
			$totimeticks = explode( '.' , $ret);
			$ret = (($totimeticks[0] * 86400) + ($totimeticks[1] * 3600) + ($totimeticks[2] * 60) + $totimeticks[3]);
		}
	}

	//Gauge32
	if(preg_match("/^Gauge32/", $result))
	{
		$ret = str_replace("Gauge32: ", "", $result);
	}
	return $ret;
}

////////////////
//startup

//parse the hosts configuration
include 'include/tsunami_host_parser.php';

echo date("Ymd H:i:s")." Starting SNMP data collection.\n";

if(!file_exists($pathRRD))
{
	echo date("Ymd H:i:s")." Creating directory \"$pathRRD\"\n";
	mkdir($pathRRD);
}

////////////////
//conf files are parsed, now collect data.

foreach($aHosts as $hostKey => $host)
{
	echo 'INFO - ' . $host->m_desc . ': v' . $host->m_snmpversion . "\n";

	$getFunction = $host->m_snmpversion == "1" ? 'snmpget' : 'snmp2_get';
	$walkFunction = $host->m_snmpversion == "1" ? 'snmpwalk' : 'snmp2_walk';

	echo date("Ymd H:i:s")." HOST (" . $getFunction . "): ".$host->m_desc." (".$host->m_id.") - ".$host->m_host."\n";

	if(is_array($host->m_monitors))
	{
		foreach($host->m_monitors as $monitorKey => $monitor)
		{
			echo date("Ymd H:i:s")." \tMONITOR: ".$monitor->m_desc." (".$monitor->m_id.") - ".$monitor->m_oid." ... ";

			$result = $getFunction($host->m_host, $host->m_community, $monitor->m_oid);

			if($result)
			{
				echo "ok ... ";
				$aHosts[$hostKey]->m_monitors[$monitorKey]->m_type = ClassifySNMPResult($result);
				$aHosts[$hostKey]->m_monitors[$monitorKey]->m_result = CleanSNMPResult($result);
				echo "$result\n";
			}
			else
			{
				echo "error!\n";
			}
		}
	}

	if(is_array($host->m_monitorsWalk))
	{
		echo date("Ymd H:i:s")." \tWALK (". $walkFunction . "):\n";
		foreach($host->m_monitorsWalk as $monitorKey => $monitor)
		{
			echo date("Ymd H:i:s")." \t\tMONITOR: ".$monitor->m_desc." (".$monitor->m_id.") - ".$monitor->m_oid." ... ";

			$aHosts[$hostKey]->m_monitorsWalk[$monitorKey]->m_result = $walkFunction($host->m_host, $host->m_community, $monitor->m_oid);

			if($aHosts[$hostKey]->m_monitorsWalk[$monitorKey]->m_result)
			{
				echo "ok, ".count($aHosts[$hostKey]->m_monitorsWalk[$monitorKey]->m_result)." results\n";
				if(is_array($aHosts[$hostKey]->m_monitorsWalk[$monitorKey]->m_result))
				{
					foreach($aHosts[$hostKey]->m_monitorsWalk[$monitorKey]->m_result as $resultKey => $result)
					{
						$aHosts[$hostKey]->m_monitorsWalk[$monitorKey]->m_type = ClassifySNMPResult($result);
						$aHosts[$hostKey]->m_monitorsWalk[$monitorKey]->m_result[$resultKey] = $monitor->m_id == 'SUID' ? CleanSNMPSUIDResult($result) : CleanSNMPResult($result);
					}
				}
				else
				{
					echo date("Ymd H:i:s")." Error: could not walk monitor \"".$aHosts[$hostKey]->m_monitorsWalk[$monitorKey]->m_desc."\" on host \"".$host->m_desc."\".\n";
				}
			}
			else
			{
				echo "error!\n";
			}
		}
		echo "\n";
	}

	if(is_array($host->m_queries))
	{
		foreach($host->m_queries as $queryKey => $query)
		{
			echo date("Ymd H:i:s")." \tQUERY: ".$query->m_desc." (".$query->m_id.") - ".$query->m_oid." ... ";

			$result = $getFunction($host->m_host, $host->m_community, $query->m_oid);

			if($result)
			{
				echo "ok ... ";
				$aHosts[$hostKey]->m_queries[$queryKey]->m_type = ClassifySNMPResult($result);
				$aHosts[$hostKey]->m_queries[$queryKey]->m_result = CleanSNMPResult($result);
				echo "$result\n";
			}
			else
			{
				echo "error!\n";
			}
		}
	}

	if(is_array($host->m_queriesWalk))
	{
		echo date("Ymd H:i:s")." \tWALK (". $walkFunction . "):\n";
		foreach($host->m_queriesWalk as $queryKey => $query)
		{
			echo date("Ymd H:i:s")." \t\tQUERY: ".$query->m_desc." (".$query->m_id.") - ".$query->m_oid." ... ";

			$aHosts[$hostKey]->m_queriesWalk[$queryKey]->m_result = $walkFunction($host->m_host, $host->m_community, $query->m_oid);

			if($aHosts[$hostKey]->m_queriesWalk[$queryKey]->m_result)
			{
				echo "ok, ".count($aHosts[$hostKey]->m_queriesWalk[$queryKey]->m_result)." results\n";
				if(is_array($aHosts[$hostKey]->m_queriesWalk[$queryKey]->m_result))
				{
					foreach($aHosts[$hostKey]->m_queriesWalk[$queryKey]->m_result as $resultKey => $result)
					{
						$aHosts[$hostKey]->m_queriesWalk[$queryKey]->m_type = ClassifySNMPResult($result);
						$aHosts[$hostKey]->m_queriesWalk[$queryKey]->m_result[$resultKey] = CleanSNMPResult($result);
					}
				}
				else
				{
					echo date("Ymd H:i:s")." Error: could not walk query \"".$aHosts[$hostKey]->m_monitorsWalk[$queryKey]->m_desc."\" on host \"".$host->m_desc."\".\n";
				}
			}
			else
			{
				echo "error!\n";
			}
		}
		echo "\n";
	}

}

////////////////
//data is collected, now push it into rrd databases.

//test code to display all host/monitor info
//foreach($aHosts as $host)
//{
//	echo "HOST- ".$host->m_desc." : ".$host->m_id." : ".$host->m_host."\n";
//	foreach($host->m_monitors as $monitor)
//	{
//		echo "\tMONITOR- ".$monitor->m_desc." : ".$monitor->m_id." : ".$monitor->m_oid." : ".$monitor->m_walk."\n";
//		echo $monitor->m_result."\n";
//	}
//
//	foreach($host->m_monitorsWalk as $monitor)
//	{
//		echo "\tMONITOR- ".$monitor->m_desc." : ".$monitor->m_id." : ".$monitor->m_oid."\n";
//		foreach($monitor->m_result as $result)
//		{
//			echo $result." ";
//		}
//
//		echo count($monitor->m_result);
//		echo "\n";
//	}
//
//	foreach($host->m_graphs as $graph)
//	{
//		echo "\tGRAPH- \"".$graph->m_desc."\" : \"".$graph->m_title."\" : \"".$graph->m_cmdLine."\"\n";
//	}
//
//}

//for each host...
foreach($aHosts as $host)
{
	//create the host's subdirectory if it doesn't exist
	$pathHost = $pathRRD.$host->m_id."/";
	if(!file_exists($pathHost))
	{
		echo date("Ymd H:i:s")." Creating directory \"".$pathHost."\"\n";
		mkdir($pathHost);
	}

	//create the host's RRD filename

	$filenameHostRRD = $pathHost.$host->m_id.".rrd";

	//if host has nonwalk oids
	if(count($host->m_monitors) > 0)
	{
		//if its RRD does not exist, create it
		if(!file_exists($filenameHostRRD))
		{
			$cmdLine = "rrdtool create $filenameHostRRD ";

			foreach($host->m_monitors as $monitor)
			{
				if ($monitor->m_type == "DERIVE") {
//					echo "$monitor->m_id matches type DERIVE\n";
					$cmdLine .= "DS:".$monitor->m_id.":".$monitor->m_type.":600:0:U "; //min=0 avoids messy resets-as-counter-wraps
				}
				else {
//					echo "$monitor->m_id is type $monitor->m_type\n";
					$cmdLine .= "DS:".$monitor->m_id.":".$monitor->m_type.":600:U:U ";
				}
			}

			$cmdLine .= "RRA:AVERAGE:0.5:1:576 	\
				RRA:AVERAGE:0.5:6:672 		\
				RRA:AVERAGE:0.5:24:720 		\
				RRA:AVERAGE:0.5:288:730 	\
				RRA:MAX:0.5:1:576 		\
				RRA:MAX:0.5:6:672 		\
				RRA:MAX:0.5:24:720 		\
				RRA:MAX:0.5:288:730";

			echo date("Ymd H:i:s")." Creating tsunami_host file '$filenameHostRRD' with command line '$cmdLine'\n";
			`$cmdLine`;
		}

		//update host's nonwalk oids with polled data

		$cmdLine = "rrdtool updatev $filenameHostRRD N";

		foreach($host->m_monitors as $monitor)
		{
			$cmdLine .= ":$monitor->m_result";
		}

		echo date("Ymd H:i:s")." Updating tsunami_host file: ".$filenameHostRRD."\n";
                echo "Command line:  $cmdLine\n";

		`$cmdLine`; // fix?



		//update host's nonwalk oids with polled data
		/* Broken in this version of PHP rrd
		$rrData = "N";

		foreach($host->m_monitors as $monitor)
		{
			$rrData .= ":$monitor->m_result";
		}

		echo date("Ymd H:i:s")." Updating $filenameHostRRD with $rrData:  ";
		if (!rrd_update($filenameHostRRD,$rrData)) {
		  $err = rrd_error();
                  echo "\t$err\n";
		} else {
		  echo "\tOK\n";
        }
        */
	}
	else
	{
		echo "host $host->m_id has no nonwalk oids.\n";
	}

	//if host has >1 walk oids (first walk oid is used only for naming/id)
	if(count($host->m_monitorsWalk) > 1 && is_array($host->m_monitorsWalk[0]->m_result))
	{
		//for each of the first walked oid results (used as an ID)
		foreach($host->m_monitorsWalk[0]->m_result as $resultKey => $monitorID)
		{
			//make the subhost filename
			//$filenameWalkedRRD = $pathHost.$host->m_id."-".sprintf("%'03d", $monitorID).".rrd";
			$filenameWalkedRRD = $pathHost.$host->m_id."-".CleanSNMPSUIDResult($monitorID).".rrd";

			//if file doesn't exist, make it
			if(!file_exists($filenameWalkedRRD))
			{
				echo date("Ymd H:i:s")." Creating tsunami_subhost file: ".$filenameWalkedRRD."\n";

				$cmdLine = "rrdtool create $filenameWalkedRRD ";

				for($monitorKey = 1; $monitorKey < count($host->m_monitorsWalk); $monitorKey++)
				{
					if ($host->m_monitorsWalk[$monitorKey]->m_type == "DERIVE") {
						$cmdLine .= "DS:".$host->m_monitorsWalk[$monitorKey]->m_id.":".$host->m_monitorsWalk[$monitorKey]->m_type.":600:0:U ";
					}
					else {
					$cmdLine .= "DS:".$host->m_monitorsWalk[$monitorKey]->m_id.":".$host->m_monitorsWalk[$monitorKey]->m_type.":600:U:U ";
					}
				}

				$cmdLine .= "RRA:AVERAGE:0.5:1:576 		\
					RRA:AVERAGE:0.5:6:672 			\
					RRA:AVERAGE:0.5:24:720 			\
					RRA:AVERAGE:0.5:288:730 		\
					RRA:MAX:0.5:1:576 			\
					RRA:MAX:0.5:6:672 			\
					RRA:MAX:0.5:24:720 			\
					RRA:MAX:0.5:288:730";

				`$cmdLine`;
			}

			//update subhost's oids with polled data

			$cmdLine = "rrdtool updatev $filenameWalkedRRD N";

			for($monitorKey = 1; $monitorKey < count($host->m_monitorsWalk); $monitorKey++)
			{
				$cmdLine .= ":".$host->m_monitorsWalk[$monitorKey]->m_result[$resultKey];
			}

			echo date("Ymd H:i:s")." Updating tsunami_subhost file: ".$filenameWalkedRRD."\n";
                        echo "Command line:  $cmdLine\n";
			`$cmdLine`; // fix?


			//update subhost's oids with polled data
			/* Broken in this version of PHP rrd
			$rrData = "N";

			for($monitorKey = 1; $monitorKey < count($host->m_monitorsWalk); $monitorKey++)
			{
				$rrData .= ":".$host->m_monitorsWalk[$monitorKey]->m_result[$resultKey];
			}
			echo date("Ymd H:i:s")." Updating $filenameWalkedRRD with $rrData:  ";
			if (!rrd_update($filenameWalkedRRD,$rrData)) {
		  	  $err = rrd_error();
                  	  echo "\t$err".something."\n";
			} else {
		    	  echo "\tOK\n";
            }
            */
		}
	}
	else
	{
		echo date("Ymd H:i:s")." Error: could not update RRD for host \"$host->m_desc\", it has walkable OIDs that did not return an array.\n";
	}
}

$fhCollected = fopen($fileCollected, "w");

fwrite($fhCollected, "<tsunami>\n");

foreach($aHosts as $host)
{
	$idHost = $host->m_id;

	if(count($host->m_monitorsWalk) > 1 && count($host->m_monitorsWalk[0]->m_result) > 0)
	{
		fwrite($fhCollected, "<host id=\"$idHost\">\n");

		foreach($host->m_monitorsWalk[0]->m_result as $subhost_id)
		{
			#$idSubhost = sprintf("%'03d", $subhost_id);
			$idSubhost = $subhost_id;
			fwrite($fhCollected, "\t<subhost id=\"$idSubhost\"/>\n");
		}

		fwrite($fhCollected, "</host>\n");
	}
	else
	{
		fwrite($fhCollected, "<host id=\"$idHost\" profile=\"$host->m_profile\"/>\n");
	}

	file_put_contents($pathWWW . $wwwPathCache . $idHost . ".json", json_encode($host));
}

fwrite($fhCollected, "</tsunami>\n");

fclose($fhCollected);


echo date("Ymd H:i:s")." Done collecting SNMP data.\n";

?>
