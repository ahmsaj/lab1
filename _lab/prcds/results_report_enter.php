<? include("../../__sys/prcds/ajax_header.php");?>
<div class="win_body"><?
if(isset($_POST['id'] , $_POST['t']) ){
	$id=pp($_POST['id']);
	$t=pp($_POST['t']);	
	$tCol=4;
	$servisEntered=array();
	$q1=" srv='$id' ";
	if($t==1){
		$services=$id;
		list($vis,$pat,$status)=get_val('lab_x_visits_services','visit_id,patient,status',$id);
		$q= "and x.id ='$id' ";		
	}
	if($t==2){
		list($vis,$smp_status,$pat,$services)=get_val('lab_x_visits_samlpes','visit_id,status,patient,services',$id);	
		$q= "and x.id IN($services)";
	}
	if($t==3){
		$vis=$id;
		//$pat=get_val('lab_x_visits','patient',$id);
		$q= "and visit_id ='$vis' ";
	}
	if($t==4){
		$q= " and x.service= '$id' ";
	}
	$action='showLReport('.$id.','.$t.')';
	list($pat,$pay_type,$d_start)=get_val('lab_x_visits','patient,pay_type,d_start',$vis);
	list($sex,$age)=getPatInfoL($pat);
	$patInfo=getPatInfo($pat,0,$d_start);
	$xVales=array();
	$edtebal=0;	
	//if($t==1){
		if($status==9){
			$sql="select * from lab_x_visits_services_results_x where $q1 and status=0";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				while($r=mysql_f($res)){
					$x_id=$r['x_id'];
					$value=$r['value'];
					$x_ser_id=$r['x_ser_id'];
					array_push($xVales,$x_ser_id);
				}
			}	
		}
	//}
	?>
	<div class="form_header lh40">
	<div class="lh40 fs20 ff B clr5 ws "><?=$name?></div>
		<div class="ic40 icc2 ic40_ref fr" onclick="<?=$action?>"></div>
		
		<? if($t==4){?>
			<div class="fl lh40 fs18 f1s clr1111"><?=get_val('lab_m_services','short_name',$id);?></div><?
		}else{
			if($pay_type==0 && modPer('kyanxtrckr',1)){?>
			<div class="ic40 icc1 ic40_add fr" onclick="addSrvToVis(<?=$vis?>)" title="<?=k_add_visit_srv?>"></div>
			<? }?>
			<div class="fl lh30 fs16 f1s clr1 ws"><ff><?=$pat?></ff> | <?=$patInfo['n'].' (	<span class="f1 fs16 clr1111"> '.$patInfo['s'].' </span> '.$patInfo['b'].' )';?></div><?
		}?>
	</div>
	<div class="form_body so" type="">
	<form name="lr_form" id="lr_form" action="<?=$f_path?>X/lab_results_report_save.php" method="post"  cb="resvLSNoDo3();win('close','#m_info2');loadFitterCostom('lab_results_sample_info')" bv="">
	<input type="hidden" name="id" value="<?=$id?>"/>
	<input type="hidden" name="id_type" value="<?=$t?>"/><?
		$enterData='';
		$stts='5,6,9,10';
		if($t!=4){
			if(_set_6up2tju3gl==2){$stts='5,6,7,8,9,10';}
			if(_set_6up2tju3gl==3){$stts='1,5,6,7,8,9,10';}
		}
		$sql="select * , z.id as z_id ,x.id as x_id , patient from lab_x_visits_services x , lab_m_services z where x.service=z.id and status IN($stts) $q order by x.id ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$qu='';
			while($r=mysql_f($res)){
				$srv_id=$r['z_id'];
				$x_id=$r['x_id'];
				$vis_id=$r['visit_id'];
				$name=$r['short_name'];
				$report_de=$r['report_de'];
				$type=$r['type'];
				$sample=$r['sample'];
				$status=$r['status'];
				$serNote=$r['note'];
				if($t==4){
					$pat=$r['patient'];
					list($sex,$age)=getPatInfoL($pat);
				}
				$Sclr='1';
				if($serNote){$Sclr='2';}				
				$edtebal=editebalAna($status);
				if($edtebal){
					if($type==2){
						echo '<input type="hidden" name="res_type" id="res_type" value="0"/>';
					}
					if($type==1 || $type==4){						
						$sql3="select * from lab_m_services_items where serv='$srv_id' and act=1 order by ord ASC  ";
						$res3=mysql_q($sql3);
						$rows3=mysql_n($res3);
						$tNote='';
						if($t==1 || $rows3==1){
							array_push($servisEntered,$x_id);
							
							if($rows3>1){
								$enterData.='<tr><td class="f1 fs16 cbg4"></td><td colspan="'.($tCol).'" class="f1 fs16 cbg44">'.splitNo($name).'</td>
								<td><input type="text" class="hide" name="note_'.$x_id.'" id="i_'.$x_id.'" value="'.$serNote.'" placeholder="'.k_notes.'"/><div class="ic40x ic40_c'.$Sclr.' ic40_det" id="b_'.$x_id.'" onclick="anaAddNote('.$x_id.')" title="'.k_add_note.'"></div></td></tr>';
							}else{
								$tNote='<input type="text" class="hide" name="note_'.$x_id.'" id="i_'.$x_id.'" value="'.$serNote.'" placeholder="'.k_notes.'"/><div class="ic40x icc'.$Sclr.' ic40_det" id="b_'.$x_id.'" onclick="anaAddNote('.$x_id.')" title="'.k_add_note.'"></div>';
							}
							$i=0;
							while($r3=mysql_f($res3)){
								$i++;
								$mSrv_id=$r3['id'];
								$s_type=$r3['type'];
								$name=$r3['name_'.$lg];
								$unit=$r3['unit'];
								$normal_code=$r3['normal_code'];
								$report_type=$r3['report_type'];
								$last='';
								if($i==$rows3 && $rows3>1){$last='last';}
								$enterData.='<tr b '.$last.'>';
								list($r_id,$val,$vsr_id)=get_LR_res($x_id,$mSrv_id);
								$bgB='s';
								if($val=='xXx'){$bgB='n';$val='';}
								$xRes=$bgB='';
								if(in_array($mSrv_id,$xVales)){
									$xRes='<div class="f1 fs16 clrw lh30 ">'.k_result_intercepted.'</div>';
									$bgB='cbg5';
								}
								list($code_txt,$unitTxt)=get_val('lab_m_services_units','code,name_'.$lg,$unit);
								list($norV,$addVals,$nor_d,$nor_d2,$nor_note)=get_LreportNormalVal($report_type,$mSrv_id,$vis_id,$sex,$age,$sample);
								//$out.='<div b >
								if($s_type==1){
									$enterData.='<td class="f1 fs16 TC clrw cbg3" width="1" colspan="'.($tCol+2).'">'.splitNo($name).'</td>';
								}else{
									$enterData.='<td class="f1 fs14 clr1" width="1"></td>
									<td class="f1 fs12 clr1">';
									if($t==4){
										$pa_txt=get_p_name($pat,3);
										//$enterData.=get_p_name($anaPatient);
										$enterData.='<div class="f1s fs12">'.$pa_txt[0].' <br><span class="">( '.$pa_txt[1].' ) '.$sex_types[$pa_txt[4]].'</span>';

									}else{
										if(in_array($report_type,array(1,2,4,7))){
											$enterData.='<div class="f1 fs14 clr55 Over" onclick="prlChartFL('.$pat.','.$mSrv_id.')">'.splitNo($name).'</div>';
										}else{
											$enterData.=splitNo($name);
										}
									}
									$enterData.='</td>';
									if($t==4){$enterData.='<td><ff>'.date('Y-m-d',get_val('lab_x_visits','d_start',$vis_id)).'</ff></td>';}
									$rrInput=' ';
									if($report_type==5 || $report_type==6){$rrInput=' colspan="3" ';}
									$enterData.='<td class="f1 fs14 clr1 '.$bgB.' " '.$rrInput.' >'.$xRes.get_LreportInput($report_type,$mSrv_id,$vis_id,$sex,$age,$val,$addVals).'</td>';
									if($report_type!=5 && $report_type!=6){
										$enterData.='<td class="ff B fs14" title="'.$unitTxt.'">'.$code_txt.'</td>
										<td class="ff B clr1" >
										<div>'.$nor_d.'</div>
										<div>'.$nor_d2.'</dv></td>';
									}
									$enterData.='<td>'.$tNote.'</td>';
								}
								$enterData.='</tr>';

							}
							list($q,$q_type)=get_vals('lab_m_services_equations','equations,type',"ana_no='$srv_id'");
							$q_txt=getaQNames($q_type,$q);							
						}
					}
					if($type==2 && $t==1){
						array_push($servisEntered,$x_id);
						$rec=getRec('lab_x_visits_services_result_cs',$id,'serv_id');
						if($rec['r']){							
							$ss_val=$rec['val'];
							$ss_sample_type=$rec['sample_type'];
							$ss_colonies=$rec['colonies'];
							$ss_level=$rec['level'];
							$ss_bacteria=$rec['bacteria'];
							$ss_wbc=$rec['wbc'];
							$ss_rbc=$rec['rbc'];					
							$ss_note=$rec['note'];
							$ss_status=$rec['status'];					
						}
						?>
						<script>//changeResType(3)</script>
						<div class="fl" id="blc1">
							<div class="f1 fs16 clr5 lh40"><?=k_sams_sts?></div>
							<div class="bu bu_t4 fl" onclick="changeResType(1)"><?=k_sound?></div>
							<div class="bu bu_t3 fl" onclick="changeResType(2)"><?=k_polluter?></div>
							<div class="bu bu_t1 fl" onclick="changeResType(3)"><?=k_detal_rep?></div>
						</div>
						<div class="hide" id="blc2">				
							<div class="lr_int fl ofx so">								
								<div class="f1 clr1 lh30"><?=k_type_sample?></div>
								<div>
									<select name="s_type" id="swabs_types"><option value="0"></option><?
										$sql="select * from lab_m_test_swabs order by name ASC";
										$res=mysql_q($sql);
										$rows=mysql_n($res);
										if($rows>0){
											while($r=mysql_f($res)){
												$s_id=$r['id'];
												$name=$r['name'];
												$colonies=$r['colonies'];
												$sel='';
												if($s_id==$ss_sample_type){$sel=' selected ';}
												echo '<option value="'.$s_id.'" '.$sel.' c="'.$colonies.'">'.$name.'</option>';
											}
										}?>
									</select>
								</div>
								
								<div class="hide" id="sw_colon">
									<div class="f1 clr1 lh30"><?=k_num_colons?></div>
									<input name="colonies" type="number" value="<?=$ss_colonies?>"/>
								</div>
								<div class="f1 clr1 lh30"><?=k_lvl_grow?></div>
								<select name="level">
									<option value=""></option>
									<option value="1">Mild</option>
									<option value="2" <? if($ss_level==2){echo ' selected ';}?> >Moderate</option>
									<option value="3" <? if($ss_level==3){echo ' selected ';}?> >Severe</option>
								</select>

								<div class="f1 clr1 lh30"><?=k_bacteria?></div>
								<div><?=make_Combo_box('lab_m_test_bacterias','name','id','','bact',0,$ss_bacteria)?></div><? 
								//if($type==2){?>
									<div class="f1 clr1 lh30"ً>W.B.C</div>
									<input name="wbc" type="text" value="<?=$ss_wbc?>"/>
									<div class="f1 clr1 lh30">R.B.C</div>
									<input name="rbc" type="text" value="<?=$ss_rbc?>"/><? 
								//}?>
								<div class="f1 clr1 lh30"><?=k_notes?></div>
								<textarea class="w100" name="note"><?=$ss_note?></textarea>
							</div>
							<div class="lr_list fl ofx so">
								<? $sql="select * from lab_m_test_antibiotics where act=1 order by ord ASC";
								$res=mysql_q($sql);
								$rows=mysql_n($res);
								if($rows>0){
									$antiEditVal=getAntiEditVal($id);
									echo '<table width="100%"  cellspacing="0" cellpadding="4" class="grad_s holdH" type="static">
									<tr><th>'.k_antibiotics.'</th><th>'.k_repellent_code.'</th><th>'.k_val.'</th><th>'.k_avrg.'</th><th>'.k_trade_name.'</th></tr>';
									while($r=mysql_f($res)){
										$n_id=$r['id'];
										$n_name=$r['name'];
										$trad_name=$r['trad_name'];
										$code=$r['code'];
										$min_val=$r['min_val'];
										$max_val=$r['max_val'];
										echo '<tr>
										<td>'.$n_name.'</td>
										<td><ff class="clr1">'.$code.'</ff></td>
										<td><input type="number" name="anti_'.$n_id.'" antib="'.$n_id.'" style="width:120px;"  s="'.$min_val.'" b="'.$max_val.'" value="'.$antiEditVal[$n_id]['val'].'"/><ff class="LiCode" id="code'.$n_id.'">'.$antiEditVal[$n_id]['code'].'</ff></td>
										<td>'.$min_val.'-'.$max_val.'</td>
										<td>'.$trad_name.'</td>
										</tr>';
									}							
									echo '</table>';
								}
								?>
							</div>
						</div><? 
					};
					if($type==5 && $t==1){
						array_push($servisEntered,$x_id);						
						$editVal=get_val_c('lab_x_visits_services_results','value',$x_id,'serv_id');
						$sql2="select * from lab_m_test_mutations where act=1 order by name ASC";
						$res2=mysql_q($sql2);
						$rows2=mysql_n($res2);
						if($rows2>0){
							$antiEditVal=getAntiEditVal2($editVal);
							echo '<table width="" cellspacing="0" cellpadding="4" class="grad_s " type="static" >';
							while($r2=mysql_f($res2)){
								$n_id=$r2['id'];
								$n_name=$r2['name'];
								$tranTr='';
								$tranV2='hide';
								$c1='checked';
								$m1_1='checked';$m1_2='';
								$m2_1='checked';$m2_2='';
								if($editVal){
									if(!$antiEditVal[$n_id]){
										$c1='';$tranTr='tranTr';
									}else{						
										$v1=$antiEditVal[$n_id]['v1'];
										$v2=$antiEditVal[$n_id]['v2'];
										if($v1==1){
											$m1_1='';$m1_2='checked';
											$tranV2='';
											if($v2==2){$m2_1='';$m2_2='checked';}
										}
									}
								}					
								echo '<tr id="mtr'.$n_id.'" class="'.$tranTr.'">
								<td><input name="mut_c_'.$n_id.'" par="mutr" type="checkbox" '.$c1.' /></td>
								<td>'.$n_name.'</td>
								<td>
									<div class="radioBlc" oc="chcklabFmfVal('.$n_id.',[v])" >
										<input type="radio" name="mut_'.$n_id.'" par="m0" '.$m1_1.' value="0"/><label>'.$lab_res_fmf_types[0].'</label>
										<input type="radio" name="mut_'.$n_id.'" par="m1" '.$m1_2.' value="1"/><label>'.$lab_res_fmf_types[0].'</label>
									</div>
								</td>
								<td>
								<div id="m_'.$n_id.'" class="'.$tranV2.'">
								<div class="radioBlc">
									<input type="radio" name="mut2_'.$n_id.'"  par="m2" '.$m2_1.' checked value="1"/><label>'.$lab_res_fmf_Stypes[1].'</label>
									<input type="radio" name="mut2_'.$n_id.'"  par="m2" '.$m2_2.' value="2"/><label>'.$lab_res_fmf_Stypes[2].'</label>
								</div>
								</div>
								</td>
								</tr>';
							}
							echo '</table>';
						}
					};
				}
				$qu=getR_Qu($srv_id,$qu);
			}
			if(($type==1 || $type==4)){
				echo '
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="grad_lab_enter " >'.$enterData.'</table>';
	
			}else{
				
			}
			if($qu){echo script("equs='".$qu."'");}
		}
		echo '<input type="hidden" value="'.implode(',',$servisEntered).'" name="srvEn"/>'?>
	</form>
	</div>
	<div class="form_fot fr">
		<?
		$edtebal=editebalAna($status);
		if($edtebal){?><div class="bu bu_t3 fl" onclick="win('close','#m_info3');save_rep(<?=$id?>);"><?=k_save?></div><? }?>
		<div class="bu bu_t2 fr" onclick="win('close','#m_info2');loadFitterCostom('lab_results_sample_info')"><?=k_close?></div>
	</div><?		
}?>
</div>