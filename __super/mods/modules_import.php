<?
$but="action:".k_add.":ti_add:exp_import_file_add()|action:".k_import.":ti_bak hide:exp_mod_import_do_confirm()";

echo header_sec($def_title,$but);?>
<div class="centerSideInHeader lh50 fs14 f1 clr5">
<?=k_sel_file_to_import_mods?>..
</div>
<div class="centerSideIn of">
	<div id="content"></div>
	<div id="result" class="hide">
		<div class="fs14 f1"><?=k_res_are_shown?>:</div> <br>
		<table width="75%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static" over="0">
			<tr><td txt width="20%"><?=k_basic_mods?></td><td m></td></tr>
			<tr><td txt><?=k_additional_modules?></td><td m_></td></tr>
			<tr><td txt><?=k_mod_files?></td><td m_f></td></tr>
			<tr><tr><td txt><?=k_lnkd_tbls_contnt?></td><td t_data></td></tr>
			<tr><td txt><?=k_jx_fl?></td><td f></td></tr>
        </table>
	</div>
</div>
<script>
	/*sezPage='';
	$(document).ready(function(e){
		
	});*/
</script>
