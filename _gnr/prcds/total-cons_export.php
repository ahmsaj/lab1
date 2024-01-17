<? session_start();
header('Content-Type: text/html; charset=utf-8');
include("../min/dbc.php");
include("../__sys/f_funs.php");
$lang_data=checkLang();
$lg=$lang_data[0];
$l_dir=$lang_data[1];
$lg_s=$lang_data[2];
$lg_n=$lang_data[3];
$lg_s_f=$lang_data[4];
$lg_n_f=$lang_data[5];
$lg_dir=$lang_data[6];
include("../__sys/cssSet.php");
include("../__sys/lang/lang_k_$lg.php");
include("../__sys/funs.php");
include('../__sys/funs_co_add.php');
include("../__sys/funs_co.php");
include("../__sys/define.php");
if(isset($_POST['pars_cons_t'])){
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=2_'.$now2.'.csv');
	$output = fopen('php://output', 'w');
	//$pars=$_POST['pars_cons_t'];
	$pars=explode('|',$_POST['pars_cons_t']);
	$q='';
	$q2='';
	foreach($pars as $p){
		if($p!=''){
			$pp=explode(':',$p);
			$cal=$pp[0];
			$val1=$pp[1];
			$val2=$pp[2];			
			if($cal=='p1'){if($q){$q.=" AND ";}$q.="iteme= '$val1' ";}
			if($cal=='p2'){if($q){$q.=" AND ";}$q.="clinic= '$val1' ";}
			if($cal=='p3'){if($q){$q.=" AND ";}$q.="doc= '$val1' ";}
			if($cal=='d1'){
				if($val1){
					if($q){$q.=" AND ";}
					$q.=" date > ". strtotime($val1);
				}
				if($val2){
					if($q){$q.=" AND ";}
					$q.=" date < ".(strtotime($val2)+86400);
				}
			}
			
		}
	}
	if($q2){if($q){$q.=" AND ";}$q.=" ";}	
	if($q){$q=" where $q ";}
	
	$sql="select sum(r_qunt)rq,iteme,clinic,doc from cln_x_services_items $q group by iteme,clinic,doc ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);	
	if($rows>0){		
		while($r=mysql_f($res)){
			$item=$r['iteme'];
			$clinc=$r['clinic'];			
			$doc=$r['doc'];
			$total_sum=$r['rq'];
			$clinic_name=get_val('gnr_m_clinics','name_'.$lg,$clinc);
			$doc_name=get_val('_users','name_'.$lg,$doc);
			list($item_name,$item_code)=get_val('str_m_items','name,code',$item);
			if($total_sum!=0){
				fputcsv($output,array($item_code,$item_name,$clinic_name,$doc_name,$total_sum));
			}			
		}
	}else{
		echo k_no_results;
	}
}?>