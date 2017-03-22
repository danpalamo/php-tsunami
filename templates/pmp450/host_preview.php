<tr>
	<td>
		<b style='font-size:20px;'><a href="<?php _host(); ?>"><?php _host(); ?></a></b> (<a target="blank" href="http://<?php _host('m_host'); ?>"><?php _host('m_host'); ?></a>)<br/>
		<?php _host('m_desc') ?><br/>
		<b>Firmware</b> <?php _e("FW_VER"); ?><br/>
		<b>Uptime</b> <?php printf("%.1f",__e("UPTIME")/(24*60*60*100)); ?> days<br>
		<b>GPS Status</b> <?php echo __e("GPS_STATUS") > 0 ? 'Up' : 'Down'; ?><br>
		<b>SUs</b> <?php _e("SU_COUNT"); ?><br/>
	</td>
	<td class="center">
		Ethernet Traffic<br>
		<?php _g("ETH_TRAFFIC_B", false, true); ?>
	</td>
	<td class="center">
		Frame Utilization<br>
		<?php _g("FRAME_UTIL", false, true); ?>
	</td>
	<td class="center">
		GPS Status<br>
		<?php _g("GPS_STATUS", false, true); ?>
	</td>
	<td class="center">
		SU Count<br>
		<?php _g("SU_COUNT", false, true); ?>
	</td>
</tr>
