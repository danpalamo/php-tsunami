<tr>
	<td>
		<b style='font-size:20px;'><?php echo "<a href=\"".$host->m_id."\">$host->m_id</a>" ?></b> (<?php echo "<a href=\"http://".$host->m_host."\">$host->m_host</a>" ?>)<br>
		<?php echo $host->m_desc ?><br>
		<b>Uptime</b> <?php insertHostQuery($host, 'UPTIME'); ?> days<br>
		<b>SUs</b> <?php insertHostQuery($host, 'SU_COUNT'); ?><br>
	<td class="center">
		<?php insertHostGraph($host, "ETH_TRAFFIC_B", true); ?>
	<td class="center">
		<?php insertHostGraph($host, "RF_DROP", true); ?>
