<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] ,$_POST['t'])){
	$id=pp($_POST['id']);
	$type=pp($_POST['t']);
	$clinic=0;
	if(!in_array($type,[2,4,6])){
		$clinic=get_val($srvTables[$type],'clinic',$id);
	}
	mysql_q("delete from gnr_m_insurance_prices where service='$id' and type='$type' ");
	$sql="select * from gnr_m_insurance_prov order by name_$lg ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$insur=$r['id'];			
			if(isset($_POST['p_'.$insur])){
				$price=pp($_POST['p_'.$insur]);
				if($price){
					mysql_q("INSERT INTO gnr_m_insurance_prices (`insur`,`type`,`cat`,`service`,`price`)
					values('$insur','$type','$clinic','$id','$price')");
				}
			}
		}
	}
	
}?>