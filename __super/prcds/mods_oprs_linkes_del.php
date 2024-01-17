<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['mod'])){
	$id=pp($_POST['id']);
    $mod=pp($_POST['mod'],'s'); 
    if(getTotalCo('_modules',"code='$mod'") && $id){
        if(mysql_q("DELETE from _modules_links where id='$id' and `mod_code`='$mod'")){
            moduleGen(1,$mod_code);
            echo 1;
        }
    }
}
?>