<table class="host_info">
	<tr>
		<td>
			<b style='font-size:20px;'><a href="<?php _host(); ?>"><?php _host(); ?></a></b> <span style="font-size:12px;line-height:20px;">(<a target="blank" href="//<?php _host('m_host'); ?>"><?php _host('m_host'); ?></a>)</span><br/>
			<b style='font-size:20px;'><a href="<?php _subhost(); ?>"><?php _subhost(); ?></a></b> <span style="font-size:12px;line-height:20px;">(<a target="blank" href="//<?php _e('IP', true); ?>"><?php _e('IP', true); ?></a>)</span><br/>
			<b>Site Name</b> <?php _e('SITE_NAME', true); ?><br/>
			<b>Delay</b> <?php _e('DISTANCE', true); ?> ns<br/>
		</td>
		<td class="center">
			<?php _g("SES_UPTIME", true, false); ?><br/><hr/>
			<?php _g("RSSI_C_SU", true, false); ?><br/><hr/>
			<?php _g("RF_TRAFFIC_B", true, false); ?><br/><hr/>
			<?php _g("U24_STA_QUAL", true, false); ?><br/>
		</td>
	</tr>
</table>
