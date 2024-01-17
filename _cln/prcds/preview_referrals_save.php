<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['v_id'] , $_POST['p_id'] , $_POST['id']) ){	
	$id=pp($_POST['id']);
	$p_id=pp($_POST['p_id']);
	$v_id=pp($_POST['v_id']);
	$h=pp($_POST['cof_8kbf0kv9on']);
	$d=pp($_POST['cof_wiilprmlc']);
	$opr=pp($_POST['cof_drvx6e5xwl']);
	$da=pp($_POST['opr_date'],'d');
	$des=pp($_POST['des_'],'s');
	$t=pp($_POST['type']);
	if($t==2){$da=$opr=$h='';}	
	if($t==3){$da=$opr=$d='';}	
	
	if($id==0){
		$sql="INSERT INTO cln_x_pro_referral (p_id,v_id,type,hospital,doctor,opr_date,des,opration,date)
		values('$p_id','$v_id','$t','$h','$d','$da','$des','$opr','$now')";
		if(mysql_q($sql)){echo last_id();}
	}else{
		$sql="UPDATE cln_x_pro_referral set 
		p_id='$p_id', 
		v_id='$v_id', 
		type='$t', 
		hospital='$h', 
		doctor='$d',
		opr_date ='$da',
		des='$des', 
		opration='$opr' 
		where id='$id'";
		if(mysql_q($sql)){echo $id;}
	}
	
	
}?>