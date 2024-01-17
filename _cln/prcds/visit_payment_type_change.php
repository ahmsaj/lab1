<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['type'])){
	$id=pp($_POST['id']);
	$type=pp($_POST['type']);
	$cType=pp($_POST['cType']);
	if(in_array($type,array(1,2,3))){
		$clinic=0;		
		$table=$visXTables[$cType];
		$table2=$srvXTables[$cType];
		if($cType==2){
			$clinic=get_val_c('gnr_m_clinics','id',2,'type');
		}else{
			$clinic=get_val($table,'clinic',$id);
		}
		$sql="UPDATE $table set pay_type='$type' where id='$id' ";
		if($res=mysql_q($sql)){
			$total_pay=1;
			if($type==3 && ($cType==1 || $cType==3 )){
				$total_pay=get_sum($table2,'total_pay'," visit_id ='$id' ");				
			}
			if($total_pay){
				$patient=get_val($table,'patient',$id);				
				addTempOpr($patient,$type,$cType,$clinic,$id);
				echo 1;				
			}else{
				echo 2;	
			}
		}
	}	
}?>