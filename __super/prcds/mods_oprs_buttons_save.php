<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['mod_code'])){
	$mod_code=$_POST['mod_code'];
	mysql_q("DELETE FROM _modules_butts where `mod_code`='$mod_code'");
	$title=$_POST['title'];
	$function=$_POST['function'];
	$style=$_POST['style'];
	for($i=0;$i<count($title);$i++){
		if($title[$i] && $function[$i] && $style[$i]){
			$t=addslashes($title[$i]); 
			$f=addslashes($function[$i]); 
			$s=addslashes($style[$i]);
			mysql_q("INSERT INTO _modules_butts (`mod_code`,`title`,`function`,`style`)values('$mod_code','$t','$f','$s')");
		}
	}
	moduleGen(1,$mod_code);
	echo 1;
}
?>