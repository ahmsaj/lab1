<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['countT'],$_POST['cont'])){
    $id=pp($_POST['id']);
	$countT=pp($_POST['countT']);
	$cont=pp($_POST['cont']);
    $r=getRecCon('bty_m_laser_device',"id = '$id' ");
    if($r['r']){        
        $device_id=$r['id'];
        $c1=$r['count1'];
        $c2=$r['count2'];
    
        if(($countT==1 || $countT==2) && $cont){
            if($countT==1){                
                $c_from=$c1;
                $c_to=$c1+$cont;
                $c1=$c_to;
            }
            if($countT==2){            
                $c_from=$c2;
                $c_to=$c2+$cont;
                $c2=$c_to;
            }		
            $sql="INSERT INTO bty_x_laser_calibration (`user`,`type`,`shoots`,`date`,`c_from`,`c_to`,`device`)
            values('$thisUser','$countT','$cont','$now','$c_from','$c_to','$device_id')";
            if(mysql_q($sql)){
                mysql_q("UPDATE bty_m_laser_device SET count1=$c1 , count2=$c2 where id='$device_id' ");                
                echo 1;
            }
        }
    }
}?>