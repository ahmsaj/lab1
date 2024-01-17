<? include("../../__sys/prcds/ajax_header.php");
$sql="select * from lab_x_visits_samlpes_group  where status>0 and date > $ss_day order by send_date DESC ";
$res=mysql_q($sql);
$rows=mysql_n($res);
echo '<div class="f1 fs16 clr1 lh40">'.k_num_payments.'<ff> ( '.$rows.' ) </ff></div><div class="uLine"> </div>';
$grp_status=array(k_payment_progress,k_sent,k_received);
if($rows>0){
	$out2='';
	echo '<div class="mg10 samp_grp_list ofx so" fix="hp:51">';
	while($r=mysql_f($res)){	
		$id=$r['id'];
		$name=$r['name'];
		$date=$r['date'];
		$send_date=$r['send_date'];
		$status=$r['status'];
		$total=getTotalCO('lab_x_visits_samlpes'," grp='$id' ");
		
		
		echo '
		<div s="'.$status.'" onclick="veiwReceiptDet('.$id.')"> 
			<div class="f1 fs18 clr1 lh40" >'.k_paym.' : '.splitNo($name).' </div>
			<div class="ff fs16 B fr lh30">'.date('A h:i',$send_date).'</div>
			<div class="f1 fs16 uLine lh30">'.k_samples_num.' : <ff> '.$total.'</ff></div>
			<div class="f1 cb clr6 TC fs14">'.$grp_status[$status].'</div>
			
		</div>';
		$i++;				
	}
	echo '</div>';
	
}else{$out2='<div class="f1 fs16 clr1">'.k_no_sams_watn.'</div>';}

echo '^';
$send=getTotalCO('lab_x_visits_samlpes'," grp IN(select id from lab_x_visits_samlpes_group where date >'$ss_day' and status=1 ) ");
$recip=getTotalCO('lab_x_visits_samlpes'," grp IN(select id from lab_x_visits_samlpes_group where date >'$ss_day' and status=2 ) ");
$all=$send+$recip;
echo $all.','.$recip.','.$send;
?>