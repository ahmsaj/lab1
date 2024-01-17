<? include("../../__sys/prcds/ajax_header.php");
$perm_dcm=modPer($mod_study);
if(isset($_POST['checkPerm'])){$checkPerm=pp($_POST['checkPerm']);}
if(($checkPerm && $perm_dcm[3])|| !$checkPerm){
	if(isset($_POST['study'])){
		$study=pp($_POST['study']);
		list($user_add,$sop_study)=get_val('xry_x_dcm_studies','user,sop_study',$study);
		if($user_add==$thisUser||$user_add=='' ||!$user_add){
			list($patient,$add_date)=get_vals('xry_x_dcm_studies','patient,add_date',"id=$study");
			$sql="DELETE FROM `xry_x_dcm_studies` WHERE id=$study";
			if(mysql_q($sql)){
				$ok=0;
				$is_another_study=getTotalCO("dcm_studies","sop_study='$sop_study'");
				if(!$is_another_study){
					$url="$dcm_server/studies/$sop_study";
					$res=json_decode(excecute_url($url,'DELETE'),true);
					if($res['RemainingAncestor']==null){$ok=1;}
				}
				if($ok){
					$path="../dicom/p-$patient/".date('y-m-d',$add_date)."/s-$study";
					echo delete_folder($path);
				}
			}
		}
	}
}
else{
  out(1);
}
