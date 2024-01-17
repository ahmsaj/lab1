<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$r_id=pp($_POST['id']);
	$r_name=get_val('lab_m_services','name_'.$lg,$r_id);
	?>
	<div class="win_body">
    <div class="form_header">
	<div class="fl lh40 fs18 f1 clr1 ws"><?=$r_name?> <? if($unitCode){echo '<ff>[ '.$unitCode.' ]</ff>';}?></div>
    <div class="fr lh40">
    <div class="il_add" onclick="anaEqu_set(1,<?=$r_id?>,0,'<?=k_equation?>')"></div>
    </div>
    </div>
	<div class="form_body so"  type="full">
	<?
    $sql="select * from lab_m_services_equations where ana_no='$r_id' order by ord ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH g_ord" type="static" t_ord="lab_m_services_equations" c_ord="ord" mod_ord="x">
        <tr>
        	<th width="30">#</th>
            <th><?=k_type?></th>
        	<th><?=k_calculated_field?></th>
        	<th><?=k_val?></th>
            <th width="100" ></th>
        </tr>
		<tbody>
        <?
		$i=1;
        while($r=mysql_f($res)){
			$id=$r['id'];
			$type=$r['type'];
			$item=$r['item'];
			$ord=$r['ord'];
			$equations=$r['equations'];
			$value=getaQNames($type,$equations);
			if($item){$item_name=get_val('lab_m_services_items','name_'.$lg,$item);}else{$item_name=k_not_existed;}
			if($type==1){							$action='anaQType=11;anaEqu_set(2,'.$r_id.','.$id.',\''.k_build_the_equation.'\','.$item.');';
			}else{
				$action='anaQType='.$type.';anaEqu_set(2,'.$r_id.','.$id.',\''.$aQtypes[$type-1][1].'\')';
			}
			
			echo '<tr row_id="'.$id.'" row_ord="'.$ord.'">
			<td><ff>'.$i.'</ff></td>
			<td class="f1">'.$aQtypes[$type-1][1].'</td>
			<td>'.$item_name.'</td>
			<td>'.$value.'</td>
			<td>
			<div class="ic40 icc2 ic40_del fl" onclick="anaEqu_del('.$id.')"></div>
			<div class="ic40 icc1 ic40_edit fl" onclick="'.$action.'"></div>			
			</td>
			</tr>';
			$i++;
		}?>
		</tbody>
        </table>
        
		<?
	}else{
		echo '<div class="f1 fs14 clr5">'.k_no_added_equations.'</div>';
	}
	?>
	</div>
	<div class="form_fot fr">
		<div class="bu bu_t2 fr" onclick="win('close','#m_info');loadModule()"><?=k_close?></div>                
	</div>
	</div><?
}?>