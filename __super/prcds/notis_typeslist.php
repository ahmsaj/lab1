<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['type'])){
    $type=pp($_POST['type']);
    $filed=pp($_POST['f'],'s');
    echo notiValList($type,$filed);
}
