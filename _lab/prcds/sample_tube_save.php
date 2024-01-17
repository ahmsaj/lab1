<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'],$_POST['id'])){
	$id=pp($_POST['id']);
	$vis=pp($_POST['vis']);
	$ch=getTotalCO('lab_m_samples_packages',"id='$id'");
	$r=getRec('lab_x_visits',$vis);
	if($r['r'] && $ch){
		$status=$r['status'];
		$pat=$r['patient'];
		if($status==1){
			if(mysql_q("INSERT INTO lab_x_visits_samlpes (`visit_id`,`pkg_id`,`services`,`user`,`date`,`patient`,`fast`,`take_date`,`full_tube`)values('$vis','$id','','$thisUser','$now','$pat','0','$now','0')")){
				$tube=last_id();
				echo 1;
				if(_set_khbw5sn3qs){
					samAutoNum($tube);
				}
			}			
		}		
	}
}?>