<table class="host_info">
	<tr>
		<td>
			<b style='font-size:20px;'><a href="."><?php _host(); ?></a></b> <span style="font-size:12px;line-height:20px;">(<a target="blank" href="//<?php _host('m_host'); ?>"><?php _host('m_host'); ?></a>)</span><br/>
			<?php _host('m_desc') ?><br/>
			<b>Uptime</b> <?php printf("%.1f",__e("UPTIME")/(24*60*60*100)); ?> days<br/>
			<b>SSID</b> <?php _e("SSID"); ?><br/>
			<b>SUs</b> <?php _e("SU_COUNT"); ?><br/>
		</td>
		<td class="center">
			<?php _g("UPTIME"); ?><br/><hr/>
			<?php _g("ETH_TRAFFIC_B"); ?><br/><hr/>
			<?php _g("RF_TRAFFIC_B"); ?><br/><hr/>
			<?php _g("SU_COUNT"); ?><br/>
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
			RF Traffic
		</td>
		<td>
			Station Quality
		</td>
	</tr>
	{content}
</table>
