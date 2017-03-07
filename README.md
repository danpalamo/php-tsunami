# php-tsunami
PHP scripts for SNMP monitoring of subscriber access network, RRDtool storage

Original code written by Alan Horne circa 2007. Various edits / changes / templates / rewrites prior to github project by Jerimiah Cole, Josh Bettigole, Dan Parrish.

tsunami is a set of PHP scripts to poll SNMP-enabled hosts for arbitrary data, store said data, and display data in html. tsunami does not require MIBs to be installed on the polling host. tsunami templates are flexible and can be customized to query, monitor, and graph any subset of data available via SNMP.

Originally written for wireless access point polling (specifically Trango M900 and Alvarion BreezeCom), tsunami can be adapted to any SNMP application for gathering and displaying data.

Definitions:
  query: a snmp query for data that generally is not graphable or is otherwise not interesting enough to graph. Examples would include firmware versions or any other non-number string
  monitor: a snmp query that returns a number, which can be stored in a .rrd file and graphed
  graph: a png display of data retrieved from a .rrd file
    
