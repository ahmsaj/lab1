<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'],$_POST['cof_252idghz1q'],$_POST['cof_eoel8yrbpz'])){
	$vis_id=pp($_POST['vis']);	
	$srv=pp($_POST['cof_252idghz1q']);
	$sample=pp($_POST['cof_eoel8yrbpz']);
	$sql="select * from lab_m_services where id='$srv' and act=1 ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$s_id=$r['id'];
		$name=$r['name_'.$lg];
		$unit=$r['unit'];
		$s_type=$r['type'];
		$s_cat=$r['cat'];					
		$unit_price=_set_x6kmh3k9mh;
		$pay_net=$unit_price*$unit;
		$total_pay=$unit_price*$unit;			

		$code=getRandString(32,3);
		list($visDate,$p)=get_val('lab_x_visits','d_start,patient',$vis_id);
		$sql="INSERT INTO lab_x_visits_services (`visit_id`,`service`,`units`,`units_price`,`pay_net`,`sample`,`fast`,`status`,`type`,`srv_cat`,`patient`,`total_pay`,`code`,`d_start`)						values('$vis_id','$s_id','$unit','$unit_price','$pay_net','$sample',0,0,'$s_type','$s_cat','$p','$total_pay','$code','$visDate')";
		if(mysql_q($sql)){
			mysql_q("UPDATE lab_x_visits SET status=1 where id='$vis_id'");
			if(getTotalCO('gnr_x_roles',"mood=2 and vis='$vis_id'")){
				mysql_q("UPDATE gnr_x_roles SET status=0 where mood=2 and vis='$vis_id'");
			}else{
				addRoles($vis_id,2);
			}
			echo 1;
		}
	}else{echo '0';}
	
}?>