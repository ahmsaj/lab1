<? session_start();
include("../../__sys/dbc.php");
include($folderBack.'__sys/token.php');
include("../../__sys/f_funs.php");
if(isset($_SESSION[$logTs.'user_id'])){
	echo 1;
}elseif($log=checkCookie()){
	echo 1;
}
?>
