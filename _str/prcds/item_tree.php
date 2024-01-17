<? include("../../__sys/prcds/ajax_header.php");if(isset($_POST['s'] , $_POST['t'])){
$s=pp($_POST['s'],'s');$t=pp($_POST['t']);echo drowTree($s,$t);} ?>