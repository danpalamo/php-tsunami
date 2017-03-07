<?php

include '/usr/local/tsunami/include/tsunami_common.php';
include '/usr/local/tsunami/config/tsunami_config.php';

//parse the hosts configuration
include '/usr/local/tsunami/include/tsunami_host_parser.php';

//parse the collector output
include '/usr/local/tsunami/include/tsunami_collected_parser.php';

$id = $_GET['id'];

preg_match("/^(.+)-(.+)-(.+)-(.+)$/",$id,$m);

$host= $m[1];
$subHost= $m[2];
$graphName= $m[3];
$timePeriod= $m[4];


foreach ($aHosts as $h) {
  if ($h->m_id != $host)
    continue;


  foreach ($aCollectedHosts[$h->m_id]->m_subhosts as $s) {
    if($s != $subHost)
      continue;


    foreach ($h->m_graphsWalk as $g) {
      if ($g->m_name != $graphName)
        continue;

      foreach ($aGraphTimeframes as $t) {
        if ($t->m_desc != $timePeriod)
          continue;

        // make graph
        $filenameRRD    = "/usr/local/tsunami/rrd/" . $h->m_id . "/" . $h->m_id . "-" . $s . ".rrd";
        $filenamePNG    =  "-";
        $title = $g->m_title." - ".$t->m_desc." - ".$h->m_id."-".$s;
        $timeStart      = $t->m_timeStart;
        $timeEnd        = $t->m_timeEnd;
        $height         = 60;
        $width          = 400;


        eval("\$cmdLine = \"".addslashes($g->m_cmdLine)."\";");
        $cmdLine .= " --color BACK#00000000 --color CANVAS#ffffff --color ARROW#00000000 --color SHADEA#00000000 --color SHADEB#00000000";

        header("Content-Type:  image/png");
        echo `$cmdLine`;

        exit;
      }
    }
  }
}

?>
