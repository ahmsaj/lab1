<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['p'])){
	$id=pp($_POST['id']);
	$p=pp($_POST['p']);
	$sql="select * from dts_x_dates  where id='$id' and (p_type=2 OR other=1) limit 1";
	$res=mysql_q($sql);
	if(mysql_n($res)>0){
		$r=mysql_f($res);
        $oldPat=$r['patient'];
        $other=$r['other'];
        $app=$r['app'];
        $checkNewPat=getTotalCO('gnr_m_patients',"id=$p");
        if($checkNewPat){
            $t=2;            
            if($other){
               $t=1;               
            }            
            if(mysql_q("UPDATE dts_x_dates SET patient='$p' , p_type=1 where patient='$oldPat' and  p_type=$t ")){
                datesTempUp($id);
                mysql_q("UPDATE dts_x_patients_black_list SET patient='$p' , pat_type=1 where patient='$oldPat' and pat_type=$t ");
                if($other==0){
                    if($app){
                        $token=get_val('dts_x_patients','token',$oldPat);
                        if($token){
                            mysql_q("UPDATE gnr_m_patients SET token='$token' where id='$p' and token='' ");
                        }
                    }
                    mysql_q("DELETE from dts_x_patients where id='$oldPat' limit 1");
                }
                echo 1 ;			
            }
        }
       
	}	
}?>