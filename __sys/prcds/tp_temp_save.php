<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['name'],$_POST['data'])){
	$name=pp($_POST['name'],'s');
    $data=$_POST['data'];
    if($name){
        $sql="INSERT INTO  _tp_temps (`name`,`data`,`user`)values('$name','$data','$thisUser');";
        $res=mysql_q($sql);
        if($res){echo 1;}
    }
}?>