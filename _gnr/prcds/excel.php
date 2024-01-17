<? session_start();
include("../__sys/mods/protected.php");
$folderBack='';
if($_GET['root']){
    $folderBack=intval($_GET['root']);
    $folderBack=str_repeat('../',$folderBack);
}
include($folderBack."__sys/dbc.php");
include($folderBack."__main/define.php");
include($folderBack."__sys/f_funs.php");
$lang_data=checkLang();
$lg=$lang_data[0];//main languge
$l_dir=$lang_data[1];//defult diratoin (ltr or rtl)
$l_dirX=$lang_data[7];
$lg_s=$lang_data[2];// active lang list code ar en sp
$lg_n=$lang_data[3];// active lang list text Arabic English
$lg_s_f=$lang_data[4];// all lang list code ar en sp
$lg_n_f=$lang_data[5];// all lang list text Arabic English
$lg_dir=$lang_data[6];
if($l_dir=="ltr"){define('k_align','left');	define('k_Xalign','right');}else{define('k_align','right');define('k_Xalign','left');}
include($folderBack."__main/lang/lang_k_$lg.php");
include($folderBack."__sys/lang/lang_k_$lg.php");
if($thisGrp=='s'){include($folderBack."__super/lang/lang_k_$lg.php");}
include($folderBack."__sys/cssSet.php");
include($folderBack."__main/lang/lang_k_$lg.php");
include($folderBack."__sys/lang/lang_k_$lg.php");
include($folderBack."__sys/funs.php");
include($folderBack."__sys/funs_co.php");
include($folderBack.'__main/funs.php');
include($folderBack."__sys/define.php");
loginAjax();list($proAct,$proUsed)=proUsed();
foreach($proUsed as $p){	
	$inc_file1=$folderBack.'_'.$p.'/funs.php';
	$inc_file2=$folderBack.'_'.$p.'/define.php';
	if(file_exists($inc_file1)){include_once($inc_file1);}
	if(file_exists($inc_file2)){include_once('../_'.$p.'/define.php');}
}
if(isset($_GET['type'] , $_GET['id'])){
	header('Content-Type: text/csv; charset=UTF-8');
	header('Content-Disposition: attachment; filename=insur_'.$now.'.csv');
	$output = fopen('php://output', 'w');
	fputs($output, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
	$type=pp($_GET['type'],'s');
	$id=pp($_GET['id']);
	$id2=pp($_GET['id2']);
	if($type=='Insur'){
		$custumPrices=array();
		$sql="select * from gnr_m_insurance_prices where type='$id' and insur='$id2' ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		while($r=mysql_f($res)){
			$service=$r['service'];
			$price=$r['price'];
			$custumPrices[$service]=$price;
		}
		fputcsv($output,array($ex_title));
		if($id==1){				
			$sql="select * from cln_m_services where act=1 order by clinic ASC , name_$lg ASC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows){					
				$ex_title ='أسعار خدمات العيادات المقدم  للشركة التأمين ( '.get_val('gnr_m_insurance_prov','name_'.$lg,$id2).' ) - عدد البنود :  ( '.$rows.' )';
				fputcsv($output,array($ex_title));
				fputcsv($output,array('#','العيادة','الخدمة','السعر'));
				$i=1;
				while($r=mysql_f($res)){						
					$s_id=$r['id'];
					$clinic=$r['clinic'];
					$name=$r['name_'.$lg];
					$hos_part=$r['hos_part'];
					$doc_part=$r['doc_part'];						
					$price=$hos_part+$doc_part;
					$f_price=$price/((100-_set_1foqr1nql3)/100);
					$f_price=roundNo($f_price,500);
					if($custumPrices[$s_id]){$f_price=$custumPrices[$s_id];}					
					fputcsv($output,array($i,get_val('gnr_m_clinics','name_'.$lg,$clinic),$name,$f_price));
					$i++;
				}
			}				
		}
		if($id==2){
			$sql="select * from lab_m_services where act=1 order by cat ASC , short_name ASC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows){
				$ex_title=k_tests_prices_to_insure_comps.' ( '.get_val('gnr_m_insurance_prov','name_'.$lg,$id2).' ) - '.k_items_num.' : ( '.$rows.' )';
				fputcsv($output,array($ex_title));
				fputcsv($output,array('#',k_cat,k_service,k_price));
				$i=1;
				while($r=mysql_f($res)){						
					$s_id=$r['id'];
					$cat=$r['cat'];
					$name=$r['short_name'];
					$unit=$r['unit'];						
					$price=$unit*_set_x6kmh3k9mh;
					$f_price=$price+($price*_set_1foqr1nql3/100);
					if($custumPrices[$s_id]){$f_price=$custumPrices[$s_id];}
					fputcsv($output,array($i,get_val('lab_m_services_cats','name_'.$lg,$cat),$name,$f_price));
					$i++;
				}
			}				
		}
        if($id==3){				
			$sql="select m.name_$lg as srv , x.price as price , clinic from xry_m_services m  , gnr_m_insurance_prices x 
            where m.act=1 
            and x.insur=$id
            and x.type=3
            and x.service=m.id
            order by clinic ASC , name_$lg ASC";
            $res=mysql_q($sql);
            $rows=mysql_n($res);
            if($rows){
				$ex_title =k_clin_srvcs_to_insure_comps.' ( '.get_val('gnr_m_insurance_prov','name_'.$lg,$id2).' ) - 
				'.k_items_num.' :  ( '.$rows.' )';
				fputcsv($output,array($ex_title));
				fputcsv($output,array('#',k_tclinic,k_service,k_price));
				$i=1;
				while($r=mysql_f($res)){						
					$s_id=$r['id'];
					$clinic=$r['clinic'];
					$name=$r['srv'];
                    $price=$r['price'];
									
					fputcsv($output,array($i,get_val_arr('gnr_m_clinics','name_'.$lg,$clinic,'c'),$name,$price));
					$i++;
				}
			}				
		}
		if($id==4){			
			$sql="select * from den_m_services where act=1 order by cat ASC , name_$lg ASC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows){
				$ex_title =k_dent_prices_to_insur_comps.' ( '.get_val('gnr_m_insurance_prov','name_'.$lg,$id2).' ) - '.k_items_num.' : ( '.$rows.' )';
				fputcsv($output,array($ex_title));
				fputcsv($output,array('#',k_cat,k_service,k_price));
				$i=1;
				while($r=mysql_f($res)){
					$star='';
					$s_id=$r['id'];
					$cat=$r['cat'];
					$name=$r['name_'.$lg];
					$hos_part=$r['hos_part'];
					$doc_part=$r['doc_part'];						
					$price=$hos_part+$doc_part;
					$f_price=$price+($price*_set_1foqr1nql3/100);
					if($custumPrices[$s_id]){$f_price=$custumPrices[$s_id];}
					fputcsv($output,array($i,get_val('den_m_services_cat','name_'.$lg,$cat),$name,$f_price));
					$i++;
				}					
			}			
		}
	}
	fclose($output);
}?>