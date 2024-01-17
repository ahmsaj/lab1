<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['m'],$_POST['p'],$_POST['srv'])){
	$ret=100;
	$id=pp($_POST['id']);
	$mood=pp($_POST['m']);
	$p=pp($_POST['p']);
	$srv=pp($_POST['srv'],'s');
	$rec=getRec('gnr_m_offers',$id);
	if($rec['r'] && $srv){
		$type=$rec['type'];
		if($type==1 || $type==2){
			$table=$srvTables[$mood];
			$sql="select * from $table where id IN($srv) ";
			$res=mysql_q($sql);
			while($r=mysql_f($res)){
				$s_id=$r['id'];
				if($mood==2){
					$unit=$r['unit'];
					$unit_price=_set_x6kmh3k9mh;
					if($unit_price){$unit_price=roundNo(($unit_price/100)*(100-$p),1);}
					$price=$unit_price*$unit;
					mysql_q("INSERT INTO gnr_m_offers_items (`offers_id`,`mood`,`service`,`hos_part`,`doc_part`,`doc_percent`,`price`)
					values('$id','$mood','$s_id','$unit','$unit_price','0','$price')");
				}else{
					$hos_part=$r['hos_part'];
					$doc_part=$r['doc_part'];
					$doc_percent=$r['doc_percent'];

					if($hos_part){$hos_part=roundNo(($hos_part/100)*(100-$p),$ret);}
					if($doc_part){$doc_part=roundNo(($doc_part/100)*(100-$p),$ret);}
					$price=$hos_part+$doc_part;					
					mysql_q("INSERT INTO gnr_m_offers_items (`offers_id`,`mood`,`service`,`hos_part`,`doc_part`,`doc_percent`,`price`,`dis_percent`)
					values('$id','$mood','$s_id','$hos_part','$doc_part','$doc_percent','$price','$p')");
				}
				
			}
		}
		echo 1;
	}
}else if(isset($_POST['id'],$_POST['mood'],$_POST['offSubType'],$_POST['offSubSrv'])){
	$id=pp($_POST['id']);
	$r=getRec('gnr_m_offers',$id);
	if($r['r']){
		$sett=$r['sett'];
		$clinics=$r['clinics'];
		/**************/
		$mood=pp($_POST['mood']);
		$clinic=pp($_POST['offSubType']);
		$service=pp($_POST['offSubSrv']);
		$price=pp($_POST['price']);
		$num=pp($_POST['num']);
		//if(get_val('gnr_m_clinics','type',$clinic)==$mood){
			if(getTotalCO($srvTables[$mood],"id='$service'")){
				if($price && $num>1){
					$v=$clinic.','.$service.','.$price.','.$num;				
					if($sett){
						$s=explode(',',$sett);
						$v=$s[0].','.$s[1].','.$price.','.$num;
					}
					if(mysql_q("UPDATE gnr_m_offers SET sett='$v' , clinics='$mood' where id='$id' ")){
						echo 1;
					}					
				}
			}
		//}	
	}
}?>