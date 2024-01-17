<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$sql="select * from den_x_opr_teeth where patient='$id' and last_opr=1 ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		if(mysql_q("INSERT INTO den_x_tooth_status (`doc`,`patient`,`date`)values('$thisUser','$id','$now')")){
			$status_id=last_id();
			echo 1;
			while($r=mysql_f($res)){
				$teeth_no=$r['teeth_no'];
				$teeth_part=$r['teeth_part'];
				$teeth_part_sub=$r['teeth_part_sub'];
				$opr_type=$r['opr_type'];
				$opr=$r['opr'];
				$opr_sub=$r['opr_sub'];
				$last_opr=$r['last_opr'];
				$cav_no=$r['cav_no'];
				mysql_q("INSERT INTO den_x_tooth_status_items  (`status_id`, `teeth_no`, `teeth_part`, `teeth_part_sub`, `opr_type` ,`opr` ,`opr_sub` ,`last_opr` ,`cav_no`) values	('$status_id' ,'$teeth_no' ,'$teeth_part' ,'$teeth_part_sub' ,'$opr_type' ,'$opr' ,'$opr_sub' ,'$last_opr' ,'$cav_no')");
			}
		}
	}
}?>