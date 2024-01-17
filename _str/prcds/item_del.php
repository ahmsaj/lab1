<? include("../../__sys/prcds/ajax_header.php");if(isset($_POST['id'] , $_POST['t'])){
$id=pp($_POST['id']);$t=pp($_POST['t']);
$table='str_x_transfers_items';
if($t==1){if(mysql_q("DELETE from str_x_bill_items where status=0 and id='$id'")){echo 1;}}
if($t==2){
	$iteme=get_val('str_x_transfers_items','item_id',$id);
	if(mysql_q("DELETE from str_x_transfers_items where status=0 and item_id='$iteme'")){echo 1;}}
}?>
