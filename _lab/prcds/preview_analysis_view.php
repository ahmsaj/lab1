<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['t'])){	
	$id=pp($_POST['id']);
	$t=pp($_POST['t']);
	if($t==1){
		list($vis,$doc)=get_val('lab_x_visits_requested','lab_vis,doc',$id);
		$ref_id=$id;
		if($vis){
			$pat=get_val('lab_x_visits','patient',$vis);			
			list($sex,$age)=getPatInfoL($pat);
			$pa_txt=get_p_name($pat,3);
			$sendAllId=$vis;
			$title=$pa_txt[0].' <br><span class="lh20 fs14">( '.$pa_txt[1].' ) '.$sex_types[$pa_txt[4]].'</span>';
			$q=" x.visit_id='$vis' ";
			$q2=" and r_id='$id' ";
		}
		mysql_q("UPDATE lab_x_visits_requested_items SET status='3' where r_id='$id' and action=1 and status=2  ");
	}else if($t==2){
		list($x_srv,$action,$r_id)=get_val('lab_x_visits_requested_items','service_id,action,r_id',$id);
		$ref_id=$r_id;
		if($action==2){$q2=" and id='$id' ";}		
		mysql_q("UPDATE lab_x_visits_requested_items SET status='3' where id='$id' and status=2  ");
		list($pat,$doc,$vis)=get_val('lab_x_visits_requested','patient,doc,lab_vis',$r_id);
		list($sex,$age)=getPatInfoL($pat);
		$pa_txt=get_p_name($pat,3);
		$title=$pa_txt[0].' <br><span class="lh20 fs14">( '.$pa_txt[1].' ) '.$sex_types[$pa_txt[4]].'</span>';		
		$q=" x.id='$x_srv' ";
		$sendAllId=$id;
	}else if($t==3){
		$title=get_val('lab_m_services','short_name',$id);
		$q=" x.service='$id' ";
		$sendAllId=$id;
		
	}
	$sql="select * , x.id as x_id , z.id as z_id , x.fast as x_fast from lab_x_visits_services x , lab_m_services z where x.service=z.id and $q and status IN(8,1)  order by z.type ASC , x.fast DESC , x.id ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	$tCol=5;
	if($t==3){$title.=' <ff class="clr5"> ( '.$rows.' ) </ff>';}
	?>
    <div class="win_body">
		<div class="form_header">
			<div class="fr ic40 icc1 ic40_ref" title="<?=k_refresh?>" onclick="veiwAnaResult(<?=$id?>,<?=$t?>)"></div>
			<div class="lh30 fs18 f1s clr1"><?=$title?></div>
		</div>
    	<div class="form_body so" ><?
        $balans=0;
        if(_set_0zmrcedu52==1){$balans=get_visBal($vis);}
        if($balans==0){
            $revData='';		
            $actType=0;
            if($rows>0){
                while($r=mysql_f($res)){
                    $srv_id=$r['z_id'];
                    $x_id=$r['x_id'];
                    $vis=$r['visit_id'];
                    $name=$r['short_name'];
                    $report_de=$r['report_de'];
                    $sample=$r['sample'];
                    $type=$r['type'];
                    $a_id=$x_id;
                    $report_wr=$r['report_wr'];
                    $service=$r['service'];
                    $status=$r['status'];
                    $pat=$r['patient'];
                    if($t==3){
                        list($sex,$age)=getPatInfoL($pat);
                        $pa_txt=get_p_name($pat,3);
                    }

                    /*echo $ri_Status=get_val_c('lab_x_visits_requested_items','status',$x_id,'service_id');
                    if($ri_Status==3){
                        mysql_q("UPDATE lab_x_visits_requested_items SET status=4 where service_id='$x_id' ");
                    }*/

                    $fast=$r['x_fast'];
                    $date_enter=$r['date_enter'];
                    $date_reviwe=$r['date_reviwe'];
                    if($type==1){$ala_name=get_val('lab_m_services','short_name',$service);}
                    if($type==2){$ala_name=$name;}				
                    if($type==1 || $type==4){
                        $sql3="select * from lab_m_services_items where serv='$srv_id'  order by ord ASC  ";
                        $res3=mysql_q($sql3);
                        $rows3=mysql_n($res3);
                        if($rows3>1){							
                            $revData.='<tr><td colspan="'.$tCol.'" class="f1 fs16 cbg44 ">'.splitNo($name).'</td></tr>';
                        }
                        $i=0;
                        while($r3=mysql_f($res3)){
                            $i++;			
                            $mSrv_id=$r3['id'];
                            $s_type=$r3['type'];
                            $name=splitNo($r3['name_'.$lg]);
                            $unit=$r3['unit'];
                            $normal_code=$r3['normal_code'];
                            $report_type=$r3['report_type'];
                            if($t==3){
                                $name='<div class="f1s fs12">'.$pa_txt[0].' <br><span class="">( '.$pa_txt[1].' ) '.$sex_types[$pa_txt[4]].'</span></div>';
                            }

                            $last='';
                            if($i==$rows3 && $rows3>1){$last='last';}
                            list($r_id,$val,$vsr_id)=get_LR_res($x_id,$mSrv_id);
                            if($hide==0){
                                if($s_type==1){
                                    $revData.='<tr>
                                    <td class="f1 fs16 TC clrw cbg3" width="1" colspan="'.($tCol+2).'">'.$name.'</td></tr>';
                                }else{
                                    $revData.='<tr b class="reprort_s reportRevBlok" >';
                                    $rrv=0;
                                    $rrvBut='';
                                    if($status==10){							
                                        $rrv=getTotalCO('lab_x_visits_services_results_x',"  x_id='$vsr_id'");
                                        if($rrv){
                                            $rrvBut='<div class="f1 fs14 clr5 Over lh30" title=
                                            "'.k_previous_results.'" onclick="x_result('.$vsr_id.')">'.k_previous_results.'</div>';			
                                        }
                                    }
                                    $nor_val=show_LreportNormalVal($report_type,$mSrv_id,$sex,$age,$sample,$val,$unit,$normal_code);
                                    $new_val=$nor_val[3];
                                    list($unit_code,$unit_txt,$dec_point)=get_val('lab_m_services_units','code,name_'.$lg.',dec_point',$unit);
                                    $revData.='<td class="f1 clr1 fs16 " width="250">'.$name.$rrvBut.'</td>';
                                    $revData.=drowReport(1,$report_type,$name,$unit_txt,$unit_code,$dec_point,$nor_val);
                                }
                            }
                        }
                    }
                    if($type==2){
                        $rec=getRec('lab_x_visits_services_result_cs',$x_id,'serv_id');
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
                        if($ss_val==1){$revData='<div class="f1 fs14 clr6 ">'.$lab_res_CS_types[$ss_val].'</div>';}
                        if($ss_val==2){$revData='<div class="f1 fs14 clr5 ">'.$lab_res_CS_types[$ss_val].'</div>';}
                        if($ss_val==3){
                            $revData.='<div class="lh30 fl_d cb">
                            <div class="clr1 frr f1 fs16">'.k_type_sample.' : '.get_val('lab_m_test_swabs','name',$ss_sample_type).'</div> 
                            <div class="clr1 fll fs16 pd5">'.$lab_res_CS_level[$ss_level].'</div> 
                            <div class=" fll fs16"> Result
    </div>
                            <div class="clr5 fll fs16 pd5"> '.get_val('lab_m_test_bacterias','name',$ss_bacteria).'</div>
                            </div>';
                            $revData.='<div class="lh30 fl_d cb">';
                            if($ss_colonies){$revData.='<div class="fl f1 fs14 pd5">'.k_num_colons.' : <ff  class="clr1">'.number_format($ss_colonies).'</ff> | </div>';}	
                            if($ss_wbc){$revData.='<div class="fl f1 fs14 pd5">W.B.C : <ff class="clr1">'.$ss_wbc.'</ff> |</div>';}
                            if($ss_rbc){$revData.='<div class="fl f1 fs14 pd5">R.B.C : <ff class="clr1">'.$ss_rbc.'</ff> |</div>';}
                            $revData.='</div>';	
                            if($ss_note){$revData.='<div class="cb f1 fs16 pd5 lh30">'.k_notes.' : <span class="clr1 fs14 f1">'.$ss_note.'</span> </div>';}

                            $sql="select * from lab_x_visits_services_result_cs_sub where p_id='$x_id' order by id ASC";
                            $res=mysql_q($sql);
                            $rows=mysql_n($res);
                            if($rows>0){
                                $revData.='<table width="100%"  cellspacing="0" cellpadding="0" class="grad_s " type="static" dir="ltr">
                                <tr><th rowspan="2">ANTIMICROBIAL<br>AGENTS</th><th colspan="3">Zone Diameter ( MM )</th><th rowspan="2">COMMERCIAL<br>NAME</th></tr>
                                <tr><th width="100">Results ( MM )</th><th width="100">R ( Below )</th><th width="100">S ( Over )</th></tr>';
                                while($r=mysql_f($res)){
                                    $antibiotics=$r['antibiotics'];
                                    $val=$r['val'];
                                    $n_id=$r['id'];
                                    $code=$r['code'];				
                                    $min_val=$r['min_val'];
                                    $max_val=$r['max_val'];	list($n_name,$trad_name)=get_val('lab_m_test_antibiotics','name,trad_name',$antibiotics);
                                    $revData.= '<tr><td><ff>'.$n_name.'</ff></td>
                                    <td><ff>( '.$val.' ) </ff><ff class="clr1">'.$code.'</ff></td>
                                    <td><ff>'.$min_val.'</ff></td>
                                    <td><ff>'.$max_val.'</ff></td>
                                    <td><ff>'.$trad_name.'</ff></td>
                                    </tr>';
                                }							
                                $revData.= '</table>';
                            }	
                        }
                        //echo $out;
                    };
                    if($type==5){			
                        $editVal=get_val_c('lab_x_visits_services_results','value',$ser_id,'serv_id');			
                        $sql="select * from lab_m_test_mutations where act=1 order by name ASC";
                        $res=mysql_q($sql);
                        $rows=mysql_n($res);
                        if($rows>0){
                            $antiEditVal=getAntiEditVal2($editVal);
                            $out.='<div class="fl_d ff fs22 TC B lh30 pd10">Assay for the Identication of MEFV geng mutatione <br> Based on real time polymerase chain reaction ( real time PCR ) </div>';
                            $out.='<div class="fl_d ff fs18 pd10 lh30">Mutations detected with this test, potentially leading to a FMF phenotype , are  as follws :  </div><div class="fl_d pd10">';
                            $out.='<table width=""  cellspacing="0" cellpadding="6" class="grad_s " dir="ltr" type="static" >';
                            $c=0;
                            while($r=mysql_f($res)){
                                $n_id=$r['id'];
                                $n_name=$r['name'];				
                                $t1='<ff class="clr5">'.$lab_res_fmf_types[0].'</ff>';
                                $t2='';
                                if($editVal){
                                    if($antiEditVal[$n_id]){
                                        $c++;
                                        $v1=$antiEditVal[$n_id]['v1'];
                                        $v2=$antiEditVal[$n_id]['v2'];
                                        if($v1==1){
                                            $t1='<ff class="clr6">'.$lab_res_fmf_types[1].'</ff>';
                                            if($v2==1){$t2=' - '.$lab_res_fmf_Stypes[1];}if($v2==2){$t2=' - '.$lab_res_fmf_Stypes[2];}
                                        }	
                                        $out.= '<tr><td width="30"><ff>'.$c.'</ff></td><td><ff>'.$n_name.'</ff></td><td>'.$t1.' <ff> '.$t2.'</ff></td></tr>';
                                    }
                                }
                            }							
                            $out.='</table></div>';
                        }
                    };
                    if($actType>1){
                        $revData='
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="grad_lab_enter " >'.$revData.'</table>';
                    }
                    $actType=$type;		
                }
                if($actType==1 || $actType==4){
                    $revData='
                    <table width="100%" border="0" cellspacing="0" cellpadding="6" class="grad_lab_enter " >'.$revData.'</table>';
                }
                echo $revData;

            }
            if($t==1 || ($t==2 && $action==2)){
			$sql="select * from lab_x_visits_requested_items where action =2 $q2 ";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows){
				echo '<div class="f1 fs18 clr2 lh40">'.k_tests_external.'</div>
				<table width="100%" border="0" cellspacing="0" cellpadding="6" class="grad_lab_enter " >';
				while($r=mysql_f($res)){
					$ri_id=$r['id'];
					$r_status=$r['status'];
					$ana=$r['ana'];
					$r_id=$r['r_id'];
					$ana_res=$r['res'];
					$ana_status=$r['status'];
					$doc=get_val('lab_x_visits_requested','doc',$r_id);
					$action=$r['action'];

					echo '<tr><td class="f1 clr1 fs16 ">'.get_val('lab_m_services','name_'.$lg,$ana).'</td><td id="tri'.$ri_id.'">';
					//if($r_status==0 && $doc==$thisUser){
						echo '<textarea class="w100" t id="anaresTxtRes" txt>'.$ana_res.'</textarea>';
					//}else{
						//echo $ana_res;
					//}
					echo '</td>';
					echo '<td width="40" id="bri'.$ri_id.'" >';
					if($doc==$thisUser){
						//if($r_status==0){
							echo '<div class="ic40 icc2 ic40_save" title="'.k_save.'" onclick="prvSaveAna('.$ri_id.','.$t.','.$ref_id.')"></div>';
						//}
						/*if($r_status==3){
							echo '<div class="ic40 icc1 ic40_edit" title="'.k_edit.'" onclick="prvEditAna('.$ri_id.','.$t.','.$id.')"></div>';
						}*/
					}
					echo '</td>';
					echo '</tr>';
				}
				echo '</table>';
			}
		}
        }else{
            echo '<div class="f1 fs14 lh40 clr5">'.k_res_cannot_pres.'</div>';
        }
		?>
		</div>
        <div class="form_fot fr">
            <div class="bu bu_t2 fr" onclick="win('close','#m_info2'); loadAna(<?=$ref_id?>)"><?=k_close?></div>
        </div>
    </div>
	<?
	//echo script('loadAnalRes('.$id.','.$actActionType.')');
	
	
}?>