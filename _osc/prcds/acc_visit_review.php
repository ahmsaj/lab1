<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['fil'] , $_POST['p'])){
	$pvl=pp($_POST['fil'],'s');
	$pars=explode('|',$pvl);
	$q='';
	$q2='';
	$cond=array();
	foreach($pars as $p){
		if($p!=''){
			$pp=explode(':',$p);
			$cal=$pp[0];
			$val1=$pp[1];
			$val2=$pp[2];			
			if($cal=='p2'){if($q2){$q2.=" AND ";}$q2.="f_name like '%$val1%' ";}
			if($cal=='p3'){if($q2){$q2.=" AND ";}$q2.="ft_name like '%$val1%' ";}
			if($cal=='p4'){if($q2){$q2.=" AND ";}$q2.="l_name like '%$val1%' ";}	
			if($cal=='p5'){if($q2){$q2.=" AND ";}$q2.=" sex = '$val1' ";}
			if($cal=='d1'){
				if($val1){		
					array_push($cond," d_start > ". strtotime($val1));
				}
				if($val2){					
					array_push($cond," d_start < ".(strtotime($val2)+86400));
				}
			}
			if($cal=='p1'){array_push($cond," id = '$val1' ");}
			if($cal=='p6'){array_push($cond," reg_user = '$val1' ");}
            if($cal=='p61'){array_push($cond," dts_reg = '$val1' ");}            
			if($cal=='p7'){array_push($cond," doctor = '$val1' ");}
			if($cal=='p8'){array_push($cond," clinic = '$val1' ");}
			if($cal=='p9'){array_push($cond," status = '$val1' ");}
			if($cal=='p10'){array_push($cond," type = '$val1' ");}
			if($cal=='p11'){array_push($cond," pay_type = '$val1' ");}
			if($cal=='p12'){array_push($cond," fast = '$val1' ");}
            if($cal=='pIns'){array_push($cond," pay_type=3 and  pay_type_link = '$val1'  ");}
		}
	}
	if($thisGrp=='9k0a1zy2ww'){array_push($cond," doctor = '$thisUser' ");}
	$q=implode(' AND ',$cond);
	if($q2){
		if($q){$q.=" AND ";}
		$q.=" patient IN( select id from gnr_m_patients where $q2 ) ";
	}
	if($q){$q=" where $q ";}
	$sql="select count(*)c from osc_x_visits $q";
	$res=mysql_q($sql);
	$r=mysql_f($res);
	$pagination=pagination('','',10,$r['c']); 
	$page_view=$pagination[0];
	$q_limit=$pagination[1];	
	$all_rows=$pagination[2];
	echo ' '.number_format($all_rows).' <!--***-->';
	$sql="select * from osc_x_visits $q order by id DESC $q_limit";
	$res=mysql_q($sql);
	$rows=mysql_n($res);	
	if($rows>0){?>
		<table width="100%" border="0"  class="grad_s holdH" type="static" cellspacing="0" cellpadding="4" over="0" >		
		<tr>
       	<th class="fs16 f1">#</th>
        <th class="fs16 f1"><?=k_patient?></th> 
        <th class="fs16 f1"><?=k_reception?></th>
        <th class="fs16 f1">حاجز الموعد</th>
        <th class="fs16 f1"><?=k_dr?></th>
        <th class="fs16 f1"><?=k_clinic?></th>        
		<th class="fs16 f1"><?=k_start_date?></th>
        <th class="fs16 f1"><?=k_ent_time?></th>
        <th class="fs16 f1"><?=k_out_time?></th>
        <? if($thisGrp=='hrwgtql5wk' || $thisGrp=='o81muv4ggi' || $thisGrp=='s'){echo '<th class="fs16 f1">'.k_actu_time.'</th>';}?>
		<th class="fs16 f1"><?=k_staff?></th>
        <th class="fs16 f1"><?=k_status?></th>
        <th class="fs16 f1" width="40"></th>
        </tr> <?
		$cType=7;
		while($r=mysql_f($res)){
			$id=$r['id'];
			$doctor=$r['doctor'];
			$patient=$r['patient'];
			$clinic=$r['clinic'];			
			$type=$r['type'];
			$pay_type=$r['pay_type'];
            $pay_type_link=$r['pay_type_link'];
            $payLinkName=paymentName($pay_type,$pay_type_link);
			$status=$r['status'];
			$time_chck=$r['d_check'];
			$time_entr=$r['d_start'];
			$time_out=$r['d_finish'];
			$reg_user=$r['reg_user'];
            $dts_reg=$r['dts_reg'];
			$ray_tec=$r['ray_tec'];
			$workTxt='';
			$work=$r['work'];
			if($work){
				$workPers=($work*100)/($time_out-$time_chck);
				$workTxt='<div>'.dateToTimeS($work).' ('.number_format($workPers).'% ) </div>
				<div class="clr1">'.k_waiting.' :'.dateToTimeS($time_chck-$time_entr).' </div>';				
			}
			$action='';
			if($thisGrp=='hrwgtql5wk' || $thisGrp=='o81muv4ggi' || $thisGrp=='s'){$action='showAcc('.$id.','.$cType.')';}            
			if(in_array($thisGrp,array('9k0a1zy2ww'))){$action='showDocVis('.$id.')';}
			?><tr>
			<td class="ff B fs16"><?=$id?></td>
			<td class="f1"><?=get_p_name($patient)?></td>
            <td class="f1"><?=get_val_arr('_users','name_'.$lg,$reg_user,'u')?></td>
            <td class="f1"><?=get_val_arr('_users','name_'.$lg,$dts_reg,'u')?></td>
            <td class="f1"><?=get_val_arr('_users','name_'.$lg,$doctor,'u');?></td>
            <td class="f1"><?=get_val_arr('gnr_m_clinics','name_'.$lg,$clinic,'c')?></td>			
			<td class="f1 ff B fs14"><?=dateToTimeS3($time_entr);?></td>
			<td class="f1 ff B fs14"><?=date('Ah:i',$time_chck);?></td>
            <td class="f1 ff B fs14"><?=date('Ah:i',$time_out);?></td>
            <? if($thisGrp=='hrwgtql5wk' || $thisGrp=='o81muv4ggi' || $thisGrp=='s'){echo '<td>'.$workTxt.'</td>';}?>
            <td class="f1"><?
                $aad_r=getRecCon('osc_x_visits_services_add',"visit_id='$id'" );                        
                echo '
                <div>'.k_endoscopy_tech.': '.get_val_arr('osc_m_team','name_'.$lg,$aad_r['tec_endoscopy'],'t').'</div>
                <div>'.k_anesthesia_tech.': '.get_val_arr('osc_m_team','name_'.$lg,$aad_r['tec_anesthesia'],'t').'</div>
                <div>'.k_sterilization_tech.': '.get_val_arr('osc_m_team','name_'.$lg,$aad_r['tec_sterilization'],'t').'</div>
                <div>'.k_nurse.': '.get_val_arr('osc_m_team','name_'.$lg,$aad_r['tec_nurse'],'t').'</div>                
                ';?>
            </td>
			<td class="f1"><div style="color:<?=$stats_arr_col[$status]?>" class="f1 fs14"><?=$stats_arr[$status]?></div>
			<? if($pay_type){ ?><div class="clr5 f1"><?=$pay_types[$pay_type]?> - <?=$payLinkName?></div><? }?></td>
			
            <td class="f1"><div class="ic40 icc1 ic40_info" onclick="<?=$action?>"></div></td>
			</tr><?
		}		
	}else{
		echo '<div class="lh40 f1 fs18 clr5">'.k_no_results.'</div>';
	}
	echo '<!--***-->'.$page_view;	
	}
?>
