<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['val'])){
	$id=$_POST['id'];
	$val=$_POST['val'];
	$pars=explode('|',$val);
	
	$p_table=$pars[0] ?? '';
	$p_col=$pars[1] ?? '';
	$p_view=$pars[2] ?? '';
	$p_c_view=$pars[3] ?? '';
	$p_mod_link=$pars[4] ?? '';
	$p_cond=$pars[5] ?? '';
	$p_evens=$pars[6] ?? '';
	?>
	<div class="win_body">
	<div class="form_header">
		<div class="lh40 clr1 fs18 fl f1"><?=k_ent_prp?></div>	
	</div>
	<div class="form_body so" >
	<table width="100%" border="0" cellspacing="0" type="static" cellpadding="4" class="grad_s" >
		<tr><td txt><?=k_table?></td><td dir="ltr"><?=tablesList('parent_table_'.$id,'coll_'.$id,$p_table)?></td></tr>
		<tr><td txt><?=k_val?> </td>
		<td><div link="coll_<?=$id?>" v link_id="par_val_<?=$id?>" dir="ltr"><?=columeList($p_table,$p_col)?></div></td></tr>
		<tr><td txt><?=k_menu?></td><td><div link="coll_<?=$id?>" l link_id="par_txt_<?=$id?>" dir="ltr"><?=columeList($p_table,$p_view)?></div></td></tr>
		<tr><td txt><?=k_menu?>2</td>
			<td><div dir="ltr"><input type="text" id="par_txt2_<?=$id?>" value="<?=$p_c_view?>"/></div></td>
		</tr>
		<tr><td txt><?=k_lk_md?></td><td dir="ltr"><?=modulesList('par_mod_'.$id,$p_mod_link)?></td></tr>
		<tr><td txt><?=k_condition?></td><td dir="ltr"><input type="text" id="par_con_<?=$id?>" value="<?=$p_cond?>"/></td></tr>
		<tr><td txt><?=k_evnt_cod?></td><td dir="ltr"><input type="text" id="par_evn_<?=$id?>"  value="<?=$p_evens?>"/></td></tr>
	</table>
	</div>
	<div class="form_fot fr">
		<div class="bu bu_t1 fl" onclick="saveParentVals()"><?=k_end?></div>
		<div class="bu bu_t2 fr" onclick="win('close','#m_info')"><?=k_close?></div>
	</div>
	</div>
	<script>makeColumrName('coll_<?=$id?>')</script><?
}?>

