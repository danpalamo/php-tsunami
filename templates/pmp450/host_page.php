<table class="host_info">
	<tr>
		<td>
			<b style='font-size:20px;'><a href="."><?php _host(); ?></a></b> <span style="font-size:12px;line-height:20px;">(<a target="blank" href="http://<?php _host('m_host'); ?>"><?php _host('m_host'); ?></a>)</span><br/>
			<?php _host('m_desc') ?><br/>
			<b>Hardware</b> <?php _e("HW_VER"); ?><br/>
			<b>Firmware</b> <?php _e("FW_VER"); ?><br/>
			<b>Uptime</b> <?php printf("%.1f",__e("UPTIME")/(24*60*60*100)); ?> days<br/>
			<b>GPS Status</b> <?php echo __e("GPS_STATUS") > 0 ? 'Up' : 'Down'; ?><br/>
			<b>Downlink Percentage</b> <?php _e("DL_PERCENT"); ?><br>
			<b>Maximum Range</b> <?php _e("MAX_RANGE"); ?> miles<br>
			<b>Control Slots</b> <?php _e("CONTROL_SLOTS"); ?><br>
			<b>Color Code</b> <?php _e('COLOR_CODE'); ?><br/>
			<b>SUs</b> <?php _e("SU_COUNT"); ?><br/>
		</td>
		<td class="center">
			<?php _g("UPTIME"); ?><br/><hr/>
			<?php _g("ETH_TRAFFIC_B"); ?><br/><hr/>
			<?php _g("RF_TRAFFIC_B"); ?><br/><hr/>
			<?php _g("FRAME_UTIL"); ?><br/>
			<?php _g("RF_DROP"); ?><br/><hr/>
			<?php _g("GPS_STATUS"); ?><br/><hr/>
			<?php _g("SU_COUNT"); ?><br/>
		</td>
	</tr>
</table>

<hr/>

<table class="subhost_preview">
	<tr class="host_preview_header">
		<td/>
		<td>
			Association
		</td>
		<td>
			Session Uptime
		</td>
		<td>
			RSSI
		</td>
		<td>
			RF Traffic
		</td>
	</tr>
	{content}
</table>
