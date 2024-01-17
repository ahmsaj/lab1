<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['mod'])){
	$id=pp($_POST['id']);
    $mod=pp($_POST['mod'],'s');
    $type=pp($_POST['con_type']);
    $col=pp($_POST['con_colume'],'s');
    $val=pp($_POST['con_val'],'s');
    if(getTotalCo('_modules',"code='$mod'") && $type && $col){
        if($id){
            mysql_q("UPDATE _modules_cons SET `mod_code`='$mod',`type`='$type',`colume`='$col',`val`='$val' where id='$id' ");
        }else{
            mysql_q("INSERT INTO _modules_cons (`mod_code`,`type`,`colume`,`val`) values ('$mod','$type','$col','$val')");
        }
        moduleGen(1,$mod);
        echo 1;
    }
}?>