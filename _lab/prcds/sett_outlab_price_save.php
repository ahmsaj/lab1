<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	if(getTotalCO('lab_m_external_Labs'," id='$id' ")>0){
		mysql_q("DELETE from lab_m_external_Labs_price where lab='$id' ");
		$sql="select * from lab_m_services order by outlab DESC , short_name ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			while($r=mysql_f($res)){
				$a_id=$r['id'];
				if(isset($_POST['a_'.$a_id])){
					$price=pp($_POST['a_'.$a_id]);
					if($price!=''){mysql_q("INSERT INTO lab_m_external_Labs_price(`lab`,`ana`,`price`)values('$id','$a_id','$price')");}
				}
			}			
		}
	}
}?>