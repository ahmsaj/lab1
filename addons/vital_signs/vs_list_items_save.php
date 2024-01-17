<? include("../header.php");
if(isset($_POST['id'],$_POST['pat'],$_POST['vis'])){
	$id=pp($_POST['id']);
	$pat=pp($_POST['pat']);
	$vis=pp($_POST['vis']);
	$type=1;
	$r=getRecCon('cln_x_visits'," id='$vis' and patient='$pat' and doctor='$thisUser'");
	if($r['r']){
		$visStatus=$r['status'];
		if($visStatus==1 || _set_whx91aq4mx){
			$date=pp($_POST['date'],'s');		
			$ch2=1;	
			list($sex,$birth)=get_val('gnr_m_patients','sex,birth_date',$pat);	
			$birthCount=birthCount($birth);
			$depart=getVitalDepart($type);
			$seDate=$now;
			if($date){$seDate=convDate2Strep($date);}
			if(!$id){			
				$res=mysql_q("INSERT INTO cln_x_vital (`date`,`patient`,`doc`,`depart`,`depart_type`)values('$seDate','$pat','$thisUser','$depart','$type')");
				$id=last_id();			
			}else{
				if($date){
					$seDate=convDate2Strep($date);						
					$res2=mysql_q("UPDATE cln_x_vital SET `date` = '$seDate' where id='$id' ");
				}
				mysql_q("delete from cln_x_vital_items where session_id='$id'");		
				$ch2=getTotal('cln_x_vital','id',$id);
				$seDate=get_val('cln_x_vital','date',$id);
			}
			if($ch2){
				$sql="select * from cln_m_vital where act=1 order by ord";
				$res=mysql_q($sql);
				while($r=mysql_f($res)){
					$v_id=$r['id'];
					$v_type=$r['type'];
					if(isset($_POST['vs_'.$v_id])){
						$value=pp($_POST['vs_'.$v_id],'s');
						if($value){
							$vital_normaVal=vitalNormaVal($v_id,$sex,$birth);
							$normal_val='';
							if($vital_normaVal[0]!=0){
								list($normal_val,$add_value)=get_val('cln_m_vital_normal','value,add_value',$vital_normaVal[0]);	
							}
							$sql2="INSERT INTO cln_x_vital_items (`session_id`,`patient`,`vital`,`v_type`,`value`,`normal_val`,`add_value`,`depart`,`depart_type`,`date`)values
							('$id','$pat','$v_id','$v_type','$value','$normal_val','$add_value','$depart','$type','$seDate')";
							$res2=mysql_q($sql2);
						}
					}
				}
				if(getTotalCO('cln_x_vital_items'," session_id='$id'")==0){
					mysql_q("delete from cln_x_vital where id='$id'");	
				}
				echo $id;
			}else{
				exit; out();
			}
		}
	}
}?>
