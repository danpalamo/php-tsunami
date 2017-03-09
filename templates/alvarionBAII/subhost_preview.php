<tr>
	<td width=150>
		<b style='font-size:20px;'><?php echo "<a href=\"".$subhost."\">$subhost</a>" ?></b><br>
		<b>MAC</b> <?php insertSubhostQuery($host, $subhost, 'MAC'); ?><br>
		<b><?php insertSubhostQuery($host, $subhost, 'ASSOCIATION'); ?></b><br>
	<td class="center">
		<?php insertSubhostGraph($host, $subhost, "ASSOCIATION", true); ?>
	<td class="center">
		<?php insertSubhostGraph($host, $subhost, "RSSI_SU", true); ?>
	<td class="center">
		<?php insertSubhostGraph($host, $subhost, "RF_TRAFFIC_P", true); ?>
