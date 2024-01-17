<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['code'],$_POST['data'])){
	$code=pp($_POST['code'],'s');
	$data=pp($_POST['data'],'s');
	if($data){
		$r=getRecCon('_ex_col'," mod_code='$code'");
		if($r['r']){
			$id=$r['id'];
			$sql="UPDATE _ex_col SET cols='$data' where mod_code='$code' ";
		}else{
			$sql="INSERT INTO _ex_col (`mod_code`,`cols`)VALUES('$code','$data') ";
		}
	}else{
		$sql="DELETE from  _ex_col where mod_code='$code' ";
	}
	mysql_q($sql);
}?>