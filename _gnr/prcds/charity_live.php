<? include("../../__sys/prcds/ajax_header.php");
$sql="select * from gnr_x_temp_oprs where type=2  order by status ASC , date ASC";
$res=mysql_q($sql);
$rows=mysql_n($res);
if($rows){	
	while($r=mysql_f($res)){
		$id=$r['id'];
		$type=$r['type'];
		$pat_name=$r['pat_name'];
		$status=$r['status'];
		//$sub_status=$r['sub_status'];
		$date=$r['date'];
		$col='';		
		$statusTxt=k_since.' <ff14> '.dateToTimeS2($now-$date);
		if($status==1){$col='cbg7';$statusTxt=k_request_succes;}
		echo'
		<div class="chrBlc '.$col.'" onclick="chr_det('.$id.')">
			<div class="f1 fs14 clr1">'.$pat_name.'</div>
			<div class="fs14 lh20">'.$statusTxt.'</ff14></div>
		</div>';
	}
}else{
	echo '<div class="f1 fs14 clr5 lh40">'.k_no_req_chart.'</div>';
}?>