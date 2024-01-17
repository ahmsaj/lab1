<?/***XRY***/ 
function get_xx_cats($clinic){	
	global $lg,$clr1;	
	$out='';
	$sql="select * from xry_m_services_cat where clinic_id='$clinic'  order by name_$lg ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){					
		$out.='<div class="ana_list_cat">';
		$out.='<div class="actCat" cat_num="0">'.k_all_cats.'</div>';		
		while($r=mysql_f($res)){
			$id=$r['id'];
			$catname=$r['name_'.$lg];
			$out.='<div class="norCat" cat_num="'.$id.'">'.$catname.'</div>';
		}
		$out.='</div>';
	}
	return $out;
}
function get_xx($id,$c){
	global $lg,$clr1;
	$out='';
	$selected=array();
	if($id){
		$sql2="select mad_id from xry_x_pro_radiography_items where xph_id='$id'";
		$res2=mysql_q($sql2);
		$rows2=mysql_n($res2);	
		if($rows2>0){while($r2=mysql_f($res2)){$id2=$r2['mad_id'];array_push($selected,$id2);}}
	}
	//$sql=" SELECT * , z1.id as id , z1.name_$lg as name from cln_m_services z1 , xry_m_services_cat z2 where z1.cat=z2.id and z2.clinic_id='$c' ORDER BY z1.name_$lg ASC";
	$sql=" SELECT * , z1.id as id , z1.name_$lg as name , (z1.hos_part+z1.doc_part) as price from xry_m_services z1 , gnr_m_clinics z2 where z1.clinic=z2.id and z2.id='$c' ORDER BY z1.name_$lg ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){		
		$out.='<div class="ana_list_mdc">';
		while($r=mysql_f($res)){
			$id=$r['id'];
			$name=$r['name'];
			$price=$r['price'];
			$cat=$r['cat'];
			$del=0;
			/*if(in_array($id,$selected)){$del=1;}
			$out.='<div class="norCat" cat_mdc="'.$cat.'" s="0" mdc="'.$id.'" name="'.$name.'" del="0" >'.$name.'</div>';*/
			
			$out.='<div class="norCat " cat_mdc="'.$cat.'" s="0" mdc="'.$id.'" name="'.($name).'" code=""  del="0" price="'.$price.'">'.splitNo($name).'</div>';
		}
		$out.='</div>';			
	}
	return $out;
}
function replacRepVals($pat,$def_txt){
	global $now;
	$def_txt=str_replace('<p>','',$def_txt);
	$def_txt=str_replace('</p>','',$def_txt);
	$def_txt=str_replace('[p]',get_p_name($pat),$def_txt);
	$def_txt=str_replace('[p]',get_p_name($pat),$def_txt);
	$def_txt=str_replace('[d]',date('Y-m-d',$now),$def_txt);
	return $def_txt;
}
function prinx_rep($id){
	$status=get_val('xry_x_visits_services','status',$id);
	if($status==1){
		return '<div class="fr ic40 icc1 ic40_print ic40Txt" onclick="x_report_print('.$id.')">'.k_print.'</div>';
	}
}
function get_ser_xry_cats($clinic){	
	global $lg,$clr1;	
	$sql="select * from xry_m_services_cat where clinic_id='$clinic'  order by name_$lg ASC";
	$out='';	
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){		
		$out.='<div class="ana_list_cat">';
		$out.='<div class="actCat" cat_num="0">'.k_all_photos.'</div>';		
		while($r=mysql_f($res)){
			$id=$r['id'];
			$catname=$r['name_'.$lg];
			$out.='<div class="norCat" cat_num="'.$id.'">'.$catname.'</div>';
		}
		$out.='</div>';
	}
	return $out;
}
function get_ser_xry($id,$doc){
	global $lg,$clr1;
	$out='';
	$selected=array();
	$sql=" SELECT * FROM xry_m_services where act=1 and clinic='$id' ORDER BY name_$lg ASC";	
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){		
		$out.='<div class="ana_list_mdc">';
		while($r=mysql_f($res)){
			$id=$r['id'];
			$name=$r['name_'.$lg];
			$cat=$r['cat'];			
			$ana_count=$r['ana_count'];
			$hos_part=$r['hos_part'];
			$doc_part=$r['doc_part'];
			$price=$hos_part+$doc_part;
			if($price && $doc){						
				$newPrice=get_docServPrice($doc,$id,3); 
				$newP=$newPrice[0]+$newPrice[1];
				if($newP){$price=$newP;}
			}
			$del=0;
			if(in_array($id,$selected)){$del=1;}
			$out.='<div class="norCat " cat_mdc="'.$cat.'" mdc="'.$id.'" code="" name="'.$name.'" del="'.$del.'" price="'.$price.'">'.$name.'</div>';
		}
		$out.='</div>';			
	}
	return $out;
}
function fixVisitSevesXry($id){
	$sql="select * from xry_x_visits where id='$id' and  status>1 limit 1";	
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
		if($d_check==0){mysql_q("UPDATE xry_x_visits SET d_check=d_start where id='$id' ");}
		$sql2="select * from xry_x_visits_services where visit_id='$id' ";
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
				$sql3="UPDATE xry_x_visits_services set 
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
			if($pay_type==2){fixCharServ(3,$id);}
			if($pay_type==1){fixExeServ(3,$id);}
		}
	}
}

/**********************Dicom**************************************/
$dcm_perm='';
function modalities($abbreviation){
	global $lg;
	$name=get_val_arr('xry_m_dcm_modalities',"name_$lg","$abbreviation",'dcm_modals','abbreviation');
	return $name;
}
function dicom_link($patient,$service=0,$style=1,$report=0,$hold=''){
	global $mod_study,$dcm_perm;
	//اختبار الصلاحية
	if($dcm_perm==''){$dcm_perm=modPer($mod_study)[0];}
	if($dcm_perm){
		//التحقق من وجود دراسات للمريض
		$query="patient='$patient'";
		if($service){$query.=" and service='$service'";}
		$studies_co=getTotalCO('xry_x_dcm_studies',$query);
		$cbg='icc1';
		if($studies_co){$cbg='icc3 ';}	
		$out='';
		$action='onclick="loadpatientStudies('.$patient.','.$service.','.$report.',\''.$hold.'\')"';
		$title="DICM ($patient)";
		if($style=='1'){
			$title="DICM ";
			$out='<div class="bu buu ic40n Over '.$cbg.'" '.$action.' fix="w:120">'.$title.'</div>';
		}
		if($style=='2'){
			$title="DICM ";
			$cbg='icc3';
			$title=k_add_dicom_img;
			if($studies_co){$title=k_added_imgs.' <ff>('.$studies_co.')</ff> ';$cbg='icc1 ';}	
			$out='<div class="ic40 ic40_image ic40Txt  '.$cbg.'" '.$action.' fix="wp:0">'.$title.'</div>';
		}
		if($style=='3'){
			if($studies_co){
				$title=' ('.k_dicm_imgs_added.') ';
				$out='<div class="ic40 ic40_image ic40Txt icc4" '.$action.' fix="">'.$title.'</div>';
			}
		}
		if($style=='4'){
			//if($studies_co){
				$out='<div i2 '.$action.' >'.k_dicom_imgs.' <span> ( '.$studies_co.' )</span></div>';
			//}
		}
		return $out;
	}	
}
function store_patient_info($patient,$sop_patient){
	$patient_id=get_val('xry_x_dcm_patients','id',"sop_patient='$sop_patient'");
	if(!$patient_id || $patient_id==''){
		$sql="insert into xry_x_dcm_patients (patient,sop_patient) values('$patient','$sop_patient')";
		if(mysql_q($sql)){return last_id();}
	}
	return 0;
}
function store_series_info($info_series,$study){
	global $req_attr_series;
	$sop_series=$info_series['ID'];
	$isStable=intval($info_series['IsStable']);
	$modality=$info_series['MainDicomTags']['Modality'];
	//وصف السيريس يمكن أن يكون من أكثر من حقل
	$description='';
	foreach($req_attr_series as $attr){
		$val_attr=$info_series['MainDicomTags'][$attr];
		if(isset($val_attr) && $description!=''){$description.=' | ';}
		if(isset($val_attr)){ $description.=$val_attr; }
	}
	//تخزين المعلومات
	$sql="INSERT INTO `xry_x_dcm_series`(`sop_series`,`isStable`,`modality`,`description`,`study`) VALUES ('$sop_series','$isStable','$modality','$description','$study')";
	if(mysql_q($sql)){ return last_id();}
	return 0;
}
function store_study_info($info_study,$patient,$service,$sop_patient,$study=0){
	global $req_attr_studies;
	$ok=0;
	$sop_study=$info_study['ID'];
	$studyDate=$info_study['MainDicomTags']['StudyDate'];
	$institution=$info_study['MainDicomTags']['InstitutionName'];
	$isStable=intval($info_study['IsStable']);
	//وصف الدراسة يمكن أن يكون من أكثر من حقل
	$description='';
	foreach($req_attr_studies as $attr){
		$val_attr=$info_study['MainDicomTags'][$attr];
		if(isset($val_attr)&&$description!=''){$description.=' | ';}
		if(isset($val_attr)){ $description.=$val_attr; }
	}
	$studyDate=strtotime($studyDate);
	if(!$service && isset($info_study['service'])){$service=$info_study['service'];}
	if(!$service){$service=selCloseSrv($patient,$studyDate);}
	//تخزين معلومات المريض إن لم توجد
	$patient_id=store_patient_info($patient,$sop_patient);
	//تخزين المعلومات
	if($patient_id){
		if($study){
			$sql="update xry_x_dcm_studies set sop_study='$sop_study', sop_patient='$patient_id', studyDate='$studyDate',institution='$institution', isStable='$isStable', description='$description' where id='$study'";
			mysql_q($sql);
			if(mysql_a()>0){return 1;}
		}else{
			$sql="insert into xry_x_dcm_studies (sop_study,patient,sop_patient,studyDate,institution,isStable,description,status) values ('$sop_study','$patient','$patient_id','$studyDate','$institution','$isStable','$description','sync') ";
			if(mysql_q($sql)){$study=last_id(); $ok=1;}
		}
		if($service && $study){
			$sql="update xry_x_dcm_studies set service=$service where id=$study";
			if(mysql_q($sql)){$ok=1;}
		}
		if($ok){return $study;}
	}
	return 0;
}
function selCloseSrv($patient,$studyDate){
	$out=0;
	$s_date=$studyDate-($studyDate%86400);
	$e_date=$s_date+86400;
	$sql="select * from xry_x_visits_services where patient='$patient' and
	d_start>=$s_date and d_start< $e_date order by d_start ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows){		
		if($rows==1){
			$r=mysql_f($res);
			$out=$r['id'];
		}else{
			$break=0;
			while($r=mysql_f($res)){
				if($break==0){
					$id=$r['id'];
					if(getTotalCO('xry_x_dcm_studies'," patient='$patient' and service ='$id' ")==0){
						$out=$id;
						$break=1;
					}
				}
			}
		}
	}
	return $out;
}
function excecute_url($url,$type='GET',$path=0,$dataPost=0){
	$result='';
	$cont=[];
	if($path){ $cont = glob("$path/*"); }
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
	if($type=='POST'){
		curl_setopt($ch, CURLOPT_POST,1 );
		if($path==0){
			curl_setopt($ch, CURLOPT_POSTFIELDS,$dataPost);
		}

	}elseif($type!='GET'){
		  curl_setopt($ch, CURLOPT_CUSTOMREQUEST,$type);
	}
	//application/octet-stream
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));

	if(count($cont)>0){
		foreach($cont as $file){
			curl_setopt($ch, CURLOPT_POSTFIELDS,file_get_contents($file) );
			$result=curl_exec ($ch);
			//print_r($result);
		}
	}else{
		$result=curl_exec($ch);
		//print_r($result);
	}

	return $result;
}
function sync($study_path,$files){
	global $dcm_server;
	$error=$success='';$results=[];
	foreach($files as $file){
	    $file_path="$study_path/$file";
		$url="$dcm_server/instances";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt($ch, CURLOPT_POST,1 );
		curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: application/octet-stream'));
		curl_setopt($ch, CURLOPT_POSTFIELDS,file_get_contents($file_path));

		$result= json_decode(curl_exec($ch),true);
		if((isset($result['error'])&& $result['error'])||!$result){
			if($error!=''){$error.=',';}
			$error.="'$file'";
		}else{
			if($success!=''){$success.=',';}
			$success.="'$file'";
		}
		$results["'$file'"]=$result;
	}
	$out=['success'=>$success,'error'=>$error,'results'=>$results];
	return $out;
}
function calc_sync_percent($study){
	$donePer=0;
	$status_study=get_val('xry_x_dcm_studies','status',$study);
	if($status_study=='sync'){ $donePer=100;}
	else{
		$studyFiles=getTotalCO('xry_x_dcm_files',"study=$study");
		$fileSyncDo=getTotalCO('xry_x_dcm_files',"study=$study and status='sync'");
		$donePer=100*$fileSyncDo/$studyFiles;
	}
	return $donePer;
}
function dcm_PACS_to_DB($patient,$service){
	global $req_attr_studies,$req_attr_series,$dcm_server;
	//نجلب كل دراسات المريض على الباكس
	$url="$dcm_server/tools/find";
	$query='{"Level":"Study","Expand":true,"Limit":0,"Query":{"StudyDate":"*","PatientID":"'.$patient.'"}}';
	$patientStudies=json_decode(excecute_url($url,'POST',0,$query),true);
	//نجلب كل دراسات المريض المخزنة في الداا والتي تم مزامنتها مع الباكس
	$syncStudies=get_vals('xry_x_dcm_studies','sop_study',"patient=$patient",'arr');
	//من أجل كل دراسة موجودة على الباكس وغير موجودة في الداتا يتم تخزينها في الداتا ليتم عرضها
	foreach($patientStudies as $info_study){
		$sop_study=$info_study['ID'];
		if(!in_array($sop_study,$syncStudies)||empty($syncStudies)){
			//نخزن معلومات الدراسة في الداتا عدا  السيريس المتعلقة بها
			$study=store_study_info($info_study,$patient,$service,'');
			if($study){
				//نجلب السيريس المتعلقة بها ونخزن معلوماتها في الجدول
				$series_ids='';
				$url="$dcm_server/studies/$sop_study/series";
				$series=json_decode(excecute_url($url),true);
				foreach($series as $info_series){
					$series_id=store_series_info($info_series,$study);
					if($series_id){
						if($series_ids!=''){$series_ids.=',';}
						$series_ids.=$series_id;
					}
				}
				//نخزن السيريس المرتبطة بالدراسة
				$sql="update xry_x_dcm_studies set `sop_series`='$series_ids' where id=$study";
				if(mysql_q($sql)){return 1;}
			}
		}
	}
	return 0;
}
function dcm_create_folder($patient,$add_date,$study){
	$path="../dicom/p-$patient/".date('y-m-d',$add_date)."/s-$study";
	if(!file_exists('../dicom')){mkdir('../dicom',0777);}

	if(!file_exists("../dicom/p-$patient")){mkdir("../dicom/p-$patient",0777);}

	if(!file_exists("../dicom/p-$patient/".date('y-m-d',$add_date))){mkdir("../dicom/p-$patient/".date('y-m-d',$add_date),0777);}

	if(!file_exists($path)){mkdir($path,0777);}
	return $path;
}
function get_series($study){
	global $modalities,$stableTxt,$mod_study;
	$out='';
	$donePer=calc_sync_percent($study);
	$sql="select* from xry_x_dcm_series where study=$study";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	//--series--
	if($rows){
		$out.='
	  <div fix="wp:0|h:10">
		<div class="fl ic40 cbg1111 ic_dicom_series mg10" ></div>
		<div class="f1 fs14 fl lh50 clr1111" >'.k_series.' <ff>['.SplitNo($rows).']</ff>:</div>
	  </div>
	  <div fix="wp:0|hp:100" class="ofx so series_list">';
	    $i=1;
		while($r=mysql_f($res)){
			$series=$r['id'];
		  $sop_series=$r['sop_series'];
		  $description=str_replace('^',' ',$r['description']);
		  $isStable=$r['isStable'];
		  $modality=$r['modality'];
		  $out.='
		  <div class="fl lh20 " fix="wp%:30">
		  	<div>';
			if(modPer($mod_study)[4]){
				$out.='
				<div class="fr Over  ic_dicom_view" onclick="get_viewer(\'series\','.$series.')" title="'.k_view_series.'"></div>';
			}
			$out.='
				<div class="fl fs12 clr5 B" >'.k_description.': '.$description.'
				</div>
			</div>
			<div class="cb clr111">'.modalities($modality).' ('.$modality.')</div>
			<div>
				<div class="fl fs12">'.k_status.':'.$stableTxt[$isStable].'</div>
				<div class="fr"><ff class="fs14 clr111">#'.$i.'</ff></div>
			</div>
		  </div>';
		  $i++;
		}
	$out.='
	  </div>';
	}elseif($donePer==0){
	  $out.='<div class="pd10 f1 clr5 lh60 fs16"> '.k_no_series_send_to_server.' </div>';
	}
	return $out;
}
function delete_folder($path){
	if(is_dir($path)){
		$res=array_map('unlink', glob("$path/*")); 
		if(!in_array(0,$res)){
			if(rmdir($path)){return 1;}
		}
	}else{return 1;}
}
function get_info_study($study,$info_study=0){
	global $stableTxt,$clr44,$mod_study,$thisUser;
	$user_add=get_val('xry_x_dcm_studies','user',$study);
	$out='';
	$cbg='cbg4';
	if($info_study==0){
		$info_study=getRecCon('xry_x_dcm_studies',"id=$study");
	}
	$study=$info_study['id'];
	$title=$info_study['title'];
	$studyDate=$info_study['studyDate'];
	$institution=$info_study['institution'];
	$isStable=$info_study['isStable'];
	$description=$info_study['description'];
	$status=$info_study['status'];
	$syncPer=number_format(calc_sync_percent($study),2);
	if($status!='sync' || $syncPer<100){$cbg="cbg555";}else{
		$cbg='cbg4';
	}
	$out.=
	'<div tit class="'.$cbg.'" fix="h:30">
		<div class="fl f1 fs16 pd10" title="'.k_edit_std_name.'">'.SplitNo($title).'</div>
		<ff class="fr fs16 pd10">'.$syncPer.'%</ff>
	</div>
	<div  att style="background-color:'.$clr44.';">';
	if($syncPer==0){
		$out.= '<div class="pd10 f1">'.k_no_imgs_sent.'</div>';
	}else{
		$out.='
		<div class=" TC fs12  clr5 B" >'.trim($description).'</div>
		<div class=" TC fs12" >'.k_status.': '.$stableTxt[$isStable].'</div>
		<div class=" TC fs12" >'.k_organisation.': '.$institution.'</div>';
		if($studyDate){
			$out.='<div class="TC" ><ff class="fs14 clr6" >'.date('Y-m-d',intval($studyDate)).'</ff></div>';
		}
	}
	$out.='
	</div>';
	return $out;
}
/*************New*****************/
function get_ser_xry_catsN($c){
	global $lg,$clr1;	
	$sql="select * from xry_m_services_cat where clinic_id='$c' order by name_$lg ASC";
	$out='';	
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){		
		$out.='<div class="ana_list_catN" actButt="act" type="3">';
		$out.='<div act cat_num="0">'.k_all_cats.'</div>';		
		while($r=mysql_f($res)){
			$id=$r['id'];
			$catname=$r['name_'.$lg];
			$out.='<div cat_num="'.$id.'">'.$catname.'</div>';
		}
		$out.='</div>';
	}
	return $out;
}
function get_ser_xryN($vis,$pat,$clinic,$srvs){
	global $lg,$srvTables,$srvXTables;
    $mood=3;
    $ms_table=$srvTables[$mood];
	$xs_table=$srvXTables[$mood];	   
	$out='';
    $selectedSrvs=explode(',',$srvs);
	$sql=" SELECT * from xry_m_services where clinic='$clinic' and act=1 order by ord ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$out.='<div class="ana_list_mdcN">';
		while($r=mysql_f($res)){
			$id=$r['id'];
			$code=$r['code'];
			$name=$r['name_'.$lg];
			$cat=$r['cat'];
            $hos_part=$r['hos_part'];
            $doc_part=$r['doc_part'];
			$price=$hos_part+$doc_part;
            $del='0';
            $c='';
            if(in_array($id,$selectedSrvs)){
                $del='1';
                $c='class="hide"';
            }
			$out.='<div '.$c.' cat_mdc="'.$cat.'" s="0"  code="'.strtolower($code).'" mdc="'.$id.'" name="'.$name.'" del="'.$del.'" price="'.$price.'">'.splitNo($name).'</div>';
		}
		$out.='</div>';			
	}
	return $out;
}
function showXrySrvOffer($id,$offerSrv,$bupOffer,$price){
    $Mprice=$Nprice=$price;  
    if($bupOffer[0]==3){
        $offerTxt='<div class="fl w100 clr66 lh30 pd5 cbg666 mg10v TC br5">'.k_gen_discount.' <ff14>%'.$bupOffer[1].'</ff14> <span class="LT clr5">('.number_format($Mprice).')</span></div>';
        $offerDisPrice=$price;
        $Nprice=($price/100)*(100-$bupOffer[1]);
    }
    if($bupOffer[0]==4){
        $offerTxt='<div class="fl w100 clr66 lh30 pd5 cbg666 mg10v TC br5">'.k_for_discount.'<ff14>%'.$bupOffer[1].'</ff14> <span class="LT clr5">('.number_format($Mprice).')</span></div>'; 
        $offerDisPrice=$price;
        $Nprice=($price/100)*(100-$bupOffer[1]);
    }
    foreach($offerSrv as $o){
        if($o[1]==$id){					
            if($o[0]==2){
                $offerTxt='<div class="fl w100 clr66 lh30 pd5 cbg666 mg10v TC br5"> '.k_ser_descount.'<ff14>%'.$o[2].'</ff14> <span class="LT clr5">('.number_format($Mprice).')</span></div>';
                $offerDisPrice=$price;
                //$Nprice=($price/100)*(100-$o[2]);
                $Nprice=$o[4];
            }
            if($o[0]==1){
                $offerTxt='<div class="fl w100 clr66 lh30 pd5 cbg666 mg10v TC br5">'.k_patient_bou_ser.' <span class="LT clr5">('.number_format($Mprice).')</span></div>';
                $Nprice=0;						
            }
            $trClr=' cbg666 ';
        }
    }
    return array($Nprice,$offerTxt);
}
function get_edit_xryN($vis,$pat,$doc,$srvs){
    global $lg,$bupOffer;
    $mood=3;	
    if(_set_9iaut3jze){
        $bupOffer=array();        
        $offersAv=offersList($mood,$pat);        
        $offerSrv=getSrvOffers($mood,$pat);
    }     
	$out='';
    if($srvs){                
        $sql=" SELECT * from xry_m_services where  act=1 and id IN($srvs) order by ord ASC";
        $res=mysql_q($sql);
        $rows=mysql_n($res);
        if($rows>0){
		while($r=mysql_f($res)){
			$id=$r['id'];
			$name=$r['name_'.$lg];            
			$hos_part=$r['hos_part'];
            $doc_part=$r['doc_part'];
            $price=$hos_part+$doc_part;	
            if($price && $doc){		
                $newPrice=get_docServPrice($doc,$id,$mood);
                $newP=$newPrice[0]+$newPrice[1];							
                if($newP){$price=$newP;}
            }            
            $offerTxt='';
            if(_set_9iaut3jze){
                $offerTxt=showXrySrvOffer($id,$offerSrv,$bupOffer,$price);                
                $price=$offerTxt[0];
            }            
            $out.=xryTempLoad($id,$price,$name,$offerTxt[1]);            
		}	
	}
    }
	return $out;
}
function xryTempLoad($id,$price,$short_name,$offerTxt=''){
    global $lg;
    $out='<div class="fl w100 bord pd10 cbgw br5 mg10v" anaSel="'.$id.'" pr="'.$price.'">
        <div class="fr i30 i30_x mg5v" delSelAna></div>
        <div class="f1 fs12 lh40 b_bord">'.$short_name.'</div>
        <div class="fl w100 lh40">
            <div class="fr lh40"><ff class="clr6">'.number_format($price).'</ff></div>            
        </div>'.$offerTxt.'
    </div>';
    return $out;
}
function xry_selSrvs($vis,$c,$doc,$pat,$reqOrd,$type,$dts_id=0){
	global $f_path,$lg,$bupOffer,$srvXTables,$srvTables;
	$mood=3;
	$out='';
	$ms_table=$srvTables[$mood];
	$xs_table=$srvXTables[$mood];
    $srvs='';
	if($vis){
        delOfferVis($mood,$vis);        
        $srvs=get_vals($xs_table,'service',"visit_id='$vis'");
    }else if($reqOrd){        
        $srvs=get_vals('xry_x_visits_requested_items','xphoto',"r_id='$reqOrd'");
        $printOrd='<div class="fl br0 ic40 icc4 ic40_print ic40Txt mg10" printXrySrv="'.$reqOrd.'">'.k_print_xry_request.'</div>';
    }
    if($dts_id){
        $srvs=get_vals('dts_x_dates_services','service',"dts_id='$dts_id'");
    }    
    $srvsTxt='';
    if($srvs){$srvsTxt=get_edit_xryN($vis,$pat,$doc,$srvs);}
	$out.='
	<div class="fl w100 lh50 b_bord cbg4 pd10f fxg" fxg="gtc:1fr auto auto">		
		<div class="lh40 fl">
			<input type="text" fix="h:40" placeholder="'.k_search.'" id="srvLabSrch"/>
		</div>
        <div class="srvEmrg fr f1 fs14" s="0">'.k_emergency.'</div>
		<div class="srvTotal fr"><ff rvTot>0</ff></div>
        <div class="winLabTmp of so"></div>
	</div>
	<div class="fl w100 of h100 fxg " fxg="gtc:220px 3fr 4fr" >
        <div class="r_bord pd5f ofx so soL1 cbg4">'.get_ser_xry_catsN($c).'</div>
        <div class="r_bord pd5f  ofx so soL2">'.get_ser_xryN($vis,$pat,$c,$srvs).'</div> 
        <div class="pd10 fxg of h100" fxg="gtr:50px 1fr">
            <div class="f1 fs14 b_bord lh50">'.k_sel_reqmage.' <ff id="countAna">( 0 )</ff></div>
            <div id="anaSelected" class="pd10 ofx so">'.$srvsTxt.'</div>
        </div>';        
	$out.='</div>
	<div class="fl w100 lh60 cbg4 pd10f t_bord">
		<div class="fl br0 ic40 icc2 ic40_save ic40Txt " saveXrySrv="'.$type.'">'.k_save.'</div>'.$printOrd.'
	</div>';
	return $out;
}
function xry_selSrvs_save($vis_id,$pat,$emplo,$cln,$doc,$fast,$req=0){
	global $now,$thisUser,$visXTables,$srvXTables,$srvTables,$lg;
    $mood=3;
	$vTable=$visXTables[$mood];
	$sTable=$srvXTables[$mood];
	$smTable=$srvTables[$mood];
    $doc_ord=$visit_link=0;
    if($req){
        $rr=getRec('xry_x_visits_requested',$req);        
        $req_status=$rr['status'];
        $xry_vis=$rr['xry_vis'];
        if($req_status==1 || ($req_status==2 && $xry_vis==0)){
            $doc_ord=$rr['doc'];
            $visit_link=$rr['visit_id'];           
        }
    }
    if($vis_id==0){	
        $new_pat=isNewPat($pat,$doc,$mood);
        $sql="INSERT INTO $vTable (`patient`,`clinic`,`d_start`,`reg_user`,`fast`,`emplo`,`ray_tec`,`doc_ord`,`new_pat`,`visit_link`)values ('$pat','$cln','$now','$thisUser','$fast','$emplo','$doc','$doc_ord','$new_pat','$visit_link')";
        if(mysql_q($sql)){$vis_id=last_id();}
    }else{        
        delOfferVis($mood,$vis_id);
        mysql_q("DELETE from $sTable where `visit_id`='$vis_id' ");
        list($doc_ord,$visit_link)=get_val($vTable,'doc_ord,visit_link',$vis_id);
        if($doc_ord){
            list($req_id,$reqStatus)=get_val_con('xry_x_visits_requested','id,status',"visit_id='$visit_link' and 
            doc='$doc_ord'");
            if($reqStatus<3){
                $req=$req_id;
            }
        }
    }
    $srvs=pp($_POST['srvs'],'s');
    /****************************/
    if($vis_id){
        if($req){
            mysql_q("UPDATE xry_x_visits_requested set status=2 , xry_vis ='$vis_id' where id='$req' and status in(1,2) ");            
        }
        /******************************************/        
        $sql="select * from $smTable where clinic='$cln' and id IN($srvs) and act=1 order by ord ASC";
        $res=mysql_q($sql);
        $rows=mysql_n($res);
        if($rows>0){
            while($r=mysql_f($res)){
                $s_id=$r['id'];
                $name=$r['name_'.$lg];
                $hos_part=$r['hos_part'];
                $doc_part=$r['doc_part'];
                $edit_price=$r['edit_price'];
                $opr_type=$r['opr_type'];

                if($edit_price){$hos_part=$doc_part=0;}
                $total_pay=$hos_part+$doc_part;
                $doc_percent=$r['doc_percent'];
                $multi=$r['multi'];
                $rev=$r['rev'];					
                //$ch_p=ch_prv($s_id,$pat,$doc);
                $ch_p=0;
                if($ch_p==1 && $rev){$hos_part=0;$doc_part=0;}
                $pay_net=$hos_part+$doc_part;
                if($pay_net && $doc){								
                    $newPrice=get_docServPrice($doc,$s_id,$mood);
                    $newP=$newPrice[0]+$newPrice[1];
                    if($newP){
                        $doc_percent=$newPrice[2];
                        $hos_part=$newPrice[0];
                        $doc_part=$newPrice[1];
                        $pay_net=$newP;$total_pay=$newP;
                    }
                }
                if($emplo && $pay_net){
                    if(_set_z4084ro8wc){
                        $hos_part=$hos_part-($hos_part/100*_set_z4084ro8wc);
                        $hos_part=round($hos_part,-1,PHP_ROUND_HALF_DOWN);
                        $doc_part=$doc_part-($doc_part/100*_set_z4084ro8wc);
                        $doc_part=round($doc_part,-1,PHP_ROUND_HALF_DOWN);
                        $pay_net=$hos_part+$doc_part;
                    }
                }
                
                $m=1;
                if($multi){$m=pp($_POST['m_'.$s_id]);}								
                for($s=0;$s<$m;$s++){						
                    mysql_q("INSERT INTO xry_x_visits_services (`visit_id`, `clinic`, `service`, `hos_part`, `doc_part`, `doc_percent`, `pay_net`, `rev`,`d_start`,`total_pay`, `patient`, `doc`, `srv_type`) values ('$vis_id', '$cln', '$s_id', '$hos_part', '$doc_part', '$doc_percent', '$pay_net', '$ch_p','$now','$total_pay','$pat',0,'$opr_type')");
                    $srv_x_id=last_id();
                    if($req){
                        mysql_q("UPDATE xry_x_visits_requested_items set status=1 , service_id='$srv_x_id'  where r_id='$req' and action=1 and xphoto='$s_id' ");                        
                    }
                    if(_set_9iaut3jze){activeOffer($mood,$cln,$doc,$pat,$vis_id,$s_id,$srv_x_id);}	
                }
                
            }
            mysql_q("UPDATE gnr_x_roles set status=2 where vis='$vis_id' and mood='$mood' and  status=4");
            if($req){delTempOpr($mood,$req,8);}
        }else{return '0';}
        return $vis_id;
    }else{return '0';}
}
function xry_selSrvsSta($vis){
	global $f_path,$lg,$bupOffer,$payStatusArrRec,$reqStatusArr,$insurStatusColArr;	
	$mood=3;
	$editable=1;
    $out='';
	$sql="select * from xry_x_visits where id='$vis' ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$patient=$r['patient'];
		$clinic=$r['clinic'];
		$type=$r['type'];
		$doctor=$r['doctor'];
		$dts_id=$r['dts_id'];
		$pay_type=$r['pay_type'];
		$d_start=$r['d_start'];	
		$status=$r['status'];
		$sub_status=$r['sub_status'];
		if(($status>0 || $sub_status>0) && $pay_type==0){$editable=0;}
		$emplo=$r['emplo'];
		list($c_name,$mood)=get_val('gnr_m_clinics','name_'.$lg.',type',$clinic);
		$out.='<div class="fl w100 ofx so pd10 " >';	
		$sql="select * from xry_x_visits_services where visit_id='$vis' order by id ASC";
		$res=mysql_q($sql);
		$rows2=mysql_n($res);
		if($rows2>0){
            if($pay_type==1){
                $gm_note=get_val_con('gnr_x_exemption_notes','note'," vis='$vis' and mood='$mood' "); 
                if($gm_note){ $out.='<div class="f1 fs14 lh50 clr5">'.k_management_notes.' : '.$gm_note.'  </div>';}else{$out.='<div class="hh10"></div>';}
            }
            $out.='
			<table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s holdH mg10v" over="0">';
			if($pay_type!=0){
				$out.='<tr><th>'.k_services.'</th>
				<th>'.k_notes.'</th>
				<th width="80">'.k_price.'</th>
				<th width="80">'.k_includ.'</th>
				<th width="80">'.k_must_be_paid.'</th>				
				</tr>';
			}else{
				$out.='<tr><th>'.k_services.'</th>
				<th>'.k_notes.'</th>
				<th width="80">'.k_price.'</th></tr>';
			}
            $total1=0;
            $total2=0;
            while($r=mysql_f($res)){					
                $s_id=$r['id'];
                $service=$r['service'];	list($serviceName,$edit_price,$hPart,$dPart)=get_val('xry_m_services','name_'.$lg.',edit_price,hos_part,doc_part',$service);
				$srvPriceOrg=$hPart+$dPart;
                $hos_part=$r['hos_part'];
                $doc_part=$r['doc_part'];
				$offer=$r['offer'];
                $app=$r['app'];
				$edit_priceTxt='';
				if($edit_price){$hos_part=$doc_part=0;$edit_priceTxt='<div class="f1 clr1111 lh30">'.k_price_det_by_dr.'</div>';}
                $pay_net=$r['pay_net'];
				$rev=$r['rev'];
                $total_price=$hos_part+$doc_part;
                $price=$total_price;
				if($emplo && $price){$price=$srvPriceOrg;}
				$dis=$price-$pay_net;
				$total1+=$price;
                $total2+=$pay_net;	
                $netTotal=$pay_net;
				if(_set_9iaut3jze){$offerText=getSrvView($offer,$mood,$vis,$s_id);}
				$msg='';
                if($pay_type!=0){$offerText='';}
                if($app){$msg.='<div class="f1 clr5">خضم موعد التطبيق ( '.number_format($total_price-$pay_net).' )</div>';}
				if($rev && $pay_net==0){$msg.='<div class="f1 clr5"> ( '.k_review.' )</div>';}
                $out.= '<tr>					
                <td class="f1">'.$serviceName.'</td>';
                if($pay_type==0){
				    $out.='<td class="f1">'.$msg.$edit_priceTxt.$offerText.'</td>
                    <td><ff>'.number_format($pay_net).'</ff></td>';
                }
				if($pay_type!=0){
					$insurS='-';
					if($status==0){$insurS='<span class="clr5 f1 fs14">'.k_not_included.'</span>';}
					$cancelServ='';
                    $incPerc='';
                    if($pay_type==3){
                        $sur=getRecCon('gnr_x_insurance_rec'," visit='$vis' and service_x='$s_id'  and mood='$mood'");
                        $in_status=$sur['res_status'];
                        $in_s_date=$sur['s_date'];
                        $in_r_date=$sur['r_date'];
                        $ref_no=$sur['ref_no'];
                        if($ref_no){$ref_no=' <ff14 class="lh30">('.$ref_no.')</ff14>';}
                        if($in_status==2){
                            $cancelServ='
                            <div class="fl ic30 ic30_del icc2" srvDelIn="'.$s_id.'" mood="'.$mood.'" onclick1="delServ('.$s_id.','.$mood.')" title="'.k_cncl_serv.'"></div>';
                        }
                        if($in_status==1){
                            $incPerc=' <ff14 class="clr6"> '.number_format(($dis*100/$price),2).'%</ff14>';
                        }
                        if($in_status!=''){$insurS=$reqStatusArr[$in_status];}
                    }
					$out.= '
                    <td class="f1">
                        <div class="f1 '.$insurStatusColArr[$in_status].'" > '.$reqStatusArr[$in_status].''.$incPerc.$ref_no.$cancelServ.'</div>
                    </td>
                    <td><ff>'.number_format($total_price).'</ff></td>
                    <td><ff>'.$dis.'</ff></td>
                    <td><ff class="clr6">'.number_format($pay_net).'</ff></td>';
				}
                $out.= '</tr>';
            }
			$totClr1='cbg66';
			$totClr2='cbg666';
			if($total2==0){$totClr1='cbg88';$totClr2='cbg888';}
            $out.='<tr >					
            <td class="f1 B '.$totClr2.'" colspan="2">'.k_total.'</td>';
            if($pay_type!=0){
                $out.='<td class="'.$totClr2.'"><ff>'.number_format($total1).'</ff></td>
                <td class="'.$totClr2.'"><ff>'.number_format($total1-$total2).'</ff></td>';
            }
            $out.='<td class="fs18 ff B '.$totClr1.' "><ff class="clrw">'.number_format($total2).'</ff></td></tr>';
			$showNetPay=0;
            $cardPay=get_sum('gnr_x_acc_payments','amount',"mood='$mood' and vis='$vis' and pay_type=2");
            if($cardPay){// دفع الكتروني جزئي
                $total2-=$cardPay;
                $showNetPay=1;
                $out.='<tr>					
                <td class="f1 B cbg555" colspan="2">'.k_ele_payment.'</td>';
                if($pay_type!=0){$out.='<td colspan="2" class="f1 cbg555"></td>';}
                $out.='<td class="fs18 ff B cbg55 "><ff class="clrw">'.number_format($cardPay).'</ff></td>';
                $out.='</tr>'; 
            }
            if($dts_id){// دفعة موعد مقدمة
				$dtsPay=DTS_PayBalans($dts_id,$vis,$mood);				
				if($dtsPay){										
					$total2-=$dtsPay;
                    $showNetPay=1;
					$out.='<tr>					
					<td class="f1 B cbg555" colspan="2">'.k_payment_amount.'</td>';
					if($pay_type!=0){$out.='<td colspan="2" class="f1 cbg555"></td>';}
                    $out.='<td class="fs18 ff B cbg55 "><ff class="clrw">'.number_format($dtsPay).'</ff></td>';
					$out.='</tr>';
				}
			}
            if($showNetPay){
                $totClr1='cbg66';
                $totClr2='cbg666';
                if($total2==0){$totClr1='cbg88';$totClr2='cbg888';}
                if($total2<0){$totClr1='cbg55';$totClr2='cbg555';}
                $out.='<tr>					
					<td class="f1 B '.$totClr2.'" colspan="2">'.k_net.'</td>';
                    if($pay_type!=0){$out.='<td colspan="2" class="f1 '.$totClr2.'"></td>';}
					$out.='<td class="fs18 ff B '.$totClr1.' "><ff class="clrw">'.number_format($total2).'</ff></td>';
					
					$out.='</tr>';
            }
            $out.='</table>';
		}else{
            $out.='<div class="f1 fs14 lh30 pd10v clr5">لا يوجد خدمات محدد يرجى تحرير الزيارة</div>';
        }
		$out.='</div>';
        $out.=visStaPayFot($vis,$mood,$total2,$pay_type,$editable);
    	
	}
    if($rows==0 || $status>0){
        delTempOpr($mood,$vis,'a');
		$out.= script("closeRecWin();");
    }
	return $out;
}
function xry_recAlert($vis,$alert_id,$alert_status){
    global $visXTables,$srvXTables,$srvTables,$ser_status_Tex,$ser_status_color,$lg;
    $mood=3;$out='';
    $table2=$srvXTables[$mood];
    $r=getRec($visXTables[$mood],$vis);
    if($r['r']){
        $pat=$r['patient'];
        $clinic=$r['clinic'];
        $doc=$r['doctor'];
        $docTxt='';
        if($doc){
            $dName=get_val('_users','name_'.$lg,$doc);
            $docTxt='<div class=" lh30 f1 fs12  ">'.k_doctor.' : '.$dName.'</div>';
        }
        $r=getRec('gnr_m_patients',$pat);
        if($r['r']){
            $photo=$r['photo'];
            $sex=$r['sex'];
            $title=$r['title'];
            $birth_date=$r['birth_date'];
            $birthCount=birthCount($birth_date);
            $bdTxt='<div class="f1 clr5 fs12 lh30">'.k_age.' : <ff14 class="clr5">'.$birthCount[0].'</ff14> <span class="clr5 f1">'.$birthCount[1].'</span></div>';
            $titles=modListToArray('czuwyi2kqx');
            $patPhoto=viewPhotos_i($photo,1,40,60,'css','nophoto'.$sex.'.png');
            $pName=$titles[$title].' : '.$r['f_name'].' '.$r['ft_name'].' '.$r['l_name'];
        }
        $cnlicName=get_val('gnr_m_clinics','name_'.$lg,$clinic); 
        $out.='
        <div class="h100 fxg" fxg="gtc:1fr 2fr|gtr:auto 50px">
            <div class="ofx so fxg r_bord" fxg="grs:2">
                <div class="fl pd10 of fxg" fxg="gtr:auto auto 1fr" >
                    <div class="fl w100 b_bord fxg" fxg="gtc:50px 1fr">
                        <div class="fl pd5">'.$patPhoto.'</div>
                        <div class="fl pd10f">
                            <div class="lh20 f1 fs14 clr1111">'.$pName.'</div>
                            <div class="lh20 f1 fs12 clr1">'.$bdTxt.'</div>
                        </div>
                    </div>
                    <div class="fl w100  pd5v">				
                        <div class=" lh30 f1 fs12 ">'.k_clinic.' : '.$cnlicName.'</div>
                        '.$docTxt.'
                    </div>
                </div>
            </div>
            <div class="ofx so pd10f b_bord">
            <div class="f1 fs16 clr1 lh40 ">'.k_srvs_prvd.'</div>';
            $sql="select * from $table2 where visit_id='$vis'";
            $res=mysql_q($sql);
            $rows=mysql_n($res);
            if($rows){
                $priceT=$payT=$backT=0;
                $out.='<table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s holdH mg10v" Over="0">                
                <th>'.k_service.'</th>
                <th width="80">'.k_price.'</th>
                <th width="80">'.k_receive.'</th>
                <th width="80">'.k_return.'</th>
                </tr>';
                while($r=mysql_f($res)){
                    $srv=$r['service'];
                    $price=$r['pay_net'];
                    $status=$r['status'];
                    $pay=$back=0;                   
                    if($status==5){$pay=$price;}
                    if($status==4){$back=$price;}
                    $priceT+=$price;
                    $payT+=$pay;
                    $backT+=$back;
                    $name=get_val_arr($srvTables[$mood],'name_'.$lg,$srv,'srv');
                    $out.='<tr >
                    <td class="f1 fs12">'.$name.'
                    <div class="f1 clr5 lh20" >'.$ser_status_Tex[$status].'</div>
                    </td>
                    <td><ff class="clr1">'.number_format($price).'</ff></td>
                    <td><ff class="clr6">'.number_format($pay).'</ff></td>
                    <td><ff class="clr5">'.number_format($back).'</ff></td>                    
                    </tr>';
                }
                //*********مستحقات المريض****
                $sql="select * from gnr_x_insur_pay_back where patient='$pat' and mood='$mood' and visit='$vis'";
                $res=mysql_q($sql);
                $rows=mysql_n($res);
                if($rows){			
                    while($r=mysql_f($res)){			
                        $visit=$r['visit'];
                        $insur_rec=$r['insur_rec'];
                        $mood=$r['mood'];
                        $service_x=$r['service_x'];
                        $back=$r['amount'];                        
                        list($srv,$price)=get_val($table2,'service,pay_net',$service_x);                        
                        $name=get_val_arr($srvTables[$mood],'name_'.$lg,$srv,'srv');                        
                        $backT+=$back;                        
                        $out.='<tr style="color:'.$ser_status_color[$status].'">
                        <td class="f1 fs12">'.$name.'
                            <div class="f1 clr5 lh20" >'.k_insure_benefits.'</div>
                        </td>
                        <td><ff class="clr1">'.number_format($price).'</ff></td>
                        <td><ff class="clr6">0</ff></td>
                        <td><ff class="clr5">'.number_format($back).'</ff></td>                    
                        </tr>';
                    }
                }
                $out.='<tr>
                    <td class="f1 fs12">'.k_total.'</td>
                    <td class="cbg888"><ff class="clr1">'.number_format($priceT).'</ff></td>
                    <td class="cbg666"><ff class="clr6">'.number_format($payT).'</ff></td>
                    <td class="cbg555"><ff class="clr5">'.number_format($backT).'</ff></td>                    
                </tr>';
                $bankPay=get_sum('gnr_x_acc_payments','amount',"mood='$mood' and vis='$vis' and pay_type=2 and type=2");
                if($bankPay){
                    $out.= '<tr class="cbg444">
                        <td class="f1 fs12">'.k_ele_payments.'</td>
                        <td class=""></td>
                        <td class=""></td>
                        <td class=""><ff class="clr5">'.number_format($bankPay).'</ff></td>
                    </tr>';
                }
                $out.='</table>';
            }            
            $bal=$payT-$backT;
            $out.='</div>
            <div class="cbg4">
            '.visStaPayAlertFot($alert_id,$vis,$mood,$bal,$alert_status).'
            </div>
        </div>';
    }
    return $out;
}
function xry_ticket($r){
	global $lg,$ser_status_Tex,$srvXTables,$srvTables;	
	$mood=3;
	$out='';
    $srvTable=$srvXTables[$mood];
    $srvMTable=$srvTables[$mood];
	if($r['r']){		
        $vis=$r['id'];
		$patient=$r['patient'];
		$clinic=$r['clinic'];
		$type=$r['type'];
		$doctor=$r['doctor'];
		$dts_id=$r['dts_id'];
		$pay_type=$r['pay_type'];
		$d_start=$r['d_start'];	
		$vis_status=$r['status'];
        $pat=$r['patient'];
		$sub_status=$r['sub_status'];		
		if($vis_status==1 && _set_9iaut3jze){
            $bupOffer=array();        
            $offersAv=offersList($mood,$pat);        
            $offerSrv=getSrvOffers($mood,$pat);
        }	        
        $visChanges=getTotalCo($srvTable,"visit_id='$vis' and status IN(2,4)");
		$out.='<div class="fl w100 ofx so pd10 " >';	
		$sql="select * from $srvTable where visit_id='$vis' order by id ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
            if($pay_type==1){
                $gm_note=get_val_con('gnr_x_exemption_notes','note'," vis='$vis' and mood='$mood' "); 
                if($gm_note){ $out.='<div class="f1 fs14 lh50 clr5">'.k_management_notes.' : '.$gm_note.'  </div>';}else{$out.='<div class="hh10"></div>';}
            }
            $out.='
			<table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s holdH mg10v" over="0">
                <tr><th>'.k_services.'</th>				
				<th width="80">'.k_price.'</th>';
			if($vis_status==1 && $visChanges){
				$out.='
				<th width="80">'.k_receive.'</th>
				<th width="80">'.k_return.'</th>';
			}
			$out.='</tr>';
			$totalPay=0;
            $totalPrice=0;
            $totalIN=0;
            $totalOut=0;
            while($r=mysql_f($res)){					
                $s_id=$r['id'];
                $service=$r['service'];	list($serviceName,$edit_price,$hPart,$dPart)=get_val($srvMTable,'name_'.$lg.',edit_price,hos_part,doc_part',$service);
				$srvPriceOrg=$hPart+$dPart;
                $hos_part=$r['hos_part'];
                $doc_part=$r['doc_part'];
                $price=$hos_part+$doc_part;
				$offer=$r['offer'];
                $status=$r['status'];
				$edit_priceTxt='';				
                $pay_net=$r['pay_net'];
				$rev=$r['rev'];
                $price2=$price;
                if(_set_9iaut3jze &&  $status==2 && $price>0){
                    $Nprice=$price;
                    if($bupOffer[0]==3){
                        $offerTxt='<div class="f1 fs12 clr66">'.k_gen_discount.'<ff14>%'.$bupOffer[1].'</ff14></div>';
                        $offerDisPrice=$price2;
                        $Nprice=($price2/100)*(100-$bupOffer[1]);
                    }
                    if($bupOffer[0]==4){
                        $offerTxt='<div class="f1 fs12 clr66">'.k_for_discount.'<ff14>%'.$bupOffer[1].'</ff14></div>';
                        $offerDisPrice=$price2;
                        $Nprice=($price2/100)*(100-$bupOffer[1]);
                    }
                    foreach($offerSrv as $o){			
                        if($o[1]==$s_id ){					
                            if($o[0]==2){
                                $offerTxt='<div class="f1 fs12 clr66">'.k_ser_descount.' <ff14>%'.$o[2].'</ff14></div>';
                                $offerDisPrice=$price2;
                                //$Nprice=($price2/100)*(100-$o[2]);
                                $Nprice=$o[4];
                            }
                            if($o[0]==1){
                                $offerTxt='<div class="f1 fs12 clr55">'.k_patient_bou_ser.'</div>';
                                $Nprice=0;						
                            }
                            $trClr=' cbg666 ';
                        }
                    }
                    $pay_net=$Nprice;
                }
                $showPice=$pay_net;
                $showIN=0;
                $showOut=0;
                if($status==2){
                    $showPice=0;
                    $showIN=$pay_net;
                }else{
                    $totalPrice+=$showPice;
                }
                if($status==4){                    
                    $showOut=$pay_net;
                }
                $totalIN+=$showIN;	
                $totalOut+=$showOut;                
				
				$msg='';                
				if($rev && $pay_net==0){$msg='<div class="f1 clr5"> ( '.k_review.' )</div>';}
                
                $out.= '<tr>					
                <td class="f1 fs14">'.$serviceName.'<div class="clr5 f1">'.$ser_status_Tex[$status].'  '.$msg.'</div></td>';
				$out.='<td><ff>'.number_format($showPice).'</ff></td>';
				if($vis_status==1 && $visChanges){
					$insurS='-';
					$cancelServ='';
                    $incPerc='';                    
					$out.= '
                    <td><ff class="clr6">'.number_format($showIN).'</ff></td>
                    <td><ff class="clr5">'.number_format($showOut).'</ff></td>';
				}
                $out.= '</tr>';
            }
			$totClr1='cbg66';
			$totClr2='cbg666';
			//if($total2==0){$totClr1='cbg88';$totClr2='cbg888';}
            $out.='<tr >					
            <td class="f1 fs14 cbg444" >'.k_total.'</td>
            <td class="cbg888"><ff>'.number_format($totalPrice).'</ff></td>';
            if($vis_status==1 && $visChanges){
                $out.='
                <td class="cbg666"><ff>'.number_format($totalIN).'</ff></td>
                <td class="cbg555"><ff>'.number_format($totalOut).'</ff></td>';
                $totalPay=$totalIN-$totalOut;
            }            
            $out.='</tr>
            </table>';
		}
		$out.='</div>'; 
        $out.=visTicketFot($vis,$mood,$vis_status,$totalPay,$visChanges);
	}
    return $out;
}
function xry_ticket_cancel($r){
	global $lg,$payArry;	
	$mood=3;
	$out='';
	if($r['r']){		
        $vis=$r['id'];
		$pay_type=$r['pay_type'];
		$vis_status=$r['status'];
		$out.='<div class="fl w100 ofx so pd10 " >';	
		$sql="select * from gnr_x_acc_payments where vis='$vis' and mood='$mood' and type NOT IN(6,9,10) order by date ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){            
            $out.='
			<table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s holdH mg10v" over="0">
            <tr><th>'.k_paym_type.'</th>				
            <th width="80">'.k_receive.'</th>
            <th width="80">'.k_return.'</th>
            </tr>';
			            
            $totalIN=0;
            $totalOut=0;
            while($r=mysql_f($res)){
                $payType=$r['type'];
				$amount=$r['amount'];
                $showIN=$showOut=0;
                if(in_array($payType,array(1,2,5,7))){
                    $showIN=$amount;
                }elseif(in_array($payType,array(3,4,8))){
                    $showOut=$amount;
                }
                $totalIN+=$showIN;	
                $totalOut+=$showOut;                
				
                $out.= '<tr>					
                <td class="f1 fs12">'.$payArry[$payType].'</td>				
				<td><ff class="clr6">'.number_format($showIN).'</ff></td>
                <td><ff class="clr5">'.number_format($showOut).'</ff></td>
                </tr>';
            }
			$totClr1='cbg66';
			$totClr2='cbg666';
			//if($total2==0){$totClr1='cbg88';$totClr2='cbg888';}
            $out.='<tr >					
            <td class="f1 fs14 cbg444" >'.k_total.'</td>
            <td class="cbg666"><ff>'.number_format($totalIN).'</ff></td>
            <td class="cbg555"><ff>'.number_format($totalOut).'</ff></td>
            </tr>
            </table>';
            $totalPay=$totalIN-$totalOut;
		}
		$out.='</div>'; 
        $out.=visTicketFotCancel($vis,$mood,$totalPay);
	}
    return $out;
}