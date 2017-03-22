<tr>
	<td>
		<b style='font-size:20px;'><a href="<?php _subhost(); ?>"><?php _subhost(); ?></a></b><br/>
		<b>IP</b> <a target="blank" href="http://<?php _e('IP', true); ?>"><?php _e('IP', true); ?></a><br/>
		<b>Site Name</b> <?php _e('SITE_NAME', true); ?><br/>
		<b>Status</b> <?php echo __e('ASSOCIATION', true) == 1 ? 'Associated' : 'Not Associated'; ?><br/>
	</td>
	<td class="center">
		<?php _g("ASSOCIATION", true, true); ?>
	</td>
	<td class="center">
		<?php _g("SES_UPTIME", true, true); ?>
	</td>
	<td class="center">
		<?php _g("RSSI_C_SU", true, true); ?>
	</td>
	<td class="center">
		<?php _g("RF_TRAFFIC_O", true, true); ?>
	</td>
</tr>
