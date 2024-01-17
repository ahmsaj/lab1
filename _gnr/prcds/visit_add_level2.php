<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['p'] , $_POST['c']) || isset($_POST['vis']) ){
	$vis=pp($_POST['vis']);
	$doc=pp($_POST['doc']);	
	$mood=pp($_POST['t']);
	$p=pp($_POST['p']);
	$c=pp($_POST['c']);
	//$m_clinic=getMClinic($c);
	$selectedSrvsArr=array();
	$h=' hide ';
	$table=$visXTables[$mood];
	$table2=$srvXTables[$mood];
	if($vis){
		if($mood==2){
			$c=get_val_c('gnr_m_clinics','id',2,'type');
			$p=get_val('lab_x_visits','patient',$vis);
			$selectedSrvs=get_vals('lab_x_visits_services','service',"visit_id='$vis'");
		}else{
			list($p,$c,$doc)=get_val($table,'patient,clinic,doctor',$vis);
			$selectedSrvs=get_vals($table2,'service',"visit_id='$vis'");
		}
		$selectedSrvsArr=explode(',',$selectedSrvs);
	}else{
		if($doc){
			$doc_clin=get_val('_users','subgrp',$doc);
			if($c!=$doc_clin){
				$selClnc=explode(',',getAllLikedClinics($c,','));
				if(in_array($doc_clin,$selClnc)){
					$c=$doc_clin;
				}
			}
		}
	}
	$m_clinic=getMClinic($c);
	$p_name=get_p_name($p);
	list($emplo,$sex,$birth_date)=get_val('gnr_m_patients','emplo,sex,birth_date',$p);
	$birthCount=birthCount($birth_date);
	$bb='<ff>'.$birthCount[0].' </ff>'.$birthCount[1];	
	if($emplo){$emploTxt=' <span class="f1 fs18 lh20 clr5 ">( '.k_employee.' )</span>';}
	list($c_name,$photo)=get_val('gnr_m_clinics','name_'.$lg.',photo',$c);		
	if($p_name){
		if(getTotalCO('gnr_x_roles'," clic='$c' and pat='$p' and status < 2 ") && $mood==1){echo '0^<div class="f1 fs14 clr5 lh40">'.k_two_appoints_two_pats_one_clin.'</div>';exit;}		
		if(!($mood==2 && $vis)){echo $mood.'^';}
		?><div class="win_body">
		<div class="form_header" type="full"><?
        if($mood==2){
			echo '<div class="fr save2ToList2 ve2ToL" onclick="load_ls_temp()" title="'.k_utst_tmplt.'"></div>
			<div class="fr loadToList2 ve2ToL" onclick="l_save_temp()" title="'.k_sv_tsamplt.'"></div>';
        }
		if($mood!=4 && $mood!=6 ){echo '<div class="fr serTotal ff fs18 B" id="serTotal">0</div>';}
		$visConut=0;
		if($doc){echo '<div class="f1 fs18 lh40">'.k_doctor.' : '.get_val('_users','name_'.$lg,$doc).'</div>';}
		echo '<div class="f1 fs16 lh20 clr1 Over fl" onclick="check_card_do('.$p.')">'.$p_name.' ['.$bb.'] ('.$sex_types[$sex].') '.$emploTxt.'</div>
		<div class="fl f1 clr5 fs16 Over pd10" onclick="editPaVis('.$p.',\'r\')"> ( تحرير ) </div>';
		
		if($mood==2){
			$sql="select d_start from $table where patient='$p' and id != '$vis' order by d_start DESC limit 1";			
		}else{
			$cQ='';
			if($mood!=4){$cQ=" and clinic='$c'";}
			$sql="select d_start , doctor from $table where patient='$p' $cQ and id != '$vis' order by d_start DESC limit 1";
		}
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){$r=mysql_f($res);$d_start=$r['d_start'];$doctor=$r['doctor'];$visConut++;}
		if($d_start){
			echo '
			<div class="cb lh30 w100">
			<div class="fl f1 fs14">'.k_date_lst_vis.' : </div>			
			<div class="fl ff fs16 B" dir="ltr">&nbsp; '.dateToTimeS3($d_start,1).' &nbsp;</div> 
			<div class="fl fs14"> | '.k_since.' '.dateToTimeS($now-$d_start).'</div>';			
			if($doctor){echo '<div class="cb fs14 f1 clr1">'.k_dr.' : '.get_val('_users','name_'.$lg,$doctor).'</div>';}
			echo '</div>';
		}
		if($visConut==0){echo'<div class="cb f1 fs14 lh30 w100">'.k_frvist.'</div>';}
		if($mood==1){?>
		<div class="lh50"><input type="text" placeholder="<?=k_search?>" id="servSelSrch"/></div>
		<? }?>
        </div>
        <div class="form_body ofx so"><?
			if($mood==1){		
				$sql="select * from cln_m_services where clinic='$m_clinic' and act=1 order by ord ASC";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows>0){?>
					<form name="n_visit" id="n_visit" action="<?=$f_path?>X/gnr_visit_add_save.php" method="post"  cb="viSts(1,[1]);" bv="id">
					<div class="lh40">
					<div class="f1 fl fs16 lh40 clr5 hide" id="fast_v"><?=k_emergency?><input type="checkbox" name="fast" value="1"/></div>&nbsp;</div>
					<input type="hidden" name="c" value="<?=$c?>"/>
					<input type="hidden" name="p" value="<?=$p?>"/>
					<input type="hidden" name="d" value="<?=$doc?>"/>
					<input type="hidden" name="t" value="<?=$mood?>"/>
					<input type="hidden" name="vis" value="<?=$vis?>"/>
					<table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s holdH">
					<tr><th width="30">#</th><th><?=k_service?></th><th width="80"><?=k_multip?></th><th width="80"><?=k_price?></th><?
					$q_pay='';
					$q_price=0;
					while($r=mysql_f($res)){
						$s_id=$r['id'];
						$name=$r['name_'.$lg];
						$hos_part=$r['hos_part'];						
						$doc_part=$r['doc_part'];
						$edit_price=$r['edit_price'];
						$edit_priceTxt='';
						if($edit_price){$hos_part=$doc_part=0;$edit_priceTxt='<div class="f1 clr6">'.k_price_det_by_dr.'</div>';}
						$total_pay=$hos_part+$doc_part;
						$rev=$r['rev'];
						$def=$r['def'];
						$multi=$r['multi'];
						$price=$hos_part+$doc_part;
						$ch_p=ch_prv($s_id,$p,$doc);
						$msg='';
						$ch="";
						if($ch_p==1 && $rev){$price=0;$msg='<div class="f1 clr5">'.k_review.'</div>';}
						if($price && $doc){						
							$newPrice=get_docServPrice($doc,$s_id,$mood);
							$newP=$newPrice[0]+$newPrice[1];							
							if($newP){$price=$newP;}
						}
						if($vis){
							if(in_array($s_id,$selectedSrvsArr)){$ch=" checked ";}
						}else{
							if($def && $emplo==0){
								if(_set_p7svouhmy5==0){$ch=" checked ";}
								if($q_pay!=''){$q_pay.=' , ';}
								$q_pay.=$name;
								$q_price+=$price;
							}
						}
						$muliTxt='-';
						if($multi){$muliTxt='<input type="number" name="m_'.$s_id.'" qunt value="1" min="1" max="3"/>';}
						
						echo '<tr serName="'.$name.'" no="'.$s_id.'">
						<td><input type="checkbox" name="ser_'.$s_id.'" '.$ch.'  par="ceckServ" value="'.$price.'" /></td>
						<td class="f1 fs14">'.$name.$msg.$edit_priceTxt.'</td>
						<td>'.$muliTxt.'</td>
						<td><ff>'.number_format($price).'<ff></td>';						
						echo '</tr>';
					}?>
					</table></form><?
				}
			}			
			if($mood==2){
				$action="viSts(2,[1]);";
				if($vis){$action="openLabSWin(0,[1]);";}
				$ph_src=viewImage($photo,1,35,35,'img','clinic.png');?>
                <div class="of h100">
                <div class="list_cat fl so">
              	 <div class="f1 blc_win_title"><?=k_sel_req_tsts?></div>
                    <div class="lh40"><input type="text" placeholder="<?=k_search?>" onkeyup="serServIN(this.value)" id="ssin"/></div>
                    <div class="fl ana_list so"><?=get_ser_lab_cats($c)?></div>
                    <div class="fl ana_list so"><?=get_ser_lab($vis)?></div>           	
                </div>               
                <div class="anaSel fl">
				    <div class="f1 blc_win_title bwt_icon2"><?=k_selected_tests?> <ff id="countAna">( 0 )</ff></div>
                    <div id="anaSelected" class="so">
					<form name="n_visit" id="n_visit" action="<?=$f_path?>X/gnr_visit_add_save.php" method="post" cb="<?=$action?>" bv="id">					
					<input type="hidden" name="c" value="<?=$c?>">
					<input type="hidden" name="p" value="<?=$p?>">
                    <input type="hidden" name="vis" value="<?=$vis?>">
                    <input type="hidden" name="t" value="<?=$mood?>"/>
					
                  	<table width="100%" id="srvData" border="0" cellspacing="0" cellpadding="6" class="grad_s holdH" type="static">
                  	<th width="40"><?=k_emergency?></th><th><?=k_analysis?></th><th><?=k_type_sample?></th><th> <?=k_price?></th><th width="30"></th>
					</table>
                   </form>					
                    </div>
                </div>
                </div><?
			}
			if($mood==3){
				$txt1=k_sel_reqmage;
				$txt2=k_sel_imgs;				
				$ph_src=viewImage($photo,1,35,35,'img','clinic.png');				
				?>
                <div class="list_cat fl so">  
                              	
                    <div class="f1 blc_win_title iconTitle" style=" background-image:url(<?=$image?>)"><?=$txt1?></div>
                    <div class="lh40"><input type="text" placeholder="<?=k_search?>" onkeyup="serServIN(this.value)" id="ssin"/></div>
                    <div class="fl ana_list so"><?=get_ser_xry_cats($m_clinic)?></div>
                    <div class="fl ana_list so"><?=get_ser_xry($m_clinic,$doc)?></div>           	
                </div>               
                <div class="anaSel fl">
                     <div class="f1 blc_win_title bwt_icon2"><?=$txt2?></div>
                    <div id="anaSelected" class="so">
					<form name="n_visit" id="n_visit" action="<?=$f_path?>X/gnr_visit_add_save.php" method="post" cb="viSts(3,[1]);" bv="id">					
					<input type="hidden" name="c" value="<?=$c?>">
					<input type="hidden" name="p" value="<?=$p?>">
					<input type="hidden" name="t" value="<?=$mood?>"/>
					<input type="hidden" name="d" value="<?=$doc?>"/>
					<input type="hidden" name="vis" value="<?=$vis?>"/>
                    <div class="f1 fs16 lh40 clr5"><?=k_emergency?><input type="checkbox" name="fast" value="1"/></div>
					<table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s" id="srvData">
					<tr><th><?=k_service?></th><th width="80"><?=k_price?></th><th width="40"></th></tr>					
                    </table></form>
					
                    </div>
                </div><?
				if($vis){
					foreach($selectedSrvsArr as $sa){					
						if($sa){echo script('clickanaList('.$sa.','.$mood.');');$h='';}						
					}
				}
			}
			if($mood==4){
				$dayNo=date('w');
				$sql="select * , u.id as uid from _users u , gnr_m_users_times d where u.id=d.id and u.grp_code='fk590v9lvl' and u.act=1 ";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				$docs_data=array();
				if($rows>0){
					$i=0;
					while($r=mysql_f($res)){
						$docs_data[$i]['act']=0;
						if(in_array($dayNo,explode(',',$r['days']))){$docs_data[$i]['act']=1;}
						$docs_data[$i]['doc']=$r['uid'];
						$docs_data[$i]['name']=$r['name_'.$lg];
						$docs_data[$i]['subgrp']=$r['subgrp'];
						$docs_data[$i]['days']=$r['days'];
						$docs_data[$i]['type']=$r['type'];
						$docs_data[$i]['data']=$r['data'];
						$i++;
					}
				}
				rsort($docs_data);
				if(count($docs_data)){
					echo '
					 <div class="f1 fs16 clr5 lh30 ">'.k_consult_val.' : <ff>'._set_lbza344hl.'</ff> '.k_sp.'</div>
					<div class="f1 fs16 clr1 lh40 ">'.k_chos_from_avble_drs.'</div>
					<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">
					
					<tr><th></th><th>'.k_doctor.'</th><th>'.k_tim.'</th><th>'.k_status.'</th><th></th></tr>';
					foreach($docs_data as $data){
						$act =$data['act'];
											
						$d_time=get_doc_Time($data['type'],$data['data'],$data['days']);					
						$d_realTime=$d_time[1]-$d_time[0];
						$docDate=clockStr($d_time[0]).' - '.clockStr($d_time[1]);
						$fColor='';
						$butColor='icc4';
						$docStatus='<div class="f1 fs14 clr4">'.k_navailble.'</div>';
						if($act==0){
							$fColor=' clr5 ';
							$docStatus='<div class="f1 fs14 clr5">'.k_tday_dnt_word.'</div>';
							$docDate='-';
							$butColor='icc2';
						}
												
						if(getTotalCO('_log'," user='".$data['doc']."'")){
							$docStatus='<div class="f1 fs14 clr6">'.k_available.'</div>';
						}
						//$consul=getTotalCO('gnr_x_roles',"clic='".$data['subgrp']."'");
						//$consulwi=getTotalCO('gnr_x_roles',"clic='".$data['subgrp']."' and status < 3 ");
						$clinic=get_val_arr('gnr_m_clinics','name_'.$lg,$data['subgrp'],'cl');

						echo '<tr>
						<td><div class="ic40 icc1 ic40_time" title="'.k_docs_appoints.'" onclick="dateDocInfo('.$data['doc'].')"></div></td>
						<td><div class="f1 fs14 '.$fColor.'">'.$data['name'].' [ '.$clinic.' ]</div></td>
						<td><bdi><ff class="'.$fColor.'">'.$docDate.'</ff></bdi></td>
						<td>'.$docStatus.'</td>
						<td><div class="ic40 '.$butColor.' ic40_done" title="'.k_doc_choos.'" onclick="denConsAdd('.$data['doc'].','.$p.')"></div></td>
						</tr>';
						/*if(!in_array($data['doc'],$x_doctor)){
							if($d_time[0]<$min_time || $min_time==0)$min_time=$d_time[0];
							if($d_time[1]>$max_time || $max_time==0)$max_time=$d_time[1];
						}*/
						//}
					}
					echo '</table>';
				}
			}
			if($mood==5){
				?>
                <div class="list_cat fl so">
					<div class="f1 blc_win_title"><?=k_sepec_reqrd_srvcs?></div>
                    <div class="lh40"><input type="text" placeholder="<?=k_search?>" onkeyup="serServIN(this.value)" id="ssin"/></div>
                    <div class="fl ana_list so"><?=get_bty_cats($m_clinic,$mood)?></div>
                    <div class="fl ana_list so"><?=get_bty_srv($m_clinic,$doc)?></div>           	
                </div>               
                <div class="anaSel fl">
                     <div class="f1 blc_win_title bwt_icon2"><?=k_sel_srvcs?> </div>
                    <div id="anaSelected" class="so">
					<form name="n_visit" id="n_visit" action="<?=$f_path?>X/gnr_visit_add_save.php" method="post" cb="viSts(<?=$mood?>,[1]);" bv="id">					
					<input type="hidden" name="c" value="<?=$c?>">
					<input type="hidden" name="p" value="<?=$p?>">
					<input type="hidden" name="d" value="<?=$doc?>"/>
					<input type="hidden" name="t" value="<?=$mood?>"/>
					<input type="hidden" name="vis" value="<?=$vis?>"/>
					<table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s" id="srvData">
					<tr><th><?=k_service?></th><th width="80"><?=k_price?></th><th width="40"></th></tr>  
                    </table></form>					
                    </div>
                </div><?
				if($vis){
					foreach($selectedSrvsArr as $sa){
						if($sa){echo script('clickanaList('.$sa.','.$mood.');');$h='';}						
					}
				}
			}
			if($mood==6){
				?>
                <div class="list_cat fl so">
					<div class="f1 blc_win_title"><?=k_sepec_reqrd_srvcs?></div>
                    <div class="lh40"><input type="text" placeholder="<?=k_search?>" onkeyup="serServIN(this.value)" id="ssin"/></div>
                    <div class="fl ana_list so"><?=get_bty_cats($m_clinic,$mood)?></div>
                    <div class="fl ana_list so"><?=get_bty_srv($m_clinic)?></div>           	
                </div>               
                <div class="anaSel fl">
                     <div class="f1 blc_win_title bwt_icon2"><?=k_sel_srvcs?> </div>
                    <div id="anaSelected" class="so">
					<form name="n_visit" id="n_visit" action="<?=$f_path?>X/gnr_visit_add_save.php" method="post" cb="viSts(<?=$mood?>,[1]);" bv="id">				
					<input type="hidden" name="c" value="<?=$c?>">
					<input type="hidden" name="p" value="<?=$p?>">
					<input type="hidden" name="d" value="<?=$doc?>"/>
					<input type="hidden" name="t" value="<?=$mood?>"/>
					<input type="hidden" name="vis" value="<?=$vis?>"/>
					<table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s" id="srvData">
					<tr><th><?=k_service?></th><th width="40"></th></tr>
                    </table>
					</form>
                    </div>
                </div><?
				if($vis){					
					foreach($selectedSrvsArr as $sa){
						if($sa){echo script('clickanaList('.$sa.','.$mood.');');$h='';}
					}
				}
			}
			if($mood==7){               
                 $h='hide';?>
				<form name="n_visit" id="n_visit" action="<?=$f_path?>X/gnr_visit_add_save.php" method="post" cb="viSts(7,[1]);" bv="id">
					<input type="hidden" name="c" value="<?=$c?>">
					<input type="hidden" name="p" value="<?=$p?>">
					<input type="hidden" name="d" value="<?=$doc?>"/>
					<input type="hidden" name="t" value="<?=$mood?>"/>
					<input type="hidden" name="vis" value="<?=$vis?>"/>
					<input name="oscSrv" id="oscSrv" type="hidden" value="0">
				
				<!--<div class="lh50 uLine"><input type="text" placeholder="<?=k_search?>" onkeyup="serServIN(this.value)" id="ssin" fix="wp:0"/></div>-->
                <? if(_set_qejqlfmies){
                    $fee='';
                    if($vis){
                        $fee=get_val_c('osc_x_visits_services','doc_fees',$vis,'visit_id'); 
                    }?>
                    <div class="lh60 uLine fl w100 cbg666 pd10f bord">
                        <div class="f1 fs16 fl lh40" fix="w:240">أجور الطبيب :</div>
                        <div class="fl lh40" fix="wp:240"><input type="number" name="fee" value="<?=$fee?>" id="docFees" fix="wp:0"/></div>
                    </div>
                <?}?>
                </form>
				<div class="fl of" fix="hp:62|wp:0">
					<div class="fl ana_list ofx so" fix="hp:0|w:240"><?=get_ser_osc_cats($m_clinic)?></div>
					<div class="fl ana_list ofx so" fix="hp:0|wp:240"><?=get_ser_osc($m_clinic,$doc)?></div>
				</div>
				<?
			}
	?></div>
        <div class="form_fot fr">
    	<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
        <? if($mood!=7){?>
            <div class="bu bu_t3 fl <?=$h?>" id="saveButt" onclick="saveRecSrvs(<?=$mood?>);"><?=k_save?></div>
        <? }?>
		<? if($q_pay!='' && _set_p7svouhmy5){
			echo '<div class="bu bu_t4 fl"  id="dirButt"  onclick="diractPay('.$p.','.$c.');">'.k_direct_pay.' : '.$q_pay.' <ff>( '.number_format($q_price).' )</ff></div>';
		}?>
		</div>
        </div><?
	}else{echo '0^<div class="f1 fs14 clr5 lh40">'.k_no_patient_number.'</div>';}
}?>