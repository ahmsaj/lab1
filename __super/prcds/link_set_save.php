<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['p_id'] , $_POST['s_id'] , $_POST['col'])){
	$p_id=$_POST['p_id'];
	$s_id=$_POST['s_id'];
	$col=$_POST['col'];
	
	$p_data='1|'.$s_id;
	$s_data='2|'.$p_id.'|'.$col.'|'.$s_id;
	$lastVal=get_val_c('_modules_items','link',$p_id,'code');
	if($lastVal!=''){$p_data=$lastVal.'^'.$p_data;}
	mysql_q("UPDATE _modules_items set link='$p_data' where code='$p_id' ");
	mysql_q("UPDATE _modules_items set link='$s_data' where code='$s_id' ");
}?>