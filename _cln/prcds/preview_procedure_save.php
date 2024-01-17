<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['type'])&&isset($_POST['num'])){
	$type=pp($_POST['type']);
	$num=pp($_POST['num']);
	$v_id=pp($_POST['v_id']);
	$p_id=pp($_POST['p_id']);
	
	if($type==1)$table='cln_x_prv_complaints';
	if($type==2)$table='cln_x_prv_diagnosis';
	if($type==3){$table='cln_x_prv_story';}
	if($type==4){$table='cln_x_prv_clinical';}
	if(mysql_q("INSERT INTO $table (`visit`,`patient`,`opr_id`)values('$v_id','$p_id','$num') ")){
		echo $type.'-'.$num;
	}
}?>