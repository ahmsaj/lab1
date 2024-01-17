<? include("../../__sys/mods/protected.php");?>
<? $code='lab';$tab=0;$fillter='';$chart='';$data=array();//echo $PER_ID;
/**********/
if($PER_ID=='ezgwv9isc4'){$page=1;	
	$data[0]=[k_dly_lb];
	$data[1]=[k_mth_lb,1];
	$data[2]=[k_lb_date];
	$data[3]=[k_monthly_report];
	$data[4]=[k_test_mnth_tot];
	$data[5]=[k_tot_test_date];
	$data[6]=[k_recev_date];
}
if($PER_ID=='89z1c7yfug'){$page=2;
	$data[0]=[k_daily_report];
}
if($PER_ID=='c4cx1re6h4'){$page=3;
	$fillter='<select>
		<option value="0">'.k_choose_ana_status.'</div>
		<option value="1">'.k_finished.'</div>
		<option value="2">'.k_cncled.'</div>
		<option value="5">'.k_sample_selected.'</div>
		<option value="6">'.k_incomplete_report_entered.'</div>
		<option value="7">'.k_full_rep_entered.'</div>
		<option value="8">'.k_report_accepted.'</div>
		<option value="9">'.k_report_rejected.'</div>
	</select>';
	$data[0]=[k_dly_lb,1];
}
if($PER_ID=='4l1nmj8660'){$page=4;
	$options='';
	$options='<option value="0"></option>';
	$sql="select * from lab_m_external_labs where act=1 order by name_$lg asc";
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
    $data[2]=[k_rp_dte,1];
    $data[3]=[k_tot_mnthly,0];
    $data[4]=[k_tot_bdate,0];
    $data[5]=[k_test_mnth_tot,1];
    $data[6]=[k_tot_test_date,1];
    $data[7]=[k_test_mnth_tot.'-'.k_hosp,1];
    $data[8]=[k_tot_test_date.'-'.k_hosp,1];
    $data[9]=[k_test_mnth_tot.'-'.k_hosp,1];
    $data[10]=[k_tot_test_date.'-'.k_hosp,1];
    
}
/**********/
echo setReportPage($code,$page,$tab,$fillter,$data,$chart);?>