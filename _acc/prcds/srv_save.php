<? include("../../__sys/prcds/ajax_header.php"); 
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$mood=pp($_POST['mood']);
	$subType=pp($_POST['subType']);
	$subSrv=pp($_POST['subSrv']);
	$acc_m=pp($_POST['acc_m'],'s');
	$acc_n=pp($_POST['acc_n'],'s');
	$cost=pp($_POST['cost'],'s');
	if($id==0){
		if($mood && $subType && $subSrv && $acc_m && $acc_n && $cost){
			$sql="INSERT INTO acc_m_service (mood,clinic,service,acc_morning,acc_night,codt_code)
			values('$mood','$subType','$subSrv','$acc_m','$acc_n','$cost')";
			if(mysql_q($sql)){echo 1;}
		}
	}else{
		if($acc_m && $acc_n && $cost){
			$sql="UPDATE acc_m_service SET acc_morning='$acc_m',acc_night='$acc_n',codt_code='$cost' where id='$id'";
			if(mysql_q($sql)){echo 1;}
		}
	}
}?>