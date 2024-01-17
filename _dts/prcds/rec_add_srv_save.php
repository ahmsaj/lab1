<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['m'],$_POST['c'],$_POST['d'],$_POST['p'])){
	$mood=pp($_POST['m']);
	$c=pp($_POST['c']);//clinic
	$p=pp($_POST['p']);//patient
    $d=pp($_POST['d']);//doctor
    $dts_id=pp($_POST['dts']);//app Id
	$p_type=0;
	$doctor=0;
	/*if($p!=0){// التأكد من أن الطبيب يحجز الموعد لمريضه
		$pat_ch=getTotalCO('gnr_m_patients'," id='$p'");
		if($pat_ch && in_array($thisGrp,array('7htoys03le','fk590v9lvl','9yjlzayzp','66hd2fomwt','fk590v9lvl','9k0a1zy2ww'))){
			$p_type=1;
			$doctor=$thisUser;
		}else{
			out();exit;           
		}
	}*/
	if($mood==4){
		$doctor=0;
	}else{
		$cc=getTotalCO('gnr_m_clinics'," id='$c'");		
	}
    
	$m_clinic=getMClinic($c);
	if($mood){		
		if($dts_id==0){			
			$sql="INSERT INTO dts_x_dates(`clinic`,`date`,`reg_user`,`patient`,`p_type`,`doctor`,`type`)
			values ('$c','$now','$thisUser','$p','$p_type','$doctor','$mood')";
			mysql_q($sql);
			$dts_id=last_id();
            addTempOpr($p,9,$mood,$c,$dts_id);
		}else{					
			mysql_q("DELETE from dts_x_dates_services where dts_id='$dts_id'");
            datesTempUp($dts_id);
		}
		echo $dts_id;		
		if($mood==4){
			$teethTime=pp($_POST['teethTime']);
			mysql_q("INSERT INTO dts_x_dates_services (`dts_id`, `service`,`ser_time` ) values ('$dts_id','1','$teethTime')");
		}else{
            if(is_array($_POST['srvs'])){
                $srvs=implode(',',$_POST['srvs']);
            }
            if($mood==3 || $mood==7){
                $srvs=pp($_POST['srvs'],'s');
            }
            if($mood==5 || $mood==6){
                $srvs=$_POST['srvs'];
                $srvs=pp($_POST['srvs'],'s');
                $srvAr=explode(',',$srvs);
                $srvArr=[];        
                foreach($srvAr as $v){
                    $vv=explode(':',$v);
                    $srvArr[$vv[0]]=$vv[1];
                } 
                $srvs=implode(',',array_keys($srvArr));
            }
            $srvs=pp($srvs,'s');
            $table=$srvTables[$mood];
            $qClnc="clinic='$m_clinic'";
            if($mood==5 || $mood==6){
                $qClnc="cat IN(select id from bty_m_services_cat where clinic='$c')";
            }
            if($srvs){
                $sql="select * from $table where $qClnc and act=1 and id IN($srvs) ";            
                $res=mysql_q($sql);
                $rows=mysql_n($res);		
                if($rows>0){
                    while($r=mysql_f($res)){
                        $s_id=$r['id'];
                        $ser_time=$r['ser_time']*_set_pn68gsh6dj;
                        list($timeN,$price)=get_docTimePrice($d,$s_id,$mood);
                        mysql_q("INSERT INTO dts_x_dates_services (`dts_id`, `service` ,`ser_time`) values ('$dts_id','$s_id','$ser_time')");
                        
                    }
                }
            }
		}
	}else{echo '0';}
}?>