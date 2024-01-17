<? include("ajax_header.php");
if(isset($_POST['user'],$_POST['op'],$_POST['np'],$_POST['rp'])){
	$un=pp($_POST['user'],'s');
	$op=pp($_POST['op'],'s');
	$op= md5($op);
	$np=pp($_POST['np'],'s');
	$rp=pp($_POST['rp'],'s');
	$out=0; 	
	$user=getRec('_users',$thisUser);
	if($user['r']){		
		//echo encodePass($op).'='.$user['pw'];
		if(password_verify($op,$user['pw'])){			
			if($un!='' && passValidate($np)){		
				$np=encodePass($np);
				if(mysql_q("UPDATE  _users set pw='$np' , un='$un' where `grp_code`='$thisGrp' and id='$thisUser' and act=1")){				
					$out=1;
				}
			}
		}
	}
	echo $out;
}
?>



