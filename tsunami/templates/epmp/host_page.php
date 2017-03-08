<table class="host_info">
	<tr>
		<td>
			<b style='font-size:20px;'><a href="<?php _host(); ?>"><?php _host(); ?></a></b> <span style="font-size:12px;line-height:20px;">(<a target="blank" href="//<?php _host('m_host'); ?>"><?php _host('m_host'); ?></a>)</span><br/>
			<?php _host('m_desc') ?><br/>
			<?php $hwarray = array(
				'/\b3\b/' => 'ePMP 1000 2.4ghz GPS Connectorized',
				'/\b10\b/' => 'ePMP 2000 5.7ghz GPS Connectorized', );
				echo ($hwstring = preg_replace(array_keys($hwarray), array_values($hwarray), __e("HW_VER"))); ?></br>
			<b>Firmware Version</b> <?php _e('FW_VER'); ?><br/>
			<b>Uptime</b> <?php printf("%.1f",__e("UPTIME")/(24*60*60*100)); ?> days<br/>
<!--			<b>GPS Status</b> <?php echo __e("GPS_STATUS") > 0 ? 'Up' : 'Down'; ?><br/> -->
	                <b>GPS Status</b> 
                        <?php $gpsarray = array(
                                '0' => 'init',
                                '1' => 'nosync',
                                '2' => 'sync',
                                '3' => 'holdoff',
                                '4' => 'regain',
                                '5' => 'freerun', );
                       	echo ($gpsstring = str_replace(array_keys($gpsarray), $gpsarray, __e("GPS_STATUS"))); ?></br>
			<b>AP SSID</b> <?php _e('AP_SSID'); ?><br/>
			<b>Channel Frequency</b> <?php _e('CHAN_FREQ'); ?><br/>
			<b>Channel Width</b> <?php echo __e("CHAN_WIDTH") == 1 ? '20' : '40'; ?><br/>
			<b>SUs</b> <?php _e("SU_COUNT"); ?><br/>
		</td>
		<td class="center">
			<?php _g("UPTIME"); ?><br/><hr/>
			<?php _g("ETH_TRAFFIC_B"); ?><br/><hr/>
			<?php _g("RF_TRAFFIC_B"); ?><br/><hr/>
<!--			<?php _g("EPMP_FRAME_USED_UP"); ?><br/>
			<?php _g("EPMP_FRAME_USED_DOWN"); ?><br/> -->
			<?php _g("RF_DROP"); ?><br/><hr/>
			<?php _g("EPMP_GPS_STATUS"); ?><br/><hr/>
			<?php _g("EPMP_GPS_SATS_STATS"); ?><br/><hr/>
<!--			<?php _g("EPMP_FRAME_USED_UP"); ?><br/><hr/>
			<?php _g("EPMP_FRAME_USED_DOWN"); ?><br/><hr/> -->
			<?php _g("SU_COUNT"); ?><br/>
		</td>
	</tr>
</table>

<hr/>

<table class="subhost_preview">
	<tr class="host_preview_header">
		<td></td>
		<td>
			Session Uptime
		</td>
		<td>
			RSSI
		</td>
		<td>
			RF Traffic
		</td>
		<td>
			SNR
		</td>
	</tr>
	{content}
</table>
