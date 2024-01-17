<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] ,$_POST['vis'])){
	$id=pp($_POST['id']);
	$vis=pp($_POST['vis']);
	$x_clinic=pp($_POST['c']);
    $dia=pp($_POST['dia'],'s');
	if(getTotalCO('gnr_m_clinics',"id='$x_clinic' and type=3 ")==0){exit;}
	
    $visTable='cln_x_visits';
    if($PER_ID=='1egd0ntqt4'){$visTable='den_x_visits';}
    $p=get_val($visTable,'patient',$vis);
    
	if($id==0){
		$sql="INSERT INTO xry_x_visits_requested(`visit_id`,`patient`,`date`,`doc`,`x_clinic`,`diagnosis`)values ('$vis','$p','$now','$thisUser','$x_clinic','$dia')";
		if(mysql_q($sql)){$id=last_id();}
	}else{
		if(get_val('xry_x_visits_requested','satatus',$id)<2){
			mysql_q("DELETE from xry_x_visits_requested_items where r_id='$id' ");
			mysql_q("UPDATE xry_x_visits_requested set status=0 , diagnosis='$dia' where id='$id' ");			
		}else{
			echo 0; exit;
		}
	}
	/****************************/
	if($id){
		$sql="select id,act from xry_m_services ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){			
			while($r=mysql_f($res)){
				$s_id=$r['id'];
				$act=$r['act'];
				if(isset($_POST['s_'.$s_id])){					
					mysql_q("INSERT INTO xry_x_visits_requested_items (`r_id`,`xphoto`,`act`,`action`)values('$id','$s_id','$act','$act')");
				}
			}
			echo $id;
		}else{echo '0';}		
	}
}?>