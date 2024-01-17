<? include("_ajax_head_cFile.php");
if(isset($_POST['type'],$_POST['fil'])){
$type=pp($_POST['type']);
$fil=pp($_POST['fil'],'s');
/************************************/
if($type==1){$fname='Service';}
if($type==2){$fname='';}
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename='.$fname.'_'.date('Ymd-His').'.csv');
$output = fopen('php://output', 'w');
fputs($output, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
/************************************/
if($type==1){
	$q='';	
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
	$sql="select * from gnr_x_insurance_rec $q order by id DESC ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){		
		$ex_header=array(k_patients,k_clinic,k_procedure,k_date,k_doctor,k_job_code,k_insure_code,k_insure_comp,k_price_serv,k_ten_percent);
		fputcsv($output,$ex_header);        
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
			list($u_name,$career_code,$insurance_code)=get_val('_users','name_'.$lg.',career_code,insurance_code',$doc);
			fputcsv($output,
				array(
					get_p_name($patient),
					get_val('gnr_m_clinics','name_'.$lg,$clinic),
					$serName,
					dateToTimeS3($s_date),
					$u_name,
					$career_code,
					$insurance_code,
					get_val('gnr_m_insurance_prov','name_'.$lg,$company),
					number_format($in_price),
					number_format($in_price/10)
				)
			);
		}
	}
}
}?>