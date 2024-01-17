<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['o'])){
	$id=$_POST['id'];
	$o=$_POST['o'];	
	if($o==1){
		$code=getRandString(10);
		if(getTotalCO('_modules','code',$id)>0){
			$ord=getMaxValOrder('_modules_items','ord'," where mod_code='$id' ");
			mysql_q("INSERT INTO _modules_items (mod_code,code,ord,type)values('$id','$code','$ord',10)");
		}
	}
	if($o==0){
		mysql_q("DELETE from _modules_items where code='$id' ");echo "DELETE from _modules_items where code='$id' ";
	}
	
}?>