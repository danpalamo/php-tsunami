<?php

echo '<?php
$timeframe = "'.$aGraphTimeframes[0]->m_desc.'";
if(isset($_GET["timeframe"]))
	$timeframe = $_GET["timeframe"];
?>';

?>

<html>

<head>
	<title><?php echo $pageTitle?></title>
	<style type="text/css" media="all">@import "//<?php echo $wwwHostname ?>style.css";</style>
</head>

<body>
<div class="div_main">
	<div class="div_header">
		<a href="//<?php echo $wwwHostname ?>"><img src="/tsunami/images/tsunami.png"></a>
	</div>
	
	<div class="div_content">
		<table>
			<tr>
				<td class="td_menu"  width=100>
					<!-- a handy place to put URLs -->	
					<a href="//github.com/danpalamo/php-tsunami/">php-tsunami github</a><br>
					<a href="//ipchicken.com">ipchicken.com</a><br>
				<td class="td_main">
					<?php insertTimeframes(); ?>
					<hr>
					<?php echo $pageContent ?>
		</table>
	</div>
	
	<div class="div_footer"><?php echo date("M d, Y H:i "); ?></div>
	
</body>

</html>
