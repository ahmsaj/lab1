<? include("../../__sys/mods/protected.php");?>
<? $code='bty';$tab=0;$fillter='';$chart='';$data=array();//echo $PER_ID;
$fin=1;//إظهار العلومات المالية
if($thisGrp=='o9yqmxot8'){//مجموعة التسويق
    $fin=0;
}
/**********/
$docsGrpsQ="'".implode("','",$docsGrp)."'";
$btyFilter='';
$options='<option value="0">كافة العيادات</option>';
if($PER_ID=='f7dktu22g5'){
    $sql="select * from gnr_m_clinics where type in(5) and linked=0 order by name_$lg ";
}else{
    $sql="select * from gnr_m_clinics where type in(5) order by name_$lg ";
}
if($PER_ID=='dukyy69x3h'){
    $sql="select * from gnr_m_clinics where type in(6) order by name_$lg ";
}
$res=mysql_q($sql);
$rows=mysql_n($res);
if($rows>0){
    while($r=mysql_f($res)){
        $id=$r['id'];
        $name=$r['name_'.$lg];
        $options.='<option value="'.$id.'">'.$name.'</option>';
    }
}
$btyFilter='<select>'.$options.'</select>';
/**************/
if($PER_ID=='tcu2ouaj6w'){$page=1;
    $fillter=$btyFilter;	
    $data[0]=[k_daily,1];
	$data[1]=[k_monthly,1];
	$data[2]=[k_b_date,1];
}
if($PER_ID=='dukyy69x3h'){$page=2;
    $fillter=$btyFilter;
    $data[0]=[k_daily,1];
	$data[1]=[k_monthly,1];
	$data[2]=[k_b_date,1];
}
if($PER_ID=='t4cg7xr59'){$page=3;
    $options='<option value="0">كافة العيادات</option>';
    $sql="select * from gnr_m_clinics where type in(5) order by name_$lg ";
    $res=mysql_q($sql);
    $rows=mysql_n($res);
    if($rows>0){
        while($r=mysql_f($res)){
            $id=$r['id'];
            $name=$r['name_'.$lg];
            $options.='<option value="'.$id.'">'.$name.'</option>';
        }
    }
    $fillter='<select>'.$options.'</select>';;
    $data[0]=[k_dly_drs_perf,1];
	$data[1]=[k_mnthly_drs_perf,1];
	$data[2]=[k_drs_perf_by_dat,1];
}
if($PER_ID=='f7dktu22g5'){$page=4;
    $fillter=$btyFilter;
    $data[0]=[k_daily,1];
	$data[1]=[k_monthly,1];
	$data[2]=[k_b_date,1];
}

echo setReportPage($code,$page,$tab,$fillter,$data,$chart);