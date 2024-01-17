<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['g'],$_POST['id'],$_POST['o'])){
	$g=pp($_POST['g']);
	$id=pp($_POST['id']);
	$o=pp($_POST['o']);	
	$r=getRec('lab_x_work_table',$g);
	if($r['r']){
		$status=$r['status'];
		if($status<2){
			if($o==0){
				if(mysql_q("UPDATE lab_x_visits_services SET w_table='0' where w_table='$g' and status in(5) and service='$id' ")){echo 1;}
				fixWTSrvs($g);
			}else{
				if($o==1 || $o==2){
					$s='0';
					if($o==2){$s='-1';}
					if(mysql_q("UPDATE lab_x_visits_services SET w_table='$s' where w_table='$g' and status in(5) and id='$id' ")){echo 1;}
					
				}elseif($o==3){
					if(mysql_q("UPDATE lab_x_work_table SET status=2 where id='$g' and status=1 ")){echo 1;}
				}
			}
		}
		
	}
}?>