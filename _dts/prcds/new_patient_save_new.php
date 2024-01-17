<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['d'] , $_POST['p'] , $_POST['t'])){	
	$id=pp($_POST['d']);
	$p=pp($_POST['p']);
	$t=pp($_POST['t']);
	$r=getRec('dts_x_dates',$id);
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
        $q=" and status=0 ";
        if($t==3){
            $t=1;
            $q=" and status=1 ";
        }        
		if(mysql_q("UPDATE dts_x_dates SET patient='$p', p_type='$t'  where id='$id' $q")){
			editTempOpr($mood,$id,9,2); 
            datesTempUp($id);
            echo 1;
            
		}
	}
}?>