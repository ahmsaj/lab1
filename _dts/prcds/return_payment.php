<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$r=getRec('dts_x_dates',$id);
	if($r['r']){		
		//if($r['status']==1 || $r['status']==5 || $r['status']==8){
			$pay=DTS_PayBalans($id);
			if($pay){
				echo addPay($id,8,$r['clinic'],$pay);
			}
		//}
	}
}?>