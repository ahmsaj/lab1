<? include("../../__sys/prcds/ajax_header.php");
if(modPer($mod_study)[4]){
	echo getEditorSet();
	if(isset($_POST['id'],$_POST['status'])){
		$id=pp($_POST['id'],'s');
		$attr='err';
		$title='';
		$service=0;
		$service_status='';
		$status=pp($_POST['status'],'s');
		if($status=='series'){
			list($sop_series,$title,$study)=get_val('xry_x_dcm_series','sop_series,description,study',$id);
			if($sop_series && $sop_series!=''){$attr='series='.$sop_series;}
			$service=get_val('xry_x_dcm_studies','service',$study);
		}elseif($status=='study'){
			list($sop_study,$title,$service)=get_val('xry_x_dcm_studies','sop_study,title,service',$id);
			if($sop_study && $sop_study!=''){$attr='study='.$sop_study;}
		}
		if($service){
			list($doc,$service_status,$m_srv_id)=get_val('xry_x_visits_services','doc,status,service',$service);
			$srv_name=' | '.k_service.' : '.get_val('xry_m_services','name_'.$lg,$m_srv_id);			
		}
		if($attr=='err'){
			echo 0;
		}else{
			$src="$dcm_server/osimis-viewer/app/index.html?$attr";?>
			<div id="dcm_loader"><div class="fl loadeText"><?=k_study_loading_wait?></div></div>
			
            <div class="winButts">
                <div class="wB_x fr" onclick="moveXryReport('back');win('close','#full_win4');"></div>
                <? 

            if($thisGrp=='nlh8spit9q' && $service_status=0){?>
                <section class="fr ic40 ic40_edit icc2 ic40Txt lh50 " fix="w:150|h:48" repedit 
                ><?=k_report_edit?></section><?}?>
            </div>
            <div class="win_free">
				<div class="fl w100 h100" fix="wp:0|hp:0">
					<iframe class="so" width="100%" height="100%" src="<?=$src?>" frameborder="0" id="foo"></iframe>
				</div>
			</div><?
			echo '^-^'.k_study." : ".trim($title)." ".$srv_name;
		}
	}
}else{ 
	out(1);
}?>
