<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['emp'],$_POST['opr'])){
	$id=pp($_POST['id']);
	$emp=pp($_POST['emp']);
	$opr=pp($_POST['opr']);
	$vType=pp($_POST['vType']);
	$s_date=strtotime(pp($_POST['s_date'],'s'));
	$e_date=strtotime(pp($_POST['e_date'],'s'));
	$s_time=timeToIntger(pp($_POST['s_time'],'s'));
	$e_time=timeToIntger(pp($_POST['e_time'],'s'));
	$err=0;
	if($id){
		$r=getRec('gnr_x_vacations',$id);
		if($r['r']){
			$hide='';
			$emp=$r['emp'];
			$vType=$r['type'];
			$e_s_date=date('Y-m-d',$r['s_date']);
			$e_e_date=date('Y-m-d',$r['e_date']);
			$e_s_time=clocFromstr($r['s_hour']);
			$e_e_time=clocFromstr($r['e_hour']);
			$e_qd_s_date=$r['s_date'];
			$e_qd_e_date=$r['e_date']+86400;
			if($vType==2){
				$e_qd_s_date=$e_s_date+$e_s_time;
				$e_qd_e_date=$e_s_date+$e_e_time;
			}
		}else{
			$err=1;
		}
	}
	if(getTotalCO('_users'," id='$emp' ")){
		if($vType==1){
			if(!$s_date || !$e_date || ($s_date>$e_date)){
				$err=1;
			}else{
				$s_time=$e_time=0;			
				$qd_s_date=$s_date;
				$qd_e_date=$e_date+86400;
			}			
		}
		if($vType==2){			
			if(!$s_date || !$s_time || !$e_time || ($s_time>($e_time-900))){
				$err=1;
			}else{
				$e_date=$s_date;							
				$qd_s_date=$s_date+$s_time;
				$qd_e_date=$s_date+$e_time;
			}
		}
		
		if($err==0){
			if($opr==1){
				$xDate=getTotalCO('dts_x_dates'," doctor='$emp' and 
				((d_start > $qd_s_date and d_start < $qd_e_date) OR
				(d_end > $qd_s_date and d_end < $qd_e_date))and status in(1,9,10)
				");
				if($xDate==0){$opr=2;}else{echo '1,'.$xDate;}
			}
			if($opr==2){
				if($id){
					$sql="UPDATE  gnr_x_vacations SET 
					`type`='$vType',
					`s_date`='$s_date',
					`e_date`='$e_date',
					`s_hour`='$s_time',
					`e_hour`='$e_time' where id='$id' ";
					if(mysql_q($sql)){
						echo '2,1';
						logOpr($id,2);
						vacaConflict('del',$emp,$e_qd_s_date,$e_qd_e_date);
						vacaConflict('add',$emp,$qd_s_date,$qd_e_date);
					}
				}else{
					$emps=$emp;
					$same_users=get_vals('_users','same_users',"id='$emp'");					
					if($same_users){$emps=$emp.','.$same_users;}
					$em=explode(',',$emps);
					foreach($em as $ee){
						$sql="INSERT INTO gnr_x_vacations
						(`emp`,`type`,`s_date`,`e_date`,`s_hour`,`e_hour`,`date`)
						values
						('$ee','$vType','$s_date','$e_date','$s_time','$e_time','$now')";
						if(mysql_q($sql)){							
							$id=last_id();
							logOpr($id,1);
							vacaConflict('add',$emp,$qd_s_date,$qd_e_date);
						}
					}
					echo '2,1';
				}
			}
		}
	}
}?>