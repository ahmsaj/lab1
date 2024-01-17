<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){$mod_code=$_POST['id'];?>
    <div class="win_body">
    <form name="add_task_form" id="add_task_form" action="<?=$f_path?>M/mods_oprs_buttons_save.php" method="post">
    <input type="hidden" name="mod_code" value="<?=$mod_code?>"/>    
    <div class="form_body so">    
	<table width="100%" border="0" id="tab_tasks"  class="grad_s" type="static" cellspacing="0" cellpadding="4" style="margin-bottom:40px;">
	<tr>
        <th><?=k_title?></th>
        <th><?=k_fnc?></th>
        <th><?=k_icon?></th>
        <th width="20" align="center"><div class="fr ic40 ic40_add icc4" onclick="addRowForTasks()">&nbsp;</div></th>
    </tr><?
	$sql="select * from _modules_butts where mod_code='$mod_code' order by id ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	$i=0;
	while($r=mysql_f($res)){
		$id=$r['id'];
		$title=$r['title'];
		$function=$r['function'];
		$style=$r['style'];
		echo '<tr id="tk_row_'.$i.'">
		<td><input type="text" name="title[]" value="'.$title.'" /></td>
		<td><input type="text" name="function[]" value="'.$function.'" /></td>
		<td><input type="text" name="style[]" value="'.$style.'" /></td>
		<td><div class="i30 i30_del" onclick="deletRow(\'tk_row_'.$i.'\')"></div></td>
		</tr>';
		$i++;
	}?>
	<tr id="tk_row_<?=$i?>">
		<td><input type="text" name="title[]" value="" /></td>
		<td><input type="text" name="function[]" value="" /></td>
		<td><input type="text" name="style[]" value="" /></td>
		<td><div class="i30 i30_del" onclick="deletRow('tk_row_<?=$i?>')"></div></td>
	</tr>
	</table>
    
    </div>
    <div class="form_fot fr">        
        <div class="fl ic40 ic40_save icc22 ic40Txt mg10f br0" onclick="sub('add_task_form')"><?=k_save?></div>
        <div class="fr ic40 ic40_x icc3 ic40Txt mg10f br0" onclick="win('close','#m_info');"><?=k_cancel?></div>
    </div>    
    </form>
    <script>all_rows=<?=$i?></script>
    </div>
	<?
}

?>