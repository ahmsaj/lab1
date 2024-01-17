<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'])){
	$vis=pp($_POST['vis']);	
	$clinic=$userSubType;
	if($thisGrp=='7htoys03le'){
		$clic_type=1;
		$sql="select doctor from cln_x_visits where clinic in ($clinic) AND id='$vis'";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$r=mysql_f($res);
			$doc=$r['doctor'];			
			if($doc==0){
				if(mysql_q("UPDATE cln_x_visits SET doctor='$thisUser' where id ='$vis' ")){
					mysql_q("UPDATE cln_x_visits_services SET doc='$thisUser' where visit_id='$vis'");			
				}
			}
			echo $clic_type;
		}else{
			delTempOpr($clic_type,$vis,'a');
			echo 0;
		}
	}else if($thisGrp=='1ceddvqi3g' || $thisGrp=='nlh8spit9q'){//XRY
		$clinic=$userSubType;
		$clic_type=3;
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$r=mysql_f($res);
			$doc=$r['doctor'];
			$ray_tec=$r['ray_tec'];
			if($ray_tec==0){
				mysql_q("UPDATE xry_x_visits SET ray_tec='$thisUser' where id ='$vis' ");
			}
			echo $clic_type;			
		}else{
			delTempOpr($clic_type,$vis,'a');
			echo 0;
		}	
	}else if($thisGrp=='9yjlzayzp'){//BTY
		$clinic=$userSubType;
		$clic_type=5;
		$sql="select doctor from bty_x_visits where clinic='$clinic' AND id='$vis'";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$r=mysql_f($res);
			$doc=$r['doctor'];
			if($doc==0){
				if(mysql_q("UPDATE bty_x_visits SET doctor='$thisUser' where id ='$vis' ")){
				   mysql_q("UPDATE bty_x_visits_services SET doc='$thisUser' where visit_id='$vis'");
				echo $clic_type;}
			}else{ 
				echo $clic_type;
			}
		}else{
			delTempOpr($clic_type,$vis,'a');
			echo 0;
		}
	}else if($thisGrp=='66hd2fomwt'){//BTY Laser
		$clinic=$userSubType;
		$clic_type=6;
		$sql="select doctor from bty_x_laser_visits where clinic='$clinic' AND id='$vis'";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$r=mysql_f($res);
			$doc=$r['doctor'];
			if($doc==0){
				if(mysql_q("UPDATE bty_x_laser_visits SET doctor='$thisUser' where id ='$vis' ")){
				   mysql_q("UPDATE bty_x_laser_visits_services SET doc='$thisUser' where visit_id='$vis'");
				}
			}
			echo $clic_type;
			
		}else{
			delTempOpr($clic_type,$vis,'a');
			echo 0;
		}
	}else if($thisGrp=='9k0a1zy2ww'){//OSC
		$clic_type=7;
		$sql="select doctor from osc_x_visits where clinic ='$clinic' AND id='$vis'";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$r=mysql_f($res);
			$doc=$r['doctor'];		
			if($doc==0){
				if(mysql_q("UPDATE osc_x_visits SET doctor='$thisUser' where id ='$vis' ")){
					mysql_q("UPDATE osc_x_visits_services SET doc='$thisUser' where visit_id='$vis'");
				}
			}
			echo $clic_type;
		}else{
			delTempOpr($clic_type,$vis,'a');
			echo 0;
		}
	}else{echo 0;}
}?>