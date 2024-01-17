<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['code'])){
	$id=pp($_POST['id']);
    $code=pp($_POST['code'],'s');
    echo imageUpN(0,$code,$code,$id,1,0,"tpImgLoad('$code',[data])");
}?>