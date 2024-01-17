<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$r=getRec('lab_m_services',$id);	
	if($r['r']){		
		$con=$r['conditions'];
		$sample_type=$r['sample_type'];
		$time_req=$r['time_req'];
		$ch_sample=$r['ch_sample'];
		$cus_unit_price=$r['cus_unit_price'];
		$fast=$r['fast'];
		if($ch_sample){
			$nn=make_Combo_box('lab_m_samples','name_'.$lg,'id','','s_'.$id,1,$sample_type,' t ');
		}else{
			$nn=get_val('lab_m_samples','name_'.$lg,$sample_type).'<input type="hidden" name="s_'.$id.'" value="'.$sample_type.'" />';
		}
		echo $nn;
		if($con){
			$cons=get_vals('lab_m_services_condition','name_'.$lg,"id IN($con)",'|');
			echo '<div class="fa  f1 fs14 clr5">'.k_conditions.' : '.$cons.'</div>';
		}
		echo '^';
		if($fast){
			echo '<input type="checkbox" name="f_'.$id.'"/>';
		}
	}
}?>