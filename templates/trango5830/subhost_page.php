<table class="host_info">
	<tr>
		<td>
			<b style='font-size:20px;'><a href=".."><?php echo $host->m_id; ?></a></b> (<a href="http://<?php echo $host->m_host ?>"><?php echo $host->m_host; ?></a>)<br>
			<b style='font-size:20px;'><a href="."><?php echo $subhost ?></a></b> (<a href="http://<?php echo insertSubhostQuery($host, $subhost, 'IP'); ?>"><?php echo insertSubhostQuery($host, $subhost, 'IP'); ?></a>)<br>
			<b><?php insertSubhostQuery($host, $subhost, 'ASSOCIATION'); ?></b><br>
			<b>Range</b> <?php insertSubhostQuery($host, $subhost, 'DISTANCE'); ?> mi<br>
			<b>MAC</b> <?php insertSubhostQuery($host, $subhost, 'MAC'); ?><br>
			<b>CIR </b> <?php insertSubhostQuery($host, $subhost, 'CIR'); ?><br>
			<b>MIR </b> <?php insertSubhostQuery($host, $subhost, 'MIR'); ?><br>
			<br>
			<b>HW ver</b> <?php insertSubhostQuery($host, $subhost, 'HW_VER'); ?><br>
			<b>FW ver</b> <?php insertSubhostQuery($host, $subhost, 'FW_VER'); ?><br>
		<td class="center">
			<?php insertSubhostGraph($host, $subhost, "ASSOCIATION"); ?><br><hr>
			<?php insertSubhostGraph($host, $subhost, "RSSI"); ?><br><hr>
			<?php insertSubhostGraph($host, $subhost, "SU_TXPOWER"); ?><br><hr>
			<?php insertSubhostGraph($host, $subhost, "ETH_TRAFFIC_KBPS"); ?><br><hr>
			<?php insertSubhostGraph($host, $subhost, "RF_TRAFFIC_B"); ?><br><hr>
			<?php insertSubhostGraph($host, $subhost, "TEMPERATURE"); ?><br>
</table>
