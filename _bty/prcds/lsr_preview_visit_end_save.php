<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'],$_POST['p'] , $_POST['c'] , $_POST['d'], $_POST['n'])){
	$vis=pp($_POST['vis']);
	$price=pp($_POST['p'],'f');
	$newCounter=pp($_POST['c']);
    $startCounter=pp($_POST['s']);
	$dis=pp($_POST['d']);
	$note=pp($_POST['n'],'s');
	$mood=6;
	$c=getTotalCO('bty_x_laser_visits_services',"visit_id='$vis' and  status=0 ");
	if($c==0){
		$r=getRec('bty_x_laser_visits',$vis);
		if($r['r']){
			$status=$r['status'];
			$doctor=$r['doctor'];
			$patient=$r['patient'];
			$clinic=$r['clinic'];
            $device=$r['device'];
			$dts_id=$r['dts_id'];
			$mac_type=$r['mac_type'];
            
            $r=getRecCon('bty_m_laser_device',"id = '$device' ");
            if($r['r']){        
                $device_id=$r['id'];
                $c1=$r['count1'];
                $c2=$r['count2'];
                if($mac_type==1){$lastCounter=$r['count1'];$c1=$newCounter;}
                if($mac_type==2){$lastCounter=$r['count2'];$c2=$newCounter;}
                if(_set_h9i176pni4==1){
                    $lastCounter=$startCounter;
                }
                
                if($doctor!=$thisUser){out();exit;}
                if($status==1 && $newCounter && $price){
                    $counter=get_sum('bty_x_laser_visits_services_vals','counter'," visit_id ='$vis' ");
                    $counter_r=$newCounter-$lastCounter;
                    $total=$counter_r*$price;
                    $totalPay=roundNo($total,50,'n');
                    $totalPay-=$dis;
                    
                    
                    if($newCounter >= ($lastCounter+$counter) && ($totalPay>=0) ){
                        $sql="UPDATE bty_x_laser_visits SET 
                        status=2 , 
                        d_finish='$now' ,
                        mac_s='$lastCounter',
                        mac_e='$newCounter',
                        vis_shoot='$counter',
                        vis_shoot_r='$counter_r',
                        price='$price',
                        dis='$dis',
                        total='$total',
                        note='$note',
                        total_pay='$totalPay'
                        where id='$vis' ";
                        if(mysql_q($sql)){   
                            makeSerPayAlert($vis,$mood);
                            mysql_q("UPDATE bty_m_laser_device SET count1=$c1 , count2=$c2 where id='$device_id' ");
                            delTempOpr($mood,$vis,4);
                            fixPatintAcc($patient);
                            mysql_q("UPDATE bty_x_laser_visits_services SET status=5 where visit_id='$vis' ");
                            mysql_q("UPDATE gnr_x_roles set status=4 where vis='$vis' and mood='6' ");		
                            mysql_q("DELETE from gnr_x_visits_timer where visit_id='$vis' and mood=6 ");
                            //if($code){mysql_q("UPDATE _settings SET val='$newCounter' where code='$code' ");} 
                            if($dts_id>0){
                                mysql_q("UPDATE dts_x_dates SET status='4' , d_end_r='$now' where id ='$dts_id' ");
                                datesTempUp($dts_id);
                            }                            
                            api_notif($patient,1,56,$vis);
                            echo 1;
                        }
                    }                    
                }	
            }        
		}
	}
}?>