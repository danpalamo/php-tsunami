<table class="host_info">
	<tr>
		<td>
			<b style='font-size:20px;'><a href=".."><?php _host(); ?></a></b> <span style="font-size:12px;line-height:20px;">(<a target="blank" href="//<?php _host('m_host'); ?>"><?php _host('m_host'); ?></a>)</span><br/>
			<b style='font-size:20px;'><a href="."><?php _subhost(); ?></a></b> <span style="font-size:12px;line-height:20px;">(<a target="blank" href="//<?php _e('IP', true); ?>"><?php _e('IP', true); ?></a>)</span><br/>
			<b>Site Name</b> <?php _e('SITE_NAME', true); ?><br/>
			<b>MAC</b> <?php _e('MAC', true); ?><br/>
			<b>Priority</b> <?php _e('PRIORITY', true); ?><br/>
			<b>Distance</b> <?php _e('DISTANCE', true); ?> meters<br/>
			<b>MIR D/U</b> <?php _e('MIR_DOWN', true); ?>/<?php _e('MIR_UP', true); ?><br/>
		</td>
		<td class="center">
			<?php _g("EPMP_SES_UPTIME", true, false); ?><br/>
			<?php _g("RSSI", true, false); ?><br/>
			<?php _g("EPMP_SNR", true, false); ?><br/>
			<?php _g("EPMP_MCS", true, false); ?><br/>
			<?php _g("RF_TRAFFIC_P", true, false); ?><br/>
			<?php _g("EPMP_RF_TRAFFIC_KBPS", true, false); ?><br/>
<!--			<?php _g("RF_DROP", true, false); ?><br/><hr/>
			<?php _g("RF_RETRY", true, false); ?><br/> -->
		</td>
	</tr>
</table>
