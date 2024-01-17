<? include("../../__sys/prcds/ajax_header.php");
$mood=4;
if(isset($_POST['id'],$_POST['tooth'],$_POST['vis'])){	
	$id=pp($_POST['id']);
	$vis=pp($_POST['vis']);
	$tooth=pp($_POST['tooth'],'s');
    $p=get_val($visXTables[$mood],'patient',$vis);
	$r=getRec($srvTables[$mood],$id);	
	if($r['r']){
		$tooth_link=$r['tooth_link'];
		$hos_part=$r['hos_part'];
		$doc_part=$r['doc_part'];
		$total_pay=$r['total_pay'];        
		$doc_percent=$r['doc_percent'];
		$total_pay=$hos_part+$doc_part;
		$pay_net=$hos_part+$doc_part;
		$tooth_no=0;
		if($tooth){$tn=explode(',',$tooth);$tooth_no=count($tn);}
		if($tooth_link==0 || ($tooth_link!=0 && $tooth!=0)){
			list($p,$emplo)=get_val($visXTables[$mood],'patient,emplo',$vis);			
			if($pay_net){
				$newPrice=get_docServPrice($thisUser,$id,$mood);
				$newP=$newPrice[0]+$newPrice[1];							
				if($newP){
					$doc_percent=$newPrice[2];
					$hos_part=$newPrice[0];
					$doc_part=$newPrice[1];
					$pay_net=$newP;$total_pay=$newP;
				}
			}
			if($emplo && $pay_net){
				if(_set_96voskjo2){
					$hos_part=$hos_part-($hos_part/100*_set_96voskjo2);
					$hos_part=round($hos_part,-1,PHP_ROUND_HALF_DOWN);
					$doc_part=$doc_part-($doc_part/100*_set_96voskjo2);
					$doc_part=round($doc_part,-1,PHP_ROUND_HALF_DOWN);
					$pay_net=$hos_part+$doc_part;
				}
			}			
			if(chDenSrvLev($id)){
				$sql="INSERT INTO den_x_visits_services (`visit_id`, `clinic`, `service`, `hos_part`, `doc_part`, `doc_percent`, `pay_net`,`d_start`,`total_pay`,`patient`,`doc_add`,`teeth`,`tooth_no`)values ('$vis','$userSubType','$id','$hos_part','$doc_part','$doc_percent','$pay_net','$now','$total_pay','$p','$thisUser','$tooth','$tooth_no')";
				if(mysql_q($sql)){echo '1^'.last_id();
                    $x_srv=last_id();
                    $sql="select * from den_m_services_levels where service	='$id' order by ord ASC";
                    $res=mysql_q($sql);
                    while($r=mysql_f($res)){
                        $lev=$r['id'];
                        $percet=$r['percet'];					
                        //$price=$total_pay*$percet/100;
                        $newPrice=0;
                        if($percet>0){
                            $newPrice=($total_pay*$percet)/100;
                            $doc_part=($newPrice*$doc_percent)/100;
                        }else{
                            $doc_part=0;
                        }
                        $sql3="INSERT INTO den_x_visits_services_levels (vis,patient,service,x_srv,lev,date,price,lev_perc,doc_part)values
                        ('$vis','$p','$id','$x_srv','$lev','$now','$newPrice','$percet','$doc_part')";
                        mysql_q($sql3);                        
                    }
                }
			}else{
				echo '2^';
			}
		}else{
			if(chDenSrvLev($id)){
				echo '0^'.$tooth_link;
			}else{
				echo '2^';
			}
		}
	}
}?>