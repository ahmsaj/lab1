<? include("../../__sys/prcds/ajax_header.php");
if(modPer($mod_study)[2]){
  if(isset($_POST['type'],$_POST['study'])){
	$type=pp($_POST['type'],'s');
	$study=pp($_POST['study']);
	$user_add=get_val('xry_x_dcm_studies','user',$study);
	if($user_add==$thisUser ||$user_add=='' ||!$user_add){
		if($type=="process"){
			if(isset($_POST['title'])){
				$title=pp($_POST['title'],'s');
				$sql="update `xry_x_dcm_studies` set title='$title' where id=$study";
				if(mysql_q($sql)){echo 1;}
			}
		}
		elseif($type=="view"){
			$title=get_val('xry_x_dcm_studies','title',$study);
			list($patient,$service)=get_vals("xry_x_dcm_studies",'patient,service',"id=$study");
?>
			<div class="win_body">
				<div class="form_header">
					<div class="ic40 ic_dicom_edit fl"></div>
					<div class="lh40 f1 fs16 fl pd10"><?=k_edit_std_name?>:</div>
				</div>
                <div class="form_body so" fix="h:150">
                    <div class="fl f1  clr1 fs14 lh40 pd10" style="width:20%"><?=k_study_name?>:</div>
                    <input style="width:70%" type="text" id="studyTit" class="fl" value="<?=$title?>" />
                </div>
                <div class="form_fot fr">
                    <div up class="bu bu_t3 fl" onclick="editTitle(<?=$study?>,<?=$patient?>,<?=$service?>);"><?=k_save?></div>
                    <div up class="bu bu_t2 fr" onclick="win('close','#m_info3')"><?=k_close?></div>
                </div>
			</div>
		<?	
		}
	}else{out(1);}
  }
}else{
  out(1);
}?>