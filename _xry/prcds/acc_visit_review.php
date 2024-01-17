<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['fil'] , $_POST['p'])){
	$pvl=pp($_POST['fil'],'s');
	$pars=explode('|',$pvl);
	$q='';
	$q2='';
	if(in_array($thisGrp,array('nlh8spit9q'))){$q.=" (doctor = '$thisUser' or ray_tec='$thisUser') ";}	
	if(in_array($thisGrp,array('1ceddvqi3g'))){$q.=" ray_tec = '$thisUser' and doctor =0 ";}
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
					if($q){$q.=" AND ";}
					$q.=" d_start > ". strtotime($val1);
				}
				if($val2){
					if($q){$q.=" AND ";}
					$q.=" d_start < ".(strtotime($val2)+86400);
				}
			}
			if($cal=='p1'){if($q){$q.=" AND ";}$q.=" id = '$val1' ";}
			if($cal=='p6'){if($q){$q.=" AND ";}$q.=" reg_user = '$val1' ";}
            if($cal=='p61'){if($q){$q.=" AND ";}$q.=" dts_reg = '$val1' ";}
			if($cal=='p7'){if($q){$q.=" AND ";}$q.=" (doctor = '$val1' or ray_tec='$thisUser') ";}
			if($cal=='p8'){if($q){$q.=" AND ";}$q.=" clinic = '$val1' ";}
			
			if($cal=='p9'){if($q){$q.=" AND ";}$q.=" status = '$val1' ";}
			if($cal=='p10'){if($q){$q.=" AND ";}$q.=" type = '$val1' ";}
			if($cal=='p11'){if($q){$q.=" AND ";}$q.=" pay_type = '$val1' ";}
			if($cal=='p12'){if($q){$q.=" AND ";}$q.=" fast = '$val1' ";}
            if($cal=='pIns'){if($q){$q.=" AND ";}$q.="pay_type=3 and  pay_type_link = '$val1' ";}
			
		}
	}
	if($q2){if($q){$q.=" AND ";}
	$q.=" patient IN( select id from gnr_m_patients where $q2 ) ";}
	
	if($q){$q=" where $q ";}
	$sql="select count(*)c from xry_x_visits  $q ";
	$res=mysql_q($sql);
	$r=mysql_f($res);
	$pagination=pagination('','',10,$r['c']); 
	$page_view=$pagination[0];
	$q_limit=$pagination[1];	
	$all_rows=$pagination[2];
	echo ' '.number_format($all_rows).' <!--***-->';
	$sql="select * from xry_x_visits $q order by id DESC $q_limit";
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
		<th class="fs16 f1"><?=k_status?></th>
        <th class="fs16 f1" width="40"></th>
        </tr> <?
		$cType=3;
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
			if(in_array($thisGrp,array('nlh8spit9q','1ceddvqi3g'))){$action='showDocVis('.$id.')';}
			?><tr>
			<td class="ff B fs16"><?=$id?></td>
			<td class="f1"><?=get_p_name($patient)?></td>
            <td class="f1"><?=get_val_arr('_users','name_'.$lg,$reg_user,'u')?></td>
            <td class="f1"><?=get_val_arr('_users','name_'.$lg,$dts_reg,'u')?></td>
            <td class="f1"><?=get_val_arr('_users','name_'.$lg,$doctor,'u');
            if($ray_tec){echo '<div class="f1 clr1">'.k_technician.' : '.get_val_arr('_users','name_'.$lg,$ray_tec,'u').'</div>';}?></td>
            <td class="f1"><?=get_val_arr('gnr_m_clinics','name_'.$lg,$clinic,'c')?></td>			
			<td class="f1 ff B fs14"><?=dateToTimeS3($time_entr);?></td>
			<td class="f1 ff B fs14"><?=date('Ah:i',$time_chck);?></td>
            <td class="f1 ff B fs14"><?=date('Ah:i',$time_out);?></td>
            <? if($thisGrp=='hrwgtql5wk' || $thisGrp=='o81muv4ggi' || $thisGrp=='s'){echo '<td>'.$workTxt.'</td>';}?>
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
