<? 
include("../dbc.php");
include("../f_funs.php");
echo '404';exit;
$TimeZon=get_val_c('_settings','val','adldd2qmz8','code');
$TimeZon_secs=($TimeZon*60*60);
$now=date('U')+$TimeZon_secs;
$ip=$_SERVER['REMOTE_ADDR'];
$address=$_SERVER['REQUEST_URI'];
$sql="INSERT INTO _p404 (user,ip,date,address)values('$thisUser','$ip','$now','$address')";
mysql_q($sql);
header("Location:"._path); ?>