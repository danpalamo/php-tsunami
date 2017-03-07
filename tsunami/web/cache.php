<?php

$host = '';
$subhost = '';
$cache = array();
$hostData = array();
$subhostData = array();

function openCache($path)
{
	global $cache;
	global $host;
	global $hostData;
	global $subhostData;
	$subhostMap = array();
	
	$cache[$host] = (array)json_decode(file_get_contents($path), true);
	$hostData[$host] = array();
	$subhostData[$host] = array();
	
	if(is_array($cache[$host]['m_monitors']))
	{
		foreach($cache[$host]['m_monitors'] as $monitor)
			$hostData[$host][$monitor['m_id']] = $monitor;
	}		
	if(is_array($cache[$host]['m_queries']))
	{
		foreach($cache[$host]['m_queries'] as $query)
			$hostData[$host][$query['m_id']] = $query;
	}
	if(is_array($cache[$host]['m_monitorsWalk']))
	{	
		$subhostMap = $cache[$host]['m_monitorsWalk'][0]['m_result'];
		foreach($subhostMap as $subhost)
		{
			$subhostData[$host][$subhost] = array();
		}
		
		foreach($cache[$host]['m_monitorsWalk'] as $monitorWalk)
			foreach($monitorWalk['m_result'] as $resultIndex => $result)
				$subhostData[$host][$subhostMap[$resultIndex]][$monitorWalk['m_id']] = $result;
		
		foreach($cache[$host]['m_queriesWalk'] as $queriesWalk)
			foreach($queriesWalk['m_result'] as $resultIndex => $result)
				$subhostData[$host][$subhostMap[$resultIndex]][$queriesWalk['m_id']] = $result;
	}	
}

function _host($query = false)
{
	global $host;
	global $cache;
	if($query)
		echo $cache[$host][$query];
	else
		echo $host;
}

function _subhost($query = false)
{
	global $host;
	global $subhost;
	echo $subhost;
}

function __e($query, $subhost=false)
{
	global $host;
	global $subhost;
	global $cache;
	global $hostData;
	global $subhostData;
	if($subhost)
		$data = $subhostData[$host][$subhost][$query];
	else
		$data = $hostData[$host][$query]['m_result'];
	return $data;
}

function _e($query, $subhost=false)
{
	print(__e($query, $subhost));
}

function __g($graphID, $subhost=false, $preview=false)
{
	global $host;
	global $subhost;
	global $cache;
	global $hostname;
	global $graphs;
	global $timeframe;
	
	if($subhost)
	{
		foreach($cache[$host]['m_graphsWalk'] as $graph)
		{
			if($graph['m_name'] == $graphID)
			{
				if($preview)
					$URLGraph = "//" . $hostname . $graphs . $host . "/" . $subhost . "/" . $host . "-" . $subhost . "-" . $graph['m_name'] . "-" . $timeframe . "-preview.png";
				else   // realtime
					$URLGraph = "//" . $hostname . "/makeGraph.php?id=" . $host . "-" . str_replace('-','.',$subhost) . "-" . $graph['m_name'] . "-" . $timeframe;
				return '<img src="' . $URLGraph . '">';
			}
		}
	}
	else
	{
		foreach($cache[$host]['m_graphs'] as $graph)
		{
			if($graph['m_name'] == $graphID)
			{
				$URLGraph = "//" . $hostname . $graphs . $host . "/" . $host . "-" . $graph['m_name'] . "-" . $timeframe;
				if($preview)
					$URLGraph .= "-preview.png";
				else
					$URLGraph .= ".png";
				return '<img src="' . $URLGraph . '">';
			}
		}
	}
}

function _g($graphID, $subhost=false, $preview=false)
{
	print(__g($graphID, $subhost, $preview));
}

?>
