<? include("../__sys/mods/protected.php");?>
<?
if($_SESSION[$logTs.'theme']){$q="where id='".$_SESSION[$logTs.'theme']."'";}else{$q="order by def DESC";}
if(isset($_GET['gct'])){
	$q="where id='".pp($_GET['gct'])."'";
}
$sql="select * from _themes $q limit 1";
$res=mysql_q($sql);
$rows=mysql_n($res);
if($rows>0){
	$r=mysql_f($res);
	$clr1=$r['c1'];
	$clr11=$r['c11'];
	$clr111=$r['c111'];
	$clr1111=$r['c1111'];
	$clr2=$r['c2'];
	$clr3=$r['c3'];
	$clr4=$r['c4'];
	$clr44=$r['c44'];
	$clr5=$r['c5'];
	$clr55=$r['c55'];
	$clr6=$r['c6'];
	$clr66=$r['c66'];
}
$clr444='#f5f5f5';$clr555='#fadede';$clr666='#e9fade';
$clr7='#feef9d';$clr77='#efd129';$clr777='#fbf7e2';
$clr8='#3d74e3';$clr88='#2150ae';$clr888='#d4e2fe';
$clr9='#999';

if(isset($_GET['d'])){
$dir=$_GET['d'];

if($dir=='ltr'){$align='left';$Xalign='right';$Xdir='rtl';}else{$align='right';$Xalign='left';$Xdir='ltr';}}
?>