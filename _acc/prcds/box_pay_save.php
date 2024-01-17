<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['pt'],$_POST['t'],$_POST['src'])){
	$pay_type=pp($_POST['pt']);
	$type=pp($_POST['t']);
	$source=pp($_POST['src']);
	$amount=pp($_POST['amount']);
	$note=pp($_POST['note'],'s');
	$ch=1;
	$m_box=0;
	$date=$now;	
	$m_box=$thisUser;
	if($pay_type==1){
		$type=2;
		$source=0;
	}
	if($pay_type==2){
		$ch=getTotalCO('gnr_m_charities',"id='$source'"); echo '('.$ch.')';
	}
	if($pay_type==3){
		$ch=getTotalCO('gnr_m_insurance_prov',"id='$source'");
	}
	if($amount && $ch){
		$sql="INSERT INTO gnr_x_box_oprs (m_box,date,amount,type,pay_type,source,note) values ('$m_box','$date','$amount','$type','$pay_type','$source','$note')";
		$res=mysql_q($sql);		
	}
}?>