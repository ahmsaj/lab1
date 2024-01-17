<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['doc'])){
	$doc=pp($_POST['doc']);
	$date=pp($_POST['date'],'s');
	$d=strtotime($date);
	//$act=get_val('_users','act',$doc);
	//if($act){
		sencDocWorkDoo($d,$doc);
		echo 1;
	//}else{
		//echo 0;
	//}
	
}?>