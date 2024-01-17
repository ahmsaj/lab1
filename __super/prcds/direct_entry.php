<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$r=getRec('_users',$id);
	if($r['r']){		
		$grpt=1;
		$grp=$r['grp_code'];
		$user_id=$r['id'];
		$user_code=$r['code'];
		$lang=$r['lang'];
		$theme=$r['theme'];
		$x=getTotalCO('_perm'," type='2' and g_code='$user_code'");
		if($x>0){$grpt=2;}
		$_SESSION[$logTs.'user_id']=$user_id;
		$_SESSION[$logTs.'user_code']=$user_code;
		$_SESSION[$logTs.'grp_code']=$grp;
		$_SESSION[$logTs.'grpt']=$grpt;
		$_SESSION[$logTs.'theme']=$theme;
	}
}?>