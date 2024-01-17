<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['vals'])){
	$id=pp($_POST['id']);
	$vals=pp($_POST['vals'],'s');
	if($vals){
		$sql="select * from osc_x_report where vis='$id' and id in($vals) 
		ORDER BY FIELD(id,$vals)";
		$res=mysql_q($sql);
		$i=1;
		while($r=mysql_f($res)){
			$s_id=$r['id'];			
			mysql_q("UPDATE osc_x_report set ord='$i' where id='$s_id' ");
			$i++;
		}
		echo 1;
	}
}?>