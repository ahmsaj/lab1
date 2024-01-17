<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['trans_id'])){
	$trans_id=pp($_POST['trans_id']);
	$otp=pp($_POST['otp']);
	$error=0;
	$msg='';
	$transactionId='';
	$r=getRec('api_x_payments_mtn',$trans_id);
	if($r['r']){
		list($error,$transactionId)=enterMTN_OTP($trans_id,$r['token'],$otp); 		
		if($error){			
			$msg=get_val_c('api_errors','name_'.$lg,$error,'no');
		}else{
			compleatMTN_payment($r,$transactionId);
		}
	}
	$out=['err'=>$error,'msg'=>$msg];
    echo json_encode($out);
}?>