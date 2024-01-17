<? include("ajax_header.php");
if(isset($_POST['num'])){
	$num=pp($_POST['num']);
	//if($num==3){ echo view_favorite(); }
	//else{
		if(isset($_POST['m_code'])){
			$m_code=pp($_POST['m_code'],'s');
			if($num==1){
				$user='s'; $p_type=0;
				$count=getTotalCO('_fav_list',"user_code='$thisUserCode'");
				$ord=getMaxValOrder('_fav_list','ord'," where user_code='$thisUserCode' ");
				if($count<_set_fltfu89tyr){
					if($thisUser!='s'){
						$p_type=$_SESSION[$logTs.'grpt'];
						if($p_type==1){$user=$thisGrp;}
						if($p_type==2){$user=$thisUserCode;}
					}
					mysql_q("INSERT INTO _fav_list (user_code,m_code,g_code,p_type,ord) values('$thisUserCode','$m_code','$user','$p_type','$ord')");
					if(mysql_a()>0){echo 1;}
				}
			}
			if($num==2){
				mysql_q("DELETE FROM _fav_list where m_code='$m_code' and user_code='$thisUserCode' ");
				if(mysql_a()>0){echo 1;}
			}
		}
	//}		
}
?>
