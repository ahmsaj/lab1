<? session_start();
$PBL='../../';
$lg='ar';
include($PBL."__sys/dbc.php");
include($PBL."__sys/f_funs.php");

include($PBL."__sys/cssSet.php");	
include($PBL."__main/lang/lang_k_$lg.php");
include($PBL."__sys/lang/lang_k_$lg.php");
include($PBL."__sys/funs.php");
include($PBL."__sys/funs_co.php");
include($PBL."__main/funs.php");
include($PBL."__sys/define.php");
include($PBL."_api/funs.php");
include($PBL."_api/define.php");
include($PBL."_dts/funs.php");
include($PBL."_gnr/funs.php");
include($PBL."_lab/funs.php");
include($PBL."_gnr/define.php");
/***********************************************/
$s_date=$ss_day+86400;
$e_date=$s_date+86400;
mysql_q("delete from dts_x_dates_alerts where date<$s_date ");
$ids=get_vals("dts_x_dates_alerts",'date_id',"date>$s_date ");
$q='';
if($ids){$q=" and date_id NOT IN ($ids)";}
$sql="select * from dts_x_dates as d  where d_start>=$s_date and d_start< $e_date $q";
$res=mysql_q($sql);
$rows=mysql_n($res);
while($r=mysql_f($res)){
    $id=$r['id'];
    $date=$r['d_start'];
    $patient=$r['patient'];
    $pat_type=$r['p_type'];
    if($pat_type==1){
        $token=get_val('gnr_m_patients','token',$patient);
    }
    if($pat_type==2){
        $token=get_val('dts_x_patients','token',$patient);
    }
    if($token){
        echo '('.$id.')';
        alertPatDts($id,$patient,$pat_type,$date,2);
        mysql_q("INSERT INTO dts_x_dates_alerts (`date_id`,`date`)values('$id','$date')");
    }
}

?>