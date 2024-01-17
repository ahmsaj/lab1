<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['fil'] , $_POST['p'])){
	$q='';
	$fil=pp($_POST['fil'],'s');
	$pars=explode('|',$fil);
	foreach($pars as $p){
		if($p!=''){
			$pp=explode(':',$p);
			$cal=$pp[0];
			$val1=$pp[1];
			$val2=$pp[2];			
			if($cal=='d1'){
				if($val1){
					if($q){$q.=" AND ";}
					$q.=" s_date > ". strtotime($val1);
				}
				if($val2){
					if($q){$q.=" AND ";}
					$q.=" s_date < ".(strtotime($val2)+86400);
				}
			}
		}
	}
	if($q){$q=" where $q ";}
	$sql="select count(*)c from gnr_x_insurance_rec  $q ";
	$res=mysql_q($sql);
	$r=mysql_f($res);
	$pagination=pagination('','',10,$r['c']); 
	$page_view=$pagination[0];
	$q_limit=$pagination[1];	
	$all_rows=$pagination[2];
	echo ' '.number_format($all_rows).' <!--***-->
	<form name="ex_form" method="post" action="Excel-Ex" target="_blank">	
	<input type="hidden" name="fil" value="'.$fil.'" />    
    <input type="hidden" name="type" value="1" />    
	</form>';
	//echo ' <div class="bu bu_t3 fr" onclick="sub(\'ex_form\')">تصدير</div> <!--***-->';
	$sql="select * from gnr_x_insurance_rec $q order by id DESC $q_limit";
	$res=mysql_q($sql);
	$rows=mysql_n($res);	
	if($rows>0){?>
		<div class="hh10"></div>
		<table width="100%" border="0"  class="grad_s holdH" type="static" cellspacing="0" cellpadding="4" over="0" >		
		<tr>       	
		<th class="fs16 f1"><?=k_patients?></th>
		<th class="fs16 f1"><?=k_clinic?></th>
		<th class="fs16 f1"><?=k_procedure?></th>
		<th class="fs16 f1"><?=k_date?></th>
        <th class="fs16 f1"><?=k_doctor?></th> 
        <th class="fs16 f1"><?=k_job_code?></th>
        <th class="fs16 f1"><?=k_insure_code?></th>
        <th class="fs16 f1"><?=k_insure_comp?></th>
        <th class="fs16 f1"><?=k_price_serv?></k_?></th>
		<th class="fs16 f1"><?=k_ten_percent?></th>
        </tr> <?
		while($r=mysql_f($res)){
			$id=$r['id'];
			$patient=$r['patient'];
			$visit=$r['visit'];
			$mood=$r['mood'];	
			$service=$r['service'];
			$in_price=$r['in_price'];
			$company=$r['company'];
			$doc=$r['doc'];
			$s_date=$r['s_date'];
			if($mood==1){
				$clinic=get_val('cln_x_visits','clinic',$visit);
				$serName=get_val('cln_m_services','name_'.$lg,$service);
			}
			if($mood==2){
				$clinic=get_val_con('gnr_m_clinics','id'," type=2 ");
				$serName=get_val('lab_m_services','name_'.$lg,$service);
			}
			if($mood==3){
				$clinic=get_val('xry_x_visits','clinic',$visit);
				$serName=get_val('xry_m_services','name_'.$lg,$service);
			}
			if($mood==4){
				$clinic=get_val('den_x_visits','clinic',$visit);
				$serName=get_val('den_m_services','name_'.$lg,$service);
			}
			if($mood==5){
				$clinic=get_val('bty_x_visits','clinic',$visit);
				$serName=get_val('bty_m_services','name_'.$lg,$service);
			}
			$u_name=$career_code=$insurance_code='';
			list($u_name,$career_code,$insurance_code)=get_val('_users','name_'.$lg.',career_code,insurance_code',$doc)?>
			<tr>			
			<td class="f1"><?=get_p_name($patient)?></td>            
            <td class="f1"><?=get_val('gnr_m_clinics','name_'.$lg,$clinic);?></td>
			<td class="f1"><?=$serName;?></td>
			<td class="f1 ff B fs14"><?=dateToTimeS3($s_date);?></td>
			<td class="f1"><?=$u_name;?></td>
			<td class="f1"><?=$career_code;?></td>
			<td class="f1"><?=$insurance_code;?></td>
			<td class="f1"><?=get_val('gnr_m_insurance_prov','name_'.$lg,$company)?></td>
			<td><ff><?=number_format($in_price)?></ff></td>
			<td><ff><?=number_format($in_price/10)?></ff></td>
			</tr><?
		}
		?></table><?
	}else{
		echo '<div class="lh40 f1 fs18 clr5">'.k_no_results.'</div>';
	}
	echo '<!--***-->'.$page_view;
}
?>

	