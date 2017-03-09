<tr>
	<td>
		<b style='font-size:20px;'><a href="<?php _host(); ?>"><?php _host(); ?></a></b> (<a target="blank" href="//<?php _host('m_host'); ?>"><?php _host('m_host'); ?></a>)<br/>
<!--		<?php _host('m_desc') ?><br/> -->
		<?php $hwarray = array(
			'/\b3\b/' => 'ePMP 1000 2.4ghz GPS Connectorized',
			'/\b10\b/' => 'ePMP 2000 5.7ghz GPS Connectorized', );
		echo ($hwstring = preg_replace(array_keys($hwarray), array_values($hwarray), __e("HW_VER"))); ?></br>
		<b>Firmware</b> <?php _e("FW_VER"); ?>
		<b>Uptime</b> <?php printf("%.1f",__e("UPTIME")/(24*60*60*100)); ?> days<br/>
		<b>GPS Status</b>
		<?php $gpsarray = array(
			'0' => 'init',
			'1' => 'nosync',
			'2' => 'sync',
			'3' => 'holdoff',
			'4' => 'regain',
			'5' => 'freerun', );
		echo ($gpsstring = str_replace(array_keys($gpsarray), $gpsarray, __e("GPS_STATUS"))); ?>
		<b>SUs</b> <?php _e("SU_COUNT"); ?><br/>
	</td>
	<td class="center">
		<?php _g("ETH_TRAFFIC_B", false, true); ?>
	</td>
	<td class="center">
<!--		<?php _g("RF_DROP", false, true); ?>
	<td class="center">
		<?php _g("FRAME_UTIL", false, true); ?> -->
	</td>
	<td class="center">
		<?php _g("EPMP_GPS_STATUS", false, true); ?>
	</td>
	<td class="center">
		<?php _g("SU_COUNT", false, true); ?>
	</td>
</tr>
