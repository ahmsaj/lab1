<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$note=pp($_POST['note'],'s');
	$reasons=pp($_POST['reason']);
	$r=getRecCon('gnr_x_temp_oprs'," type=1 and id='$id' and status=0");
	if($r['r']){
		$pat=$r['patient'];
		$mood=$r['mood'];
		$clinic=$r['clinic'];
		$vis=$r['vis'];
		
		$sub_status=$r['sub_status'];		
		$vx_table=$visXTables[$mood];
		$sx_table=$srvXTables[$mood];
		$sm_table=$srvTables[$mood];
		$q='';
		if($mood!=4){$q=" and status=0 ";}
		$sql="select * from $sx_table where visit_id='$vis' $q ";
		$res=mysql_q($sql);
		$date=$now;
		$covPrices=0;
		while($r=mysql_f($res)){
			$s_id=$r['id'];
			$service=$r['service'];
			$price=$r['total_pay'];				
			$pay_net=$r['pay_net'];
			$s_status=$r['status'];
			$covPrice=pp($_POST['ser'.$s_id]);
			$covPrices+=$covPrice;
			if($covPrice && $covPrice<=$price){
				$s=0;
				if($mood==4){$s=1;}
				$sql="INSERT INTO gnr_x_exemption_srv (`patient`,`mood`,`clinic`,`vis`,`x_srv`,`m_srv`,`srv_price`,`srv_covered`,`date`,`status`)values('$pat','$mood','$clinic','$vis','$s_id','$service','$price','$covPrice','$date','$s')";				
				mysql_q($sql);
				$pay_net=$price-$covPrice;
				mysql_q("UPDATE $sx_table set pay_net='$pay_net' , pay_type=1 where id='$s_id'");
			}
		}
		mysql_q("UPDATE $vx_table SET  sub_status=1 , pay_type_link='$reasons' where id='$vis'");
		editTempOpr($mood,$vis,1,1);
		if(getTotalCO('gnr_x_exemption_notes',"mood='$mood' and vis='$vis'")){
			mysql_q("UPDATE gnr_x_exemption_notes SET  note='$note' where mood='$mood' and id='$vis'");
		}else{
			if($note){
				mysql_q("INSERT INTO gnr_x_exemption_notes (`vis`,`mood`,`note`)values('$vis','$mood','$note')");
			}
		}
		if($mood==4){
            mysql_q("UPDATE gnr_x_visits_services_alert SET status=1 where mood='$mood' and visit_id='$vis' ");
			addPay4($vis,5,$covPrices);
			delTempOpr($mood,$vis,'a');
		}
	}
}?>