<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['v'])){
	$vis=pp($_POST['v']);
    $mood=pp($_POST['m']);
    $amount=pp($_POST['pay']);
	$mobile=pp($_POST['mobile']);
    $r=getRec($visXTables[$mood],$vis);
    if($vis && $mood){
        $r=getRec($visXTables[$mood],$vis);
        if($r['r']){   
			$trans_id=0;        
            $pat=$r['patient'];		    
			list($error,$token)=mtn_get_token();
			if(!$error){
				$res=mysql_q("INSERT INTO api_x_payments_mtn (`token`,`patient`,`phone`,`opration`,`rec_id`,`mood`,`amount`,`date`)
				values('$token','$pat','$mobile','2','$vis','$mood','$amount','$now')");
				$trans_id=last_id();
				$mobile='963'.$mobile;
				$error =createMTN_OTP($trans_id,$token,$mobile,$amount);
			}
			$msg='';
			if($error){$msg=get_val_c('api_errors','name_'.$lg,$error,'no');}
			$out=['err'=>$error,'msg'=>$msg,'trans_id'=>$trans_id];
            echo json_encode($out);
        }
    }
}?>