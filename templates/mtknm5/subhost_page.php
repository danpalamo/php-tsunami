<table class="host_info">
	<tr>
		<td>
			<b style='font-size:20px;'><a href=".."><?php _host(); ?></a></b> <span style="font-size:12px;line-height:20px;">(<a target="blank" href="http://<?php _host('m_host'); ?>"><?php _host('m_host'); ?></a>)</span><br/>
			<b style='font-size:20px;'><a href="."><?php _subhost(); ?></a></b> <span style="font-size:12px;line-height:20px;">(<a target="blank" href="http://<?php _e('IP', true); ?>"><?php _e('IP', true); ?></a>)</span><br/>
		</td>
		<td class="center">
			<?php _g("SES_UPTIME", true, false); ?><br/><hr/>
			<?php _g("RSSI", true, false); ?><br/><hr/>
			<?php _g("NM5_SNR", true, false); ?><br/><hr/>
			<?php _g("RF_TRAFFIC_O", true, false); ?><br/><hr/>
			<?php _g("RF_TRAFFIC_P", true, false); ?><br/>
		</td>
	</tr>
</table>
