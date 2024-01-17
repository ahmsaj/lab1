<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['qun'])){
	$id=pp($_POST['id']);
	$qun=pp($_POST['qun']);
	$qun=min($qun,10);
	$r=getRec('gnr_x_prescription_itemes',$id);
	if($r['r']){		
		$drug=$r['mad_id'];
		$presc=$r['presc_id'];
		$doc=$r['doc'];
		if($doc==$thisUser){
			if(mysql_q("UPDATE gnr_x_prescription_itemes SET presc_quantity='$qun' where mad_id='$drug' and presc_id='$presc' ")){echo 1;}
		}
	}
}?>