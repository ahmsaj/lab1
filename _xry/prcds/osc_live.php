<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'])){	
	$vis=pp($_POST['vis']);
	$service=get_val_c('xry_x_visits_services','service',$vis,'visit_id');
	$servTime=get_val('xry_m_services','ser_time',$service);	
	$s_time=$servTime*_set_pn68gsh6dj*60;
	
	$work_time=getRealWorkTime($vis,3);	
	$flasher='';
	if($work_time>$s_time){$flasher=' flasher ';}
	echo '
	<div class="oscTi '.$flasher.'">
	<div t1>'.dateToTimeS2($work_time).'</div>
	<div t2>'.dateToTimeS2($s_time).'</div>	
	</div>';	
}?>
