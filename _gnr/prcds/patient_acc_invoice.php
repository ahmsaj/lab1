<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);?>
	<div class="win_body">
	<div class="form_header so lh30 clr1 f1 fs18">	
		<ff><?=$id?></ff> | <?=get_p_name($id)?>
		<div class="f1 clr55 fs14 lh30">أختر الإجراءات المراد طباعتها</div>
	</div>
	<div class="form_body so" type="full">		
		<form id="denElm"><?
			$sql="select * from den_x_visits_services where patient='$id' and status !=3 order by d_start DESC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){?>		
				<table class="grad_s headH" width="100%" cellpadding="4" cellspacing="0" type="static" over="0">
				<tr>
					<th width="30"><input type="checkbox" par="check_all" name="s_print" /></th>
					<th width="100"><?=k_date?></th>
					<th><?=k_doctor?></th>
					<th><?=k_service?></th>
					<th><?=k_status?></th>
					<th><?=k_val_srv?></th>
				</tr><?
				$t1=$t2=$t3=$srvDone=0;
				while($r=mysql_f($res)){
					$s_id=$r['id'];
					$service=$r['service'];
					$doc=$r['doc'];
					$total_pay=$r['total_pay'];
					$d_start=$r['d_start'];
					$end_percet=$r['end_percet'];
					$teeth=$r['teeth'];
					$status=$r['status'];
					$teethTxt='';
					if($teeth){$teethTxt='<ff14 class="clr5" dir="ltr"> (  '.$teeth. ' )</ff14>';}
					$srvTxt=get_val_arr('den_m_services','name_'.$lg,$service,'s');
					$docTxt=get_val_arr('_users','name_'.$lg,$doc,'doc');
					?>
					<tr>
						<td><input name="denPrint" type="checkbox" par="grd_chek" value="<?=$s_id?>" /></td>
						<td><ff14><?=date('Y-m-d',$d_start)?></ff14></td>
						<td class="fs12 f1"><?=$docTxt?></td>
						<td><div class="TL f1"><?=$srvTxt.$teethTxt?></div></td>
						<td style="background-color:<?=$denSrvSCol[$status]?>"><div class="f1" ><?=$denSrvS[$status]?></div></td>
						<td><ff class="clr1"><?=number_format($total_pay)?></ff></td>	
					</tr><?
				}?>
				</table><?
			}else{?>
				<div class="f1 fs16 clr5 lh40"><?=k_no_srvcs?></div><?
			}?>
			</form>			
			
	</div>
	<div class="form_fot fr">
		<div class="bu bu_t2 fr" onclick="win('close','#m_info4');"><?=k_close?></div> 
		<div class="bu bu_t3 fl" onclick="printDenInvDo(<?=$id?>);"><?=k_print?></div> 
	</div>
	</div><?
}?>