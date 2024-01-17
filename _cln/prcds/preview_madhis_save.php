<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['sta'])){
	$id=pp($_POST['id']);
	$sta=pp($_POST['sta']);
	
	$s_date=pp($_POST['s_date'],'s');
	$e_date=pp($_POST['e_date'],'s');
	$num=pp($_POST['num']);
	$note=pp($_POST['note'],'s');
	$num=0;
	if(isset($_POST['act'])){$num=1;}
	
	if($id){
		$sql="UPDATE";
	}else{
		$sql="INSERT cln_x_medical_his (cat,opr_id,s_date,e_date,num,active,note)values
		('cat','opr_id','s_date','e_date','num','active','note')";
	}
	if(mysql_q($sql)){echo 1;}
}?>