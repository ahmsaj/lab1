<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	
	$r2=getRec('xry_x_visits_services',$id);	
	if($r2['r']){
		$visit_id=$r2['visit_id'];
		$service=$r2['service'];
		$patient=$r2['patient'];
		$doc=$r2['doc'];		
	}	
	$visStatus=get_val('xry_x_visits','status',$visit_id);
	if($visStatus==1){
		$doc=get_val('xry_x_visits','doctor',$visit_id);
		$r=getRec('xry_x_visits_services_add',$id);
		$t1=$t2=$t3=$t4=0;
		if($r['r']){
			$t1=$r['tec_endoscopy'];
			$t11=$r['tec_endoscopy_wages'];
			$t2=$r['tec_anesthesia'];
			$t3=$r['tec_sterilization'];
			$t4=$r['tec_nurse'];

		}?>
		<div class="win_body">
		<div class="form_header so lh40 clr1 f1 fs18"><?=get_p_name($patient)?></div>
		<div class="form_body so">
			<form name="oscTeam" id="oscTeam" action="<?=$f_path?>X/xry_osc_team_save.php" method="post" cb="teamInfo(<?=$id?>);" bv="">
			<input type="hidden" name="srv" value="<?=$id?>"/>
			<input type="hidden" name="vis" value="<?=$visit_id?>"/>
			<div class="f1 fs16 lh40 clr5 uLine"><?=get_val('xry_m_services','name_'.$lg,$service)?></div>
			<table class="fTable" cellpadding="0" cellspacing="0" border="0">
			<tr><td n><?=k_doctor?> : </td><td class="f1 fs16 clr1"><?=get_val('_users','name_'.$lg,$doc)?></td></tr>
			<tr><td n><?=k_endoscopy_tech?> : <span>*</span></td><td><?=make_Combo_box('xry_m_osc_team','name_'.$lg,'id',' where type=1','t1',1,$t1,' t ')?></td></tr>
			<tr><td n><?=k_endoscopy_tech_fee?> : <span>*</span></td><td><?='<input type="number" name="t11" value="'.$t11.'" required/>'?></td></tr>
			<tr><td n><?=k_anesthesia_tech?> : <span>*</span></td><td><?=make_Combo_box('xry_m_osc_team','name_'.$lg,'id',' where type=2','t2',1,$t2,' t ')?></td></tr>
			<tr><td n><?=k_sterilization_tech?> : <span>*</span></td><td><?=make_Combo_box('xry_m_osc_team','name_'.$lg,'id',' where type=3','t3',1,$t3,' t ')?></td></tr>
			<tr><td n><?=k_nurse?> : </td>    <td><?=make_Combo_box('xry_m_osc_team','name_'.$lg,'id',' where type=4','t4',0,$t4,' t ')?></td></tr>
			</table>
			</form>
		</div>
		<div class="form_fot fr">
			<div class="bu bu_t3 fl" onclick="sub('oscTeam');"><?=k_save?></div>
			<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>     
		</div>
		</div><?
	}
}?>