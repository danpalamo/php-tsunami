<tr>
	<td width=150>
		<b style='font-size:20px;'><?php echo "<a href=\"".$subhost."\">$subhost</a>" ?></b> (<a href="http://<?php insertSubhostQuery($host, $subhost, 'IP'); ?>"><?php insertSubhostQuery($host, $subhost, 'IP'); ?></a>)<br>
		<b>MAC</b> <?php insertSubhostQuery($host, $subhost, 'MAC'); ?><br>
		<b><?php insertSubhostQuery($host, $subhost, 'ASSOCIATION'); ?></b><br>
	<td class="center">
		<?php insertSubhostGraph($host, $subhost, "ASSOCIATION", true); ?>
	<td class="center">
		<?php insertSubhostGraph($host, $subhost, "RSSI", true); ?>
	<td class="center">
		<?php insertSubhostGraph($host, $subhost, "ETH_TRAFFIC_B", true); ?>
