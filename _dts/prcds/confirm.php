<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$sql="select * from dts_x_dates where id='$id' and status in(1,9) ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows){
		$r=mysql_f($res);
		$dts_date=$r['d_start'];
		$patient=$r['patient'];
		$clinic=$r['clinic'];
		$doctor=$r['doctor'];		
		$c_type=$r['type'];
        $p_type=$r['p_type'];
        $reg_user=$r['reg_user'];
        $app=$r['app'];
        $fromApp=0;
        if($app){$fromApp=1;}
        if($p_type==1){
            $m_clinic=getMClinic($clinic);            
            setDtsBList(1,$patient,1);
            $dts_id=$id;
            $lastDate=0;
            if($dts_date<$now-(60*_set_d9c90np40z )){
                $dts_date=0;
                $dts_id=0;
                $lastDate=1;
            }
            if($c_type==1){
                if(getTotalCO('cln_x_visits',"dts_id='$id'")==0){                    
					if($ch_p==1 && $rev){$hos_part=0;$doc_part=0;}
                    $sql11="INSERT INTO cln_x_visits                    (`doctor`,`patient`,`clinic`,`d_start`,`type`,`reg_user`,`dts_id`,`dts_date`,`new_pat`,`app`,`dts_reg`)values
                    ('$doctor','$patient','$clinic','$now','1','$thisUser','$dts_id','$dts_date','$new_pat','$fromApp','$reg_user')";
                    if(mysql_q($sql11)){			
                        $vis_id=last_id();
                        if($lastDate){
                            $res=mysql_q("UPDATE dts_x_dates SET d_confirm='$now',vis_link='$vis_id', status=8 where id='$id' ");
                            datesTempUp($id);                            
                        }else{
                            $res=mysql_q("UPDATE dts_x_dates SET vis_link='$vis_id',d_confirm='$now' where id='$id'");
                            datesTempUp($id);
                        }
                        addTempOpr($patient,4,$c_type,$clinic,$vis_id);
                        if($res){
                            datesTempUp($d_srv_id);
                            echo $vis_id;
                        }
                        $sql2="select * from dts_x_dates_services where dts_id='$id' and status<2 ";
                        $res2=mysql_q($sql2);
                        while($r2=mysql_f($res2)){
                            $d_srv_id=$r2['id'];
                            $service=$r2['service'];	list($hos_part,$doc_part,$doc_percent,$rev)=get_val('cln_m_services','hos_part,doc_part,doc_percent,rev',$service);
                            $total_pay=$hos_part+$doc_part;
                            if($doctor){						
                                $newPrice=get_docServPrice($doctor,$service,$c_type);
                                $newP=$newPrice[0]+$newPrice[1];
                                if($newP){
                                    $doc_percent=$newPrice[2];
                                    $hos_part=$newPrice[0];
                                    $doc_part=$newPrice[1];
                                    $pay_net=$newP;$total_pay=$newP;
                                }
                            }						
                            $ch_p=ch_prv($service,$patient,$doctor);
                            if($ch_p==1 && $rev){$hos_part=0;$doc_part=0;}						
                            $pay_net=$hos_part+$doc_part;						
                            $sql="INSERT INTO cln_x_visits_services (`visit_id`, `clinic`, `service`, `hos_part`, `doc_part`, `doc_percent`, `pay_net`, `d_start`, `total_pay`, `patient`,`rev`)values				('$vis_id','$m_clinic','$service','$hos_part','$doc_part','$doc_percent','$pay_net','$now','$total_pay','$patient', '$ch_p')";
                            if(mysql_q($sql)){
                                $srv_x_id=last_id();                                
                                if(_set_9iaut3jze){activeOffer($c_type,$clinic,$doctor,$patient,$vis_id,$service,$srv_x_id);}
                                mysql_q("UPDATE dts_x_dates_services SET status=1 where id='$d_srv_id' ");
                            }
                        }
                        activeAppDiscount($c_type,$vis_id);
                        
                    }
                }else{
                    echo $vis_id=get_val_con('cln_x_visits','id',"dts_id='$id'");
                }
            }
            if($c_type==3){
                if(getTotalCO('xry_x_visits',"dts_id='$id'")==0){
                    $doc='doctor';
                    if(get_val('_users','grp_code',$doctor)=='1ceddvqi3g'){$doc='ray_tec';}
                    $new_pat=isNewPat($patient,$doctor,$c_type);
                    $sql11="INSERT INTO xry_x_visits (`$doc`,`patient`,`clinic`,`d_start`,`type`,`reg_user`,`dts_id`,`dts_date`,`new_pat`,`app`,`dts_reg`)values
                    ('$doctor','$patient','$clinic','$now','1','$thisUser','$dts_id','$dts_date','$new_pat','$fromApp','$reg_user')";
                    if(mysql_q($sql11)){			
                        $vis_id=last_id();
                        addTempOpr($patient,4,$c_type,$clinic,$vis_id);
                        if($lastDate){
                            $res=mysql_q("UPDATE dts_x_dates SET d_confirm='$now' , vis_link='$vis_id' , status=8 where id='$id' ");
                            datesTempUp($id);
                        }else{
                            $res=mysql_q("UPDATE dts_x_dates SET vis_link='$vis_id' , d_confirm='$now'  where id='$id' ");
                            datesTempUp($id);
                        }
                        if($res){echo $vis_id;}
                        $sql2="select * from dts_x_dates_services where dts_id='$id' and status<2 ";
                        $res2=mysql_q($sql2);
                        while($r2=mysql_f($res2)){
                            $d_srv_id=$r2['id'];
                            $service=$r2['service'];	list($hos_part,$doc_part,$doc_percent,$rev)=get_val('xry_m_services','hos_part,doc_part,doc_percent,rev',$service);
                            $total_pay=$hos_part+$doc_part;
                            /*if($doctor){						
                                $newPrice=get_docServPrice($doctor,$service,$c_type);
                                $newP=$newPrice[0]+$newPrice[1];
                                if($newP){
                                    $doc_percent=$newPrice[2];
                                    $hos_part=$newPrice[0];
                                    $doc_part=$newPrice[1];
                                    $pay_net=$newP;$total_pay=$newP;
                                }
                            }	*/					
                            //$ch_p=ch_prv($service,$patient,$doctor);                            
                            $ch_p=0;
                            if($ch_p==1 && $rev){$hos_part=0;$doc_part=0;}						
                            $pay_net=$hos_part+$doc_part;						
                            $sql="INSERT INTO xry_x_visits_services (`visit_id`, `clinic`, `service`, `hos_part`, `doc_part`, `doc_percent`, `pay_net`, `d_start`, `total_pay`, `patient`)values				('$vis_id','$m_clinic','$service','$hos_part','$doc_part','$doc_percent','$pay_net','$now','$total_pay','$patient')";
                            if(mysql_q($sql)){
                                $srv_x_id=last_id();                                
                                if(_set_9iaut3jze){activeOffer($c_type,$clinic,$doctor,$patient,$vis_id,$service,$srv_x_id);}
                                mysql_q("UPDATE dts_x_dates_services SET status=1 where id='$d_srv_id' ");                            
                            }
                        }
                        activeAppDiscount($c_type,$vis_id);
                    }
                }else{
                    echo $vis_id=get_val_con('xry_x_visits','id',"dts_id='$id'");
                }
}
            if($c_type==4){
                if(getTotalCO('den_x_visits',"dts_id='$id'")==0){
                    $new_pat=isNewPat($patient,$doctor,$c_type);
                    $sql11="INSERT INTO den_x_visits (`doctor`,`patient`,`clinic`,`d_start`,`reg_user`,`dts_id`,`dts_date`,`type`,`new_pat`,`app`,`dts_reg`)values
                    ('$doctor','$patient','$clinic','$now','$thisUser','$dts_id','$dts_date',0,'$new_pat','$fromApp','$reg_user')";
                    if(mysql_q($sql11)){
                        $vis_id=last_id();
                        conformDatePay($dts_id);
                        addTempOpr($patient,4,$c_type,$clinic,$vis_id);
                        if($lastDate){
                            $res=mysql_q("UPDATE dts_x_dates SET d_confirm='$now' , vis_link='$vis_id' , status=8 where id='$id' ");
                            datesTempUp($id);
                        }else{
                            $res=mysql_q("UPDATE dts_x_dates SET vis_link='$vis_id' , d_confirm='$now'  where id='$id' ");
                            datesTempUp($id);
                        }
                        if($res){echo $vis_id;}
                        mysql_q("UPDATE dts_x_dates_services SET status=1 where dts_id='$dts_id' ");
                    }
                }
            }
            if($c_type==5){
                if(getTotalCO('bty_x_visits',"dts_id='$id'")==0){
                    $new_pat=isNewPat($patient,$clinic,$c_type);
                    $sql11="INSERT INTO bty_x_visits (`doctor`,`patient`,`clinic`,`d_start`,`reg_user`,`dts_id`,`dts_date`,`new_pat`,`app`,`dts_reg`)values
                    ('$doctor','$patient','$clinic','$now','$thisUser','$dts_id','$dts_date','$new_pat','$fromApp','$reg_user')";
                    
                    if(mysql_q($sql11)){			
                        $vis_id=last_id();
                        addTempOpr($patient,4,$c_type,$clinic,$vis_id);
                        if($lastDate){
                            $res=mysql_q("UPDATE dts_x_dates SET d_confirm='$now' , vis_link='$vis_id' , status=8 where id='$id' ");
                            datesTempUp($id);
                        }else{
                            $res=mysql_q("UPDATE dts_x_dates SET vis_link='$vis_id' , d_confirm='$now'  where id='$id' ");
                            datesTempUp($id);
                        }
                        if($res){echo $vis_id;}
                        $sql2="select * from dts_x_dates_services where dts_id='$id' and status<2 ";
                        $res2=mysql_q($sql2);
                        while($r2=mysql_f($res2)){
                            $d_srv_id=$r2['id'];
                            $service=$r2['service'];
                            list($hos_part,$doc_part,$doc_percent)=get_val('bty_m_services','hos_part,doc_part,doc_percent',$service);											
                            $total_pay=$hos_part+$doc_part;
                            /*if($doctor){						
                                $newPrice=get_docServPrice($doctor,$service,$c_type);
                                $newP=$newPrice[0]+$newPrice[1];
                                if($newP){
                                    $doc_percent=$newPrice[2];
                                    $hos_part=$newPrice[0];
                                    $doc_part=$newPrice[1];
                                    $pay_net=$newP;$total_pay=$newP;
                                }
                            }	*/	
                            $pay_net=$hos_part+$doc_part;
                            $sql="INSERT INTO bty_x_visits_services (`visit_id`, `clinic`, `service`, `hos_part`, `doc_part`, `doc_percent`, `pay_net`, `d_start`, `total_pay`, `patient`)values				('$vis_id','$m_clinic','$service','$hos_part','$doc_part','$doc_percent','$pay_net','$now','$total_pay','$patient')";
                            if(mysql_q($sql)){
                                $srv_x_id=last_id();                                
                                if(_set_9iaut3jze){activeOffer($c_type,$clinic,$doctor,$patient,$vis_id,$service,$srv_x_id);}
                                mysql_q("UPDATE dts_x_dates_services SET status=1 where id='$d_srv_id' ");
                            }
                        }
                        activeAppDiscount($c_type,$vis_id);
                    }
                }else{
                    echo $vis_id=get_val_con('bty_x_visits','id',"dts_id='$id'");
                }
            }
            if($c_type==6){
                if(getTotalCO('bty_x_laser_visits',"dts_id='$id'")==0){
                    $new_pat=isNewPat($patient,$doctor,$c_type);
                    $sql11="INSERT INTO bty_x_laser_visits 
                    (`doctor`,`patient`,`clinic`,`d_start`,`reg_user`,`dts_id`,`dts_date`,`new_pat`,`app`,`dts_reg`)values
                    ('$doctor','$patient','$clinic','$now','$thisUser','$dts_id','$dts_date','$new_pat','$fromApp','$reg_user')";
                    if(mysql_q($sql11)){			
                        $vis_id=last_id();
                        conformDatePay($dts_id);
                        addTempOpr($patient,4,$c_type,$clinic,$vis_id);
                        if($lastDate){
                            $res=mysql_q("UPDATE dts_x_dates SET d_confirm='$now' , vis_link='$vis_id' ,status=8 where id='$id' ");
                            datesTempUp($id);
                        }else{
                            $res=mysql_q("UPDATE dts_x_dates SET vis_link='$vis_id' , d_confirm='$now'  where id='$id' ");
                            datesTempUp($id);
                        }
                        if($res){echo $vis_id;}
                        $sql2="select * from dts_x_dates_services where dts_id='$id' and status<2 ";
                        $res2=mysql_q($sql2);
                        while($r2=mysql_f($res2)){
                            $d_srv_id=$r2['id'];
                            $service=$r2['service'];

                            $sql="INSERT INTO bty_x_laser_visits_services (`visit_id`, `clinic`, `service`,`d_start`,`patient`)values				('$vis_id','$clinic','$service','$now','$patient')";
                            if(mysql_q($sql)){
                                mysql_q("UPDATE dts_x_dates_services SET status=1 where id='$d_srv_id' ");
                            }
                        }                        
                    }
                }
            }
            if($c_type==7){
                if(getTotalCO('osc_x_visits',"dts_id='$id'")==0){
                    $new_pat=isNewPat($patient,$doctor,$c_type);
                    $sql11="INSERT INTO osc_x_visits 
                    (`doctor`,`patient`,`clinic`,`d_start`,`type`,`reg_user`,`dts_id`,`dts_date`,`new_pat`,`app`,`dts_reg`)values
                    ('$doctor','$patient','$clinic','$now','1','$thisUser','$dts_id','$dts_date','$new_pat','$fromApp','$reg_user')";
                    if(mysql_q($sql11)){			
                        $vis_id=last_id();
                        if($lastDate){
                            $res=mysql_q("UPDATE dts_x_dates SET d_confirm='$now' , vis_link='$vis_id' , status=8 where id='$id' ");
                            datesTempUp($id);
                            addTempOpr($patient,4,$c_type,$clinic,$vis_id);
                        }else{
                            $res=mysql_q("UPDATE dts_x_dates SET vis_link='$vis_id' , d_confirm='$now'  where id='$id' ");
                            datesTempUp($id);
                        }
                        if($res){echo $vis_id;}
                        $sql2="select * from dts_x_dates_services where dts_id='$id' and status<2 ";
                        $res2=mysql_q($sql2);
                        while($r2=mysql_f($res2)){
                            $d_srv_id=$r2['id'];
                            $service=$r2['service'];	list($hos_part,$doc_part,$doc_percent,$rev)=get_val('osc_m_services','hos_part,doc_part,doc_percent,rev',$service);
                            $total_pay=$hos_part+$doc_part;
                            if($doctor){						
                                $newPrice=get_docServPrice($doctor,$service,$c_type);
                                $newP=$newPrice[0]+$newPrice[1];
                                if($newP){
                                    $doc_percent=$newPrice[2];
                                    $hos_part=$newPrice[0];
                                    $doc_part=$newPrice[1];
                                    $pay_net=$newP;$total_pay=$newP;
                                }
                            }						
                            //$ch_p=ch_prv($service,$patient,$doctor);                            
                            $ch_p=0;
                            if($ch_p==1 && $rev){$hos_part=0;$doc_part=0;}						
                            $pay_net=$hos_part+$doc_part;	
                            $sql="INSERT INTO osc_x_visits_services (`visit_id`, `clinic`,`doc`, `service`, `hos_part`, `doc_part`, `doc_percent`, `pay_net`, `d_start`, `total_pay`, `patient`)values				('$vis_id','$m_clinic','$doctor','$service','$hos_part','$doc_part','$doc_percent','$pay_net','$now','$total_pay','$patient')";
                            if(mysql_q($sql)){
                                $srv_x_id=last_id();                                
                                if(_set_9iaut3jze){activeOffer($c_type,$clinic,$doctor,$patient,$vis_id,$service,$srv_x_id);}
                                mysql_q("UPDATE dts_x_dates_services SET status=1 where id='$d_srv_id' ");
                            }
                        }
                        activeAppDiscount($c_type,$vis_id);
                    }
                }else{
                    echo $vis_id=get_val_con('osc_x_visits','id',"dts_id='$id'");
                }
            }
            vacaConflictAlert();
        }
	}else{
        echo $id;
    }
}?>