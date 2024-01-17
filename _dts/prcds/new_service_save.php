<? include("../../__sys/prcds/ajax_header.php");
if( isset($_POST['c'] , $_POST['d'] , $_POST['p'])){
	$c=pp($_POST['c']);
	$d=pp($_POST['d']);
	$p=pp($_POST['p']);
	$p_type=0;
	$doctor=0;
	if($p!=0){
		$pat_ch=getTotalCO('gnr_m_patients'," id='$p'");
		if($pat_ch && in_array($thisGrp,array('7htoys03le','fk590v9lvl','9yjlzayzp','66hd2fomwt','fk590v9lvl','9k0a1zy2ww'))){
			$p_type=1;
			$doctor=$thisUser;
		}else{
			out();exit;
		}
	}
	$c_type=0;
	if($_POST['teethTime']){
		$doctor=0;
		$c=get_val('_users','subgrp',$doctor);
		$c=0;
		$c_type=4;
	}else{
		$cc=getTotalCO('gnr_m_clinics'," id='$c'");
		if($cc){
			$c_type=get_val('gnr_m_clinics','type',$c);
		}
	}
	$m_clinic=getMClinic($c);
	if($c_type){		
		if($d==0){			
			$sql="INSERT INTO dts_x_dates(`clinic`,`date`,`reg_user`,`patient`,`p_type`,`doctor`,`type`)
			values ('$c','$now','$thisUser','$p','$p_type','$doctor','$c_type')";
			mysql_q($sql);
			$dts_id=last_id();
		}else{
			$dts_id=$d;			
			mysql_q("DELETE from dts_x_dates_services where dts_id='$dts_id'");
            datesTempUp($dts_id);
		}
		echo $dts_id;
		
		if($c_type==4){
			$teethTime=pp($_POST['teethTime']);
			mysql_q("INSERT INTO dts_x_dates_services (`dts_id`, `service`,`ser_time` ) values ('$dts_id','1','$teethTime')");
			
		}else{
			if($c_type==1){
				$sql="select * from cln_m_services where clinic='$m_clinic' and act=1 ";
				$res=mysql_q($sql);
				$rows=mysql_n($res);		
				if($rows>0){
					while($r=mysql_f($res)){
						$s_id=$r['id'];
						$ser_time=$r['ser_time']*_set_pn68gsh6dj;
						if(isset($_POST['ser_'.$s_id])){								
							mysql_q("INSERT INTO dts_x_dates_services (`dts_id`, `service` ,`ser_time`) values ('$dts_id','$s_id','$ser_time')");
						}
					}
				}
			}
			if($c_type==3){
				$sql="select * from xry_m_services where clinic='$m_clinic' and act=1 ";
				$res=mysql_q($sql);
				$rows=mysql_n($res);		
				if($rows>0){
					while($r=mysql_f($res)){
						$s_id=$r['id'];
						$ser_time=$r['ser_time']*_set_pn68gsh6dj;
						if(isset($_POST['ser_'.$s_id])){								
							mysql_q("INSERT INTO dts_x_dates_services (`dts_id`, `service` ,`ser_time`) values ('$dts_id','$s_id','$ser_time')");	
						}
					}
				}
			}
			if($c_type==5 || $c_type==6){
				$sql="select * from bty_m_services where cat IN(select id from bty_m_services_cat where clinic='$m_clinic') and act=1 ";
				$res=mysql_q($sql);
				$rows=mysql_n($res);		
				if($rows>0){
					while($r=mysql_f($res)){
						$s_id=$r['id'];
						$ser_time=$r['ser_time']*_set_pn68gsh6dj;
						if(isset($_POST['ser_'.$s_id])){								
							mysql_q("INSERT INTO dts_x_dates_services (`dts_id`, `service` ,`ser_time`) values ('$dts_id','$s_id','$ser_time')");	
						}
					}
				}
			}
			if($c_type==7){
				$sql="select * from osc_m_services where clinic='$m_clinic' and act=1 ";
				$res=mysql_q($sql);
				$rows=mysql_n($res);		
				if($rows>0){
					while($r=mysql_f($res)){
						$s_id=$r['id'];
						$ser_time=$r['ser_time']*_set_pn68gsh6dj;
						if(isset($_POST['ser_'.$s_id])){								
							mysql_q("INSERT INTO dts_x_dates_services (`dts_id`, `service` ,`ser_time`) values ('$dts_id','$s_id','$ser_time')");	
						}
					}
				}
			}
		}
	}else{echo '0';}
}?>