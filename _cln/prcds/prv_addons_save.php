<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['data'])){
	$data=pp($_POST['data'],'s');
	$data=str_replace(',',"','",$data);
	$clinic=$userSubType;
	$finData=get_vals('cln_m_addons','code',"
	((clinic=0 AND service=0) OR (clinic='$clinic')) and code IN('$data') OR (req=1) order by FIELD(code,'$data')");
	
	$r=getRecCon('cln_x_addons_per'," user='$thisUser'");
	if($r['r']){
		$id=$r['id'];
		$sql="UPDATE cln_x_addons_per SET addons='$finData' where id='$id' ";
	}else{
		$sql="INSERT INTO cln_x_addons_per (`user`,`addons`)VALUES('$thisUser','$finData') ";
	}
	mysql_q($sql);
}?>