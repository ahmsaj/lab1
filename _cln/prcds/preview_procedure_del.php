<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['type'] , $_POST['num'])&& isset($_POST['v_id'])){
	$type=pp($_POST['type']);
	$num=pp($_POST['num']);
	$v_id=pp($_POST['v_id']);
	if($type==1){$table='cln_x_prv_complaints';}
	if($type==2){$table='cln_x_prv_diagnosis';}
	if($type==3){$table='cln_x_prv_story';}
	if($type==4){$table='cln_x_prv_clinical';}			
	mysql_q("DELETE FROM $table where visit='$v_id' and opr_id='$num' limit 1");
}?>