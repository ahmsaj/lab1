<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=$_POST['id'];
	if(getTotalCO('_langs'," id='$id'")>0){
		mysql_q("UPDATE `_langs` set `def`=0");
		mysql_q("UPDATE `_langs` set `def`=1 where id='$id'");
		echo 1;
	}
}