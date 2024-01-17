<? include("../../__sys/prcds/ajax_header.php");
$clinic=get_val_c('gnr_m_clinics','id',2,'type');
$sampels=getTotalCO('lab_x_visits_samlpes','status=2');
/***************************************************************/
$dayNo=date('w');
$h_time=get_host_Time();
$h_realTime=$h_time[1]-$h_time[0];
$thisDay2=$now-($now%86400);
if(($h_realTime+$thisDay2+$h_time[0])<$now){$h_realTime=($now%86400)-$h_time[0];}
$x_doctor=array();
$date=date('Y-m-d');
/********************************************/
// veiwSamplInfo('.$id.')
$sql="select * from lab_x_visits_samlpes where status =2 order by date DESC ";
$res=mysql_q($sql);
$rows=mysql_n($res);
echo '<div class="f1 fs16 clr1 lh40">'.k_sams_awat_recp.' <ff> ( '.$rows.' ) </ff></div><div class="uLine"> </div>';
if($rows>0){
	echo '<section c_ord  class="fl lvisR3" w="50" m=0">';	
	$out2='';
	while($r=mysql_f($res)){	
		$r_id=$r['id'];
		$visit_id=$r['visit_id'];
		$pkg_id=$r['pkg_id'];
		$services=$r['services'];
		$date=$r['date'];
		$no=$r['no'];
		$status=$r['status'];
		$action=' veiwSamplInfo('.$no.')';
		$title=get_p_name(get_val('lab_x_visits','patient',$visit_id));
		echo '<div onclick="'.$action.'" class="fl" c_ord1>
		<div class="fl">'.get_samlpViewC(0,$pkg_id,3,$no.'&#013;'.$title).'</div></div>';
		$i++;				
	}
	echo '</section>';
	//echo script('findRack(1001)');
}else{$out2='<div class="f1 fs16 clr1">'.k_no_sams_watn.'</div>';}?>