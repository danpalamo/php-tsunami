<table class="host_info">
	<tr>
		<td>
			<b style='font-size:20px;'><a href="."><?php echo $host->m_id; ?></a></b> (<a href="http://<?php echo $host->m_host ?>"><?php echo $host->m_host ?></a>)<br>
			<?php echo $host->m_desc ?><br>
			<b>Uptime</b> <?php insertHostQuery($host, 'UPTIME'); ?> days<br>
			<b>SUs</b> <?php insertHostQuery($host, 'SU_COUNT'); ?><br>
		<td class="center">
			<?php insertHostGraph($host, "UPTIME"); ?><br><hr>
			<?php insertHostGraph($host, "ETH_TRAFFIC_B"); ?><br><hr>
			<?php insertHostGraph($host, "RF_TRAFFIC_B"); ?><br><hr>
			<?php insertHostGraph($host, "RF_DROP"); ?><br><hr>
			<?php insertHostGraph($host, "SU_COUNT"); ?><br>
</table>

<hr>

<table class="subhost_preview">
	<tr class="host_preview_header">
		<td>
		<td>
			Association
		<td>
			RSSI
		<td>
			Ethernet Traffic
		<? echo $content ?>
</table>
