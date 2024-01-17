<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['s'])&& isset($_POST['mod'])){
	$id=pp($_POST['id']);
	$s=pp($_POST['s']);
	$mod=pp($_POST['mod']);
	$clinic=$userSubType;
	$table=$visXTables[$mod];	
	if($mod==2){$clinic=getDoc_Clinic();}
	$sql="select * from gnr_x_roles where status < 2 and id ='$id' and clic in($clinic) limit 1";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$r_id=$r['id'];
		$status=$r['status'];
		$clinic=$r['clic'];
		$vis=$r['vis'];
		if($r_id==$id){
			if($status==0){mysql_q("UPDATE gnr_x_roles SET status=1 where id ='$id' ");}		
			if($status==1){
				if($s==2){
					mysql_q("UPDATE gnr_x_roles SET status=2 where id ='$id' ");
					mysql_q("UPDATE $table SET d_check='$now' where id ='$vis' ");
					if($mod!=2 ){
						mysql_q("INSERT INTO gnr_x_visits_timer (`visit_id`,`s_time`,`e_time`,`user`,`mood`)
						values('$vis','$now','$now','$thisUser','$mod')");
						$vid_dts=get_val($table,'dts_id',$vis);
						if($vid_dts>0){
                            mysql_q("UPDATE dts_x_dates SET status='3' , d_start_r='$now' where id ='$vid_dts' ");
                            datesTempUp($vid_dts);
                        }
					}
					echo $vis;
				}
				if($s==3){mysql_q("UPDATE gnr_x_roles SET status=3 where id ='$id' ");}
			}
		}
	}else{
		$sql="select * from $table where status = 1 and id ='$id'  and clinic in ($clinic) limit 1";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$clinic=$r['clinic'];
			mysql_q("UPDATE  $table SET d_check='$now' where id ='$id' ");
			if($mod==1 || $mod==3){
				$r=getRecCon('gnr_x_visits_timer',"visit_id='$id' and mood='$mod'");
				if($r['r']==0){
					mysql_q("INSERT INTO gnr_x_visits_timer (`visit_id`,`s_time`,`e_time`,`user`,`mood`)
					values('$id','$now','$now','$thisUser','$mod')");
				}
			}
			if(in_array($thisGrp,array('7htoys03le','nlh8spit9q','9yjlzayzp','66hd2fomwt','1ceddvqi3g'))){echo $id;}
		}		
	}
}