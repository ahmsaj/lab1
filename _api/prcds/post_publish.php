<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
    $sql="UPDATE api_x_posts set publish =1 where id='$id'";
    $res=mysql_q($sql);
    if($res){echo 1;}
}?>