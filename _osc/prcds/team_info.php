<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);	
	$r=getRec('osc_x_visits_services_add',$id);
	$vis=$r['visit_id'];
	$visStatus=get_val('osc_x_visits','status',$vis);
	if($r['r']){
		$types=modListToArray('t9ezglh4me');
		echo '
		<div class="f1 fs14  clr1 lh30 ">'.$types[1].' : 
		<span class="f1 fs14  clr5 ">'.get_val('osc_m_team','name_'.$lg,$r['tec_endoscopy']).'</span></div>
		<div class="f1 fs14  clr1 lh30">'.$types[2].' : 
		<span class="f1 fs14  clr5 ">'.get_val('osc_m_team','name_'.$lg,$r['tec_anesthesia']).'</span></div>
		<div class="f1 fs14  clr1 lh30">'.$types[3].' : 
		<span class="f1 fs14  clr5 ">'.get_val('osc_m_team','name_'.$lg,$r['tec_sterilization']).'</span></div>
		<div class="f1 fs14  clr1 lh30">'.$types[4].' : 
		<span class="f1 fs14  clr5 ">'.get_val('osc_m_team','name_'.$lg,$r['tec_nurse']).'</span></div>
		';
		echo '<div class="uLine lh1">&nbsp;</div>';
	}else{
		echo '<div class="f1 fs14 lh40 clr5">'.k_staff_not_determined.'</div>';		
	}					
}?>