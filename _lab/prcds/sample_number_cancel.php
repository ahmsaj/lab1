<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['vis'])){
	$id=pp($_POST['id']);
	$vis=pp($_POST['vis']);	
	if(mysql_q("UPDATE lab_x_visits_samlpes set status=0 , no= NULL where id='$id' and status=1")){
		$serv=get_val('lab_x_visits_samlpes','services',$id);
		if($serv){mysql_q("UPDATE lab_x_visits_services set sample=''  where service IN('$serv')");}
		mysql_q("UPDATE gnr_x_roles set status=2  where vis='$vis' and mood=2 and  status=4");
		endLabVist($vis);
	echo 1;}
}?>