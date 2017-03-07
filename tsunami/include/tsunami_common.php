<?php

////////////////
//set error reporting
//error_reporting(E_ALL);
error_reporting(0);
ini_set(0);

////////////////
//classes

//host class - holds its ID and description (plus data copied from its profile)
class Host
{
	var $m_desc;                    //verbose description
	var $m_id;                      //filename-friendly ID
	var $m_community;				//SNMP read community
	var $m_host;                    //host address

	//copied from profile:
	var $m_snmpversion;				//SNMP version accepted by host
	var $m_monitors = array();      //non-walkable monitors for this host
	var $m_monitorsWalk = array();  //walkable monitors for this host
	var $m_graphs = array();		//array of graphs for this host
	var $m_graphsWalk = array();	//array of walkable graphs for this host
	var $m_queries = array();		//queries for this profile
	var $m_queriesWalk = array();	//walkable queries for this profile

	var $m_templateHostPreview;		//template for a host's div
	var $m_templateSubhostPreview;	//template for a subhost's div
	var $m_templateHostPage;		//template for the host's page
	var $m_templateSubhostPage;		//template for a subhost's page

	//NOTE: if a host has walkable OIDs defined, the first walkable OID results will serve 
	//as the IDs for its "subhosts" (and not recorded as data in the rrd.)
}

//host profile class - holds set of monitors, graphs, and queries
class HostProfile
{
	var $m_name;					//profile name
	var $m_snmpversion;				//SNMP version accepted by host
	var $m_monitors = array();		//non-walkable monitors for this profile
	var $m_monitorsWalk = array();	//walkable monitors for this profile
	var $m_graphs = array();		//graphs for this profile
	var $m_graphsWalk = array();	//walkable graphs for this profile
	var $m_queries = array();		//queries for this profile
	var $m_queriesWalk = array();	//walkable queries for this profile
	
	var $m_templateHostPreview;		//template for a host's div
	var $m_templateSubhostPreview;	//template for a subhost's div
	var $m_templateHostPage;		//template for the host's page
	var $m_templateSubhostPage;		//template for a subhost's page
}

//monitor class - holds information for an OID
class Monitor
{
	var $m_desc;					//verbose description
	var $m_id;						//rrd-friendly ID
	var $m_oid;						//OID
	var $m_result;					//place to hold result(s) from SNMP query
}

//graph class - holds a graph's ID and description (plus data copied from its profile)
class Graph
{
	var $m_title;					//title for the graph
	var $m_args;
	var $m_bPreview;				//whether to generate a thumbnail for this graph

	//copied from profile:
	var $m_name;					//filename-friendly ID
	var $m_desc;					//verbose description
	var $m_cmdLine;					//command line to run to generate this graph
}

//graph profile class - holds all the information needed to create a graph with rrdtool
class GraphProfile
{
	var $m_name;					//filename-friendly profile name
	var $m_desc;					//verbose description of graph profile
	var $m_cmdLine;					//command line to run to generate this graph
}

//collected host - holds all of the subhosts collected on last update for a given host
class CollectedHost
{
	var $m_id;						//host ID (to find it in the hosts config)
	var $m_subhosts = array();		//subhosts reached on last poll
}

class GraphTimeframe
{
	function GraphTimeframe($desc, $timeStart, $timeEnd)
	{
		$this->m_desc = $desc;
		$this->m_timeStart = $timeStart;
		$this->m_timeEnd = $timeEnd;
	}

	var $m_desc;
	var $m_timeStart;
	var $m_timeEnd;
}

?>
