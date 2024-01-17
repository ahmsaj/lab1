<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['grp_id'] , $_POST['grp_name'])){
	$id=pp($_POST['grp_id']);
	$name=pp($_POST['grp_name'],'s');	
	if($id==0){
		if($name){
			if(mysql_q("INSERT INTO lab_x_visits_samlpes_group (`name`,`date`)values('$name','$now')")){
				$id=last_id();
			}
		}else{exit;}
	}
	if($id){		
		if(getTotalCO('lab_x_visits_samlpes_group'," id ='$id'")){
			if($_POST['rec']){
				$ids=implode(',',$_POST['rec']);
				//echo "UPDATE lab_x_visits_samlpes set grp='$id' where id IN($ids) and grp=0 ";
				if(mysql_q("UPDATE lab_x_visits_samlpes set grp='$id' where id IN($ids) and grp=0 ")){echo $id;}
			}
		}
	}
}?>