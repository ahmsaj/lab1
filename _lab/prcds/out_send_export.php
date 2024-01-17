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
if(isset($_POST['pars_sams_s'])){
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=3_'.$now2.'.csv');
	$output = fopen('php://output', 'w');
	//$pars=$_POST['pars_cons_t'];
	$pars=explode('|',$_POST['pars_sams_s']);
	$q='';
	$q2='';
		foreach($pars as $p){
			if($p!=''){
				$pp=explode(':',$p);
				$cal=$pp[0];
				$val1=$pp[1];
				$val2=$pp[2];			
				if($cal=='p1'){if($q){$q.=" AND ";}$q.="name_".$lg."like%'$val1'% ";}
				if($cal=='p5'){if($q){$q.=" AND ";}$q.="code='$val1'";}
				if($cal=='p6'){if($q){$q.=" AND ";}$q.="short_name like%'$val1'% ";}
				if($cal=='p2'){if($q){$q.=" AND ";}$q.="x.patient in (select id from gnr_m_patients where f_name like '%$val1%')";}
				if($cal=='p3'){if($q){$q.=" AND ";}$q.="x.patient in (select id from gnr_m_patients where ft_name like '%$val1%')";}
				if($cal=='p4'){if($q){$q.=" AND ";}$q.="x.patient in (select id from gnr_m_patients where l_name like '%$val1%')";}
				if($cal=='p7'){if($q){$q.=" AND ";}$q.="x.patient in (select id from gnr_m_patients where sex = '$val1')";}
				if($cal=='d1'){
					if($val1){
						if($q2){$q2.=" AND ";}
						$q2.="sample_link in(select id from lab_x_visits_samlpes where  date > ". strtotime($val1).")";
					}
					if($val2){
						if($q2){$q2.=" AND ";}
						$q2.="sample_link in (select id from lab_x_visits_samlpes where  date < ".(strtotime($val2)+86400).")";
					}
				}

			}
		}
		if($q2){$q2=" WHERE $q2";}

		if($q){$q=" AND $q ";}
		 $sql="select *, x.visit_id as visitid , x.patient as patientid, x.id as x_id from lab_x_visits_services x ,lab_m_services m where  x.service=m.id and x.out_lab=0 and $q2 m.outlab=1 $q ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			while($r=mysql_f($res)){
				$x_id=$r['x_id'];
				$visit_id=$r['visitid'];
				$code=$r['code'];
				$short_name=$r['short_name'];
				$patient=$r['patientid'];
				list($f_name,$ft_name,$l_name)=get_val('gnr_m_patients','f_name,ft_name,l_name',$patient);
				$patient_name=$f_name.' '.$ft_name.' '.$l_name;
				$price=$r['total_pay'];
				fputcsv($output,array($visit_id,$patient_name,$code,$short_name,$price));
				
			}
		
	}else{
		echo k_no_results;
	}
}?>
