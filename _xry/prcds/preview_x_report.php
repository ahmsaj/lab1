<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$selTemp=pp($_POST['r']);		
	list($vis,$srv,$s_status)=get_val('xry_x_visits_services','visit_id,service,status',$id);	
	list($pat,$clinic,$doc_ord,$vis_status,$visit_link)=get_val('xry_x_visits','patient,clinic,doc_ord,status,visit_link',$vis);
	dcm_PACS_to_DB($pat,$id);
	$clinic_type=get_val('gnr_m_clinics','type',$clinic);
	if($thisGrp=='1ceddvqi3g' || $thisGrp=='nlh8spit9q'){	list($d_txt,$doc_ask,$photos,$part,$report,$mas,$kv,$film)=get_val('xry_x_pro_radiography_report','report,doc_ask,photos,part,report,mas,kv,film',$id);	
	$parts=[];
	if($part){
		$parts=get_vals('xry_m_services_parts','name'," id IN($part) ",'arr');
	}
	if(!$mas){$mas='';}
	if(!$kv){$kv='';}
	list($srvClinic,$srvName)=get_val('xry_m_services','clinic,name_'.$lg,$srv);
		$data=getServItem($srv);		
		$storage=getSubStorge($userSubType);
		$action='';
		if($storage && $data){
			$action="newCons(".$storage.",'".$data."','prvXCost(".$id.",[data])',' ( ".get_val('xry_m_services','name_'.$lg,$srv)." )')";
		}		
		$srvs=getTotalCO('xry_x_visits_services',"visit_id='$vis'");
		//echo dicom_link($pat,$id,1);		
		?>
		<div class="fl lh40 f1 fs16 pd5"><?=$srvName?></div>^<?		
		if($s_status==0){
			?>
			<form name="x_rep_form" id="x_rep_form" action="<?=$f_path?>X/xry_preview_x_report_save.php" method="post" cb="xry_prv_srvs(<?=$vis?>,<?=$id?>);<?=$action?>" bv=""fix="wp:0|hp:0">
				<input type="hidden" name="id" value="<?=$id?>"/>
				<input type="hidden" name="opr" value="1"/>
				<div class="fl" fix="wp:0|hp:0" >
				<div class="fl ofx so r_bord pd10" fix="wp%:32|hp:0">
					<div class="fs16 ff lh40 B">DICOM : </div>
					<div id="dicomH"><?=dicom_link($pat,$id,2,1,'dicomH');?></div>
					<div class="hh10"></div>
					<div class="fs14 f1 lh40 "><?=k_report_photoes?> :</div>
					<? $cData=getColumesData('a0qs2dbv9y',1);?>
					
					<div><?=co_getFormInput(0,$cData['m6m8y467sx'],$photos,0,1);?></div>
					<div class="fs14 f1 lh40 "><?=k_pic_areas?> :</div>
					<div id="xParts" class="fl w100">					
						<div class="fl ic40 ic40_edit icc1" onclick="selXPart(<?=$srv?>,'<?=$part?>')"></div>
						<span id="partTxt">
						<? foreach($parts as $p){ echo '<div class="fr cMulSel">'.$p.'</div>';}?></span>
						<input type="hidden" name="part" id="partIn" value="<?=$part?>" />
					</div>
					<div class="fs16 ff lh40 B">MAS : </div>
					<div><input type="number" name="mas" value="<?=$mas?>" /></div>
					<div class="lh20 clr9 lh20 "><?=k_val_between?> 1 - 400</div>
					<div class="hh10"></div>
					<div class="fs16 ff lh40 B">KV : </div>
					<div><input type="number" name="kv" value="<?=$kv?>" /></div>
					<div class="lh20 clr9 lh20"><?=k_val_between?> 30 - 125</div>
					<div class="hh10"></div>
					<div class="fs14 f1 lh40 "><?=k_film_size?> : </div>
					<div><?=selectFromArray('film',$films,0,1,$film)?></div>
					<div class="hh10"></div>
					<div class="fs14 f1 lh40 "><?=k_req_doc_rep?> :</div>
					<div><?
					if($doc_ord){
                        if($visit_link){
						  $doc_id=get_val('xry_x_visits_requested','doc',$doc_ord);
                          $docName=get_val('_users','name_'.$lg,$doc_id);
                        }else{                            
                            $docName=get_val('gnr_m_doc_req','name',$doc_ord);
                        }
						echo '<div class="f1 fs16 clr1">'.$docName.'</div>';
					}else{
						$cData=getColumesData('a0qs2dbv9y',1,'1j8mrbbsvw');	
						echo co_getFormInput(0,$cData['1j8mrbbsvw'],$doc_ask,0,1);
					}?>
					</div>
				</div>
				<div class="fl of " fix="wp%:68|hp:0"><? 
					if($thisGrp=='nlh8spit9q'){?>
						<div class="fl w100 lh50 b_bord pd10" >
							<div class="fl f1 fs18 lh60 "><?=k_report?></div><?
							if($s_status==0){?>
								<div class="fr ic40x icc4 ic40_done ic40Txt mg10v mg5" onclick="saveRep();"><?=k_ed_srv?></div><?
							}
							if($s_status==0 && $srvs>1){?>
								<div class="fr ic40x icc2 ic40_del ic40Txt mg10v mg5" title="<?=k_cncl_serv?>" onclick="xry_caclSrv(<?=$id?>,1)"><?=k_cncl_serv?></div><?
							}?>
							<div class="fr ic40 ic40_edit icc1 ic40Txt mg10v mg5" repEdit ><?=k_report_write?></div>
						</div>
						<div class="ofx so w100 pd10f" fix="hp:60">						
							<div class="xRepView cbg444 pd10f bord"><?=$report?></div>
						</div>
						<?
					}else{?>
						<div class="fl w100 lh50 b_bord pd10" >
							<div class="fl f1 fs18 lh60 "><?=k_procedure?></div><?
							if($s_status==0){?>
								<div class="fr ic40x icc4 ic40_done ic40Txt mg10v mg5" onclick="saveRep();"><?=k_ed_srv?></div><?
							}?>
						</div>
						
						<div class="fl pd10f mg10v" inputHolder>				
							<div class="radioBlc" req="1">
								<input type="radio" name="opr" value="1"/><label><?=k_end?></label>
								<input type="radio" name="opr" value="2"/><label><?=k_send_to_dr?></label>
							</div>				
						</div><? 
					}?>
				</div>
				</div>
			</form>
			<?
		}else{
			if($s_status==1 || $s_status==6){?>
				<div class="of" fix="wp:0|hp:0">
					<div class="fl r_bord" fix="hp:0|w:320">
						<div class="lh60 b_bord pd10 f1 fs18 of" fix="h60"><?=k_main_inf?></div>
						<div class="pd10f ofx so" fix="hp:40"><?
							if($mas){echo '<div class="fs16 lh30 fl w100">MAS :  <ff class="clr1">'.$mas.'</ff></div>';}
							if($kv){echo '<div class="fs16 lh30 w100">KV :  <ff class="clr1">'.$kv.'</ff></div>';}
							if($film){echo '<div class="fs16 lh30 f1">'.k_film_type.' : <ff class="clr1">'.$films[$film].'</ff></div>';}
							if($doc_ask){
								echo '<div class="fs16 lh30 f1">'.k_doc_req_rep.' : <span class="fs16 lh40 f1 clr1">'.get_val('gnr_m_doc_req','name',$doc_ask).'</span></div>';
							}
							if($part){
								echo '<div class="fs16 lh30 f1">'.k_photo_area.' : <span class="fs16 lh40 f1 clr1">'.get_vals('xry_m_services_parts','name'," id IN ($part) " ,' | ').'</span></div>';
							}?>
							<div class="cb"><?=dicom_link($pat,$id,3);?></div>
							<? if($photos){?>														
								<div class="cb pd10v"><?=imgViewer($photos,280,160)?></div>
							<? }?>
						</div>
					</div>
					<div class="fl" fix="hp:0|wp:320">
						<div class="fl w100 lh50 b_bord pd10" fix="">
							<div class="fl f1 fs18 lh60 "><?=k_report?></div><?
							if($thisGrp=='nlh8spit9q'){
							if($s_status==1 && $vis_status==1){?>
								<div class="fr ic40x br0 icc4 ic40_print ic40Txt mg10v mg5" onclick="x_report_print(<?=$id?>)"><?=k_print?></div>
								<div class="fr ic40w br0 icc1 ic40_edit ic40Txt mg10v mg5" onclick="xry_openSrv(<?=$id?>)"><?=k_open_srv_again?></div><?
							}
							if($s_status==4 && $vis_status==1){?>
								<div class="fl ic40x br0 icc1 ic40_ref ic40Txt mg10v mg5" title="<?=k_repeat?>" onclick="xry_caclSrv(<?=$id?>,2)"></div><?
							}
							}?></div>
						<div  class="pd10f ofx so" fix="hp:40">
						<div class="xRepView cbg444 pd10f bord"><?=$report?></div>
						</div>
					</div>
				</div><?
			}else{
				echo '<div class="f1 fs16 clr5 lh40">'.$ser_status_Tex[$s_status].'</div>';
			}?>
			<div class="lh40">&nbsp;</div>					
		<?}
	}
}else{out();}?>
