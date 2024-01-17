<? include("../../__sys/prcds/ajax_header.php");
$perm_dcm=modPer($mod_study);
if($perm_dcm[0]){
  if(isset($_POST['type'])){
  	$type=pp($_POST['type'],'s');
  	if($type=="view"){
  		if(isset($_POST['patient'],$_POST['service'])){
    		$patient=pp($_POST['patient']);
    		$service=pp($_POST['service']);			
    		$patientName=get_p_name($patient);			
			$endAction='upDICOMst('.$patient.','.$service.');';			
    		echo k_pats_sutdies." ( $patientName )^";
    		//جلب الدراسات المخزنة على السيرفر وغير مخزنة محلياً
    		dcm_PACS_to_DB($patient,$service);
			$q='';
			if($service){$q=" and service='$service' ";}
    		/*--------------------*/
    		$sql="select * from xry_x_dcm_studies where patient='$patient' $q order by id desc";
    		$res=mysql_q($sql);
    		$studies_co=mysql_n($res);?>
        	<div class="win_body">
    			<div class="winButts">
    				<div class="wB_x fr" onclick="<?=$endAction?>"></div>
    			</div>
    			<div class="form_body so of" type="pd0">
    				<div class="fl r_bord" fix="w:300|hp:0" >
    					<div class="b_bord lh50" fix="wp:0|h:50" >
    						<div class="fl ic40 ic_dicom_studies"></div>
    						<div class=" fl fs18 f1 lh50" ><?=k_pats_sutdies?> [<ff> <?=$studies_co?> </ff>]</div>
              			  <? if($perm_dcm[1]){?>
    						<div class="fr ic40 icc2 ic40_add" onclick="loadFormAddStudy(<?=$patient?>,<?=$service?>,0)" title="<?=k_new_study?>"></div>
                			<?}?>
    					</div>
    					<div fix="hp:50" all class="ofx so plistV1 cb"><?
    						if($studies_co>0){
								while($r=mysql_f($res)){
									$study=$r['id'];?>
									<div study="<?=$study?>" class="studies_list" study="<?=$study?>"><?=get_info_study($study,$r)?></div>
							  <?}

							}?>

    					</div>
    				</div>
    				<div class="fl" fix="wp:300|hp:0">
    					<div class="b_bord" fix="wp:0|h:50" id="study_icons">
    						<div class="fl ic40  ic_dicom_details " ></div>
    						<div class="fl fs18 f1 lh50" ><?=k_study_details?> </div>
							<? if($studies_co>0){
								 
							}?>
    					</div>

    					<div class="details_study" fix="wp:0|hp:50" ></div>
    				</div>
    			</div>
    			<div class="form_fot fr">
    				<div> &nbsp </div>
    			</div>
    		</div>
  	<?}
  	}	  
  	elseif($type=='get_details'){
  		if(isset($_POST['study'])){
  			$out='';
  			$study=pp($_POST['study']);
  			if($study){
				//جلب الأيقونات
				$perm_edit=$perm_del=0;
				$user_add=get_val('xry_x_dcm_studies','user',$study);
				if($user_add==$thisUser||$user_add=='' ||!$user_add){$perm_edit=1;}
				if($user_add==$thisUser){$perm_del=1;}
				
				if($perm_dcm[4]){?>
					  <div id="s_v" class=" fr ic40 icc1 ic_dicom_view2" title="<?=k_study_prev?>"  ></div>
				<?}
				 if($perm_dcm[2] && $perm_edit){?>
				  <div id="s_e" class=" fr ic40 icc4 ic_dicom_edit_name" title="<?=k_edit_std_name?>" ></div>
				<?}if($perm_dcm[3]  && $perm_del){?>
				  <div id="s_d" class=" fr ic40 icc2 ic40_del" title="<?=k_study_del?>" ></div>
				<?}
				echo '^';
  				//----جلب معلومات المزامنة
  				$studyFiles=getTotalCO('xry_x_dcm_files',"study=$study");
  				$fileSyncDo=getTotalCO('xry_x_dcm_files',"study=$study and status='sync'");
  				$donePer=calc_sync_percent($study);
  				$fix='fix="wp:0|hp:120" ';
  				//--progres--
  				if($donePer<100){
					if($perm_dcm[1]){?>
					   <div fix="wp:0|h:120" class="uLine">
						    <div fix="wp:0|h:30" class="clr5 f1 lh30 cbg7 pd10"><?=k_all_study_must_sent?></div>
							<div class="fl w100 pd10" fix="wp:0|h:40">
								<div class="fl" fix="wp:50">
									<div class="clr1 f1 fs14 lh30"><?=k_sent_files?> <ff class="fs14" id="counter_exc"><?="( $fileSyncDo / $studyFiles )"?></ff>  </div>
									<div class="snc_prog fl">
										<div sync_progress class="fl <?=$clr?>" style="width:<?=$donePer?>%"></div>
									</div>
								</div>
								<div id="ssb" e class="fr ic40 icc3 ic40_pus <?=$hide?>" ></div>
							</div>

							<div class="cb clr6 <?=$hide?> pd10" fix="wp:0|hp:40" time>
								<div class="f1 fs12 fl lh40" > <?=k_predicted_end_time?> </div>
								<div class="fl mg10" style="border:1px solid; padding:5px;">
								<ff  id="expected_time">00:00:00</ff>
								</div>
							</div>
					 </div>
				  <?}else{
					  echo '<div class="clr5 f1 fs16 pd10"> '.k_admin_complete_imgs_send.' </div>';
				  }
         		}else{$fix='fix="hp:0|wp:0"';}
				//--series--?>
				<div <?=$fix ?> id="series_view"><?
					echo get_series($study);?>
				</div>
  			<?
				
			}

  		}
  	}
  }
}else{
  out(1);
}
