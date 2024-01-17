<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'],$_POST['id'],$_POST['data'])){
	$id=pp($_POST['id']);
	$vis=pp($_POST['vis']);
	$data=$_POST['data'];
	list($doc,$status)=get_val('bty_x_laser_visits','doctor,status',$vis);
	if($doc==$thisUser && $status==1){
		$r=getRecCon('bty_x_laser_visits_services_vals',"id='$id' and status=0");
		if($r['r']){
			$serv_x=$r['serv_x'];
			$v_fluence=pp($data['flun'],'f');
			$v_pulse=pp($data['pulse'],'f');
			$v_rep_rate=pp($data['rate'],'f');
			$v_wave=pp($data['wave'],'f');
			$counter=pp($data['counter']);	
			if($v_fluence!='' && $v_pulse!='' && $v_rep_rate!='' && $v_wave!='' && $counter){			
				if(mysql_q("UPDATE bty_x_laser_visits_services_vals SET v_fluence='$v_fluence' , v_pulse='$v_pulse' , v_rep_rate='$v_rep_rate' , v_wave='$v_wave' ,counter='$counter' , date='$now' , status=1 where id='$id' and status=0 ")){					
					checkLsrSrvEnd($serv_x);
					echo 1;
				}
			}
		}
	}
}?>