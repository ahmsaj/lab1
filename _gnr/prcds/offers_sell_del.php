<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$r=getRec('gnr_x_offers',$id);
	if($r['r']){
		$ch=getTotalCO('gnr_x_offers_items'," x_offer_id='$id' and status=1 ");
		if($ch==0){
			mysql_q("delete from gnr_x_offers_items where x_offer_id='$id' ");
			mysql_q("delete from gnr_x_offers where id='$id' ");
			mysql_q("delete from gnr_x_acc_payments where vis='$id' and type='10' ");
			echo 1;
		}
	}
}?>