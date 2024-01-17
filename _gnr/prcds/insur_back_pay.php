<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$r=getRec('gnr_x_insur_pay_back',$id);
	if($r['r']){
		$vis=$r['visit'];
		$amount=$r['amount'];
		$mood=$r['mood'];
		if($mood==1){addPay1($vis,6,$amount);}
		if($mood==3){addPay3($vis,6,$amount);}
		if($mood==2){addPay2($vis,6,$amount);}
		if(mysql_q("DELETE from gnr_x_insur_pay_back where id='$id' ")){echo 1;}
	}
}?>