<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'],$_POST['o'],$_POST['id'])){	
	$s=1;
	$data='';
	$o=pp($_POST['o']);
	$id=pp($_POST['id']);
	$vis=pp($_POST['vis']);
	$r=getRec('lab_x_visits_samlpes',$id);
	if($r['r']){
		$status=$r['status'];
		$services=$r['services'];
		$per_s=$r['per_s'];
		$pkg_id=$r['pkg_id'];
		$pat=$r['patient'];
		if($o==1){
			$no=pp($_POST['no']);
			if($status<2 && $no){				
				if(getTotalCO('lab_x_visits_samlpes'," no='$no' and id!='$id' ")==0){
					if(mysql_q("UPDATE lab_x_visits_samlpes SET no='$no' , status=1 where id='$id'and visit_id='$vis'")){
						$data=$no;						
					}
				}else{
					$s=0;
					$data=k_num_been_entered;
				}
			}else{
				$s=0;
				$data=k_cannot_sample_num;
			}
		}	
		if($o==2){			
			if($status<2){
				$res=mysql_q("DELETE from lab_x_visits_samlpes where id='$id' and visit_id='$vis'");
				if(mysql_a()){
					if($services){				
						mysql_q("UPDATE lab_x_visits_services SET  status=0 where sample_link='$id' and visit_id='$vis' and status=5");
						mysql_q("UPDATE lab_x_visits_services SET sample_link='0' where sample_link='$id' and visit_id='$vis' ");
					}
				}
			}else{
				$s=0;
				$data=k_sample_cannot_del;
			}
		}
		if($o==3){
			if($status<2){
				if($per_s==0){
					if(mysql_q("INSERT INTO lab_x_visits_samlpes (`visit_id`,`pkg_id`,`services`,`user`,`date`,`patient`,`fast`,`take_date`,`full_tube`,`per_s`)values('$vis','$pkg_id','','$thisUser','$now','$pat','0','$now','0','$id')")){
						$tube=last_id();						
						if(_set_khbw5sn3qs){samAutoNum($tube);}					
					}
				}else{
					$s=0;
					$data=k_sample_been_created;
				}
			}else{
				$s=0;
				$data=k_sample_cannot_del;
			}
		}
	}
	echo $s.'^'.$data;
}?>