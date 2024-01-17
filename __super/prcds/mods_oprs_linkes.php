<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['mod'])){
    $mod_code=pp($_POST['mod'],'s');?>
    <div class="win_body">      
    <div class="form_body so">    
	<table width="100%" border="0" id="tab_links"  class="grad_s" type="static" cellspacing="0" cellpadding="4" style="margin-bottom:40px;">
	<tr>
        <th><?=k_table?></th>
        <th><?=k_feld_nam?></th>
        <th><?=k_cmp_val?></th>
        <th width="60" align="center"><div class="fr ic40 ic40_add icc4" onclick="modLinkesAdd()"></div></th>
    </tr><?
	
	$sql="select * from _modules_links where mod_code='$mod_code' order by id ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	$i=0;
	while($r=mysql_f($res)){
		$id=$r['id'];
		$table=$r['table'];
		$colume=$r['colume'];
		$val=$r['val'];		
		echo '<tr id="tk_row_'.$i.'">
		<td><input type="hidden" name="table[]" value="'.$table.'" />'.tableName($table).'</td>
		<td><input type="hidden" name="colume[]" value="'.$colume.'" />'.tableName($colume).'</td>
		<td><input type="hidden" name="val[]" value="'.$val.'" />'.$val.'</td>
		<td>
            <div class="fr i30 i30_edit" onclick="modLinkesAdd('.$id.')"></div>
            <div class="fr i30 i30_del" onclick="modLinkesDel('.$id.')"></div>
        </td>
		</tr>';
		$i++;
	}?>
    </table>    
    </div>
    <div class="form_fot fr">
        <div class="fr ic40 ic40_x icc3 ic40Txt mg10v br0" onclick="win('close','#m_info');"><?=k_close?></div>
    </div>
    </div><?
}?>