<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['pat'])){
    $mood=pp($_POST['mood']);    
	$id=pp($_POST['id'],'s');
    $pat=pp($_POST['pat']);
    $doc=pp($_POST['doc']);
	$r=getRec('bty_m_services',$id);    
    if(_set_9iaut3jze){
        $bupOffer=array();
        $offersAv=offersList($mood,$pat);
        $offerSrv=getSrvOffers($mood,$pat);
    }
    $sql="select * from bty_m_services where id IN($id)";
    $res=mysql_q($sql);
    while($r=mysql_f($res)){		
		$id=$r['id'];		
        $name=$r['name_'.$lg];
        $hos_part=$r['hos_part'];
        $doc_part=$r['doc_part'];
        $multi=$r['multi'];
        $price=$hos_part+$doc_part;	
        if($price && $doc){	
            $newPrice=get_docServPrice($doc,$id,$mood);
            $newP=$newPrice[0]+$newPrice[1];							
            if($newP){$price=$newP;}
        }
        $offerTxt='';
        if(_set_9iaut3jze){
            $offerTxt=showBtySrvOffer($id,$offerSrv,$bupOffer,$price);
            $price=$offerTxt[0];
        }        
        echo BtyTempLoad($mood,$id,$price,$name,$offerTxt[1],$multi);
	}
}?>