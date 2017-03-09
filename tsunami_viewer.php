#!/usr/bin/php

<?php

include 'include/tsunami_common.php';
include 'config/tsunami_config.php';

//parse the hosts configuration
include 'include/tsunami_host_parser.php';

//parse the collector output
include 'include/tsunami_collected_parser.php';

echo date("Ymd H:i:s")." Starting viewer build.\n";

////////////////
//viewer functions

function insertTimeframes()
{
	global $aGraphTimeframes;

	$timeframe = $aGraphTimeframes[0];	
	echo '<a href="//<?php echo $_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"]; ?>?timeframe='.$timeframe->m_desc.'">'.$timeframe->m_desc.'</a>';
	for($timeframeIter = 1; $timeframeIter < count($aGraphTimeframes); $timeframeIter++)
	{
		$timeframe = $aGraphTimeframes[$timeframeIter];
		echo ' | <a href="//<?php echo $_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"]; ?>?timeframe='.$timeframe->m_desc.'">'.$timeframe->m_desc.'</a>';
	}
}

function insertHostGraph($host, $graphID, $preview = false)
{
	global $wwwHostname;
	global $wwwPathGraphs;

	foreach($host->m_graphs as $graph)
	{
		if($graph->m_name == $graphID)
		{
			$URLGraph = "//".$wwwHostname.$wwwPathGraphs.$host->m_id."/".$host->m_id."-".$graph->m_name."-"."<?php echo \$timeframe; ?>";
			if($preview)
				$URLGraph .= "-preview.png";
			else
				$URLGraph .= ".png";
			echo '<img src="'.$URLGraph.'">';
		}
	}
}

function insertSubhostGraph($host, $subhost, $graphID, $preview = false)
{
	global $wwwHostname;
	global $wwwPathGraphs;

	foreach($host->m_graphsWalk as $graph)
	{
		if($graph->m_name == $graphID)
		{
			if($preview)
			  $URLGraph = "//".$wwwHostname.$wwwPathGraphs.$host->m_id."/".$subhost."/".$host->m_id."-".$subhost."-".$graph->m_name."-"."<?php echo \$timeframe; ?>" . "-preview.png";
			else   // realtime
				$URLGraph .= "//".$wwwHostname."/makeGraph.php?id=".$host->m_id."-".$subhost."-".$graph->m_name."-"."<?php echo \$timeframe; ?>";
			echo '<img src="'.$URLGraph.'">';
		}
	}
}

function insertHostQuery($host, $queryID)
{
	foreach($host->m_queries as $query)
	{
		if($query->m_id == $queryID)
		{
			echo '<?php echo CleanSNMPResult(snmp2_get("'.$host->m_host.'", "'.$host->m_community.'", "'.$query->m_oid.'")); ?>';
			break;
		}
	}
}

function insertSubhostQuery($host, $subhost, $queryID)
{
	foreach($host->m_queriesWalk as $query)
	{
		if($query->m_id == $queryID)
		{
			if($queryID == "ASSOCIATION")
				echo '<?php 
					$result = ReadableAssociation(CleanSNMPResult(snmp2_get("'.$host->m_host.'", "'.$host->m_community.'", "'.$query->m_oid.".".(int)$subhost.'")));
					if($result == "Unassociated")
						$result = "<span class=\"span_warning\">".$result."</span>";
					echo $result; ?>';
			else if($queryID == "DISTANCE")
				echo '<?php echo ReadableDistance(CleanSNMPResult(snmp2_get("'.$host->m_host.'", "'.$host->m_community.'", "'.$query->m_oid.".".(int)$subhost.'"))); ?>';
			else if(preg_match("/MIR/", $queryID) or preg_match("/CIR/", $queryID))
				echo '<?php 
					$result = CleanSNMPResult(snmp2_get("'.$host->m_host.'", "'.$host->m_community.'", "'.$query->m_oid.".".(int)$subhost.'"));
					if($result <= 32)
						$result = "<blink class=\"blink_warning\">".$result."</blink>";
					echo $result; ?>';
			else
				echo '<?php echo CleanSNMPResult(snmp2_get("'.$host->m_host.'", "'.$host->m_community.'", "'.$query->m_oid.".".(int)$subhost.'")); ?>';
			break;
		}
	}
}

$config = array(
	'hostname'=>$wwwHostname,
	'graphs'=>$wwwPathGraphs
);
$conf = "<?php\n";
foreach($config as $var=>$val)
	$conf .= '$' . $var . ' = "' . $val . '";' . "\n";
$conf .= "?>";

////////////////
//generate tsunami index

//create "back" link
$back = '//'.$wwwHostname;

//create host preview table rows
$content = "";
$cache = "";
foreach($aHosts as $host)
{
	$content .= '<?php $host="' . $host->m_id . '"; ?>' . "\n";
	$content .= '<?php openCache("' . $pathWWW . $wwwPathCache . $host->m_id . ".json" . '"); ?>' . "\n";
	$content .= file_get_contents($pathTemplates.$host->m_templateHostPreview);
}

//insert table rows into the host preview page template
ob_start();
eval('?>'.file_get_contents($pathTemplates."mainIndex.php"));
$pageContent = ob_get_clean();
$pageTitle = "tsunami";

//insert the host preview page template into the main template
ob_start();
eval('?>'.file_get_contents($fileWWWTemplate));
$indexTemplate = ob_get_clean();

//write the file out, adding the SNMP result processing functions
$fileIndex = $pathWWW."index.php";
echo date("Ymd H:i:s")." Creating file \"$fileIndex\"\n";
$fhIndex = fopen($fileIndex, "w");
fwrite($fhIndex, file_get_contents($pathWeb.'cache.php'));
fwrite($fhIndex, $conf);
fwrite($fhIndex, $indexTemplate);
fclose($fhIndex);

////////////////
//generate host indices

//for each page
foreach($aHosts as $host)
{
	//create "back" link
	$back = '//'.$wwwHostname;	

	//create subhost preview table rows
	$content = "";

		foreach($aCollectedHosts[$host->m_id]->m_subhosts as $subhost)
		{
			$content .= '<?php $subhost="' . $subhost . '"; ?>' . "\n";
			$content .= file_get_contents($pathTemplates.$host->m_templateSubhostPreview);
		}

	//insert subhost preview table rows into subhost preview template
	$pageContent = file_get_contents($pathTemplates.$host->m_templateHostPage);
	$pageContent = str_replace('{content}', $content, $pageContent);
	$pageTitle = "tsunami | " .$host->m_id;

	//insert subhost preview template into the main template
	ob_start();
	eval('?>'.file_get_contents($fileWWWTemplate));
	$indexTemplate = ob_get_clean();

	//make sure the host's directory exists
	$pathHostPage = $pathWWW.$host->m_id."/";
	if(!file_exists($pathHostPage))
	{
		mkdir($pathHostPage);
	}

	//write the file out
	$fileIndex = $pathWWW.$host->m_id."/index.php";
	echo date("Ymd H:i:s")." Creating file \"$fileIndex\"\n";
	$fhIndex = fopen($fileIndex, "w");
	fwrite($fhIndex, file_get_contents($pathWeb.'cache.php'));
	fwrite($fhIndex, '<?php $host="' . $host->m_id . '"; ?>' . "\n");
	fwrite($fhIndex, '<?php openCache("' . $pathWWW . $wwwPathCache . $host->m_id . ".json" . '"); ?>' . "\n");
	fwrite($fhIndex, $conf);
	fwrite($fhIndex, $indexTemplate);
	fclose($fhIndex);
}

////////////////
//generate subhost indices

//for each page
foreach($aHosts as $host)
{
	foreach($aCollectedHosts[$host->m_id]->m_subhosts as $subhost)
	{
		//create "back" link
		$back = '//'.$wwwHostname.$host->m_id;	

		//create subhost page content
		$pageContent = file_get_contents($pathTemplates.$host->m_templateSubhostPage);
		$pageTitle = "tsunami | " .$host->m_id. " | ".$subhost;

		//insert subhost preview template into the main template
		ob_start();
		eval('?>'.file_get_contents($fileWWWTemplate));
		$indexTemplate = ob_get_clean();

		//make sure the host's directory exists
		$pathHostPage = $pathWWW.$host->m_id."/".$subhost."/";
		if(!file_exists($pathHostPage))
		{
			mkdir($pathHostPage);
		}

		//write the file out
		$fileIndex = $pathWWW.$host->m_id."/".$subhost."/index.php";
		echo date("Ymd H:i:s")." Creating file \"$fileIndex\"\n";
		$fhIndex = fopen($fileIndex, "w");
		fwrite($fhIndex, file_get_contents($pathWeb.'cache.php'));
		fwrite($fhIndex, '<?php $host="' . $host->m_id . '"; ?>' . "\n");
		fwrite($fhIndex, '<?php $subhost="' . $subhost . '"; ?>' . "\n");
		fwrite($fhIndex, '<?php openCache("' . $pathWWW . $wwwPathCache . $host->m_id . ".json" . '"); ?>' . "\n");
		fwrite($fhIndex, $conf);
		fwrite($fhIndex, $indexTemplate);
		fclose($fhIndex);
	}
}

echo date("Ymd H:i:s")." Done building viewer.\n";


?>
