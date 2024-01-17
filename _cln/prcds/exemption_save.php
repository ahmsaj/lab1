<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['v_id'])){
	$v_id=pp($_POST['v_id']);
	$note=pp($_POST['note'],'s');
	$cType=pp($_POST['c_type']);
	$v_table=$visXTables[$cType];
	$v_table2=$srvXTables[$cType];
	if(getTotalCO($v_table," id='$v_id' and status=0 and sub_status=0 and pay_type=1")){
		$sql="select * from $v_table2 where visit_id='$v_id'";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			while($r=mysql_f($res)){					
                $s_id=$r['id'];
                $service=$r['service'];
                if($cType==1){
					$hos_part=$r['hos_part'];
					$doc_part=$r['doc_part'];
					$price=$hos_part+$doc_part;
				}
				if($cType==3){
					$hos_part=$r['hos_part'];
					$doc_part=$r['doc_part'];
					$price=$hos_part+$doc_part;
				}
				if($cType==2){
					$units=$r['units'];
					$units_price=$r['units_price'];
					$price=$units*$units_price;
				}
				$status=$r['status'];                				
				$dis=pp($_POST['ser'.$s_id]);				
				$pay_net=$price-$dis;				
				mysql_q("UPDATE $v_table2 set pay_net='$pay_net' where id='$s_id'");
            }
		}
		mysql_q("UPDATE $v_table set sub_status='1' where id='$v_id' ");
		EditTempOpr($cType,$v_id,1,1);	
		mysql_q("UPDATE gnr_x_exemption set note='$note' where vis='$v_id' ");
	}else{echo '0';}
}?>