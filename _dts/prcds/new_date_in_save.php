<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['ds'] , $_POST['de'] , $_POST['dd'])){
	$id=pp($_POST['id']);
	$d=pp($_POST['dd']);    
	$s=pp($_POST['ds']);
	$e=pp($_POST['de']); 
    $payType=pp($_POST['pt']); 
	$dPay=pp($_POST['dPay']);
	$doc=pp($_POST['doc']);
	$note=pp($_POST['note'],'s');
    $other=0;
    if(isset($_POST['other'])){$other=1;}
	$sql="select * from dts_x_dates where id='$id' and status in (0,1,9) ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		//$doctor=$r['doctor'];
        if(!$doctor){$doctor=$doc;}
		$patient=$r['patient'];
		$clinic=$r['clinic'];
		$date=$r['date'];
		$status=$r['status'];
		$mood=$r['type'];
		$docClinic=get_val('_users','subgrp',$doctor);
		$docClinicArr=explode(',',$docClinic);
		if(!in_array($clinic,$docClinicArr)){		
			$clinic=intval($docClinic);
		}        
		$srvs=get_vals('dts_x_dates_services','service',"dts_id='$id'");
		if($mood==4){
			$timeN=get_val_c('dts_x_dates_services','ser_time',$id,'dts_id' );
			$price=0;
		}else{
			list($timeN,$price)=get_docTimePrice($doctor,$srvs,$mood,$id);
		}		//echo (($e-$s)/60).'-'.$timeN;
		$datBalance=0;
		if($dPay){$datBalance=DTS_PayBalans($id);}
		if($dPay+$datBalance<=$price){
			if($dPay){                
                addPay($id,6,$clinic,$dPay);
            }
			if(($e-$s)/60==$timeN){                
				$d_start=$d+$s;
				$d_end=$d+$e;
				$ch1=chDaConflicts($id,$d_start,$d_end,$clinic);//check Conflicts
				$ch2=chDaDocAal($doctor,$d_start,$d_end);//check doctor time is available
				if($ch1==1 && $ch2==1){
                    $q='';
                    if($status==9){ $q=" , status=1";}
                    $sql="UPDATE dts_x_dates SET d_start='$d_start' , d_end='$d_end' , doctor='$doctor' , clinic='$clinic' , note='$note' , other='$other', reserve=0 $q where id='$id' ";
					if(mysql_q($sql)){				
					    echo 1;
                        datesTempUp($id);
						if($patient){logOpr($id,2,'igilkzgy0k');}                        
                        editTempOpr($mood,$id,9,1);
                        if($status==9){vacaConflictAlert();}                        
					}
				}else{
					if($ch1!=1){echo $ch1;}
					if($ch2!=1){echo $ch2;}				
				}
			}
		}else{
			echo 'x3-0';
		}		
	}
}?>