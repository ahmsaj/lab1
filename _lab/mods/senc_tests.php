<? session_start();
include("min/dbc.php");
include("__sys/f_funs.php");
$lang_data=checkLang();
$lg=$lang_data[0];//main languge
$l_dir=$lang_data[1];//defult diratoin (ltr or rtl)
$lg_s=$lang_data[2];// active lang list code ar en sp
$lg_n=$lang_data[3];// active lang list text Arabic English
$lg_s_f=$lang_data[4];// all lang list code ar en sp
$lg_n_f=$lang_data[5];// all lang list text Arabic English
include("__main/lang/lang_k_$lg.php");
include("__sys/lang/lang_k_$lg.php");
include("__sys/funs.php");
include("__sys/funs_co.php");
include("__sys/define.php");
include("_lab/funs.php");
include("_gnr/funs.php");
$dir='tests';
$ana_arr=array();
$ana_res=array();
$cdir=scandir($dir);
echo '<meta charset="utf-8"><table border="1" cellpadding="5">
<tr><th width="250">Patient</th><th width="250">Machine</th><th width="150">Date</th><th>Sample </th><th>Ala</th></tr>';
foreach ($cdir as $key => $value){
	unset($ana_arr);
	if (!in_array($value,array(".",".."))){
  		$anal_id=0;		
 		if(!is_dir($dir . DIRECTORY_SEPARATOR . $value)){
			$file=$dir.'/'.$value;
			$fData=file_get_contents($file);		
			$lines=explode("\r", $fData);				
			$l=explode('|', $lines[0]);
			$machine=$l[2];
			list($anal_id,$data,$type,$sampleSet)=get_val_con('lab_m_devices','analysis,data,type,sample'," code='$machine' and act=1");
			list($samLine,$samObj)=explode('-',$sampleSet);

			$i=0;
			if($anal_id){
				$ana_arr=getMAnaArr($data);
				$date=$l[6];
				$sample=intval($l[9]);
				$dateTxt=substr($date,0,4).'-'.substr($date,4,2).'-'.substr($date,6,2).' '.substr($date,8,2).':'.substr($date,10,2).':'.substr($date,12,2);
				$service_id=get_anafromSamp($sample,$anal_id);
				foreach($lines as $line){
					$l=explode('|', $line);
					if($i==$samLine){$sample=intval($l[$samObj]);}
					if($i>0){						
						if(trim($l[0])=='OBX'){
							$codNo=3;
							if($type==2){$codNo=4;}
							$anaCode=$l[$codNo];							
							$ana_res[$ana_arr[$anaCode]]=$l[5];
						}else if($l[0]=='OBX' && $l[2]=='ED'){}
					}
					$i++;
				}
				if($sample){
					$service_id=get_anafromSamp($sample,$anal_id);
					$sql="select * from lab_x_visits_services where id in($service_id) ";
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					if($rows>0){
						while($r=mysql_f($res)){
							$x_id=$r['id'];
							$vis_id=$r['visit_id'];
							$name=$r['short_name'];
							$report_de=$r['report_de'];
							$type=$r['type'];
							$patient=$r['patient'];
							$vis=$r['visit_id'];
							$sample_id=$r['sample'];
							$srv_status=$r['status'];
							$srv_id=get_val('lab_x_visits_services','service',$x_id);

							list($sex,$age)=getPatInfoL($patient);		
							if(in_array($srv_status,array(5,6,7,9))){						
								if($type==1 || $type==4){					
									$sql2="select * from lab_m_services_items  where serv='$srv_id' and type=2 and act=1 order by ord ASC";echo '<br>';
									$res2=mysql_q($sql2);
									$rows2=mysql_n($res2);
									if($rows2>0){
										$completed=1;						
										while($r2=mysql_f($res2)){	
											$status=0;
											$addVals='';			
											$s_id=$r2['id'];
											$unit=$r2['unit'];				
											$r_type=$r2['report_type'];
											if($ana_res[$s_id]){
												$value=$ana_res[$s_id];
												$dec_point=get_val('lab_m_services_units','dec_point',$unit);
												$value=numFor($value,$dec_point);

												if($value!=''){$status=1;}else{$completed=0;}	list($nVal,$addVals)=get_LreportNormalVal($r_type,$s_id,$vis_id,$sex,$age,$sample_id,1);
												if(getTotalCO('lab_x_visits_services_results'," serv_id='$x_id' and serv_val_id='$s_id' ")==0){
													$sql3="INSERT INTO lab_x_visits_services_results 
													(`serv_id`, `serv_val_id`, `serv_type`, `value`, `add_value`, `normal_val`, `user`, `status`,`patient` ,`vis`,`date`) VALUES 
													('$x_id','$s_id', '$r_type', '$value', '$addVals', '$nVal','$thisUser','$status' , '$patient' ,'$vis_id','$now')";

												}else{
													$sql3="UPDATE lab_x_visits_services_results SET 
													`serv_type`='$r_type' , 
													`value`='$value',
													`add_value`='$addVals',
													`normal_val`='$nVal',
													`user`='$thisUser',
													`status`='$status'
													WHERE serv_id='$x_id' and serv_val_id='$s_id'";
												}
												if(mysql_q($sql3)){

												}
											}
										}
										if($completed==1){$vs_status=7;}else{$vs_status=6;}
										if($srv_status==9){$vs_status=10;}
										mysql_q("UPDATE lab_x_visits_services set status='$vs_status' , report_wr='$thisUser' , date_enter='$now' where id='$x_id'");
										mysql_q("UPDATE lab_x_visits_services_results_x set status=1 where srv='$x_id'");
									}
								}
							}				
							if(mysql_q("INSERT INTO lab_x_tmp_tests (`date`,`machine`,`pat`,`vis`,`serv`,`sample`,`data`)
							values('$now','$machine','$patient','$vis','$x_id','$sample','$fData');")
							){
								unlink($file);
							}
							echo '<tr>
							<td>'.get_p_name($patient).'</td>
							<td>'.$machine.'</td>
							<td>'.$dateTxt.'</td>
							<td>'.$sample.'</td>
							<td>'.$x_id.'</td>
							</tr>';
						}
					}
				}else{
					unlink($file);
				}
			}
		} 
	} 
} 
echo '</table>';
function get_anafromSamp($s,$a){
	$srvs=get_val_c('lab_x_visits_samlpes','services',$s,'no');
	if($srvs){
		//echo $sql="select * from lab_x_visits_services where id IN($srvs) and servicein('$a')";
		/*$res=mysql_q($sql);
		$r=mysql_f($res);
		return  $r['id'];*/
		return get_vals('lab_x_visits_services','id',"id IN($srvs) and service in($a)");
	}
}
function getMAnaArr($data){
	$out=array();
	$d=explode(',',$data);
	foreach($d as $i){
		$v=explode(':',$i);
		$out[$v[1]]=$v[0];
	}
	return $out;
}
?>
<script>setTimeout(function(){document.location="";},10000);</script>