<? 
include("__sys/dbc.php");
include('__sys/start.php'); 
if($thisGrp=='s'){  
include_once('_str/funs.php');
include_once('_gnr/funs.php');
include_once('_cln/funs.php');
include_once('_lab/funs.php');
include_once('_bty/funs.php');
include_once('_xry/funs.php');
include_once('_osc/funs.php');

function fixVisitSevesClnFix($id){
	$sql="select * from cln_x_visits where id='$id' and  status>0 limit 1";	
	$res=mysql_q($sql);
	$rows=mysql_n($res);	
	if($rows>0){
		$r=mysql_f($res);
		$patient=$r['patient'];
		$doctor=$r['doctor'];
		$clinic=$r['clinic'];
		$d_start=$r['d_start'];
		$d_check=$r['d_check'];
		$d_finish=$r['d_finish'];
		$pay_type=$r['pay_type'];
		if($d_check==0){mysql_q("UPDATE cln_x_visits SET d_check=d_start where id='$id' ");}
		$sql2="select * from cln_x_visits_services where visit_id='$id' ";
		$res2=mysql_q($sql2);
		$rows2=mysql_n($res2);
		if($rows2>0){
			while($r2=mysql_f($res2)){
				$s_id=$r2['id'];
				$hos_part=$r2['hos_part'];
				$doc_part=$r2['doc_part'];
				$doc_percent=$r2['doc_percent'];
				$pay_net=$r2['pay_net'];
				$service=$r2['service'];				
				$cost=$r2['cost'];
				$clinic=$r2['clinic'];
				/**********************/
				$fp_dd=0;
				$fp_hh=0;
				$total_pay=$hos_part+$doc_part;
				$dis=$total_pay-$pay_net;
				if($pay_type==2 || $pay_type==3){$dis=0;}			
				if($dis==0){
					if($doc_percent==0){
						$doc_bal= 0;
						$hos_bal=$total_pay;
					}else{
						$doc_bal= intval($doc_percent*$doc_part/100);
						$hos_bal=$total_pay-$doc_bal;
					}
				}else{
					if($hos_part<=$doc_part){
						$dis_x=$hos_part/$doc_part;
						$fp_dd=intval($dis/($dis_x+1));
						$fp_hh=$dis-$fp_dd;
					}else{
						$dis_x=$doc_part/$hos_part;
						$fp_hh=intval($dis/($dis_x+1));
						$fp_dd=$dis-$fp_hh;
					}
					if($pay_net==0 && $pay_type==1){
						$doc_bal=0;$hos_bal=0;
					}else{				
						$doc_bal=intval(($doc_part-$fp_dd)/100*$doc_percent); 
						$hos_bal=($total_pay-$dis)-$doc_bal;
					}
				}
				if($cost>0){					
					$doc_bal=($doc_part-$cost)/100*$doc_percent;
				}
				$sql3="UPDATE cln_x_visits_services set 
				total_pay='$total_pay' ,
				doc='$doctor',
				doc_dis='$fp_dd' ,
				hos_dis='$fp_hh' , 
				hos_bal='$hos_bal' ,
				doc_bal='$doc_bal' , 
				patient='$patient' ,			
				clinic='$clinic' ,
				d_start='$d_start' ,
				d_finish='$d_finish' 
				where id='$s_id' ";
				mysql_q($sql3);
			}
			/**********************/
			fixPatAccunt($patient);
			if($pay_type==2){fixCharServ(1,$id);}
			if($pay_type==1){fixExeServ(1,$id);}
		}
	}
}
$visXTables=array('','cln_x_visits','lab_x_visits','xry_x_visits','den_x_visits','bty_x_visits','bty_x_laser_visits','osc_x_visits');
$srvXTables=array('','cln_x_visits_services','lab_x_visits_services','xry_x_visits_services','den_x_visits_services','bty_x_visits_services','bty_x_laser_visits_services','osc_x_visits_services');
$srvTables=array('','cln_m_services','lab_m_services','xry_m_services','den_m_services','bty_m_services','bty_m_services','osc_m_services');
/*************************/
$oprs=[

['1','حقول إضافية'],
['9865847684','ميزة حذف خدمات الاسنان'],
['42666','خصائح الحقول'],
['84654','تصحيح العينات'],

];?>
<style>
.butts{float: left;width: 20%; border-right: 1px #ccc solid;padding:5px;margin-right:5px;height: 100%; box-sizing: border-box; background-color: #ccc; overflow-x: hidden;}
.butts div{padding:5px;margin-bottom:5px;background-color:#0D60A3;color:#fff;}
.butts div:hover{background-color:#162094;color:#fff;}
.butts div[act]{background-color:#BF1A43;color:#fff;}
a{text-decoration: none; font-family:'tahoma'; text-align: center; font-size: 14px; color: #000;}
html,body{height: 100%; margin: 0px; padding: 0px; overflow: hidden;}
.data{float: left; height: 100%; width:75%; overflow-x: hidden; background-color: #f9f9f9;padding: 10px; box-sizing: border-box;}
</style>
<!doctype html>
<html lang="en" class="no-js"><head><meta charset="utf-8">
<title>FIX</title></head><body> 
<div class="butts" style=""><?
function tableChange($old,$new){
	if(mysql_q("SHOW TABLES LIKE '$old'")){
		if(mysql_q("RENAME TABLE $old TO $new")){echo $new.'<br>';}
	}
	mysql_q("UPDATE _modules SET `table`='$new' where `table`='$old' ");
	mysql_q("UPDATE _modules_links SET `table`='$new' where `table`='$old' ");

	$sql="select id,type,prams from _modules_items where type in(5,10)";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$id=$r['id'];
			$t=$r['type'];
			$p=$r['prams'];
			if($t==5){
				$pp=explode('|',$p);
				if($pp[3]!=''){
					$mod_code=get_val_c('_modules','code',$pp[3],'module');
					if($mod_code){$p2=addslashes(str_replace($pp[3],$mod_code,$p));	
						mysql_q("UPDATE _modules_items SET prams='$p2' where id='$id'");
					}
				}
				if($pp[0]==$old){
					$new_p=addslashes(str_replace($old,$new,$p));
					echo $id.'='.$new.'<br>';
					mysql_q("UPDATE _modules_items SET prams='$new_p' where id='$id'");
					echo "UPDATE _modules_items SET prams='$new_p' where id='$id'";
				}						
			}
			if($t==10){
				$pp=explode('|',$p);
				if($pp[1]==$old){
					$new_p=addslashes(str_replace($old,$new,$p));
					echo $id.'='.$new.'<br>';
					mysql_q("UPDATE _modules_items SET prams='$new_p' where id='$id'");
				}						
			}
		}
	}

}
$h='http://'.$_SERVER['HTTP_HOST']._path.'fix/';
foreach($oprs as $o){
	$act='';
	if($o[0]==$_GET['o']){$act='act';}
	echo '<a href="'.$h.$o[0].'"><div '.$act.'>'.$o[1].'</div></a>';
}?>
</div><div class="data"><?
if(isset($_GET['o'])){
	$o=$_GET['o'];
  
    if($o==1){
		$res = mysql_q("SHOW COLUMNS FROM `gnr_x_prescription` LIKE 'add_date'");        
        if(mysql_n($res)==0){
            mysql_q("ALTER TABLE `gnr_x_prescription` ADD `add_date` INT(11) NOT NULL DEFAULT '0' ");
            mysql_q("update `gnr_x_prescription` set add_date=date ");         
        }
		/************************** */
		$res = mysql_q("SHOW COLUMNS FROM `gnr_m_clinics` LIKE 'endoscopic'");        
        if(mysql_n($res)==0){
            mysql_q("ALTER TABLE `gnr_m_clinics` ADD `endoscopic` INT(11) NOT NULL DEFAULT '0' ");                
        }
		/************************** */		
		$res = mysql_q("SHOW COLUMNS FROM `_users` LIKE 'doc_sers'");        
        if(mysql_n($res)){
            mysql_q("ALTER TABLE `_users` DROP `doc_sers`;");                
        }
		/************************** */
        if(get_val_c('_settings','id','n5ks40i6j8','code')==0){
            mysql_q("INSERT INTO `_settings` (`code`, `set_ar`, `set_en`, `type`, `note_ar`, `note_en`, `val`, `defult`, `admin`, `ord`, `pars`, `required`, `pro`, `cat`) VALUES 
            ('n5ks40i6j8', 'الجمعيات', 'الجمعيات', '3', '', '', '1', '0', '1', '61', '', '1', 'gnr', '2');");
            echo 'الجمعيات';
            echo '<br>';
        }
        if(get_val_c('_settings','id','auksyptkd','code')==0){
            mysql_q("INSERT INTO `_settings` (`code`, `set_ar`, `set_en`, `type`, `note_ar`, `note_en`, `val`, `defult`, `admin`, `ord`, `pars`, `required`, `pro`, `cat`) VALUES 
            ('auksyptkd', 'تحديد النصوص', 'تحديد النصوص', '3', '', '', '1', '0', '1', '61', '', '1', 'gnr', '2');");
            echo 'تحديد النصوص';
            echo '<br>';
        }

		
		/************************** */
		mysql_q("ALTER TABLE `xry_x_pro_radiography_report` CHANGE `report` `report` MEDIUMBLOB NULL DEFAULT NULL;");

		mysql_q("ALTER TABLE `lab_x_visits_services_results` CHANGE `value` `value` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;");
        echo 'Done';
        
        
    }

    if($o=='9865847684'){

		
		$r=mysql_q("SHOW TABLES LIKE 'den_x_service_delete_log' ;");
		
		if(!mysql_f($r)){
			mysql_q("
				CREATE TABLE den_x_service_delete_log (
					id INT(11) AUTO_INCREMENT NOT NULL,
					visit_id INT(11),
					clinic INT(11),
					doc INT(11) DEFAULT '0',
					service INT(11),
					total_pay INT(11) NOT NULL DEFAULT '0',
					user INT,
					`date` INT,
				PRIMARY KEY (id)
				) ENGINE = myisam ROW_FORMAT = DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
			");
		}
         echo 'done';
    }

	if($o=='42666'){
		$res=mysql_q("select * from _modules_items");
		echo $rows=mysql_n($res);
		echo '<br>';
		if($rows){
			while($r=mysql_f($res)){
				$id=$r['id'];
				$type=$r['type'];
				$prams=$r['prams'];
				if($type==5){
					$p=explode('|',$prams);
					if(count($p)>3){
						if(!$p[4]){$p[4]='';};
						if(!$p[5]){$p[5]='';};
						$view=explode(',',$p[2]);
						$c_view='';
						if(count($view)>1){
							$c_view='['.implode('] [',$view).']';
						}else{
							//s$p[2]='['.$p[2].']';
						}
					
						$newData=[
							'table'=>$p[0],
							'col'=>$p[1],
							'view'=>$p[2],
							'c_view'=>$c_view,
							'mod_link'=>$p[3],
							'cond'=>$p[4],
							'evens'=>$p[5] ?? '',
						];
						$newDatObj=addslashes(json_encode($newData,JSON_UNESCAPED_UNICODE));
						echo $type.' - '.$prams.'<div style="color:#f00">'.$newDatObj.'</div>';
						mysql_q("UPDATE _modules_items SET prams='$newDatObj' where id='$id' ");
					}
				}
			}
		}
		$text="[code] [file] [prog]";		
		preg_match_all('#\[(.*?)\]#', $text, $match);
		echo show_array($match);
		foreach($match[1] as $a){
			echo $a.'<br>';
		}
    }

	if($o=='84654'){
		$sql="select * from  lab_x_visits_services where sample= 0  ";
		$res=mysql_q($sql);
		while($r=mysql_f($res)){
			$id=$r['id'];
			$service=$r['service'];
			echo $sample=get_val('lab_m_services','sample_type',$r['service']);
			mysql_q("update lab_x_visits_services set sample='$sample' where id='$id' "); 
			echo '<br>';
		}
	}
	


}?>
</div></body></html><?
}?>