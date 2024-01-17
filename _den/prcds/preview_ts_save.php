<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['n'],$_POST['t'],$_POST['p'],$_POST['v'],$_POST['c'],$_POST['vis'])){
	$n=pp($_POST['n']);
	$t=pp($_POST['t']);
	$p=pp($_POST['p']);
	$v=pp($_POST['v']);
	$c=pp($_POST['c'])-1;
	$cavN=getCavNo($n,$c);
	$vis=pp($_POST['vis']);
	$ch=getTotalCO('den_m_teeth',"no='$n'");
	if($ch && (($t==1 && $p<8) || ($t==2 && $p<13)) ){
		list($status,$doctor,$patient)=get_val('den_x_visits','status,doctor,patient',$vis);
		if($stats==0){
			$q='';
			$type=1;
			if($p){$type=2;}
			if($t==1){$ch=getTotalCO('den_m_set_teeth'," opr_type='$type' and id='$v' ");}
			if($t==2){$ch=getTotalCO('den_m_set_roots'," opr_type='$type' and id='$v' ");}
			if($ch){
				$ss=0;
				if($type==2){$q="and (opr_type=1 or (opr_type=2 and teeth_part_sub='$p' ))"; }
				mysql_q("UPDATE den_x_opr_teeth SET `last_opr`=0 where `patient`='$patient' and `teeth_no`='$n' and teeth_part=$t $q ");
				$sql="INSERT INTO den_x_opr_teeth (visit,doctor,patient,teeth_no,teeth_part,opr_type,opr,teeth_part_sub,date,last_opr,cav_no)
				values('$vis','$doctor','$patient','$n','$t','$type','$v','$p','$now',1,'$cavN')";
				if(mysql_q($sql)){
					$nId=last_id();
					if($t==1){if(getTotalCO('den_m_set_teeth_sub',"status_id='$v' ")){$ss=$nId;}}
					echo '1,'.$ss.','.$t.','.$v;
				}			
			}
		}
	}
}?>