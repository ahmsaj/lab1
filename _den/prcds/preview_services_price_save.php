<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['p'])){
	$id=pp($_POST['id']);
	$p=pp($_POST['p']);
    echo changeSrvPriceAcc($id,$p);    
}?>