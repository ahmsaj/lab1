<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['opr'],$_POST['ptvis'],$_POST['ptprt'])){
	$pat_id=pp($_POST['id']);
	$opr=pp($_POST['opr']);
	$ptvis=pp($_POST['ptvis']);
	$ptprt=pp($_POST['ptprt'],'s');
	$p_name=get_p_name($pat_id);
	if($p_name){
		if($opr==1){
            if(proAct('cln')){
                $v1=getTotalCO('cln_x_visits'," patient='$pat_id' and status=2 ");
                $v2=getTotalCO('cln_x_visits'," patient='$pat_id' and status=2 and doctor='$thisUser'");
                $p4=getTotalCO('cln_x_visits'," patient='$pat_id' and report!='' ");
				if(is_array($userSubType)){
                	$v3=getTotalCO('cln_x_visits'," patient='$pat_id' and status=2 and clinic in ($userSubType)");
				}else{
					$v3=0;
				}
                $v11=getTotalCO('cln_x_vital'," patient='$pat_id' ");
            }
            if(proAct('lab')){
                $p1=getTotalCO('lab_x_visits'," patient='$pat_id' and status in(2,5,6)");
            }
            if(proAct('xry')){
			    $p2=getTotalCO('xry_x_visits'," patient='$pat_id' and status=2 ");
            }
			$p3=getTotalCO('gnr_x_prescription'," patient='$pat_id'");
			if(proAct('osc')){
			    $p5=getTotalCO('osc_x_visits'," patient='$pat_id' and status=2 ");
            }
			
			$v12=getTotalCO('gnr_x_patients_docs'," patient='$pat_id' ");?>
			<div class="winButts">
			<div class="wB_x fr" onclick="win('close','#full_win4');"></div>
			<!--<div class="wB_x fr" onclick="pat_hl_rec(1,<?=$pat_id?>,'');"></div>-->
			</div>
			<div class="win_body_full h100 of">
				<div class="fxg h100" fxg="gtc:200px 1fr" >
					<div class="pr_src r_bord ofx so pd10">
						<? if(proAct('cln')){?>
						<div class="butPRopt op1" id="op1" actButtE="act">
							<div n1 no="1" act><?=k_all_visits?><span> ( <?=$v1?> )</span></div>
							<div n1 no="2"><?=k_my_visits?> <span> ( <?=$v2?> )</span></div>
							<div n1 no="3"><?=k_clinic_visits?> <span> ( <?=$v3?> )</span></div>
						</div>
						<?}?>
						<div class="butPRopt op2" id="op2" actButtM="act">
							<div a act all><?=k_all_deps?></div>
							<? if(proAct('lab')){?><div n2 act s><?=k_thlab?> <span> ( <?=$p1?> )</span></div><?}?>
							<? if(proAct('xry')){?><div n3 act s><?=k_txry?> <span> ( <?=$p2?> )</span></div><?}?>
							<? if(proAct('osc')){?><div n6 act s><?=k_endoscopy?> <span> ( <?=$p5?> )</span></div><?}?>
							<div n4 act s><?=k_prescriptions?> <span> ( <?=$p3?> )</span></div>
							<div n5 act s><?=k_th_reports?> <span> ( <?=$p4?> )</span></div>
													
						</div>
						<div class="butPRoptIcon" >
							<div i1 onclick="pat_hl_vital(1,<?=$pat_id?>)"><?=k_vital_signs?> <span> ( <?=$v11?> )</span></div>
							<? if(proAct('xry')){echo dicom_link($pat_id,0,4,0);}?>
							<? if(modPer('b8kpe202f3','0')){?>
							<div i3 onclick="patDocs(<?=$pat_id?>,1)"><?=k_documents?>  <span> ( <?=$v12?> )</span></div>
							<? }						
							if(proAct('den')){?>
								<div i4 onclick="patRecDen(<?=$pat_id?>)"> <?=k_dental_procedures?> </div>
							<? }?>
						</div>
					</div>
					<div class="ofx so pd10 h100" id="pr_data"></div>
				</div>
			</div><?
		}else{
            $pLab=$pXry=$pPrc=$pRep=$pOsc=0;
			if(proAct('lab')){$pLab=substr($ptprt,1,1);}
			if(proAct('xry')){$pXry=substr($ptprt,2,1);}
			$pPrc=substr($ptprt,3,1);
			$pRep=substr($ptprt,4,1);
			if(proAct('osc')){$pOsc=substr($ptprt,5,1);}
			$patData=array();
			if($ptvis!=0 && proAct('cln')){
				$q='';
				if($ptvis==2){$q=" and doctor='$thisUser' ";}
				if($ptvis==3){$q=" and clinic in ($userSubType) ";}
				$sql="select * from cln_x_visits  where patient='$pat_id' and status in(2) $q ";
				$res=mysql_q($sql);
				while($r=mysql_f($res)){
					$r_id=$r['id'];
					$d_start=$r['d_start'];				
					$patData[$d_start]['type']=1;
					$patData[$d_start]['id']=$r_id;
					$patData[$d_start]['note']=$r['note'];
				}
			}
			if($pLab){
				$sql="select * from lab_x_visits  where patient='$pat_id' and status in(2,4,5,6)";
				$res=mysql_q($sql);
				while($r=mysql_f($res)){
					$r_id=$r['id'];
					$d_start=$r['d_start'];					
					$patData[$d_start]['type']=2;
					$patData[$d_start]['id']=$r_id;
				}
			}
			if($pXry){
				$sql="select * from xry_x_visits  where patient='$pat_id' and status =2";
				$res=mysql_q($sql);
				while($r=mysql_f($res)){
					$r_id=$r['id'];
					$d_start=$r['d_start'];					
					$patData[$d_start]['type']=3;
					$patData[$d_start]['id']=$r_id;
				}
			}
			if($pPrc){
				$sql="select * from gnr_x_prescription  where patient='$pat_id' ";
				$res=mysql_q($sql);
				while($r=mysql_f($res)){
					$r_id=$r['id'];
					$d_start=$r['date']-1;					
					$patData[$d_start]['type']=4;
					$patData[$d_start]['id']=$r_id;
				}
			}
			if($pRep){
				$sql="select * from cln_x_visits  where patient='$pat_id' and report!=''";
				$res=mysql_q($sql);
				while($r=mysql_f($res)){
					$r_id=$r['id'];
					$d_start=$r['d_start']-2;					
					$patData[$d_start]['type']=5;
					$patData[$d_start]['id']=$r_id;
				}
			}
			if($pOsc){
				$sql="select * from osc_x_visits  where patient='$pat_id' and status =2";
				$res=mysql_q($sql);
				while($r=mysql_f($res)){
					$r_id=$r['id'];
					$d_start=$r['d_start']+1;					
					$patData[$d_start]['type']=6;
					$patData[$d_start]['id']=$r_id;
				}
			}
			krsort($patData);
			$actYear=0;
			$c=1;
			echo '<div class=" pr_videt c_cont" fix="wp:0">
			<div class="prvLine" fix="hp:0"></div>';
			foreach($patData as $k=>$v){
				$date=date('Y-m-d',$k);
				$year=date('Y',$k);	
				$pType=$v['type'];				
				$r_id=$v['id'];
				$pr_data='';
				switch($pType){
					case 1:	
                        if(proAct('cln')){
                            list($doc,$clinic)=get_val('cln_x_visits','doctor,clinic',$r_id);
                            list($sex,$docName)=get_val('_users','sex,name_'.$lg,$doc);
                            $clnName=get_val_arr('gnr_m_clinics','name_'.$lg,$clinic,'c');
                            $title=$clnName.' | <span class="f1 fs12"> '.$sex_txt[$sex].' '.$docName.' </span> ';
                            $srvs=get_vals('cln_x_visits_services','service'," visit_id='$r_id'");
                            $srvsArr=get_vals('cln_m_services','name_'.$lg," id in($srvs)",'arr');
                            $pr_data.='<div class="his_con">';
                            $pr_data.='<div class="f1 fs16">'.k_cmpt_srvcs.'</div>';
                            foreach($srvsArr as $k2=>$s2){ 
                                $pr_data.='<div class="f1 fs12 lh30"><ff14>'.($k2+1).' - </ff14>'.$s2.'</div>';
                            }
                            $pr_data.='</div>';
                            $addons=get_arr('cln_m_addons','short_code','name_'.$lg,"addon in('med_proc','icd10_icpc') and act=1",1," order by ord ASC");
                            foreach($addons as $code=>$addons){
                                $data=his_data($r_id,$code);						
                                if($data!=''){
                                    $pr_data.='<div class="his_con">
                                    <div class="f1 fs16" t>'.splitNo($addons).'</div>
                                    <div>'.$data.'</div>
                                    </div>';
                                }
                            }
                        }
					break;
					case 2:
                        if(proAct('lab')){
                            $serv=get_vals('lab_x_visits_services','service'," visit_id = '$r_id' ");
                            $servTxt=get_vals('lab_m_services','short_name'," id in ($serv) " , ' | ');
                            $title='تحليل | <span class="f1 fs12"> '.$servTxt.' </span> ';
                            $pr_data.='<div dir="ltr">'.pr_anaView($r_id).'</div>';
                        }
					break;					
					case 3:
                        if(proAct('xry')){
						    dcm_PACS_to_DB($pat_id,$r_id);
						    list($doc,$tec,$clinic)=get_val('xry_x_visits','doctor,ray_tec,clinic',$r_id);
                            list($sex,$docName)=get_val('_users','sex,name_'.$lg,$tec);
                            $docDet=$sex_txt_tec[$sex];
                            if($doc==$tec){$docDet=$sex_txt[$sex];}
                            $clnName=get_val_arr('gnr_m_clinics','name_'.$lg,$clinic,'c');
                            $title=$clnName.' | <span class="f1 fs12"> '.$docDet.' '.$docName.' </span> ';

                            $sql="select * from xry_x_visits_services where visit_id='$r_id'";
                            $res=mysql_q($sql);
                            while($r=mysql_f($res)){
                                $x_id=$r['id'];
                                $service=$r['service'];
                                $repDoc=$r['doc'];
                                $repDocTxt='';
                                list($rd_sex,$rd_name)=get_val('_users','sex,name_'.$lg,$repDoc);
                                if($repDoc){$repDocTxt='<div class="f1 fs12 lh20 clr1">'.k_reporter.' : '.$sex_txt[$rd_sex].' '.$rd_name.'</div>';}
                                $serviceTxt=get_val_arr('xry_m_services','name_'.$lg,$service,'xs');
                                $pr_data.='<div class=" his_con">
                                <div class="f1 fs18 lh40 ">'.$serviceTxt.$repDocTxt.'</div>';
                                $r2=getRec('xry_x_pro_radiography_report',$x_id);
                                if($r2['r']){
                                    $report=$r2['report'];
                                    $photos=$r2['photos'];
                                    $pr_data.='<div class="viewRep clr2 f1 lh30">'.(splitNo($report)).'</div>';
                                }
                                $pr_data.=dicom_link($pat_id,$x_id,3);
                                if($photos){
                                    $pr_data.='<div class="fl w100 bord ">'.imgViewer($photos,80,60).'</div>';
                                }
                                $pr_data.='&nbsp;</div>';
                            }
                        }
					break;
					case 4:
						$vis=get_val('gnr_x_prescription','visit',$r_id);
						$title=' ';
						list($doc,$clinic)=get_val('cln_x_visits','doctor,clinic',$vis);
						list($sex,$docName)=get_val('_users','sex,name_'.$lg,$doc);
						$clnName=get_val_arr('gnr_m_clinics','name_'.$lg,$clinic,'c');
						$title=k_precpiction.' | <span class="f1 fs12"> '.$clnName.' - '.$sex_txt[$sex].' '.$docName.' </span> ';
						$sql="select * from gnr_x_prescription_itemes where presc_id='$r_id' order by id";
						$res=mysql_q($sql);
						$rows=mysql_n($res);
						if($rows){							
							$pr_data.= '<div class=" his_con">
							<table width="100%" border="0" cellspacing="0" cellpadding="8" class="fTable " type="static" id="mdcTable">
								';
							while($r=mysql_f($res)){
								$r_id=$r['id'];
								$mad_id=$r['mad_id'];				
								$dose=$r['dose'];
								$num=$r['num'];
								$duration=$r['duration'];
								$dose_s=$r['dose_s'];
								$name=$dose_t=$num_t=$duration_t=$dose_s_t='';
								$name=get_val_arr('gnr_m_medicines','name',$mad_id,'m');
								if($dose){$dose_t=get_val_arr('gnr_m_medicines_doses','name_'.$lg,$dose,'m1');}
								if($num){$num_t=get_val_arr('gnr_m_medicines_times','name_'.$lg,$num,'m2');}
								if($duration){$duration_t=get_val_arr('gnr_m_medicines_duration','name_'.$lg,$duration,'m3');}
								if($dose_s){$dose_s_t=get_val_arr('gnr_m_medicines_doses_status','name_'.$lg,$dose_s,'m4');}
								$pr_data.= '
								<tr mdc="'.$r_id.'">
									<td txt><ff>'.splitNo($name).'</ff></td>
									<td txt>'.splitNo($dose_t).'</td>
									<td txt>'.splitNo($num_t).'</td>
									<td txt>'.splitNo($dose_s_t).'</td>
									<td txt>'.splitNo($duration_t).'</td>
								</tr>';
							}
							$pr_data.= '</table></div>';
						}						
					break;
					case 5:
                        if(proAct('cln')){
                            list($doc,$clinic,$report)=get_val('cln_x_visits','doctor,clinic,report',$r_id);
                            list($sex,$docName)=get_val('_users','sex,name_'.$lg,$doc);
                            $clnName=get_val_arr('gnr_m_clinics','name_'.$lg,$clinic,'c');
                            $title=k_repot.' | <span class="f1 fs12"> '.$clnName.' - '.$sex_txt[$sex].' '.$docName.' </span> ';						
                            $pr_data.='<div class="his_con f1">'.nl2br($report).'</div>';
                        }
					break;
					case 6:
                        if(proAct('osc')){
                            list($doc,$clinic)=get_val('osc_x_visits','doctor,clinic',$r_id);
                            list($sex,$docName)=get_val('_users','sex,name_'.$lg,$doc);
                            $clnName=get_val_arr('gnr_m_clinics','name_'.$lg,$clinic,'c');
                            $title=$clnName.' | <span class="f1 fs12"> '.$sex_txt[$sex].'-'.$docName.' </span> ';
                            list($srvX,$service)=get_val_c('osc_x_visits_services','id,service',$r_id,'visit_id');
                            $serviceTxt=get_val_arr('osc_m_services','name_'.$lg,$service,'xs');
                            $pr_data.='<div class="f1 fs18 uLine lh40">'.$serviceTxt.'</div>';
                            $sql=" SELECT m.name_$lg , x.* FROM osc_m_report m , osc_x_report x where x.srv='$srvX' and x.report=m.id ORDER BY m.ord ASC";	
                            $res=mysql_q($sql);
                            $rows=mysql_n($res);
                            if($rows>0){	
                                $pr_data.='<div class="his_con">
                                <table width="100%" class="table5" border="0" cellpadding="7" cellspacing="0">';
                                while($r=mysql_f($res)){
                                    $r_id=$r['id'];
                                    $report=$r['report'];
                                    $report_txt=$r['name_'.$lg];
                                    $type=$r['report_type'];
                                    $val=$r['report_val'];					
                                    $pr_data.='<tr><td valign="top" class="f1 fs14 lh30" >'.$report_txt.' :</td><td>';
                                    if($type==1 || $type==2){
                                        $valls=explode(',',$val);
                                        foreach($valls as $v){
                                            $report_val=get_val_arr('osc_m_report_items','name_'.$lg,$v,'repVal1');
                                            $pr_data.='<div class="f1 fs14 lh30 " >- '.splitNo($report_val).'</div>';
                                        }
                                    }
                                    if($type==3){
                                        $pr_data.='<div class="f1 fs14 lh30 uLine" >'.splitNo(nl2br($val)).'</div>';
                                    }
                                    $pr_data.='</td></tr>';
                                }
                                $pr_data.='</table></div>';			
                            }
                            break;
                        }
				}
				if($actYear!=$year){
					$actYear=$year;
					echo '<div class="pr_year cb">'.$year.'</div>';
				}
				$editBut='';
				if($pType==1 && $thisUser==$doc){
					$link=$f_path.'_Preview-Clinic.'.$r_id;
					$editBut='<div class="fr ic40x Over ic40_edit" title="'.k_edit.'" onclick="loc(\''.$link.'\');"></div>';
				}
				echo '
				<div class="fl " fix="wp:0">
					<div n'.$pType.' class="pr_month fl">
					<span>'.$date=date('d',$k).'</span>
					<br>'.
					$date=$monthsNames[date('n',$k)].'
					</div>
					<div class="fl pr" fix="wp:85">
						<div class="pr_bHead fl" n'.$pType.' fix="wp:0" >
							<div class="fl" n>'.number_format($r_id).'</div>
							<div class="fl pd10 f1 fs14" t> '.$title.' </div>
							<div class="fr" x="2" no="'.$c.'" onclick="swLi('.$c.')"></div>
							'.$editBut.'
						</div>
						<div class="MMBo" fix="wp:1" n="'.$c.'"></div>
						<div class="pr_bbody fl of" fix="wp:0" bn="'.$c.'" >'.$pr_data.'</div>
					</div>
				</div>';
				$c++;
			}
			echo '</div>';
		}
	}
}?>