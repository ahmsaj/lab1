<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
    $vis=pp($_POST['vis']);
    $pat=pp($_POST['pat']);
    $price=pp($_POST['price']);
    $note=pp($_POST['note'],'s');
    $tooth=pp($_POST['tooth'],'s');
    $r=getRec('den_m_services',$id);
    if($r['r']){        
        $hos_part=$r['hos_part'];
        $doc_part=$r['doc_part'];
        $pay_net=$hos_part+$doc_part;
        $total_pay=$pay_net;
        $doc_percent=$r['doc_percent'];
        $tooth_link=$r['tooth_link'];        
        
        $tooth_no=0;
		if($tooth){$tn=explode(',',$tooth);$tooth_no=count($tn);}
		if($tooth_link==0 || ($tooth_link!=0 && $tooth)){ 
			if(chDenSrvLev($id)){
				 $sql="INSERT INTO den_x_visits_services (`visit_id`, `clinic`, `service`, `hos_part`, `doc_part`, `doc_percent`, `pay_net`,`d_start`,`total_pay`,`patient`,`doc_add`,`teeth`,`tooth_no`,`note`)values ('$vis','$userSubType','$id','$hos_part','$doc_part','$doc_percent','$pay_net','$now','$total_pay','$pat','$thisUser','$tooth','$tooth_no','$note')";
				if(mysql_q($sql)){
                    $x_srv=last_id();
                    echo '1^'.$x_srv; 
                    changeSrvPrice($x_srv,$price,1);
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
                        mysql_q("INSERT INTO den_x_visits_services_levels (vis,patient,service,x_srv,lev,date,price,lev_perc,doc_part)values
                        ('$vis','$pat','$id','$x_srv','$lev','$now','$newPrice','$percet','$doc_part')");
                    }
                    fixDenLevPrices($x_srv);
                }
			}else{echo '0^0';}
		}else{echo '0^0';}
    }
}?>