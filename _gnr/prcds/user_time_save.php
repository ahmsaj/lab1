<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);	
	$days='';
	$fd=0;
	for($i=0;$i<7;$i++){		
		if(isset($_POST['week'.$weekMod[$i]])){
			if($fd==1){$days.=',';}
			$fd=1;
			$days.=$weekMod[$i];
		}
	}
	$duration=pp($_POST['duration'],'s');
	$type=pp($_POST['type']);
	if($type==1){
		$sheft_s1=pp($_POST['sheft_s1'],'s');
		$sheft_e1=pp($_POST['sheft_e1'],'s');
		$sheft_s2=pp($_POST['sheft_s2'],'s');
		$sheft_e2=pp($_POST['sheft_e2'],'s');
		$data=$sheft_s1.','.$sheft_e1.','.$sheft_s2.','.$sheft_e2;
	}
	if($type==2){
		$data='';
		$f=0;
		for($i=0;$i<7;$i++){		
			if(isset($_POST['week'.$weekMod[$i]])){
				$v=$weekMod[$i];
				if($f==1){$data.='|';}
				$sheft_s1=pp($_POST['sheft_s1_'.$v],'s');
				$sheft_e1=pp($_POST['sheft_e1_'.$v],'s');
				$sheft_s2=pp($_POST['sheft_s2_'.$v],'s');
				$sheft_e2=pp($_POST['sheft_e2_'.$v],'s');
				$data.=$sheft_s1.','.$sheft_e1.','.$sheft_s2.','.$sheft_e2;
				$f=1;
			}
		}
	}
    $clinic=get_val('_users','subgrp',$id);
	$sql="UPDATE gnr_m_users_times set days='$days',duration='$duration',type='$type',clinic='$clinic',data ='$data' where id='$id'";
	if(mysql_q($sql)){echo 1;}
}?>