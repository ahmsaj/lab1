<? include("../../__sys/mods/protected.php");?>
<? $code='cln';$tab=0;$fillter='';$chart='';$data=array();//echo $PER_ID;
$fin=1;//إظهار العلومات المالية
if($thisGrp=='o9yqmxot8'){//مجموعة التسويق
    $fin=0;
}
/**********/
$docsGrpsQ="'".implode("','",$docsGrp)."'";
if($PER_ID=='kfkumg6x79'){$page=1;
	$options='<option value="">'.k_alclincs.'</option>';
	$sql="select * from gnr_m_clinics  where type=1 order by ord ASC"; 
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$id=$r['id'];
			$name=$r['name_'.$lg];
			$options.='<option value="'.$id.'">'.$name.'</option>';                
		}
	}
	$fillter='<select>'.$options.'</select>';
 	$data[0]=[k_services,1];
}
if($PER_ID=='b9c3n3wwde'){$page=2;
	$options='<option value="0">'.k_alclincs.'</option>';
	$sql="select * from gnr_m_clinics  where type=1 order by ord ASC"; 
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$id=$r['id'];
			$name=$r['name_'.$lg];
			$options.='<option value="'.$id.'">'.$name.'</option>';                
		}
	}
	$fillter='<select>'.$options.'</select>';
	$data[0]=[k_daily_report,1];
	$data[1]=[k_monthly_report,1];
	$data[2]=[k_annual_report,1];
	$data[3]=[k_general_report,1];
	$data[4]=[k_rp_dte];
}
if($PER_ID=='aj6r6qdis' || $PER_ID=='7l253ye2cq'){$page=3;$chart=1;
	$q='type!=2';
	if($thisGrp=='im22ovq3jm'){$q=" type= $userSubType ";}
	$options='<option value="">'.k_alclincs.'</option>';
	$sql="select * from gnr_m_clinics  where $q order by name_$lg ASC"; 
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$id=$r['id'];
			$name=$r['name_'.$lg];
			$options.='<option value="'.$id.'">'.$name.'</option>';                
		}
	}
	$fillter='<select>'.$options.'</select>';
	if($thisGrp=='im22ovq3jm'){
		$filter=1;
		if(in_array($userSubType,array(2,7,5,6))){$filter=1;}
		$data[0]=[k_visits,$filter];		
		$data[2]=[k_total_section];
		$data[3]=[k_num_chart];
		if($fin){$data[4]=[k_fin_chart];}
	}else{
		$data[0]=[k_cln_date,0];
		$data[1]=[k_divisions_date];
		$data[2]=[k_divisions_total];
		$data[3]=[k_divs_num_chart];
        if($fin){$data[4]=[k_divs_fin_chart];}            
	}
}
echo setReportPage($code,$page,$tab,$fillter,$data,$chart);?>