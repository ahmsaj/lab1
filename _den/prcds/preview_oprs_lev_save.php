<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['des'],$_POST['lev'])){	
	$des=pp($_POST['des'],'s');
	$lev=pp($_POST['lev']);
	//$visit_id=$_SESSION['denVis'];
	$r=getRec('den_x_visits_services_levels',$lev);
	if($r['r']){
		$patient=$r['patient'];
		$service=$r['service'];
		$doc=$r['doc'];
		$vis=$r['vis'];
		$x_srv=$r['x_srv'];		
		$lev_id=$r['lev'];
		$price=$r['price'];
		$doc_percent=get_val('den_x_visits_services','doc_percent',$x_srv);		
		$doc_part=$price*$doc_percent/100;
		if($doc==$thisUser || $doc==0){
			$ok=1;
			if(getTotalCO('den_m_services_levels_text',"id='$des' ")){
				mysql_q("INSERT INTO den_x_visits_services_levels_w (`x_srv`,`lev`,`x_lev`,`val`,`date`,`vis`,`patient`,`srv`) VALUES ('$x_srv','$lev_id','$lev','$des','$now','$vis','$patient','$service')");
			}else{
				$ok='';
			}
			echo $ok;			
		}
	}
}?>