<table class="host_info">
	<tr>
		<td>
			<b style='font-size:20px;'><a href="<?php echo ".."; ?>"><?php echo $host->m_id; ?></a></b> (<a href="http://<?php echo $host->m_host ?>"><?php echo $host->m_host; ?></a>)<br>
			<b style='font-size:20px;'><a href="."><?php echo $subhost ?></a></b><br>
			<b><?php insertSubhostQuery($host, $subhost, 'ASSOCIATION'); ?></b><br>
			<b>MAC</b> <?php insertSubhostQuery($host, $subhost, 'MAC'); ?><br>
			<b>CIR D/U</b> <?php insertSubhostQuery($host, $subhost, 'CIR_DOWN'); ?>/<?php insertSubhostQuery($host, $subhost, 'CIR_UP'); ?><br>
			<b>MIR D/U</b> <?php insertSubhostQuery($host, $subhost, 'MIR_DOWN'); ?>/<?php insertSubhostQuery($host, $subhost, 'MIR_UP'); ?><br>
			<br>
			<b>SW ver</b> <?php insertSubhostQuery($host, $subhost, 'SW_VER'); ?><br>
		<td class="center">
			<?php insertSubhostGraph($host, $subhost, "ASSOCIATION"); ?><br><hr>
			<?php insertSubhostGraph($host, $subhost, "RSSI_SU"); ?><br><hr>
			<?php insertSubhostGraph($host, $subhost, "RF_TRAFFIC_P"); ?><br><hr>
			<?php insertSubhostGraph($host, $subhost, "RF_DROP"); ?><br><hr>
			<?php insertSubhostGraph($host, $subhost, "RF_SU_RETRY"); ?><br>
</table>
