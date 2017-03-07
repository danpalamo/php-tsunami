#!/usr/bin/php

<?php

include 'include/tsunami_common.php';
include 'config/tsunami_config.php';

//parse the hosts configuration
include 'include/tsunami_host_parser.php';

//parse the collector output
include 'include/tsunami_collected_parser.php';

//if there are command line arguments, process them
if($argc > 1)
	$searchHost = $argv[1];		//use $argv[1] as host ID	

if($argc > 2)
{
	if($argv[2] == "all" or $argv[2] == "none")
		$searchSubhost = $argv[2];
	else
		$searchSubhost = sprintf("%03d", $argv[2]);	//use $argv[2] as subhost ID
}

//ignore other args

echo date("Ymd H:i:s")." Starting graphs build.\n";

//make the graphs directory if it does not exist
if(!file_exists($pathWWW.$wwwPathGraphs))
{
	echo date("Ymd H:i:s")." Creating directory \"$pathWWW$wwwPathGraphs\"\n";
	mkdir($pathWWW.$pathWWWGraphs);
}

foreach($aHosts as $host)
{
	if(isset($searchHost) and $searchHost != "all" and $host->m_id != $searchHost)
		continue;

	$pathHostGraphs = $pathWWW.$wwwPathGraphs.$host->m_id."/";

	//if there is no host graph directory, make it
	if(!file_exists($pathHostGraphs))
	{
		echo date("Ymd H:i:s")." Creating directory \"$pathHostGraphs\"\n";
		mkdir($pathHostGraphs);
	}

	if(!isset($searchSubhost) or $searchSubhost == "all" or $searchSubhost == "none")
	{
		//for each nonwalk graph, create the graph
		foreach($host->m_graphs as $graph)
		{
			foreach($aGraphTimeframes as $timeframe)
			{
				//set graph variables
				$filenameRRD	= $pathRRD.$host->m_id."/".$host->m_id.".rrd";
				$filenamePNG	= $pathHostGraphs.$host->m_id."-".$graph->m_name."-".$timeframe->m_desc.".png";
				$title			= $graph->m_title." - ".$timeframe->m_desc." - ".$host->m_id;
				$timeStart		= $timeframe->m_timeStart;
				$timeEnd		= $timeframe->m_timeEnd;
				$height			= 60;
				$width			= 400;

				echo date("Ymd H:i:s")." Creating graph \"$filenamePNG\"\n";
				eval("\$cmdLine = \"".addslashes($graph->m_cmdLine)."\";");
				if(isset($graph->m_args))
					$cmdLine .= " ".$graph->m_args;
				$cmdLine .= " --color BACK#00000000 --color CANVAS#ffffff --color ARROW#00000000 --color SHADEA#00000000 --color SHADEB#00000000";
				`$cmdLine`;

				if(isset($graph->m_bPreview))
				{
					$filenamePNG	= $pathHostGraphs.$host->m_id."-".$graph->m_name."-".$timeframe->m_desc."-preview.png";
					$height			= 30;
					$width			= 150;
					eval("\$cmdLine = \"".addslashes($graph->m_cmdLine)."\";");

					//change command line to create thumbnail
					$cmdLine .= " --title=\"\" --vertical-label=\"\" --color BACK#00000000 --color CANVAS#ffffff --color ARROW#00000000 --color SHADEA#00000000 --color SHADEB#00000000 --no-legend";
					echo date("Ymd H:i:s")." Creating graph \"$filenamePNG\"\n";
					`$cmdLine`;
				}
			}
		}
	}

	foreach($aCollectedHosts[$host->m_id]->m_subhosts as $subhost)
	{
		if(isset($searchSubhost) and $searchSubhost != "all" and $subhost != $searchSubhost)
			continue;
			
		$pathSubhostGraphs = $pathHostGraphs.$subhost."/";
		if(!file_exists($pathSubhostGraphs))
		{
			echo date("Ymd H:i:s")." Creating directory \"$pathSubhostGraphs\"\n";
			mkdir($pathSubhostGraphs);
		}

		foreach($host->m_graphsWalk as $graph)
		{
			foreach($aGraphTimeframes as $timeframe)
			{
				//set graph variables
				$filenameRRD	= $pathRRD.$host->m_id."/".$host->m_id."-".$subhost.".rrd";
				$filenamePNG	= $pathSubhostGraphs.$host->m_id."-".$subhost."-".$graph->m_name."-".$timeframe->m_desc.".png";
				$title		= $graph->m_title." - ".$timeframe->m_desc." - ".$host->m_id."-".$subhost;
				$timeStart	= $timeframe->m_timeStart;
				$timeEnd	= $timeframe->m_timeEnd;
				$height		= 60;
				$width		= 400;
				
				echo date("Ymd H:i:s")." Creating graph \"$filenamePNG\"\n";
				eval("\$cmdLine = \"".addslashes($graph->m_cmdLine)."\";");
				$cmdLine .= " --color BACK#00000000 --color CANVAS#ffffff --color ARROW#00000000 --color SHADEA#00000000 --color SHADEB#00000000";
				`$cmdLine`;

				if(isset($graph->m_bPreview))
				{
					$filenamePNG	= $pathSubhostGraphs.$host->m_id."-".$subhost."-".$graph->m_name."-".$timeframe->m_desc."-preview.png";
					$height			= 30;
					$width			= 150;
					eval("\$cmdLine = \"".addslashes($graph->m_cmdLine)."\";");

					//change command line to create thumbnail
					$cmdLine .= " --title=\"\" --vertical-label=\"\" --color BACK#00000000 --color CANVAS#ffffff --color ARROW#00000000 --color SHADEA#00000000 --color SHADEB#00000000 --no-legend";
					echo date("Ymd H:i:s")." Creating graph \"$filenamePNG\"\n";
					$cmdLine .= " --color BACK#00000000 --color CANVAS#ffffff --color ARROW#00000000 --color SHADEA#00000000 --color SHADEB#00000000";
					`$cmdLine`;
				}
			}
		}
	}
}

echo date("Ymd H:i:s")." Done building graphs.\n";

?>
