<? include("ajax_header.php");
if(isset($_POST['o'],$_POST['m'])){
	$o=pp($_POST['o']);	
	$m_code=pp($_POST['m'],'s');	
	echo $count=getTotalCO('_fav_list',"user_code='$thisUserCode'");
	if($count<_set_fltfu89tyr || $o==2){
		if($o==1){
			$ord=getMaxValOrder('_fav_list','ord'," where user_code='$thisUserCode' ");
			if($thisUser!='s'){
				$p_type=$_SESSION[$logTs.'grpt'];
				if($p_type==1){$user=$thisGrp;}
				if($p_type==2){$user=$thisUserCode;}
			}else{$user='s';}
			mysql_q("INSERT INTO _fav_list (user_code,m_code,g_code,p_type,ord) values('$thisUserCode','$m_code','$user','$p_type','$ord')");			

		}elseif($o==2){
			mysql_q("DELETE FROM _fav_list where m_code='$m_code' and user_code='$thisUserCode' ");	
		}
	
	}
}?>