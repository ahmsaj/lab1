<? include("../../__sys/prcds/ajax_header.php");
if(getTotalCO('lab_x_work_table',"status=0")==0){
	if(mysql_q("INSERT INTO lab_x_work_table(date)values('$now')")){echo last_id();}
}else{echo 0;}
?>