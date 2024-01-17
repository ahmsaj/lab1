<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$code=pp($_POST['id'],'s');
	$a0=pp($_POST['a0'],'s');	
	$a1=pp($_POST['a1'],'s');
	$a2=pp($_POST['a2'],'s');
	$a3=pp($_POST['a3'],'s');
	$a4=pp($_POST['a4'],'s');
	$a5=pp($_POST['a5'],'s');
	$a6=pp($_POST['a6'],'s');
	$vals='';
	if($a0 || $a1 || $a2 || $a3 || $a4 || $a5 || $a6){
		$vals=$a0.','.$a1.','.$a2.','.$a3.','.$a4.','.$a5.','.$a6;
	}	
	if(mysql_q("UPDATE _modules set ids_set='$vals' where code='$code' ")){echo 1;}	
	moduleGen(1,$code);
}?>
