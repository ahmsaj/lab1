<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['id_spare'])){
	$id=pp($_POST['id']);
	$id_spare=pp($_POST['id_spare']);
	list($oldSamplDate,$p,$fast,$visit_id)=get_val('lab_x_visits_samlpes','take_date,patient,fast,visit_id',$id);
	$no=pp($_POST['no']);
	$taker=pp($_POST['cof_0enuor5p1i']);
	$sample=pp($_POST['cof_flv0yzwyja']);	
	if(getTotalCO('lab_x_visits_samlpes'," no='$no' and id!='$id_spare'")==0){
		if($id_spare){
			if(mysql_q("UPDATE lab_x_visits_samlpes set no='$no' , s_taker='$taker' , `pkg_id`='$sample'  where id='$id_spare'")){echo 1;}else{echo 0;}
		}else{		
			if(mysql_q("INSERT INTO lab_x_visits_samlpes (`no`,`s_taker`,`pkg_id`,`status`,`user`,`date`,`take_date`,`patient`,`fast`,`visit_id`,`per_s`) 
			values('$no','$taker','$sample','1','$thisUser','$now','$oldSamplDate','$p','$fast','$visit_id','$id')")){
				$n_id=last_id();
				if(mysql_q("UPDATE lab_x_visits_samlpes set sub_s='$n_id' where id='$id' ")){echo 1;}else{echo 0;}
			}		
		}	
	}else{echo 0;}
}?>
