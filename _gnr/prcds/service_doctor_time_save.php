<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] ,$_POST['t'])){
	$id=pp($_POST['id']);
	$type=pp($_POST['t']);
	if($type==1){
		$clinc=get_val('cln_m_services','clinic',$id);
		mysql_q("delete from cln_m_services_times where service='$id' ");
		$selClnc=getAllLikedClinics($clinc,',');
		$sql="select * from _users where  grp_code IN('7htoys03le','nlh8spit9q') and subgrp IN($selClnc) ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			while($r=mysql_f($res)){
				$u_id=$r['id'];			
				if(isset($_POST['d_'.$u_id])){
					$val=pp($_POST['d_'.$u_id]);
					if($val){
						mysql_q("INSERT INTO cln_m_services_times (`service`,`doctor`,`ser_time`)values('$id','$u_id','$val')");
					}
				}
			}
		}
	}
	if($type==2){		
		mysql_q("delete from den_m_services_times where service='$id' ");
		$sql="select * from _users where grp_code ='fk590v9lvl' ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			while($r=mysql_f($res)){
				$u_id=$r['id'];			
				if(isset($_POST['d_'.$u_id])){
					$val=pp($_POST['d_'.$u_id]);
					if($val){
						mysql_q("INSERT INTO den_m_services_times (`service`,`doctor`,`ser_time`)values('$id','$u_id','$val')");
					}
				}
			}
		}
	}
}?>