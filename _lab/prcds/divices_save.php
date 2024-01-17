<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$data=array();
	$analysis=get_val('lab_m_devices','analysis',$id);	
	if($analysis){		
		$sql="select * from lab_m_services_items where serv in($analysis) order by ord ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows){
			while($r=mysql_f($res)){
				$iId=$r['id'];
				$val=$_POST['i'.$iId];
				if($val){
					array_push($data,$iId.':'.$val);
				}				
			}
		}
		$finData=implode(',',$data);
		if(mysql_q("UPDATE lab_m_devices SET data='$finData' where id='$id'")){echo 1;}
	}
}?>