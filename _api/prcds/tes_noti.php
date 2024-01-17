<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['noti'])){
	getRec('api_users',$thisUser);
	$noti=pp($_POST['noti']);
	$token=pp($_POST['token'],'s');
	$rec_id=pp($_POST['rec_id']);
	$r=getRec('api_noti_list',$noti);
	if($r['r']){
		$module=$r['module'];
		$no=$r['no'];
		$name=$r['name_'.$lg];
		$body=$r['body_'.$lg];
		$rec=$r['rec_'.$lg];
		$reg_ok=1;
		$pat_id=get_val_con('gnr_m_patients','id', "token ='$token' and `token`!='' ");
		if($pat_id){$_SESSION['Token']=$token;$logType=1;}else{$reg_ok=0;}
 		if($pat_id==0){
			$pat_id=get_val_con('dts_x_patients','id', "token ='$token' and `token`!='' ");
			if($pat_id){$_SESSION['Token']=$token;$logType=2;$reg_ok=1;}else{$reg_ok=0;}
		}
 		if($reg_ok){
			if($logType==1){
				$p_name=get_p_name($pat_id);
				$s_name=k_registered_patient;
			}
			if($logType==2){
				list($f_name,$l_name)=get_val('dts_x_patients','f_name,l_name',$pat_id);
				$p_name=$f_name.' '.$l_name;
				$s_name=k_registered_temp_user;
			}
			$out='';
			$out.='<div class="f1s fs14 lh30">'.k_patient.' : '.$p_name.' ( '.$s_name.' )</div>';
			$c=getTotalCO('api_notifications_push'," patient='$pat_id' and p_type='$logType' ");
			$out.='<div class="f1s fs14 lh30 uLine">'.k_devices_reg.' : <ff>( '.$c.' )</ff></div>';
 			$rSet=getRecCon('api_noti_set'," user ='$thisUser' ");
			if($rSet['r']){	
				$out.='data:{<br>&nbsp;&nbsp;&nbsp;title: '.$name.'<br>&nbsp;&nbsp;&nbsp;body: '.$body.'<br>&nbsp;&nbsp;&nbsp;sound: '.$rSet['sound'].' <br>&nbsp;&nbsp;&nbsp;icon: '.$rSet['icon'].'<br>&nbsp;&nbsp;&nbsp;color: '.$rSet['color'].'<br>&nbsp;&nbsp;&nbsp;priority=>'.$rSet['priority'].'<br>&nbsp;&nbsp;&nbsp;android_channel_id=>'.$rSet['channal'].'<br>&nbsp;&nbsp;&nbsp;type: '.$no.'<br>&nbsp;&nbsp;&nbsp;id: '.$rec_id.' <br>&nbsp;&nbsp;&nbsp;notification_id:0<br>}';
				$res_out=notiStatus(api_notif($pat_id,$logType,$no,$rec_id,'','',0));
				//$res_out=str_replace("'",'',$res_out);
				//$res_out=str_replace('"','',$res_out);
				//$res_out=str_replace(':','',$res_out);
                //$res_out = trim(preg_replace('/\s+/', ' ', $res_out));
				$out.='<div class="t_bord">'. $res_out.'</div>';
			}
			
		}else{
			$out.='<div class="f1s fs14 clr5 lh40">'.k_unregistered.'  <ff> ( '.$token.' )</div>';
		}
		echo addslashes($out);
	}
	
}?>