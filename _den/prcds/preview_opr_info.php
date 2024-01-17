<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id']) || isset($_POST['t'])){
	$id=pp($_POST['id']);
	$t=pp($_POST['t']);?>
	<div class="win_body">
	<? if($t){echo '<div class="form_header f1 clr1 fs18 lh40">السن : <ff class="clr5"> ( '.$t.' ) </ff></div>';}?>
	<div class="form_body so"><?
	if($id){
		$sql="select * from den_x_opr_teeth where id='$id' ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows){
			$r=mysql_f($res);		
			$opr_part=$r['opr_part'];
			$doc=$r['doctor'];
			if($opr_part){$opr_part_txt=' <ff class="clr5">( '.$opr_part.' )</ff>';}
			?>
			<table width="100%" border="0" class="grad_s " type="static" cellspacing="0" cellpadding="4" over="0">
			<tr><td txt><?=k_visit?></td><td><ff>#<?=$r['visit']?></ff></td><tr>
			<tr><td txt><?=k_dr?></td><td txt><?=get_val('_users','name_'.$lg,$doc)?></td><tr>
			<tr><td txt><?=k_medicines_place?> </td><td txt><?=$teethParTxt[$r['teeth_part']]?></td><tr>
			<tr><td txt><?=k_tooth?></td><td><ff><?=$r['teeth']?></ff></td><tr>
			<tr><td txt><?=k_status?></td><td txt><?=get_val('den_m_set_teeth','name_'.$lg,$r['opr']).$opr_part_txt?></td><tr>
			<? 
			if($r['opr_sub']){
				echo'<tr><td txt>'.k_sub_status.' </td><td txt>'.get_val('den_m_set_teeth_sub','name_'.$lg,$r['opr_sub']).'</td><tr>';
			}?>		
			<tr><td txt><?=k_date?></td><td><ff><?=date('Y-m-d A h:i',$r['date'])?></ff></td><tr>
			</table>
			<? 
		}
	}
	if($t){
		$sql="select * from den_x_opr_teeth where teeth_no='$t' order by date DESC ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows){?>
			<table width="100%" border="0" class="grad_s " type="static" cellspacing="0" cellpadding="4" over="0">
				<tr>
				<th><?=k_visit?></th>
				<th><?=k_dr?></th>
				<th><?=k_medicines_place?> </th>
				<th><?=k_status?></th>
				<th><?=k_sub_status?></th>
				<th><?=k_date?></th>
				<th width="30"></th>
				</tr><?
				while($r=mysql_f($res)){
					$o_id=$r['id'];
					$opr_part=$r['opr_part'];
					$doc=$r['doctor'];
					$teeth_part=$r['teeth_part'];
					$teeth_part_sub=$r['teeth_part_sub'];
					$docTxt=get_val_arr('_users','name_'.$lg,$doc,'d');
					$pSubStatus='';
					if($teeth_part==1){
						$pStatus=get_val_arr('den_m_set_teeth','name_'.$lg,$r['opr'],'s1');
						if($teeth_part_sub){$pSubStatus=$facCodes[$teeth_part_sub];}
					}
					if($teeth_part==2){
						$pStatus=get_val_arr('den_m_set_roots','name_'.$lg,$r['opr'],'s2');
						if($teeth_part_sub){$pSubStatus=$cavCodes[$teeth_part_sub];}
					}
					$opr_part_txt='-';
					if($opr_part){$opr_part_txt=' <ff class="clr5">( '.$opr_part.' )</ff>';}?>			
					<tr>
						<td><ff>#<?=$r['visit']?></ff></td>
						<td txt><?=$docTxt?></td>
						<td txt><?=$teethParTxt[$teeth_part]?></td>
						<td txt><?=$pStatus.$opr_part_txt?></td>
						<td txt><ff class="uc"><?=$pSubStatus?></ff></td>
						<td><ff><?=date('Y-m-d A h:i',$r['date'])?></ff></td>
						<td><? if($doc==$thisUser && $t){echo '<div class="ic40 icc2 ic40_del" onclick="teethOprDel('.$o_id.');" title="'.k_delete.'"></div>';}?></td>
					<tr><? 
				}?>
			</table><? 
		}
	}?>
	</div>
	<div class="form_fot fr">
		<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
		<? if($doc==$thisUser && $id){echo '<div class="bu bu_t3 fl" onclick="teethOprDel('.$id.');">'.k_delete.'</div>';}?>
	</div>
	</div><?
	
}?>