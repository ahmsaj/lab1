<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$r=getRec('den_x_visits',$id);
	if($r['r']){
		$status=$r['status'];
		$patient=$r['patient'];
		if($status==1){
			$sql="select * from den_x_visits_services where patient='$patient' and doc='$thisUser' order by d_start DESC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			?>
			<div class="win_body">
			<div class="form_header so lh40 clr1 f1 fs18"><?=get_p_name($patient)?></div>
			<div class="form_body of" type="pd0">
			<div class="fr ofx so pd10" fix="wp:360|hp:0" ><?
			if($rows>0){?>
				<div class="f1 fs18 lh40 clr1 pd10"><?=k_srvs_prvd?> </div>
				<table class="grad_s holdH" width="100%" cellpadding="4" cellspacing="0" type="static" over="0">		
				<tr>
					<th width="120"><?=k_date?></th>
					<th><?=k_service?></th>
					<th><?=k_val_srv?> </th>
					<th><?=k_complete_percent?> </th>
					<th><?=k_rcvble?></th>
				</tr><?
				$t1=$t2=$t3=0;
				while($r=mysql_f($res)){
					$service=$r['service'];
					$total_pay=$r['total_pay'];
					$d_start=$r['d_start'];
					$end_percet=$r['end_percet'];
					$srvTxt=get_val_arr('den_m_services','name_'.$lg,$service,'s');
					$srvNet=0;
					if($end_percet){
						$srvNet=$total_pay*$end_percet/100;
					}
					$t1+=$total_pay;
					$t2+=$end_percet;
					$t3+=$srvNet;
					?>
					<tr>
					<td><ff><?=date('Y-m-d',$d_start)?></ff></td>
					<td txt><?=$srvTxt?></td>
					<td><ff class="clr1"><?=number_format($total_pay)?></ff></td>					
					<td><ff>%<?=$end_percet?></ff></td>	
					<td><ff  class="clr6"><?=number_format($srvNet)?></ff></td>
					</tr><?
				}?>
				<tr fot>
					<td colspan="2" txt><?=k_total?></td>
					<td><ff class="clr1"><?=number_format($t1)?></ff></td>					
					<td>-</td>	
					<td><ff class="clr6"><?=number_format($t3)?></ff></td>
				</tr>
				</table><?
			}else{?>
				<div class="f1 fs16 clr5 lh40"><?=k_no_srvcs?> </div><?
			}
			$pay=patDenPay($patient,$thisUser);
			$bal=$t3-$pay;
			$balPay=$bal;
			if($balPay<0){$balPay=0;}
			$maxPay=$t1-$pay;
			if($maxPay<0){$maxPay=0;}
			?>
			</div>
			<div class="fl r_bord pd10f ofx so" fix="w:360|hp:0">
				<table width="100%" border="0" cellspacing="0" cellpadding="4" type="static" class="grad_s holdH">
				<tr>
					<td class="f1 fs14 lh40 b_bord"><?=k_val_srvs?>  : </td>
					<td class="TC" width="100"><ff class="clr1"><?=number_format($t1)?></ff></td>
				</tr>
				<tr>
					<td class="f1 fs14 lh40 b_bord"> <?=k_comp_srv_val?> : </td>
					<td class="TC"><ff class="clr6"><?=number_format($t3)?></ff></td>
				</tr>
				<tr>
					<td class="f1 fs14 lh40 b_bord"><?=k_prev_pays?>  :</td>
					<td class="TC"><ff class="clr5"><?=number_format($pay)?></ff></td>
				</tr>
				<tr>
					<td class="f1 fs14 lh40 b_bord"><?=k_balance?> :</td>
					<td class="TC"><ff class="clr6"><?=number_format($bal)?></ff> (<?=number_format($maxPay)?>) </td>
				</tr>
				<tr fot>
					<td class="f1 fs14 lh40 b_bord"><?=k_proposed_pay?>  :</td>
					<td class="TC"><input type="number" max="<?=$maxPay?>" id="denPay" value="<?=$balPay?>" ></td>
				</tr>
				</table>
			</div>
			</div>
			<div class="form_fot fr">
				<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div> 
				<div class="bu bu_t3 fl" onclick="endVisDenDo();"><?=k_end?></div> 
			</div>
			</div><?
		}else{
			echo script("loc('_Visit-Den')");
		}
	}
}?>