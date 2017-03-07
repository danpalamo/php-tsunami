<tr>
	<td>
		<b style='font-size:20px;'><a href="<?php _host(); ?>"><?php _host(); ?></a></b> (<a target="blank" href="//<?php _host('m_host'); ?>"><?php _host('m_host'); ?></a>)<br/>
<!--		<?php _host('m_desc') ?><br/> -->
		<?php _e('HW_VER') ?><br/>
		<b>Uptime</b> <?php printf("%.1f",__e("UPTIME")/(24*60*60*100)); ?> days<br/>
		
		<b>SUs</b> <?php _e("SU_COUNT"); ?><br/>
	</td>
	<td class="center">
		<?php _g("ETH_TRAFFIC_B", false, true); ?>
	</td>
	<td class="center">
		<!-- U24 QUAL -->
	</td>
	<td>
		<!-- GPS Status -->
	</td>
	<td class="center">
		<?php _g("SU_COUNT", false, true); ?>
	</td>
</tr>
