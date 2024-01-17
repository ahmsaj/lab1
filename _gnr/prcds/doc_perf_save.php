<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['type'])){
	$id=pp($_POST['id']);	
	$r=getRec('gnr_r_docs_details',$id);
	if($r['r']){
		$vacation=$vacation_hrs=$actual=$overtime_normal=$overtime=$delay=$absent=$absent_hrs=0;
		$type=pp($_POST['type']);
		$vaca=pp($_POST['vaca']);
		$late=pp($_POST['late']);
		$over=pp($_POST['over']);
		$over2=pp($_POST['over2']);
		$opr=pp($_POST['opr']);
		$actual=pp($_POST['actual']);
		$oprAmount=pp($_POST['oprAmount']);
		$estimated=pp($_POST['estimated']);
		$morning_hours=pp($_POST['morning_hours']);		
		if($type==1 || $type==4){
			$delay=$late;
			$overtime_normal=$over;
			$overtime=$over2;
			if($type==4){$vacation_hrs=$vaca;}
			//$actual=($estimated+$overtime_normal+$overtime)-($delay+$vacation_hrs);
		}
		if($type==2){
			$vacation=1;
			$vacation_hrs=$estimated;
		}
		if($type==3){
			$absent=1;
			$absent_hrs=$estimated;
		}		
		$sql="UPDATE gnr_r_docs_details SET 
		estimated='$estimated',
		morning_hours='$morning_hours',
		_vacation='$vacation',
		_vacation_hrs='$vacation_hrs',
		_actual='$actual',
		_overtime_normal='$overtime_normal',
		_overtime='$overtime',
		_delay='$delay',
		_absent='$absent',
		_absent_hrs='$absent_hrs',
		_operations='$opr',
		_operatons_amount='$oprAmount',		
		done=1
		where id='$id'";
		if(mysql_q($sql)){echo 1;}
	}
}?>