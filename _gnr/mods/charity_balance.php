<? include("../../__sys/mods/protected.php");?>
<?=header_sec($def_title,'');?>
<div class="centerSideIn so"><?
$sql="select * from gnr_m_charities  limit 3";
$res=mysql_q($sql);
$rows=mysql_n($res);
if($rows>0){	
	$all_in=0;
	$all_out=0;
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" >
	<tr><th>'.k_box.'</th><th>'.k_rcvble.'</th><th>'.k_receipts.'</th><th>'.k_balance.'</th><th width="50"></th></tr>';
	while($r=mysql_f($res)){
		$c_id=$r['id'];
		$name=$r['name_'.$lg];
		$chr_in=get_sum('gnr_r_charities','receivable'," chr_id='$c_id'");
		$chr_out=get_sum('gnr_x_acc_payments_charities','amount'," chr='$c_id'");		
		$chr_bal=$chr_in-$chr_out;
		$all_in+=$chr_in;
		$all_out+=$chr_out;
		echo '<tr>
		<td class="f1 fs14">'.$name.'</td>
		<td><ff>'.number_format($chr_in).'</ff></td>
		<td><ff>'.number_format($chr_out).'</ff></td>
		<td><ff class="clr5">'.number_format($chr_bal).'</ff></td>
		<td><div class="bu bu_t1 buu" onclick="chrPay('.$c_id.','.$chr_bal.')">'.k_paym.'</div></td>
		</tr>';
	}
	echo '<tr>
	<td class="f1 fs14">'.k_total.'</td>
	<td><ff>'.number_format($all_in).'</ff></td>
	<td><ff>'.number_format($all_out).'</ff></td>
	<td><ff class="clr5">'.number_format($all_in-$all_out).'</ff></td>
	<td></td>
	</tr>';
	echo '</table>';
}
?></div>