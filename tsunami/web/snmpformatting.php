<?php

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

		//convert to days
		$ret /= 8640000;
		$ret = sprintf("%1.1f", $ret);
	}

	//MAC
	if(preg_match("/^Hex-STRING/", $result))
	{
		$ret = str_replace("Hex-STRING: ", "", $result);
	}
		
	//IP
	if(preg_match("/^IpAddress/", $result))
	{
		$ret = str_replace("IpAddress: ", "", $result);
	}

	//STRING
	if(preg_match("/^STRING/", $result))
	{
		$ret = str_replace("STRING: \"", "", $result);
		$ret = str_replace("\"", "", $ret);
	}

	//Gauge32
	if(preg_match("/^Gauge32/", $result))
	{
		$ret = str_replace("Gauge32: ", "", $result);
	}

	return $ret;
}

function ReadableAssociation($result)
{
	switch($result)
	{
		case 0:
			return "Unassociated";
		case 1:
			return "Associated";
		case 2:
			return "Associating";
		case 3:
			return "Unassociated";
		default:
			return "Unknown";
	}
}

function ReadableDistance($result)
{
	return $result / 10;
}

?>
