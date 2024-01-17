<? date_default_timezone_set('UTC');
define('start_sys',true);
header("X-Powered-By: Miraware"); 
header("X-Frame-Options: DENY");
//header("Set-Cookie: name=l_mh45s6keep_connected=1; HttpOnly");
$folderBack='';
if(isset($_GET['root'])){
    $folderBack=intval($_GET['root']);
    $folderBack=str_repeat('../',$folderBack);
}
if(isset($_GET['cp'])){
    $cpPath=intval($_GET['cp']);
    $folderBack=str_repeat('../',$cpPath).'cp/';
}
include($folderBack.'__config/dbc_config.php'); 
define("_path",$_path);
define("_database",$_database);
define("_ptc",$_ptc);	
define("_pro_id",$_pro_id);
$logTs='l_'.$_pro_id;
$MFF=0;
$encrMod=0;
$proTs='HealthCenter';
$dbl=mysqli_connect($_server,$_username,$_password,$_database);
if(!$dbl){die("Connection error");exit();}
mysqli_query($dbl,"SET NAMES 'utf8'");
mysqli_query($dbl,'SET CHARACTER SET utf8');?>
