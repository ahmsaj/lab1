<?=header_sec($def_title,'');?>
<div class="centerSideInFull" >
	<div class="fl r_bord pd10" fix="w:350|hp:0"><br>
	<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" >
		<tr>
			<td><div class="f1 fs16 clr6 lh40" ><?=k_generate_styles_as_css_files?>:</div></td>
			<td width="40"><div class="ic40x icc4 ic40_play gnr_but" onclick="control_style(1);" title="<?=k_gn_fls?>"></div></td>
		</tr>
		<tr>
			<td><div class="pd10 f1 fs16 clr5 lh40" ><?=k_delete_css_style_files?></div></td>
			<td><div class="ic40x icc2 ic40_play gnr_but" onclick="control_style(2);" title="<?=k_delete?>"></div></td>
		</tr>
	</table>
	</div>
	<div class="fl" fix="wp:350|hp:0">
		<div id="info_data" class="pd10 ofx so" fix="hp:0"></div>
	</div>
</div>

