<table class="host_info">
	<tr>
		<td>
			<b style='font-size:20px;'><a href="."><?php _host(); ?></a></b> <span style="font-size:12px;line-height:20px;">(<a target="blank" href="http://<?php _host('m_host'); ?>"><?php _host('m_host'); ?></a>)</span><br/>
			<?php _host('m_desc') ?><br/>
			<b>AP Name</b> <?php _e("AP_NAME"); ?><br>
			<b>Firmware</b> <?php _e("FW_VER"); ?><br>
			<b>Serial Number</b> <?php _e("SN"); ?><br>
			<b>Uptime</b> <?php printf("%.1f",__e("UPTIME")/(24*60*60*100)); ?> days<br>
			<b>GPS Satellites GPS/GLONASS</b> <?php echo _e("GPS_SATS_SEEN"); echo "/"; echo _e("GLONASS_SATS_SEEN"); ?><br>
			<b>AP SSID</b> <?php _e("AP_SSID"); ?><br>
			<b>Traffic Split</b> <?php _e("TRAF_SPLIT"); ?><br>
			<b>Frame Length</b> <?php _e("FRAME_TIME"); ?> ms<br>
			<b>Channel Center Freq</b> <?php _e("CHAN_5FREQ"); ?><br>
			<b>Channel Width</b> <?php _e("CHAN_5WIDTH"); ?><br>
		</td>
		<td class="center">
			<?php _g("UPTIME"); ?><br/><hr/>
			<!-- <?php _g("ETH_TRAFFIC_B"); ?><br/><hr/> -->
			<?php _g("RF_TRAFFIC_O"); ?><br/><hr/>
			<?php _g("RF_TRAFFIC_P"); ?><br/><hr>
			<?php _g("RF_PER"); ?><br/><hr/>
			<?php _g("MIMOSA_GPS_SATS_STATS"); ?><br/>
		</td>
	</tr>
</table>

<hr/>

<table class="subhost_preview">
	<tr class="host_preview_header">
		<td/>
		<td>
			Session Uptime
		</td>
		<td>
			RF Traffic
		</td>
		<td>
			RSSI at AP
		</td>
		<td>
			RF PER
		</td>
	</tr>
	{content}
</table>
