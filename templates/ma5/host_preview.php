<tr>
	<td>
		<b style='font-size:20px;'><a href="<?php _host(); ?>"><?php _host(); ?></a></b> (<a target="blank" href="http://<?php _host('m_host'); ?>"><?php _host('m_host'); ?></a>)<br/>
		<?php _host('m_desc') ?><br/>
		<b>Firmware</b> <?php _e("FW_VER"); ?><br/>
		<b>Uptime</b> <?php printf("%.1f",__e("UPTIME")/(24*60*60*100)); ?> days<br>
	</td>
	<td class="center">
		Ethernet Traffic<br>
		<?php _g("ETH_TRAFFIC_B", false, true); ?>
	</td>
	<td class="center">
		RF Packets<br>
		<?php _g("RF_TRAFFIC_P", false, true); ?>
	</td>
	<td class="center">
		GPS Satellites<br>
		<?php _g("MIMOSA_GPS_SATS_STATS", false, true); ?>
	</td>
	<td class="center">
		RF PER<br>
		<?php _g("RF_PER", false, true); ?>
	</td>
</tr>
