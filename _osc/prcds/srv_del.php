<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['vis'])){
	$id=pp($_POST['id']);
	$vis=pp($_POST['vis']);
	list($status,$doc)=get_val('osc_x_visits','status,doctor',$vis);
	if($doc==$thisUser && $status==1){
		if(mysql_q("DELETE FROM osc_x_add_service where id='$id' and vis='$vis' limit 1")){echo 1;}
	}
}?>