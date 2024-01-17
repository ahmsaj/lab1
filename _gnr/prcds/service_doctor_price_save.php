<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] ,$_POST['t'])){
	$id=pp($_POST['id']);
	$mood=pp($_POST['t']);
	$selClnc=[];
	if(!in_array($mood,[4,5])){
		$clinic=get_val($srvTables[$mood],'clinic',$id);
	}
	$selClnc=getAllLikedClinics($clinic,',');
	if($mood==1){$q=" grp_code = '7htoys03le' and subgrp IN($selClnc) ";	}
	if($mood==3){$q=" grp_code = 'nlh8spit9q' ";}
	if($mood==4){$q=" grp_code = 'fk590v9lvl' ";}
	if($mood==5){$q=" grp_code = '9yjlzayzp' ";}
	if($mood==7){$q=" grp_code = '9k0a1zy2ww' ";}	
	
	mysql_q("delete from gnr_m_services_prices where service='$id' and mood='$mood' ");	
	$sql="select * from _users where  $q ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$u_id=$r['id'];			
			if(isset($_POST['v1_'.$u_id])){
				$v1=pp($_POST['v1_'.$u_id]);
				$v2=pp($_POST['v2_'.$u_id]);
				$v3=pp($_POST['v3_'.$u_id],'f');
				if($v1 || $v2 || $v3){
					$sql3="INSERT INTO gnr_m_services_prices (`mood`,`service`,`doctor`,`hos_part`,`doc_part`,`doc_percent`)
					values('$mood','$id','$u_id','$v1','$v2','$v3')";
					mysql_q($sql3);
				}
			}
		}
	}
}?>