<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['n'] , $_POST['v'])){	
	$n=pp($_POST['n'],'s');
	$v=pp($_POST['v'],'s');	
	if(mysql_q("INSERT INTO lab_m_services_templates (name,temp)values('$n','$v')")){echo 1;}
}
?>
