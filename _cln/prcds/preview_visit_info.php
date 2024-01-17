<? include("../../__sys/prcds/ajax_header.php");
?><div class="win_body"><?
if(isset($_POST['type']) && isset($_POST['v_id'])){	
	$type=pp($_POST['type']);
	$v_id=pp($_POST['v_id']);
	$clinic_type=get_val('gnr_m_clinics','type',$userSubType);
	$doc=get_val('cln_x_visits','doctor',$v_id);
	$tab_exist=getVisitLink($v_id,1);
	if($sender=='_Visits-Review'){
		echo script('visit_id='.$v_id.';');
	}?>
    
    <div class="form_body" ><? 
	if(
        ($thisUser==$doc || $thisGrp=='tmbx9qnjx4' || _set_prtba6023==1)
        ||
        ($thisGrp=='1ceddvqi3g' && $ray_tec==$thisUser && $doc==0)){?>    
        <section class="tab15">
            <div class="tabs" num="15">
	            <div icon="tab_h1"><?=k_services?></div>
                <div icon="tab_h1"><?=k_basic_information?></div>                
                <? if($tab_exist[0]==1){?><div icon="tab_h2"><?=k_precpiction?></div><? }?>
                <? if($tab_exist[1]==1){?><div icon="tab_h3"><?=k_tests?></div><? }?>
                <? if($tab_exist[2]==1){?><div icon="tab_h4"><?=k_radiograph_s?></div><? }?>
                <? if($tab_exist[3]==1){?><div icon="tab_h5"><?=k_med_report?></div><? }?>
                <? if($tab_exist[4]==1){?><div icon="tab_h7"><?=k_referrals?></div><? }?>
                <? if($tab_exist[5]==1){?><div icon="tab_h6"><?=k_operations?></div><? }?>
            </div>
            
            <div class="tabc">                
                <section  class="so"><?
				$ser_times=array();
				$totalTime=0;
				$vis_status=get_val('cln_x_visits','status',$v_id);
				$timeLimit=0;
				if($vis_status==2){
					$vis_finish=get_val('cln_x_visits','d_finish',$v_id);
					if(($now-$vis_finish)<40000){$timeLimit=1;}
				}
				echo '<div class="f1 fs16 lh40 clr1">'.$stats_arr[$vis_status].'</div>';
				$sql="select * , x.id as xid from cln_m_services z , cln_x_visits_services x where z.id=x.service and x.visit_id='$v_id' order by z.ord ASC";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows>0){				
					echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" over="0">';
					echo '<tr><th>'.k_service.'</th><th width="120">'.k_tim.'</th><th>'.k_status.'</th>';
					if($vis_status==2 && $timeLimit){echo '<th width="60"></th>';}
					echo '</tr>';
					while($r=mysql_f($res)){
						$s_id=$r['xid'];
						$s_time=$r['ser_time']*60*_set_pn68gsh6dj;
						$s_status=$r['status'];
						$name=$r['name_'.$lg];			
						echo '<tr>			
						<td class="f1">'.$name.'</td>
						<td><ff>'.dateToTimeS2($s_time).'</ff></td>
						<td class="f1">'.$ser_status_Tex[$s_status].'</td>';
						if($vis_status==2 && $timeLimit){
							echo '<td>';
							if($s_status==1){echo '<div class="ic40 icc2 ic40_ref" onclick="caclSrv('.$s_id.',0)" title="'.k_undo_quit.'"></div>';}
							echo '</td>';
						}
						echo'</tr>';
					}
					echo '</table>';			
				}	
				?>
                </section>
                <section  class="so"><?
				$sql="select * from cln_x_visits where id ='$v_id'";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows>0){
					$r=mysql_f($res);
					$doctor=$r['doctor'];
					$patient=$r['patient'];
					$d_start=$r['d_start'];
					$d_check=$r['d_check'];
					$d_finish=$r['d_finish'];
					$type=$r['type'];
					$sub_type=$r['sub_type'];
					$status=$r['status'];
					$pay=$r['pay'];
					$ref=$r['ref'];
					$ref_no=$r['ref_no'];
					$ref_date=$r['ref_date'];
					$report=$r['report'];
					$ray_tec=$r['ray_tec'];
					//$name=get_p_name($patient);?>					
                    <table width="100%" border="0"  class="grad_s g_info" type="static" cellspacing="0" cellpadding="4">
                    <tr><td class="fs14 f1" width="100"><?=k_pat_num?>: </td><td align="<?=k_align?>"><ff><?=$patient?></ff></td></tr>
                    <tr><td class="fs14 f1" width="100"><?=k_patient?>: </td><td align="<?=k_align?>" class="f1">
						<?
						$pp=get_p_name($patient,3);
						echo '<div class="f1 fs16 clr1 lh30">'.$pp[0].' - '.$pp[1].'</div>
						<div class="f1 f16 clr11"><ff>'.$pp[5].'</ff></div>';?>
					</td></tr>
                    <tr><td class="fs14 f1"><?=k_visit_num?>: </td><td align="<?=k_align?>"><ff><?=$v_id?></ff></td></tr>
                    <tr><td class="fs14 f1"><?=k_date_of_visit?>:</td><td align="<?=k_align?>"><ff><?=dateToTimeS3($d_start,1)?></ff></td></tr>
                    </table><?               
					$p_d1=his_data($id,'com');
					$p_d2=his_data($id,'dia');
					$p_d3=his_data($id,'cln');
					$p_d4=his_data($id,'str');					
					$p_d5=$r['note'];
					if($p_d1!=''){?><div class="his_con f1"><div class="his_icon1"></div><?=k_cmpnt?> : <?=$p_d1?></div><? }   if($p_d3!=''){?><div class="his_con f1"><div class="his_icon2"></div><?=k_sick_story?> : <?=$p_d3?></div><? }
					if($p_d4!=''){?><div class="his_con f1"><div class="his_icon2"></div><?=k_clincal_examination?> : <?=$p_d4?></div><? }?>
					<? if($p_d2!=''){?><div class="his_con f1"><div class="his_icon2"></div><?=k_diag?> : <?=$p_d2?></div><? }?>
					<? if($p_d5!=''){?><div class="his_con f1"><div class="his_icon3"></div><?=k_notes?> : <?=nl2br($p_d5)?></div><? }
            			      
				}?>
                </section>
                <? if($tab_exist[0]==1){?>
				<section class="so"><?				
				$sql="select * from gnr_x_prescription where mood=1 and visit='$v_id' ";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows>0){
					while($r=mysql_f($res)){
						$id=$r['id'];
						$date=$r['date'];?>
						<div><ff class="lh40 clr5" dir="ltr"><?=date('Y-m-d Ah:m',$date)?></ff></div>
						<table width="100%" border="0"  class="grad_s g_info" type="static" cellspacing="0" cellpadding="4"><?
							$sql2="select * from gnr_x_prescription_itemes where presc_id='$id' ";
							$res2=mysql_q($sql2);
							$rows2=mysql_n($res2);
							while($r2=mysql_f($res2)){
								$mad_id=$r2['mad_id'];
								$dose_s=$r2['dose_s'];
								$dose=$r2['dose'];
								$num=$r2['num'];
								$duration=$r2['duration'];
								$d_name=get_val_arr('gnr_m_medicines','name',$mad_id,'n');

								if($type){$type_t=' ( '.get_val_arr('gnr_m_medicines_doses_type','name_'.$lg,$type,'d1').' )';}
								if($dose){$dose_t=get_val_arr('gnr_m_medicines_doses','name_'.$lg,$dose,'d2');}
								if($num){$num_t=get_val_arr('gnr_m_medicines_times','name_'.$lg,$num,'d3');}
								if($duration){$duration_t=get_val_arr('gnr_m_medicines_duration','name_'.$lg,$duration,'d4');}
								if($dose){$dose_s_t=get_val_arr('gnr_m_medicines_doses_status','name_'.$lg,$dose_s,'d5');}

								?><tr><td align="<?=k_align?>">
								<div class="fs20 ff lh40 B TL clr1"><?=$d_name .' <span class="fs12 f1 clr1111">'.$type_t.'</span>'?></div>
								<div class="mad_way f1 fs14 TL"><?=splitNo($dose_t.' '.$num_t.' '.$dose_s_t.' '.$duration_t)?></div>
								</td></tr><?
							}?></table><?	
						}
					}
                ?></section><? }?>
                <? if($tab_exist[1]==1){?>
				<section class="so"><?
				$sql="select * from cln_x_pro_analy where v_id='$v_id' order by date DESC";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows>0){					
					while($r=mysql_f($res)){
						$an_id=$r['id'];
						$view=$r['view'];
						$sql2="select * from cln_x_pro_analy_items x, cln_m_pro_analysis z where x.ana_id='$an_id'
						 and x.mad_id=z.id ";
						$res2=mysql_q($sql2);
						$rows2=mysql_n($res2);
						if($rows2>0){?>
                            <div class="blc_win_title f1"><?=k_test_no?>
							<span class="ff fs18"> ( <?=($an_id)?> )</span></div>
							<? if($view==0){echo '<div class="winOprNote_err f1">'.k_m_val_enter.'</div>';} ?>
							<table width="100%" border="0"  class="grad_s" type="static" cellspacing="0" cellpadding="4"><?
                            while($r2=mysql_f($res2)){
								$an_name=$r2['name_'.$lg];
								$value=$r2['value'];
								$note=$r2['note'];?>						
								<tr>
                                <td style="text-align:<?=k_align?>" class="anName"><?=$an_name?></td>
                                <td width="100" class="ff ann_val">  <?=$value?>  </td>
								<td style="text-align:<?=k_align?>" class="ann_note"><?=$note?></td>
                                </tr><?
							}
							?></table>
							<div class="blc_win_title f1" style="margin-bottom:20px;"></div><?	
						}
					}
				}
                ?></section><? }?>
                <? if($tab_exist[2]==1){?>
				<section class="so"><?
				$sql="select * from xry_x_pro_radiography where v_id='$v_id' order by date DESC ";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows>0){
					while($r=mysql_f($res)){						
						$an_id=$r['id'];						
						$view=$r['view'];
						$date=$r['date'];
						if($view){
							$mmsg='<span class="fs12 clr6 f1">'.k_reprt_rvwd.'</span>';
						}else{
							$mmsg='<span class="fs12 clr5 f1">'.k_reprt_nrvwd.'</span>';
						}
						echo '<div class="uLine"></div><div class="f1 fs16 lh30">'.k_image_no.' <span class="ff fs18"> ( '.($an_id).' )</span>
						<br>'.$mmsg.'</div><div class="uLine"></div>';						
						echo '<div></div>';
						$sql2="select * from  xry_x_pro_radiography_items where xph_id='$an_id'";
						$res2=mysql_q($sql2);
						$rows2=mysql_n($res2);
						if($rows2){
							echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s g_info" type="static">
							<tr><th>'.k_services.'</th><th width="40">'.k_photo.'</th><th>'.k_report.'</th><th>'.k_status.'</th></tr>';
							while($r2=mysql_f($res2)){
								$mad_id=$r2['mad_id'];
								$photo=$r2['photo'];								
								$note=$r2['note'];
								$status=$r2['status'];?>								
                                <tr>                	
                                    <td class="fs12 f1" width="150"><?=xpDet($mad_id)?></td>
                                    <td><? if($photo){echo viewPhotosImg($photo,1,3,40,40);}else{echo '&nbsp;';}?></td>        
                                    <td style="text-align:<?=k_align?>"><?=$note?></td>
                                    <td><span class="fs12 f1" style="color:<?=$report_status_color[$status]?>"><?=$report_status_txt[$status]?></span></td>
                                </tr><?
							}
							echo '</table>';
						}
					}
				}
                ?></section><? }?>
                <? if($tab_exist[3]==1){?>
				<section class="so">
                <div class="blc_win_title f1"><?=k_report_details?></div>
				<div class="fs14 f1"><?=nl2br(get_val('cln_x_visits','report',$v_id))?></div></section><? }?>                
                <? if($tab_exist[4]==1){?>
				<section class="so"> <?               
					$sql="select * from cln_x_pro_referral where v_id='$v_id' order by date DESC";
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					if($rows>0){
						while($r=mysql_f($res)){
							$id=$r['id'];
							$type=$r['type'];
							$p_id=$r['p_id'];
							$hospital=$r['hospital'];
							$doctor=$r['doctor'];
							$opr_date=$r['opr_date'];
							$des=$r['des'];
							$opration=$r['opration'];
							$v_id=$r['v_id'];
							$date=$r['date'];?>	
                            <div class="blc_win_title f1"><?=$assi_typs_arr[$type]?>
							<span class="ff fs18"> ( <?=($id)?> )</span></div>							
							<table width="100%" border="0"  class="grad_s g_info" type="static" cellspacing="0" cellpadding="4">
							<? if($hospital){?><tr>
							  <td class="fs14 f1" width="150"><?=k_the_hospital?></td>
                              <td style="line-height:22px;">                              
							  <?=get_val('cln_m_pro_referral_hospitals','name_'.$lg,$hospital)?><br>
							  <?=k_phone.' : '.get_val('cln_m_pro_referral_hospitals','phone',$hospital)?><br>
							  <?=k_address.' : '.get_val('cln_m_pro_referral_hospitals','addres',$hospital)?>
							  </td></tr><? }?>
							<? if($doctor){?><tr>
							  <td class="fs14 f1" width="150"><?=k_dr?> :</td>
                              <td><?=get_val('cln_m_pro_referral_doctors','name_'.$lg,$doctor)?></td></tr><? }?>
							<? if($opration){?><tr>
							  <td class="fs14 f1" width="150"><?=k_operation?> :</td>
                              <td><?=get_val('cln_m_pro_operations','name_'.$lg,$opration)?></td></tr><? }?>
							<? if($opr_date!='0000-00-00'){?><tr>
							  <td class="fs14 f1" width="150"><?=k_date_of_operation?> :</td>
                              <td class="ff fs16"><?=$opr_date?></td></tr><? }?>
							<? if($des!=''){?><tr>
							  <td class="fs14 f1" width="150"><?=k_notes?> :</td><td><?=$des?></td></tr><? }				
							?></table><?
						}
                    }?>
                </section><? }?>
                <? if($tab_exist[5]==1){?>
				<section class="so"> <?               
					$sql="select * from cln_x_pro_x_operations where v_id='$v_id' order by date DESC";
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					if($rows>0){
						while($r=mysql_f($res)){
							$id=$r['id'];
							$opration=$r['opration'];
							$hospital=$r['hospital'];
							$opr_date=$r['date'];
							$duration=$r['duration'];
							$price=$r['price'];
							$tools=$r['tools'];														
							$status=$r['status'];
							$duration2=$r['real_dur'];
							$price2=$r['real_price'];
							$notes=$r['notes'];
							$report=$r['report'];
							$opration_name=get_val('cln_m_pro_operations','name_'.$lg,$opration);
							$hospital=get_val('cln_m_pro_referral_hospitals','name_'.$lg,$hospital);
							$date2=timeAgo(date('U')-(strtotime($opr_date)));
							?>	
							<div class="blc_win_title f1"><?=k_oper_no?><span class="ff fs18"> ( <?=($id)?> )</span></div>							
							<table width="100%" border="0"  class="grad_s g_info" type="static" cellspacing="0" cellpadding="4">
							<tr><td width="150"  class="fs14 f1"><?=k_operation?> :</td><td><?=$opration_name?></td></tr>
							<tr><td class="fs14 f1"><?=k_the_hospital?> :</td><td><?=$hospital?></td></tr>
							<tr><td class="fs14 f1"><?=k_oper_dat_tim?> :</td><td><?=$opr_date?><? if($date2!=''){ echo ' ( '.$date2.' )';}?></td></tr>
							<tr><td class="fs14 f1"><?=k_oper_dur?>:</td><td><?=$duration?></td></tr>
							<tr><td class="fs14 f1"><?=k_oper_cost?>:</td><td><?=$price?></td></tr>
							<? if($tools!=''){?>
							<tr><td class="fs14 f1"><?=k_oper_tools?>:</td><td><div id="opr_tools_d"><?=getTools($tools)?></div></td></tr>
							<? }?>
							<? if($status==1){?>
							<tr><td class="fs14 f1"><?=k_act_oper_tim?>:</td><td><?=$duration2?></td></tr>
							<tr><td class="fs14 f1"><?=k_dr_pays?>:</td><td><?=$price2?></td></tr>
							<tr><td class="fs14 f1"><?=k_notes?>:</td><td><?=$notes?></td></tr>
							<tr><td class="fs14 f1"><?=k_the_medical_report?>:</td><td><?=$report?></td></tr>
							<? }?>
							</table><?
						}
                    }?>
                </section><? }?>
            </div>
        </section><? 
	}else{
        echo '<div class="winOprNote_err f1">'.k_no_perm_med_rep.'</div>';
    }?>
	</div>
    <div class="form_fot fr">
    	<div class="bu bu_t2 fr" onclick="<?=$wlp?>win('close','#full_win1');"><?=k_close?></div>		
        <? if($doc==$thisUser){
			$loc=$f_path.'_Preview-Clinic.'.$v_id;?>
        	<div class="bu bu_t1 fl" onclick="loc('<?=$loc?>');"><?=k_prev_edit?></div>
        <? }?>
    </div><?
}?>
</div>