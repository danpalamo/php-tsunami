<table class="host_info">
	<tr>
		<td>
			<b style='font-size:20px;'><a href="."><?php _host(); ?></a></b> <span style="font-size:12px;line-height:20px;">(<a target="blank" href="http://<?php _host('m_host'); ?>"><?php _host('m_host'); ?></a>)</span><br/>
			<?php _host('m_desc') ?><br/>
			<b>Hardware</b> <?php _e("HW_VER"); ?><br/>
			<b>Firmware</b> <?php _e("FW_VER"); ?><br/>
			<b>Software</b> <?php _e("SW_VER"); ?><br/>
			<b>Serial Number</b> <?php _e("SERIAL_NUM"); ?><br>
			<b>Uptime</b> <?php printf("%.1f",__e("UPTIME")/(24*60*60*100)); ?> days<br/>
			<br>
			<b>WLAN1 SSID</b> <?php _e("WLAN1_SSID"); ?><br>
			<b>WLAN1 Band</b> <?php _e("WLAN1_CHAN_BAND"); ?><br>
			<b>WLAN1 Frequency</b> <?php _e("WLAN1_CHAN_FREQ"); ?><br>
			<b>WLAN1 SUs</b> <?php _e("WLAN1_SU_COUNT"); ?><br>
			<br>
			<b>WLAN2 SSID</b> <?php _e("WLAN2_SSID"); ?><br>
			<b>WLAN2 Band</b> <?php _e("WLAN2_CHAN_BAND"); ?><br>
			<b>WLAN2 Frequency</b> <?php _e("WLAN2_CHAN_FREQ"); ?><br>
			<b>WLAN2 SUs</b> <?php _e("WLAN2_SU_COUNT"); ?><br>
		</td>
		<td class="center">
			<?php _g("UPTIME"); ?><br/><hr/>
			<?php _g("ETH_TRAFFIC_B"); ?><br/><hr/>
			<?php _g("ETH2_TRAFFIC_B"); ?><br/><hr/>
			<?php _g("ETH3_TRAFFIC_B"); ?><br/><hr/>
			<?php _g("ETH4_TRAFFIC_B"); ?><br/><hr/>
			<?php _g("ETH5_TRAFFIC_B"); ?><br/><hr/>
			<?php _g("NM5_WLAN1_TRAF"); ?><br/><hr/>
			<?php _g("NM5_WLAN2_TRAF"); ?><br/><hr/>
			<?php _g("NM5_SU_COUNT"); ?><br/>
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
			RSSI
		</td>
		<td>
			SNR
		</td>
		<td>
			RF Traffic
		</td>
	</tr>
	{content}
</table>
