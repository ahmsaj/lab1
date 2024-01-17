<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$type=pp($_POST['type']);
    if($type==0){$type=1;}
	$pay=pp($_POST['pay']);
	$doc=pp($_POST['doc']);
	$r=getRec('gnr_m_patients',$id);
	if($r['r'] && $pay && $doc){
        echo savePatPayment($id,4,$type,$pay,$doc);
	}	
}?>