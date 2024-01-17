<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['type'])){
	$type=pp($_POST['type'],'s');
	if($type=='process'){
		if(isset($_POST['study'],$_POST['first_opr'])){
			$first_opr=pp($_POST['first_opr']);
			$study=pp($_POST['study']);
			$study_data=getRecCon('xry_x_dcm_studies',"id=$study");
			$add_date=$study_data['add_date'];
			$patient=$study_data['patient'];
			$add_date=$study_data['add_date'];
			$service=$study_data['service'];
			$sop_series_curr=$study_data['sop_series'];
			$sop_study_curr=$study_data['sop_study'];
			//تحديد الملفات المراد مزامنتها
			$study_path="../dicom/p-$patient/".date('y-m-d',$add_date)."/s-$study";
			$files=get_vals('xry_x_dcm_files','code',"study='$study' and status!='sync' limit $dcm_max_sync_files_count",'arr');
			//تحديد زمن أول ضربة
			if($first_opr==1){
				$_SESSION["first_time"]=$now;
			}
			if($files && count($files)>0){
				//تنفيذ المزامنة
				$res=sync($study_path,$files);
				if($res['success']){
					$sql="update xry_x_dcm_files set status='sync' where code in(".$res['success'].")";
					mysql_q($sql);
				}
				if($res['error']){
					$sql="update xry_x_dcm_files set status='error' where code in(".$res['error'].")";
					mysql_q($sql);
				}
				//نخزم نتائج المزامنة في الداتا
				$success=explode(',',$res['success']);
				$error=explode(',',$res['error']);

				foreach($success as $k=>$file){
					 $res_file=$res['results'][$file];
					 $sop_study=$res_file['ParentStudy'];
					 $sop_instance=$res_file['ID'];
					 $sop_patient=$res_file['ParentPatient'];
					 $sop_series=$res_file['ParentSeries'];
					 if($sop_study && $sop_instance && $sop_patient && $sop_series){
						//تخزين معلومات الدراسة
						if($k==0 && (!$sop_study_curr||$sop_study_curr=='')){
							$url="$dcm_server/studies/$sop_study";
							$info_study=json_decode(excecute_url($url),true);
							store_study_info($info_study,$patient,$service,$sop_patient,$study);
						}
						//تخزين معلومات السيريس في حال لم تكن موجودة
						$series_id=get_val_con('xry_x_dcm_series','id',"sop_series='$sop_series'&& study=$study");
						if(!$series_id|| $series_id==''){
							$url="$dcm_server/series/$sop_series";
							$info_series=json_decode(excecute_url($url),true);
							$sop_study_prev=get_val('xry_x_dcm_studies','sop_study',$study);
						    $series_id=store_series_info($info_series,$study);
							
						}
						if($series_id && $series_id!=''){
							$sop_series_new=$sop_series_curr;
							if($sop_series_new && $sop_series_new !=''){
								if(strpos($sop_series_new,$series_id)===false){
									$sop_series_new.=",$series_id";
								}
							}else{
								$sop_series_new.=$series_id;
							}

							$sql="update xry_x_dcm_studies set sop_series='$sop_series_new' where id='$study'";

							mysql_q($sql);
							$sql="UPDATE `xry_x_dcm_files` SET instance='$sop_instance' where code='$file'";
							mysql_q($sql);
						}
					}
				}
				//نسبة المزامنة
				$donePer=calc_sync_percent($study);
				$studyFiles=getTotalCO('xry_x_dcm_files',"study=$study");
				$fileSyncDo=getTotalCO('xry_x_dcm_files',"study=$study and status='sync'");
				if($donePer==100){
					mysql_q("update xry_x_dcm_studies set status='sync' where id='$study'");
				}
				//حساب زمن التنفيذ
				$waitTime=0;
				//print_r($res);
				$first_time=$_SESSION["first_time"];
				if($first_time!=0){
					$impTime=$now-$first_time;
					$totalTime=$impTime*($studyFiles/$fileSyncDo);
					$waitTime=intval($totalTime-$impTime);
				}

				$waitTime=dateToTimeS2($waitTime);
				echo $waitTime.'^ ( '.$fileSyncDo.' / '.$studyFiles.' )
					^'.number_format($donePer,2);
				echo"^not_complete";
				echo "^".get_series($study)."^".get_info_study($study)."^";
				if($res['error']){echo "1";} else{echo "0";}
			}else{
				$path="../dicom/p-$patient/".date('y-m-d',$add_date)."/s-$study";
				delete_folder($path);
				echo "complete";
			}
		}
	}
}
