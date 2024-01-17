<? include("../../__sys/prcds/ajax_header.php");
$g=pp($_POST['g']);
$sql="select * from lab_x_work_table where status<2 order by id DESC";
$res=mysql_q($sql);
$rows=mysql_n($res);
echo '( '.$rows.' )^';
if($rows){
	echo '<div actButt="act">';
	while($r=mysql_f($res)){
		$id=$r['id'];
		$name=$r['name'];
		$date=$r['date'];
		$services=$r['services'];
		$status=$r['status'];
		$anaTotal=0;
		if($services){
			$allSrv=explode(',',$services);
			$anaTotal=count($allSrv);
		}
		$act='';
		if($g==$id){$act=' act ';}
		$dStatus='';
		$txtDate='<ff>'.date('A h:i',$date).'</ff>';
		if($ss_day<$date){
			$dStatus=' '.k_tday.' | ';
		}elseif($ss_day-$date<86400){
			$dStatus=' '.k_yesterday.' | ';
		}else{
			$txtDate='<ff>'.date('Y-m-d | A h:i',$date).'</ff>';
		}
		
		echo '<div class="cbgw bord uLine pd10" grpWT="'.$id.'" '.$act.'>
			<div class="f1 fs14 lh40 b_bord clr1">'.k_number_of_tests.'  : <ff class="fs16" t>  '.$anaTotal.' </ff></div>
			<div class="f1 fs14 lh40">'.$dStatus.' '.$txtDate.'</div>
		</div>';
	}
	echo '</div>';
}else{
	echo '<div class="f1 fs14 clr5">'.k_no_work_tables.'</div>';
}

?>