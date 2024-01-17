<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['fil'] , $_POST['p'])){
	$pvl=pp($_POST['fil'],'s');
	$pars=explode('|',$pvl);
	$q='';
	$q2='';
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
			if($cal=='p7'){if($q){$q.=" AND ";}$q.=" doctor = '$val1' ";}
			if($cal=='p8'){if($q){$q.=" AND ";}$q.=" clinic = '$val1' ";}
			
			if($cal=='p9'){if($q){$q.=" AND ";}$q.=" status = '$val1' ";}
			if($cal=='p10'){if($q){$q.=" AND ";}$q.=" type = '$val1' ";}
			if($cal=='p11'){if($q){$q.=" AND ";}$q.=" pay_type = '$val1' ";}
			if($cal=='p12'){if($q){$q.=" AND ";}$q.=" fast = '$val1' ";}
            if($cal=='pIns'){if($q){$q.=" AND ";}$q.="pay_type=3 and  pay_type_link = '$val1' ";}
		}
	}
	if($q2){if($q){$q.=" AND ";}$q.=" patient IN( select id from gnr_m_patients where $q2 ) ";}
	
	if($q){$q=" where $q ";}
	$res=mysql_q("select count(*)c from lab_x_visits  $q ");
	$r=mysql_f($res);
	$pagination=pagination('','',10,$r['c']); 
	$page_view=$pagination[0];
	$q_limit=$pagination[1];	
	$all_rows=$pagination[2];
	echo ' '.number_format($all_rows).' <!--***-->';
	$sql="select * from lab_x_visits $q order by id DESC $q_limit";
	$res=mysql_q($sql);
	$rows=mysql_n($res);	
	if($rows>0){?>
		<table width="100%" border="0"  class="grad_s holdH" type="static" cellspacing="0" cellpadding="4" over="0" >		
		<tr>
       	<th class="fs16 f1">#</th>
        <th class="fs16 f1"><?=k_patient?></th> 
        <th class="fs16 f1"><?=k_reception?></th>
		<th class="fs16 f1"><?=k_start_date?></th>
		<th class="fs16 f1"><?=k_tests_val?></th>
		<th class="fs16 f1"><?=k_payed_amount?></th>
		<th class="fs16 f1"><?=k_status?></th>
        <th class="fs16 f1" width="40"></th>
        </tr> <?
		while($r=mysql_f($res)){
			$id=$r['id'];			
			$patient=$r['patient'];			
			$cType=2;
			$type=$r['type'];
			$pay_type=$r['pay_type'];
            $pay_type_link=$r['pay_type_link'];
            $payLinkName=paymentName($pay_type,$pay_type_link);
			$status=$r['status'];			
			$time_entr=$r['d_start'];			
			$reg_user=$r['reg_user'];			
			$total_pay=get_sum('lab_x_visits_services','total_pay'," visit_id='$id' and status !=3 ");
			$pay_net=get_sum('lab_x_visits_services','pay_net'," visit_id='$id' and status !=3 ");
			$action='showAcc('.$id.','.$cType.')';?>
			<tr>
			<td class="ff B fs16"><?=$id?></td>
			<td class="f1"><?=get_p_name($patient)?></td>
            <td class="f1"><?=get_val('_users','name_'.$lg,$reg_user)?></td>            
			<td class="f1 ff B fs14"><?=dateToTimeS3($time_entr);?></td>
			<td><ff class="clr1"><?=number_format($total_pay);?></ff></td>
			<td><ff class="clr6"><?=number_format($pay_net);?></ff></td>
			<td class="f1"><div style="color:<?=$lab_vis_sClr[$status]?>" class="f1 fs14"><?=$lab_vis_s[$status]?></div>
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

	