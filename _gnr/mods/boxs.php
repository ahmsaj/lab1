<? include("../../__sys/mods/protected.php");?>
<?=header_sec($def_title,'');?>
<div class="centerSideIn so">
<?
$sql="select * from _users where `grp_code` IN('buvw7qvpwq','pfx33zco65')";
$res=mysql_q($sql);
$rows=mysql_n($res);
if($rows>0){	
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" >
	<tr><th>'.k_box.'</th><th>'.k_incm_fnd.'</th><th>'.k_drawings.'</th><th>'.k_balance.'</th><th width="50"></th><th width="50"></th></tr>';
	while($r=mysql_f($res)){
		$u_id=$r['id'];
		$name=$r['name_'.$lg];
		$in=get_sum('gnr_x_acc_payments','amount'," type IN(1,2,5,6,7,10) and casher='$u_id'");
		$out=get_sum('gnr_x_acc_payments','amount'," type IN(3,4,8) and casher='$u_id'");
		$box_in=$in-$out;
		$box_out=get_sum('gnr_x_box_take','amount'," box='$u_id'");
		$box_bal=$box_in-$box_out;
		echo '<tr>
		<td class="f1 fs14">'.$name.'</td>
		<td><ff>'.number_format($box_in).'</ff></td>
		<td><ff>'.number_format($box_out).'</ff></td>
		<td><ff class="clr5">'.number_format($box_bal).'</ff></td>
		<td>';
		$paymentDate=latePay($u_id);
		$today=$now-($now%86400);
		//echo '<br>'.$paymentDate.'<br>'.$today.'<br>' ;
		if($paymentDate<$today && $box_bal>0){
			echo '<div class="bu bu_t3 buu" onclick="boxPayFix('.$u_id.')">'.k_reckoning.'</div>';
		}
		echo'</td><td>';
		if($box_bal>0){
			echo '<div class="bu bu_t1 buu" onclick="boxPay('.$u_id.','.$box_bal.')">'.k_withdraw_bal.'</div>';
		}
		echo '</td>
		</tr>';				
	}
	echo '</table>';
}
?>
</div>
