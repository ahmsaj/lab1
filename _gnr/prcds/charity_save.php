<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['char'])){
	$id=pp($_POST['id']);
	$char=pp($_POST['char']);
	$rec_no=pp($_POST['rec_no'],'s');
	$unhcr_num=pp($_POST['unhcr_num'],'s');	
	$r=getRecCon('gnr_x_temp_oprs'," type=2 and id='$id' and status=0");
	if($r['r']){
		$pat=$r['patient'];
		$mood=$r['mood'];
		$clinic=$r['clinic'];
		$vis=$r['vis'];
		$sub_status=$r['sub_status'];		
		$vx_table=$visXTables[$mood];
		$sx_table=$srvXTables[$mood];
		$sm_table=$srvTables[$mood];		
		if(getTotalCO('gnr_m_charities',"id='$char'")){
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
					$sql="INSERT INTO gnr_x_charities_srv (`charity`,`rec_no`,`patient`,`mood`,`clinic`,`vis`,`x_srv`,`m_srv`,`srv_price`,`srv_covered`,`date`,`status`,`unhcr_num`)values('$char','$rec_no','$pat','$mood','$clinic','$vis','$s_id','$service','$price','$covPrice','$date','$s','$unhcr_num')";
					mysql_q($sql);
					$pay_net=$price-$covPrice;
					mysql_q("UPDATE $sx_table set pay_net='$pay_net' , pay_type=2 where id='$s_id'");
				}
			}
			mysql_q("UPDATE $vx_table SET  pay_type_link='$char' ,sub_status=1 where id='$vis' and pay_type_link=0 ");
			editTempOpr($mood,$vis,2,1,$char);
			if($mood==4){
                delTempOpr($mood,$vis,2);
                mysql_q("UPDATE gnr_x_visits_services_alert SET status=1 where mood='$mood' and visit_id='$vis' ");                
				addPay4($vis,3,$covPrices);
				delTempOpr($mood,$vis,'a');
			}
			
		}
	}
}?>