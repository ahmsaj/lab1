<? include("../../__sys/mods/protected.php");?>
<?
$visit_id=pp($_GET['m_id']);
//if(_SET_nt5ml0o07f && $thisUser==189){echo loc('_Preview-Clinics.'.$visit_id);}
list($doctor,$patient_id)=get_val('cln_x_visits','doctor,patient',$visit_id);?>
<script src="<?=$m_path?>library/Highcharts/highcharts.src.js"></script>
<script src="<?=$m_path?>library/Highcharts/highcharts-more.js"></script><?
$mood=1;
$anType=_set_9jfawiejb9;
if($anType==1){
	$anaTops=getTotalCO('lab_x_visits_requested',"patient='$patient_id' and status < 3 ");
}else{
	$anaTops=getTotalCO('cln_x_pro_analy',"p_id='$patient_id' and view=0 ");
}
if($doctor==0){
	mysql_q("UPDATE cln_x_visits SET doctor='$thisUser' where id='$visit_id' ");
	mysql_q("UPDATE cln_x_visits_services SET doc='$thisUser' where visit_id='$visit_id' ");
	$doctor=$thisUser;
}
$clinic=$userSubType;
list($diagnosis,$compl,$m_pat)=get_val('gnr_m_clinics','diagnosis,complaint,m_patients',$clinic);
$swAction='';
if($m_pat){$swAction='onclick="loadPrvSwitch();"';}
	
if($thisUser==$doctor){
	$sql2="select * from cln_x_visits where id='$visit_id' and doctor='$doctor' limit 1";
	$res2=mysql_q($sql2);
	$rows2=mysql_n($res2);
	if($rows2>0){
		$r2=mysql_f($res2);
		$doctor=$r2['doctor'];
		$patient_id=$r2['patient'];
		$d_start=$r2['d_start'];
		$d_check=$r2['d_check'];
		$type=$r2['type'];
		$sub_type=$r2['sub_type'];
		$status=$r2['status'];
		$clinic=$r2['clinic'];
		$ref=$r2['ref'];
		$ref_no=$r2['ref_no'];
		$ref_date=$r2['ref_date'];
		$pay_type=$r2['pay_type'];
		$pay_type_link=$r2['pay_type_link'];
		if($d_check==0){mysql_q("UPDATE cln_x_visits set d_check='$now' where id='$visit_id' ");}
		mysql_q("UPDATE gnr_x_roles set doctor='$thisUser' where vis='$visit_id' and mood=1");
		if($status==2 || $status==3){
			mysql_q("UPDATE gnr_x_roles set status=4 where vis='$visit_id' and mood=1");
			delTempOpr($mood,$visit_id,'a');
			if($status==3){
				loc('_Visits');
				exit;
			}
		}
		if($pay_type==3){
			mysql_q("UPDATE gnr_x_insurance_rec SET doc='$thisUser' where doc=0 and visit='$visit_id' and mood = 1 ");
		}
		if($type==2){$typ_text=$rev_type_arr[$sub_type];}
		$sql="select * from gnr_m_patients where id='$patient_id' limit 1";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$r=mysql_f($res);
			$sex=$r['sex'];
			$birth=$r['birth_date'];
			$birthCount=birthCount($birth);
			$blood=$r['blood'];
			$p_title=$r['title'];
			if($p_title){
				$col=getColumesData('',0,'h4ljv9q3qf');		
				$p_titleTxt=viewRecElement($col[0],$p_title);
			}
			$B2='';
			if($blood==''){$B2='blod_box_0';}
			$bloodStyle=str_replace('+','1',$blood);
			$bloodStyle=str_replace('-','0',$bloodStyle);
			$patName=get_p_name($patient_id,0);?>
			<script>sezPage='Preview-Clinic';</script>
			<header>
			<div class="top_txt_sec fl">
				<div class="top_title fl f1" fix="h:30" onclick="patInfo(<?=$patient_id?>)">
					<ff><?=$patient_id?></ff> | <?=$p_titleTxt.' '.$patName?>
				</div>
				<div class="fl lh30 w100" fix="h:30">					
					<div class="fl inf_name f1 fs12 lh30 of" fix="h:30"><ff><?=$birthCount[0]?> </ff><?=$birthCount[1]?></div>        	
					 <? 
					if($pay_type==2){				
						$name_ch=get_val('gnr_m_charities','name_'.$lg,$pay_type_link);
						echo '<div class="fr  f1 fs12 pd10">'.$name_ch.' </div>';
					}
					if($pay_type==3){				
						echo '<div class="fr f1 fs14 clr55 pd10 lh30">'.k_ins_patient.'</div>';
					}?>
					<div class="fr blod_box ff <?=$B2?>" b="<?=$blood?>"><?=$blood?></div>
				</div>
				
			</div>
			<div class="top_icons">
				<? echo topIconCus(k_end,'cbg5 ti_77 fr','finshSrv(0,'.$status.')');?>
				<div class="fr timeStatus" id="timeStatus" <?=$swAction?> >
					<div line>            	
						<div icon class="fr"></div>                
						<div class="fr ff fs18 B" num id="stu_1"><?=getTotalCO("gnr_x_roles","status < 3 and clic='$clinic' and mood=1 ");?></div>
					</div>
					<div line2>
						<div class="fr" icon2></div>
						<div class="fr ff fs18 B" num2 id="stu_2"><?=dateToTimeS2(getDocWorkTime($visit_id,$clinic))?></div>
					</div>            
				</div>
				<div class="fr swWin so"></div>				
				<?
				echo topIconCus('','ti_0 fr','open_Tools()');
				//echo topIconCus(k_consumables,'fr cost_icon','newCons('.$userStore.',\'\',\'docCostAdd([data])\',\'\')');
				if(chProUsed('dts')){
					echo topIconCus(k_appointments,'ti_date fr','selDtSrvs('.$clinic.',0,'.$patient_id.')');
				}
				if(modPer('b8kpe202f3','0')){
					echo topIconCus(k_documents,'ti_docs fr','patDocs('.$patient_id.',1)');			
				}
				echo topIconCus(k_med_rec,'ti_card fr','pat_hl_rec(1,'.$patient_id.',\''.$patName.'\')');
				?>
				<div class="bloods">
				<div class="fr" co="o+"><div class="bloo_o1"></div></div>
				<div class="fr" co="a+"><div class="bloo_a1"></div></div>
				<div class="fr" co="b+"><div class="bloo_b1"></div></div>        
				<div class="fr" co="o-"><div class="bloo_o0"></div></div> 
				<div class="fr" co="a-"><div class="bloo_a0"></div></div>            
				<div class="fr" co="b-"><div class="bloo_b0"></div></div>        
				<div class="fr" co="ab+"><div class="bloo_ab1"></div></div>                   
				<div class="fr" co="ab-"><div class="bloo_ab0"></div></div>        
				<div class="fr" co=""><div class="bloo_"></div></div>

			</div>
			</div>
			<div class="toolsCont fr">        
				<div class=" ti_1 fr" onclick="prescrs(<?=$mood?>,0)" title="<?=k_precpiction?>"></div>
				<div class=" ti_2 fr" onclick="Analysis(0,<?=$anType?>)" title="<?=k_tests?>">
				<aside class="topNav ff top_ana_star">0</aside></div>
				<div class=" ti_3 fr" onclick="m_xphoto(0)" title="<?=k_radiograph_s?>">
				<aside class="topNav ff top_xp_star">0</aside></div>
				<div class=" ti_5 fr" onclick="operations(0)" title="<?=k_operations?>">
				<aside class="topNav ff top_opr_star">0</aside></div>
				<div class=" ti_4 fr" onclick="med_report()" title="<?=k_med_report?>"></div>
				<div class=" ti_8 fr" onclick="visNote()"title="<?=k_notes?>"></div>
				<div class=" ti_6 fr" onclick="assignment(0)"title="<?=k_referral?>"></div>        
				<div class=" ti_back fr" onclick="loc('_Visits')"title="<?=k_back?>"></div>
			</div>
			</header>
			<div class="centerSideInHeaderFull" style="height:40px;"><div class="datesline w100" id="prv_slider"></div></div>
			<div class="centerSideInFull of">
				<section class="tab16">
					<div class="tabs">
						<div icon="tab_p4" onclick="loadHistory(<?=$patient_id?>,0);"><?=k_visits_his?></div>
						<div icon="tab_p2" onclick="loadMadInfo()"><?=k_pat_his?></div>
						<? if(_set_xpjzniebu8){?>
							<div icon="tab_p1" onclick="loadVital(1)"><?=k_vital_signs?></div>
						<? }?>
						<div icon="tab_p3" onclick="view_list(1)"><?=k_complaints?></div>
						<? if(_set_i1aju4t6ig){?>
							<div icon="tab_p3" onclick="view_list(3)"><?=k_sick_story?></div>
						<? }?>
						<? if(_set_krtv65ih){?>
							<div icon="tab_p3" onclick="view_list(4)"><?=k_clincal_examination?></div>
						<? }?>
						<div icon="tab_p3" onclick="view_list(2)"><?=k_diagnoses?></div>
						<div icon="tab_p1" onclick="rev_ref(1,<?=$visit_id?>)"><?=k_services?></div>
						<!--<div icon="tab_p2" onclick="rev_ref(1,<?=$visit_id?>)"><?=k_pat_his?></div>-->
					</div>
					<div class="tabc">
						<section class="so"><div class="his_cont so" id="p_his"></div></section>
						<section class="mad_info so" id="madInfo"></section>
						<? if(_set_xpjzniebu8){?><section class="so" id="vital_p"></section><? }?>			
						<section class="so" type="static"><? 
							if(_set_sz8xmnxwfe){?>
								<div class="r_bord fl so" fix="w:640|hp:5">
									<div class="lh40 uLine" fix="wp:10">
									<input type="text" placeholder="<?=k_search?>" id="complaSr"/></div>
									<div class="fl ofx so" fix="w:313|hp:60" id="complaCats"><?=get_complCat($compl)?></div>
									<div class="fl ofx so" fix="w:313|hp:60" id="complaCdet">
										<div class="f1 fs14 clr1 lh40 pd10"><?=k_choose_cat_complaints?></div>
									</div>          	
								</div>
								<div class="fl pd10" fix="wp:665|hp:5">
									<div class="f1 blc_win_title bwt_icon2"><?=k_spe_complaints?></div>
									<div class="ofx so" fix="hp:50">						
										<table width="100%" id="complaSel" border="0" cellspacing="0" cellpadding="6" class="grad_s " type="static">
										<?
										$sql="select * from cln_x_prv_icpc  where `visit` ='$visit_id' ";
										$res=mysql_q($sql);
										while($r=mysql_f($res)){
											$id=$r['opr_id'];
											list($code,$name)=get_val('cln_m_icpc','code,name_'.$lg,$id);
											echo '<tr id="Crow'.$id.'"><td><ff>'.$code.'</ff></td><td txt>'.$name.'</td><td width="30"><div class="ic40 icc2 ic40_del" onclick="compla_del('.$id.')"></div></td></tr>';
										}
										?>
										</table>										
									</div>
								</div><?				
							}else{?>
								<div class="listDataSelCon">
									<div class="fl addToList" onclick="addToList(1)" title="<?=k_add?>"></div>  
									<div class="fl listDataSel"><input type="text" id="serList1" onkeyup="view_list_Ser(1)" placeholder="<?=k_find_complaint?>" /></div>                                          		
								</div>                    
								<div class="proTab_in fl">
									<div class="listData fl">
										<div class="list_option so" id="list_option1"></div>
									</div>
									<div  class="option_selected so fl" id="sel_option1"><?=ThisVisitItem($visit_id,1)?></div>
								</div><? 
							}?>
						</section>			
						<? if(_set_i1aju4t6ig){?>
						<section class="so">                
							<div class="listDataSelCon">
								<div class="fl addToList" onclick="addToList(3)" title="<?=k_add?>"></div>  
								<div class="fl listDataSel"><input type="text" id="serList3" onkeyup="view_list_Ser(3)" placeholder="<?=k_ser_sikhis?>" /></div>                                          		
							</div>                    
							<div class="proTab_in fl">
								<div class="listData fl">
									<div class="list_option so" id="list_option3"></div>
								</div>
								<div  class="option_selected so fl" id="sel_option3"><?=ThisVisitItem($visit_id,3)?></div>
							</div>                                  
						</section>
						<? }?>
						<? if(_set_krtv65ih){?>
						<section class="so">                
							<div class="listDataSelCon">
								<div class="fl addToList" onclick="addToList(4)" title="<?=k_add?>"></div>  
								<div class="fl listDataSel"><input type="text" id="serList4" onkeyup="view_list_Ser(4)" placeholder="<?=k_ser_cln_exm?>" /></div>                                          		
							</div>                    
							<div class="proTab_in fl">
								<div class="listData fl">
									<div class="list_option so" id="list_option4"></div>
								</div>
								<div  class="option_selected so fl" id="sel_option4"><?=ThisVisitItem($visit_id,4)?></div>
							</div>                                  
						</section>
						<? }?>
						<section class="so"><?
							if(_set_zlb9c4n8xm){?>
								<div class="r_bord fl so" fix="w:640|hp:5">
									<div class="lh40 uLine" fix="wp:10">
									<input type="text" placeholder="<?=k_search?>" id="diagnSr"/></div>
									<div class="fl ofx so" fix="w:313|hp:60" id="diagnCats"><?=get_diagnCat($diagnosis)?></div>
									<div class="fl ofx so" fix="w:313|hp:60" id="diagnCdet">
										<div class="f1 fs14 clr1 lh40 pd10"><?=k_choose_cat_diagnoses?></div>
									</div>          	
								</div>
								<div class="fl pd10" fix="wp:665|hp:5">
									<div class="f1 blc_win_title bwt_icon2"><?=k_spe_diagnostics?></div>
									<div class="ofx so" fix="hp:50">						
										<table width="100%" id="DiagnSel" border="0" cellspacing="0" cellpadding="6" class="grad_s " type="static">
										<?
										$sql="select * from cln_x_prv_icd10  where `visit` ='$visit_id' ";
										$res=mysql_q($sql);
										while($r=mysql_f($res)){
											$id=$r['opr_id'];
											list($code,$name)=get_val('cln_m_icd10','code,name_'.$lg,$id);
											echo '<tr id="CDrow'.$id.'"><td><ff>'.$code.'</ff></td><td txt>'.$name.'</td><td width="30"><div class="ic40 icc2 ic40_del" onclick="diagn_del('.$id.')"></div></td></tr>';
										}
										?>
										</table>										
									</div>
								</div><?				
							}else{?>
								<div class="listDataSelCon">
								<div class="fl addToList" onclick="addToList(2)" title="<?=k_add?>"></div> 
								<div class="fl listDataSel"><input type="text" id="serList2" onkeyup="view_list_Ser(2)" placeholder="<?=k_find_diagnoses?>" /></div> 
							</div>
								<div class="proTab_in fl">      
								<div class="listData fl">                   
									<div class="list_option so" id="list_option2"></div>
								</div> 
								<div  class="option_selected so fl" id="sel_option2"><?=ThisVisitItem($visit_id,2)?></div>
							</div>
							<? }?>
						</section>
						<section class="mad_info2 so" id="sevises_list"></section>
						<section class="of">                
							<div class="f1 fs18 clr1 lh50 uLine"><?=k_pat_his?> 
								<div class="fr ic40 icc1 ic40_add" onclick="madhisCatAdd()" title="<?=k_add?>"></div>
							</div>                    
							<div class=" ofx so" fix="hp:60|pw:0"

							</div>                                  
						</section>
					</div>
				</section> 
			</div>
			<script>
				var visit_id=parseInt(<?=$visit_id?>);
				var patient_id=<?=$patient_id?>;	
				//loadMadInfo();	
				//pre_timer="<?=$d_check?>";
				//var timer2=setTimeout(function(){pro_timer()},100);
				$(document).ready(function(e){
					rev_ref(1,<?=$visit_id?>);refPage(2,10000);		
					getTopStatus(<?=$anaTops?>,1);		
					getTopStatus(<?=getTotalCO('xry_x_visits_requested',"patient='$patient_id' and status < 3 ")?>,2);		
					getTopStatus(<?=getTotalCO('cln_x_pro_x_operations',"p_id='$patient_id' and status=0 and  doc='$doctor'")?>,3);
					<? if(_set_xpjzniebu8){?>diagnosisSet();complaintSet();<? }?>
					changTab('0-7');
					fixPage();
					//view_list(1);
					//assignment(0);
					//newAssignment(0);
					//Analysis(0,<?=$anType?>)
					//newAnalysis(0)
					//prescr(1);
					//showVd(325,0)
					//m_xphoto(0)
					//operations(0) 
					//new_operation(0)
					//opr_tools()
					//new_xphoto(0,22,2,'')	

				});
				//Dwidth=718

			</script><? 
		}
	}
}else{
	$status=get_val('cln_x_visits','status',$visit_id);
	if($status==2 || $status==3){
		delTempOpr($mood,$visit_id,'a');
	}
	loc('_Visits');
}
?>