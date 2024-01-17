<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['pat'])){
    $mood=2;
    $nameTypes=array('','short_name','name_en','name_ar');
	$id=pp($_POST['id'],'s');
    $pat=pp($_POST['pat']);
	$r=getRec('lab_m_services',$id);
    $sql="select * from lab_m_services where id IN($id)";
    $res=mysql_q($sql);
    
    if(_set_9iaut3jze){
        $bupOffer=array();
        $offersAv=offersList($mood,$pat);
        $offerSrv=getSrvOffers($mood,$pat);
    } 
    while($r=mysql_f($res)){		
		$id=$r['id'];
        $s_id=$id;
        $con=$r['conditions'];
		$sample_type=$r['sample_type'];
		$time_req=$r['time_req'];
		$ch_sample=$r['ch_sample'];
        $cus_unit_price=$r['cus_unit_price'];
        $short_name=$r[$nameTypes[_set_yj870gpuyy]];
        $short_name2=$short_name;
        if(_set_yj870gpuyy!=3){$short_name2=strtolower($short_name);}	
        $unit=$r['unit'];
        $fast=$r['fast'];
		$unit_price=_set_x6kmh3k9mh;
        $price=$unit*$unit_price;
        if($cus_unit_price){$price=$unit*$cus_unit_price;}
		$fast=$r['fast'];
        $offerTxt='';
        if(_set_9iaut3jze){
            $offerTxt=showLabSrvOffer($id,$offerSrv,$bupOffer,$price);
            $price=$offerTxt[0];
        }
        echo anaTempLoad($id,$price,$short_name2,$fast,$offerTxt[1]);
	}
}?>