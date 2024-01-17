<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['v'] , $_POST['a'], $_POST['mood'])){
	$vis=pp($_POST['v']);
	$amount=pp($_POST['a']);
	$mood=pp($_POST['mood']);
	$doc=pp($_POST['doc']);
	$table=$visXTables[$mood];
	$table2=$srvXTables[$mood];
	list($p,$s,$c,$d)=get_val($table,'patient,status,clinic,doctor',$vis);
	if($p){
		$sql="select * from gnr_x_visits_services_alert where visit_id='$vis' and mood='$mood' ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			//$all_add=get_sum('gnr_x_visits_services_alert','amount'," status=0 and visit_id='$vis' and mood='$mood' ");
			if($mood==6){	
				$p=addPay6($vis);
				if(mysql_q("DELETE from gnr_x_visits_services_alert where visit_id='$vis' and mood='$mood' ")){echo 1;}
			}else if($mood==4){
				$srvs=get_sum('den_x_visits_services','pay_net',"patient='$p'");
				$lastPay=patDenPay($p,$doc);
				$bal=$srvs-$lastPay;
				if($bal){$p=addPay4($vis,11,$amount,$doc);}
				if(mysql_q("DELETE from gnr_x_visits_services_alert where visit_id='$vis' and mood='$mood' ")){echo 1;}
				mysql_q("DELETE from gnr_x_temp_oprs where type=2 and mood='$mood' and vis='$vis' ");
				fixPatintAcc($p);				
			}else{
                $all_add=get_sum($table2,'pay_net',"visit_id='$vis' and status IN(5)");
				$all_del=get_sum($table2,'pay_net',"visit_id='$vis' and status IN(4)");
				$all_insur=get_sum('gnr_x_insur_pay_back','amount',"visit='$vis' and patient='$p' ");				
				$balans=$all_add-$all_del-$all_insur;
				$p1=$p2=$p3=1;
				if($balans<0){$balans=$balans*(-1);}				
				if($balans==$amount){			
					if($all_add){
						if($mood==1){$p1=addPay1($vis,22);}
						if($mood==3){$p1=addPay3($vis,22);}
						if($mood==5){$p1=addPay5($vis,22);}
					}
					if($all_del){					
						if($mood==1){$p2=addPay1($vis,4);}
						if($mood==3){$p2=addPay3($vis,4);}
						if($mood==5){$p2=addPay5($vis,4);}
					}
					if($all_insur){
						$sql="select * from gnr_x_insur_pay_back where patient='$p' ";
						$res=mysql_q($sql);
						while($r=mysql_f($res)){
							$id=$r['id'];
							$in_vis=$r['visit'];
							$amount=$r['amount'];
							if($mood==1){$p3=addPay1($in_vis,6,$amount);}
							if($mood==3){$p3=addPay3($in_vis,6,$amount);}
							if($mood==2){$p3=addPay2($in_vis,6,$amount);}
							if(mysql_q("DELETE from gnr_x_insur_pay_back where id='$id' "));
						}						
					}
					if($p1 && $p2 && $p3){
						if(mysql_q("DELETE from gnr_x_visits_services_alert where visit_id='$vis' and mood='$mood' ")){
							if($mood==1 || $mood==3 || $mood==5){
								mysql_q("UPDATE $table2 SET status=1  where visit_id='$vis' and status=5 ");
								mysql_q("UPDATE $table2 SET status=3  where visit_id='$vis' and status=4 ");
							}
							echo 1;
						}
					}
				}				
			}
		}
	}
}?>