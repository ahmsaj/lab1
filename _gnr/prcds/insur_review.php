<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['fil'] , $_POST['p'])){
	$pvl=pp($_POST['fil'],'s');
	$pars=explode('|',$pvl);
	$q='';
	$q2='';
	if($thisGrp=='pfx33zco65'){$q.=" user = '$thisUser' ";}	
	//if(in_array($thisGrp,array('1ceddvqi3g'))){$q.=" ray_tec = '$thisUser' and doctor =0 ";}
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
					$q.=" s_date >= ". strtotime($val1);
				}
				if($val2){
					if($q){$q.=" AND ";}
					$q.=" s_date < ".(strtotime($val2)+86400);
				}
			}
			if($cal=='p0'){if($q){$q.=" AND ";}$q.=" insur_no = '$val1' ";}
			if($cal=='p1'){if($q){$q.=" AND ";}$q.=" visit = '$val1' ";}
			if($cal=='p11'){if($q){$q.=" AND ";}$q.=" ref_no = '$val1' ";}
			if($cal=='p6'){if($q){$q.=" AND ";}$q.=" `user` = '$val1' ";}
			if($cal=='p7'){if($q){$q.=" AND ";}$q.=" doc = '$val1' ";}		
			if($cal=='p8'){if($q){$q.=" AND ";}$q.=" company = '$val1' ";}
			if($cal=='p9'){if($q){$q.=" AND ";}$q.=" res_status = '$val1' ";}
		}
	}
	if($q2){if($q){$q.=" AND ";}$q.=" patient IN( select id from gnr_m_patients where $q2 ) ";}
	
	if($q){$q=" where $q ";}
	$sql="select count(*)c from gnr_x_insurance_rec  $q ";
	$res=mysql_q($sql);
	$r=mysql_f($res);
	$pagination=pagination('','',10,$r['c']); 
	$page_view=$pagination[0];
	$q_limit=$pagination[1];	
	$all_rows=$pagination[2];
	echo ' '.number_format($all_rows).' <!--***-->';
	$sql="select * from gnr_x_insurance_rec $q order by id DESC $q_limit";
	$res=mysql_q($sql);
	$rows=mysql_n($res);	
	if($rows>0){?>
		<table width="100%" border="0"  class="grad_s holdH" type="static" cellspacing="0" cellpadding="4" over="0" >		
		<tr>
		<th><?=k_date?></th>
		<th><?=k_company?></th>
		<th><?=k_insurance_no?></th>
		<th><?=k_patient?></th>
		<th><?=k_doctor?></th>						
		<th><?=k_thvisit?></th>						
 		<? if($thisGrp!='kzfr3ekg3'){echo '<th>'.k_inpt.'</th>';}?>		
		<th><?=k_insure_price?></th>
		<th><?=k_includ?></th>
		<th><?=k_uncovered_amount?></th>
		<th><?=k_bill_number?></th>
		<th><?=k_status?></th>
         <th class="fs16 f1" width="40"></th>
        </tr> <?
		while($r=mysql_f($res)){
			$id=$r['id'];
			$c_id=$r['company'];
			$insur_no=$r['insur_no'];
			$patient=$r['patient'];
			$doc=$r['doc'];
			$mood=$r['mood'];
			$visit=$r['visit'];
			$service_x=$r['service_x'];
			$service=$r['service'];
			$price=$r['price'];
			$in_price=$r['in_price'];
			$in_price_includ=$r['in_price_includ'];
			$in_cost=$r['in_cost'];
			$s_date=$r['s_date'];
			$r_date=$r['r_date'];
			$user=$r['user'];
			$res_status=$r['res_status'];
			$ref_no=$r['ref_no'];			
			$docName=get_val('_users','name_'.$lg,$doc);
			
			$all_pi+=$in_price;
			$all_pii+=$in_price_includ;
			$prisX=0;
			if($res_status==1){
				$prisX=$in_price-$in_price_includ;
				$all_pix+=$prisX;
			}
			echo '<tr>';
			
			echo '<td><ff>'.date('Y-m-d',$s_date).'</ff></td>
			<td class="f1 fs14 cur " onclick="changeRVal('.$c_id.')">'.get_val('gnr_m_insurance_prov','name_'.$lg,$c_id).'</td>
			<td><ff>'.$insur_no.'</ff></td>
			<td class="f1">'.get_p_name($patient).'</td>
			<td class="f1">'.$docName.'</td>
			<td class="f1">'.$clinicTypes[$mood].'<br><ff class="fs14">'.$mood.'-'.$visit.'</ff></td>';
			if($thisGrp!='kzfr3ekg3'){echo '<td class="f1">'.get_val('_users','name_'.$lg,$user).'</td>';}
			echo '
			<td><ff class="clr1">'.number_format($in_price).'</ff></td>
			<td><ff class="clr6">'.number_format($in_price_includ).'</ff></td>
			<td><ff class="clr5">'.number_format($prisX).'</ff></td>
			<td><ff>'.$ref_no.'</ff></td>
			<td><span class="f1 '.$insurStatusColArr[$res_status].'">'.$reqStatusArr[$res_status].'</span></td>
			<td class="f1"><div class="ic40 icc1 ic40_info" onclick="insur_info('.$id.')"></div></td>
			</tr>';
		
		}		
	}else{
		echo '<div class="lh40 f1 fs18 clr5">'.k_no_results.'</div>';
	}
	echo '<!--***-->'.$page_view;	
	}
?>

	