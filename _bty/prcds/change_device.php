<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'],$_POST['id'])){
	$vis=pp($_POST['vis']);
    $id=pp($_POST['id']);
    mysql_q("UPDATE bty_x_laser_visits SET device='$id' where id='$vis' and status=1 ");
}?>