<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['mod'])){
	$mod_code=$_POST['mod'];?>
    <div class="win_body">
    <div class="form_body so" >    
    <table width="100%" border="0" id="tab_cons"  class="grad_s holdH" type="static" cellspacing="0" cellpadding="4" style="margin-bottom:10px;">
    <tr>
        <th><?=k_feld_nam?></th>
        <th><?=k_con_typ?></th>
        <th><?=k_val?></th>
        <th width="60" align="center"><div class="fr ic40 ic40_add icc4" onclick="modConsAdd()">&nbsp;</div></th>
    </tr><?
    
    $sql="select * from _modules_cons where mod_code='$mod_code' order by id ASC";
    $res=mysql_q($sql);
    $rows=mysql_n($res);
	$i=0;
    while($r=mysql_f($res)){
        $id=$r['id'];
        $colume=$r['colume'];
        $type=$r['type'];			
        $val=$r['val'];		
        echo '<tr id="con_row_'.$i.'">		
        <td>'.$colume.'<input type="hidden" name="colume[]" value="'.$colume.'"/></td>
        <td>'.$t_array[$type].'<input type="hidden" name="type[]" value="'.$type.'" /></td>
        <td>'.$val.'<input type="hidden" name="val[]" value="'.$val.'" /></td>
        <td>
            <div class="fr i30 i30_edit" onclick="modConsAdd('.$id.')"></div>
            <div class="fr i30 i30_del" onclick="modConsDel('.$id.')"></div>            
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