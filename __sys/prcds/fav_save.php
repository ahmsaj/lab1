<? include("ajax_header.php");
if(isset($_POST['mPer'])){
	$mods=$_POST['mPer'];
	$modStr="'".implode("','",$mods)."'";
	mysql_q("delete from _fav_list where user_code='$thisUserCode' and m_code NOT IN($modStr) ");
	$oldfavs=get_vals('_fav_list','m_code'," user_code='$thisUserCode' ",'arr');
	$ord=getMaxValOrder('_fav_list','ord'," where user_code='$thisUserCode' ");
	$count=0;
	foreach($mods as $m_code){
		if($count<_set_fltfu89tyr){
			if(!in_array($m_code,$oldfavs)){
				if($thisUser!='s'){
					$p_type=$_SESSION[$logTs.'grpt'];
					if($p_type==1){$user=$thisGrp;}
					if($p_type==2){$user=$thisUserCode;}
				}else{$user='s';}
				mysql_q("INSERT INTO _fav_list (user_code,m_code,g_code,p_type,ord) values('$thisUserCode','$m_code','$user','$p_type','$ord')");
				$ord++;		
			}
		}
		$count++;
	}
}?>
