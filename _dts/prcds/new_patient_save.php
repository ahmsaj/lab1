<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['d'] , $_POST['p'] , $_POST['t'])){	
	$d=pp($_POST['d']);
	$p=pp($_POST['p']);
	$t=pp($_POST['t']);
	$r=getRec('dts_x_dates',$d);
	if($r['r']){
		$q='';
		$clinic=$r['clinic'];		
		$mood=$r['type'];
		$patient=$r['patient'];
		$dts_date=$r['d_start'];
		if($clinic==0){
			$clinic=get_val('_users','subgrp',$r['doctor']);
			$q=" , clinic='$clinic' ";
		}
		if(mysql_q("UPDATE dts_x_dates SET patient='$p', p_type='$t' , status=1 $q where id='$d' and status in (0,1)")){
			if(!$patient){logOpr($d,1,'igilkzgy0k');}
			$out=1;
			if($t==1){
				$table=$visXTables[$mood];
				$date=get_val_con($table,'d_start'," patient='$p' and clinic='$clinic' and status=2 ",' order by d_start DESC');
				if($date){
					$time=$dts_date-$date;
					if($time<(8*86400)){
						$out=2;
					}
				}
			}
			echo $out;
		}        
        datesTempUp($d);
	}
}?>