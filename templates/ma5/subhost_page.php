<table class="host_info">
	<tr>
		<td>
			<b style='font-size:20px;'><a href=".."><?php _host(); ?></a></b> <span style="font-size:12px;line-height:20px;">(<a target="blank" href="http://<?php _host('m_host'); ?>"><?php _host('m_host'); ?></a>)</span><br/>
			<b style='font-size:20px;'><a href="."><?php _subhost(); ?></a></b> <span style="font-size:12px;line-height:20px;">(<a target="blank" href="http://<?php _e('IP', true); ?>"><?php _e('IP', true); ?></a>)</span><br/>
			<b>Site Name</b> <?php _e('SITE_NAME', true); ?><br/>
			<b>CIR D/U</b> <?php _e('CIR_DOWN', true); ?>/<?php _e('CIR_UP', true); ?><br/>
			<b>MIR D/U</b> <?php _e('MIR_DOWN', true); ?>/<?php _e('MIR_UP', true); ?><br/>
			<b>Adapt Rate</b> <?php _e('ADAPT_RATE', true); ?><br>
			<br>
			<b>FW ver</b> <?php _e('FW_VER', true); ?><br/>
		</td>
		<td class="center">
			<?php _g("SES_UPTIME", true, false); ?><br/><hr/>
			<?php _g("MA5_RSSI_SU", true, false); ?><br/><hr/>
			<?php _g("RF_TRAFFIC_O", true, false); ?><br/><hr>
			<?php _g("RF_TRAFFIC_P", true, false); ?><br/><hr>
			<?php _g("RF_PER", true, false); ?><br/>
		</td>
	</tr>
</table>
