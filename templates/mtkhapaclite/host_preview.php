<tr>
	<td>
		<b style='font-size:20px;'><a href="<?php _host(); ?>"><?php _host(); ?></a></b> (<a target="blank" href="http://<?php _host('m_host'); ?>"><?php _host('m_host'); ?></a>)<br/>
		<?php _host('m_desc') ?><br/>
		<b>Hardware</b> <?php _e("HW_VER"); ?><br/>
		<b>Firmware</b> <?php _e("FW_VER"); ?> <b>Software</b> <?php _e("SW_VER"); ?><br/>
		<b>Uptime</b> <?php printf("%.1f",__e("UPTIME")/(24*60*60*100)); ?> days<br>
		<b>SUs</b> <?php printf("%.0f",__e("WLAN1_SU_COUNT")+__e("WLAN2_SU_COUNT")); ?><br>
	</td>
	<td class="center">
		Ethernet Traffic<br>
		<?php _g("ETH_TRAFFIC_B", false, true); ?>
	</td>
	<td class="center">
		WLAN1 Traffic<br>
		<?php _g("NM5_WLAN1_TRAF", false, true); ?>
	</td>
	<td class="center">
		WLAN2 Traffic<br>
		<?php _g("NM5_WLAN2_TRAF", false, true); ?>
	</td>
	<td class="center">
		SU Count<br>
		<?php _g("NM5_SU_COUNT", false, true); ?>
	</td>
</tr>
