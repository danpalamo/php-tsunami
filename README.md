# php-tsunami
## PHP scripts for SNMP monitoring of subscriber access network, RRDtool storage

Original code written by Alan Horne circa 2007. Various edits / changes / templates / rewrites prior to github project by Jerimiah Cole, Josh Bettigole, Dan Parrish.

tsunami is a set of PHP scripts to poll SNMP-enabled hosts for arbitrary data, store said data, and display data in html. tsunami does not require MIBs to be installed on the polling host. tsunami templates are flexible and can be customized to query, monitor, and graph any subset of data available via SNMP.

Originally written for wireless access point polling (specifically Trango M900 and Alvarion BreezeCom), tsunami can be adapted to any SNMP application for gathering and displaying data. As of March 2017, the following platforms are templated:

* Cambium ePMP
* Cambium PMP-100 (former Motorola Canopy)(FSK)
* Cambium PMP-450 (requires release 14 or higher)
* Mikrotik NetMetal5 (RB922)(issue with SU_COUNT data type, bug opened with Mikrotik)
* Mimosa A5 (requires firmware 2.3.0 or higher)
* Trango M900
* Trango M2400 (same as M900, I believe)
* Ubiquiti AirMax M-series
* Ubiquiti Airmax AC-series

## Definitions:

* query: a snmp query for data that generally is not graphable or is otherwise not interesting enough to graph. Examples would include firmware versions or any other non-number string

* monitor: a snmp query that returns a number, which can be stored in a .rrd file and graphed

* graph: a png display of data retrieved from a .rrd file

## Additional Notes:

* php-tsunami will assume it's being hosted at a FQDN, nested web path structures may require local changes not supported in the main branch

* starting with version 1.4.0, php-tsunami will attempt to get sysUptime (.1.3.6.1.2.1.1.3.0) on any host before performing any other snmp queries. In the event this initial query fails, the host will be skipped for further snmp queries.
###
