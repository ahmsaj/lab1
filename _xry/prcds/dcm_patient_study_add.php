<? include("../../__sys/prcds/ajax_header.php");
if(modPer($mod_study)[1]){
  if(isset($_POST['type'])){
  	$type=pp($_POST['type'],'s');
  	if($type=='view'){
  		if(isset($_POST['patient'],$_POST['service'])){
  			$patient=pp($_POST['patient']);
  			$service=pp($_POST['service']);?>
  			<div class="win_body">
  			<div class="form_body so of" type="full">
				<div fix="wp:0|h:45" class=" pd10">
					<div class="fl f1  clr1 fs16 lh40" style="width:20%"><?=k_study_name?>:</div>
					<input style="width:70%" type="text" id="studyTit" class="fl" />
				</div>
				<div class="fl pd10" fix="wp:0|hp:45" id="content" >
					<div fix="wp:0|h:60">
						<div fix="wp:0|hp:0" id="info_head" class="uLine hide lh50">
							<div id="dcm_co" class="fl mg10 fs16 f1 lh50 clr66" > <?=k_files_to_download?> <ff class="pd10 ic40 cbg666 clr66"></ff></div>
							<div id="fail_co" class="fr hide mg10 fs16 f1 lh50 clr5" > <?=k_files_failed?> <ff class="pd10 ic40 cbg555 clr55">0</ff> </div>
						</div>

					</div>
					<div class="fl so ofx" fix="wp:0|hp:60" id="listing" dir="rtl" >
						<div id="selFolder">
							<div txt class="fs18 f1 lh50 TC" fix="wp:0"><?=k_choose_study_folder?>:</div>
							<div img class="imgUpHol fileUp">
								<input type="file" name="files[]" id="files" webkitdirectory multiple>
							</div>
						</div>
					</div>
				</div>
				<input  type="hidden" id="patient" value="<?=$patient?>" />
				<input  type="hidden" id="service" value="<?=$service?>" />
				<input  type="hidden" id="limit" value="<?=$dcm_max_up_files_count?>" />

  			</div>
  			<div class="form_fot fr">
  				<div close class="bu bu_t2 fr" onclick="dcm_close_win_add(<?=$patient?>,<?=$service?>)"><?=k_close?></div>
  				<div up class="bu bu_t3 fl" onclick="upload_start(<?=$patient?>,<?=$service?>);"><?=k_save?></div>
  				<div del_study class="bu bu_t3 fl hide"><?=k_study_undo?></div>&nbsp;

  			</div>
  			</div>

  	 <?}
  	}
  	elseif($type=='process'){
  		$out=''; $err=$succ=0;
  		if(isset($_FILES['files'],$_POST['index'],$_POST['study'],$_POST['patient'],$_POST['files_count'],$_POST['service'])){
  			$index=pp($_POST['index']);
  			$files=$_FILES['files'];
  			$study=pp($_POST['study']);
  			$patient=pp($_POST['patient']);
  			$service=pp($_POST['service']);
  			$files_count=pp($_POST['files_count']);
  			$title='';
  			if(isset($_POST['studyTit'])){$title=pp($_POST['studyTit'],'s');}

  			if($study==0){
  				$sql="INSERT INTO `xry_x_dcm_studies`(`title`, `patient`,`service`,`user`, `add_date`,`status`) VALUES ('$title','$patient','$service','$thisUser','$now','async')";
  				if(mysql_q($sql)){$study=last_id();}
  			}else{
				$sql="update `xry_x_dcm_studies` set title='$title',status='async' where id=$study";
				mysql_q($sql);
			}
  			//----
  			$last=$dcm_max_up_files_count;
  			if($dcm_max_up_files_count>count($files['name'])){$last=count($files['name']);}
  			for($key=0;$key<$last;$key++){
  				if($key!=0){$out.=',';}
  				if($files['error'][$key]==0){
  					/***************size*****************************/
  					$max_size=intval(ini_get('memory_limit'))*1024*1024;
  					$fileSize=$_FILES[$key]['size'];
  						if($max_size>=$fileSize){
  							/***************type***************/
  							$type = $files['type'][$key];
  							if($type=='application/octet-stream'){
  								/***************copy************/
  								$code = getRandString(10);
  								$fileName_org = $files[$key];
  								$file_ex = getFileExt($fileName_org);
  								$add_date=get_val('xry_x_dcm_studies','add_date',$study);
  								//create folders
  								$path=dcm_create_folder($patient,$add_date,$study);
  								//------
  								if(move_uploaded_file($files['tmp_name'][$key],$path."/$code")){
  									$sql="INSERT INTO `xry_x_dcm_files`(`code`, `orgin_name`, `size`, `date`,`study`,`status`) VALUES ('$code','$fileName_org','$fileSize','$now','$study','async')";
  									if(mysql_q($sql)){
  										$out.=$index; $succ++;
  									}else{$out.='err4-'.$index; $err++;}
  								}else{$out.='err3-'.$index; $err++;}
  							}else{$out.='err2-'.$index; $err++;}
  						}else{$out.='err1-'.$index; $err++;}
  				}
  				$index++;
  			}
  			echo $study.','.$out;
  		}else{echo 'err';}

  	}
  }
}else{
  out(1);
}
?>
