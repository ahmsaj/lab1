<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['dTime'])){
	$id=pp($_POST['id']);
	$dTime=pp($_POST['dTime']);	
	$r=getRec('dts_x_dates',$id);	
	if($r['r']){
		$p=$r['patient'];
		$dts_date=$r['d_start'];
		$dts_d_end=$r['d_end'];
		$p_type=$r['p_type'];
		$clinic=$r['clinic'];
		$type=$r['type'];
		$change=0;
		if($p_type==1){
			$table=$visXTables[$type];
			$date=get_val_con($table,'d_start'," patient='$p' and clinic='$clinic'  ",' order by d_start DESC');
			if($date){
				$time=$dts_date-$date;
				if($time<(8*86400)){$change=1;}
			}		
			$min=($dts_d_end-$dts_date)/60;
			if($dTime<=$min && $min>0){
				if($dTime==$min){
					echo 1;
				}else{
                    
					$newDate=$dts_date+($dTime*60);					
					if(mysql_q("UPDATE dts_x_dates SET d_end='$newDate', sub_status=1 where id='$id' ")){
                        if($type==4){
                            mysql_q("UPDATE dts_x_dates_services SET ser_time='$dTime', sub_status=1 where dts_id='$id' ");
                        }
                        datesTempUp($id);
                        echo 1;
                    }
				}
			}			
		}
	}
}?>