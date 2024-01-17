<? include("../../__sys/mods/protected.php");?>
<?=header_sec($def_title,'ref');?>
<div class="centerSideInHeader"></div>
<div class="centerSideIn">
<?
$sql="select * from lab_m_external_Labs order by id ASC";
$res=mysql_q($sql);
$rows=mysql_n($res);
if($rows>0){
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
	<tr>
	<th>'.k_lab.'</th>
	<th>'.k_tol_srv.'</th>
	<th>'.k_payms.'</th>	
	<th>'.k_balance.'</th>
	</tr>';
	$t1=$t2=$t3=0;
	while($r=mysql_f($res)){
		$id=$r['id'];
		$name=$r['name_'.$lg];		
		$tot_services=get_sum('lab_x_visits_services_outlabs','lab_price'," out_lab='$id' ");
		$tot_payments=get_sum('lab_x_acc_out_payments','amount'," lab='$id' ");
		$t1+=$tot_services;
		$t2+=$tot_payments;
		$t3+=$tot_services-$tot_payments;
		echo '<tr>
			<td class="f1 fs14">'.$name.'</td>
			<td><ff  class="clr1">'.number_format($tot_services).'</ff></td>
			<td><ff class="clr6">'.number_format($tot_payments).'</ff></td>
			<td><ff class="clr5">'.number_format($tot_services-$tot_payments).'</ff></td>	
		</tr>';
	}
	echo '<tr bgcolor="#eeeeee">
	<td class="f1 fs14">'.k_total.'</td>
	<td><ff  class="clr1">'.number_format($t1).'</ff></td>
	<td><ff class="clr6">'.number_format($t2).'</ff></td>
	<td><ff class="clr5">'.number_format($t3).'</ff></td>	
	</tr>';
	echo '</table>';
}else{
	echo '<div class="f1 fs14 clr5 lh40">'.k_nad_xtr_lb.'</div>';
}
?>
</div>