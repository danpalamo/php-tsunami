<tr>
	<td>
		<b style='font-size:20px;'><a href="<?php _subhost(); ?>"><?php _subhost(); ?></a></b><br/>
		<b>IP</b> <a target="blank" href="//<?php _e('IP', true); ?>"><?php _e('IP', true); ?></a><br/>
		<b>Site Name</b> <?php _e('SITE_NAME', true); ?><br/>
                <b>Status</b> <?php echo __e('SES_UPTIME', true) == 0 ? 'Not Associated' : 'Associated'; ?><br/>
	</td>
	<td class="center">
		<?php _g("SES_UPTIME", true, true); ?>
	</td>
	<td class="center">
		<?php _g("RSSI_C_SU", true, true); ?>
	</td>
	<td class="center">
		<?php _g("RF_TRAFFIC_B", true, true); ?>
	</td>
	<td class="center">
		<?php _g("U24_STA_QUAL", true, true); ?>
	</td>
</tr>
