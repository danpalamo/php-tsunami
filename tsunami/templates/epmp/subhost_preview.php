<tr>
	<td>
		<b style='font-size:20px;'><a href="<?php _subhost(); ?>"><?php _subhost(); ?></a></b><br/>
		<b>IP</b> <a target="blank" href="//<?php _e('IP', true); ?>"><?php _e('IP', true); ?></a><br/>
		<b>Site Name</b> <?php _e('SITE_NAME', true); ?><br/>
		<b>Distance(meters)</b> <?php _e('DISTANCE', true); ?><br/>
	</td>
	<td class="center">
		<?php _g("SES_UPTIME", true, true); ?>
	</td>
	<td class="center">
		<?php _g("RSSI", true, true); ?>
	</td>
	<td class="center">
		<?php _g("EPMP_RF_TRAFFIC_KBPS", true, true); ?>
	</td>
	<td class="center">
		<?php _g("EPMP_SNR", true, true); ?>
	</td>
</tr>
