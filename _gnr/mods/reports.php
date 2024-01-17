<? include("../../__sys/mods/protected.php");?>
<? $code='gnr';$tab=0;$fillter='';$chart='';$data=array();//echo $PER_ID;
$fin=1;//إظهار العلومات المالية
$autpLoad=1;
if($thisGrp=='o9yqmxot8'){//مجموعة التسويق
    $fin=0;
}

/**********/
$docsGrpsQ="'".implode("','",$docsGrp)."'";
if($PER_ID=='qxtt095qiz'){$page=1;$tab=1;	
	$options='<option value="0">جميع الأقسام</option>';
	/*$sql="select * from _users where `grp_code` IN($docsGrpsQ) order by name_$lg ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$id=$r['id'];
			$name=$r['name_'.$lg];
			$options.='<option value="'.$id.'">'.$name.'</option>';
		}
	}*/
	foreach($clinicTypes as $k=> $val){
		if($val && $k!=2 && $k!=6){
			$options.='<option value="'.$k.'">'.$val.'</option>';
		}		
	}
	$fillter='<select>'.$options.'</select>';
    $data[1]=[k_daily_report,1];
	$data[2]=[k_monthly_report,1];
	$data[3]=[k_b_date,1];
}
if($PER_ID=='pjbdi5p0fe'){$page=2;
	$options='<option value="0">'.k_alboxs.'</option>';
	$sql="select * from _users where `grp_code` IN('buvw7qvpwq','pfx33zco65') order by name_$lg ";
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
	if($thisGrp=='tmbx9qnjx4' || $thisGrp=='hrwgtql5wk'){
		$data[0]=[k_dly_clf,0];
		$data[11]=[k_clf_date,0];
		$data[1]=[k_daily_report,1];
		$data[2]=[k_monthly_report,1];
		$data[3]=[k_annual_report,1];
		$data[4]=[k_general_report,0];
		$data[5]=[k_fnd_date,1];
		$data[111]=[k_lab_day,1];
	}else{ $tab=1;
		$data[1]=[k_daily_report,0];
		$data[2]=[k_monthly_report,0];
	}	
}
if($PER_ID=='9p0ybo92ru'){$page=3;$tab=1;
	$options='
	<option value="0">'.k_all_deps.'</option>
	<option value="1">'.k_clinics.'</option>
	<option value="2">'.k_thlab.'</option>
	<option value="3">'.k_txry.'</option>
	<option value="33">'.k_endoscopy.'</option>
	<option value="4">'.k_thdental.'</option>
	<option value="5">'.k_tbty.'</option>
	<option value="6">'.k_tlaser.'</option>';
	$fillter='<select>'.$options.'</select>';
    $data[1]=[k_daily_report,1];
}
if($PER_ID=='zywtpwqxkk'){$page=4;
	if($thisGrp!='7htoys03le' && $thisGrp!='nlh8spit9q'){
		$options='<option value="0">'.k_aldrs.'</option>';
        $sql="select * from _users where `grp_code` IN('7htoys03le','nlh8spit9q','fk590v9lvl','9yjlzayzp','66hd2fomwt','1ceddvqi3g','9k0a1zy2ww') order by name_$lg ";
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
    }
	$data[0]=[k_dly_dtcs,1];
	$data[1]=[k_mth_inctv,1];
	if($thisGrp!='7htoys03le' && $thisGrp!='nlh8spit9q'){$data[2]=[k_tls_mth_dcts,0];}
	$data[3]=[k_dc_dte,1];
}
if($PER_ID=='9xtc9tlnvj'){$page=5;
	if($thisGrp!='7htoys03le' && $thisGrp!='nlh8spit9q'){
		$options='<option value="0">'.k_aldrs.'</option>';
		$sql="select * from _users  where `grp_code` IN('nlh8spit9q') order by name_$lg ASC";
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
    }
	$data[0]=[k_dly_dtcs,1];
	$data[1]=[k_mth_inctv,1];
	$data[2]=[k_tls_mth_dcts,0];
	$data[3]=[k_dc_dte,1];
}
if($PER_ID=='atzwjfe0ge'){$page=6;
	$options='<option value="0">'.k_alchrt.'</option>';
	$sql="select * from gnr_m_charities ";
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
	$data[3]=['يومي تجميعي',1];
	$data[4]=['شهري تجميعي',1];
	$data[5]=['بتاريخ تجميعي',1];
}
if($PER_ID=='9xda835btq'){$page=7;
	$options='<option value="0">'.k_alchrt.'</option>';
	$sql="select * from gnr_m_charities ";
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
	$data[0]=[k_daily_report,0];
	$data[1]=[k_monthly_report,0];
	//$data[2]=[k_rp_dte,0];
}
if($PER_ID=='jzc0s91s0m'){$page=8;	
    $data[0]=[k_comp_opers,0];
	$data[1]=[k_wek_oper_tbl,0];
	$data[2]=[k_mon_opers_tbl,0];
}
if($PER_ID=='jsa9kwmtii'){$page=9;$chart=1;
	$data[0]=[k_pers_sex,0];
	$data[1]=[k_pers_ags,0];
    $data[2]=['توزيع المناطق',0];
}
if($PER_ID=='rumz5hdpfs'){$page=10;
	$data[0]=[k_pats_copls,0];
	$data[1]=[k_sick_story,0];
	$data[2]=[k_clincal_examination,0];
	$data[3]=[k_drs_diags,0];
	$data[4]=[k_medcs_reps,0];
}
if($PER_ID=='mbsfd0hu6x'){$page=11;$chart=1;
	$data[0]=[k_srvcs_day,0];
	$data[1]=[k_srvc_mnth,0];
}
if($PER_ID=='9593qesyo8'){$page=12;
	$options='<option value="0">'.k_all_comps.'</option>';
	$sql="select * from gnr_m_insurance_prov ";
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
}
if($PER_ID=='wena4o7ncp'){$page=13;
	if($thisGrp!='7htoys03le' && $thisGrp!='nlh8spit9q'){   
		$options='<option value="0">'.k_aldrs.'</option>';
        $sql="select * from _users where `grp_code` IN('7htoys03le','nlh8spit9q','fk590v9lvl','9yjlzayzp','66hd2fomwt','1ceddvqi3g') order by name_$lg ";
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
    }	
	$data[0]=[k_dly_docs_srvcs,1,1];
	$data[1]=[k_mnth_docs_srvcs,1,2];
	$data[2]=[k_docs_srvcs_date,0,4];
}
if($PER_ID=='j3v66jz70q'){$page=14;$autpLoad=0;
	$data[0]=[k_dly_drs_perf,0];
	$data[1]=[k_mnthly_drs_perf,0];
	$data[2]=[k_drs_perf_by_dat,0];
}
if($PER_ID=='1xtjpd8ba'){$page=15;
	$data[0]=[k_monthly,0];
	$data[1]=[k_annual,0];
	$data[2]=[k_totl,0];
	$data[3]=[k_b_date,0];
}
if($PER_ID=='hbs86ai3mx' || $PER_ID=='ufjwbo6lv4'){$page=16;
	if($fin){$data[0]=[k_pats_day_shfts,0];}else{$tab=1;}
    if($fin){$data[10]=['عدد المرضى الشهري شفتات',0];}else{$tab=1;}
	$data[1]=[k_depts_pats_num,0];
	$data[2]=[k_depts_pats_num_yr,0];
}
if($PER_ID=='rhcnqlplst'){$page=17;
	$data[0]=[k_monthly,0];
	$data[1]=[k_annual,0];
	$data[2]=[k_totl,0];
	$data[3]=[k_b_date,0];
}
if($PER_ID=='fiyu0m7you'){$page=18;
	$data[0]=[k_daily,0];
	$data[1]=[k_monthly,0];	
	$data[2]=[k_annual,0];
	$data[3]=[k_b_date,0];
}
if($PER_ID=='f21mw0v0y2'){$page=19;	
	$data[0]=[k_daily,0];
	$data[1]=[k_monthly,0];	
	$data[2]=[k_annual,0];
	$data[3]=[k_b_date,0];
}
if($PER_ID=='kp8h1nw2k8'){$page=20;	$tab=1;
	$options='<option value="0">كل الأطباء </option>';
	$sql="select * from _users where `grp_code` IN($docsGrpsQ) order by name_$lg ";
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
    $data[1]=[k_daily_report,1];
	$data[2]=[k_monthly_report,1];
	$data[3]=[k_b_date,1];
}
if($PER_ID=='jo547o1zac'){$page=21;	$tab=1;
    $data[1]=[k_daily_report,0,1];
}
if($PER_ID=='mkr8fm3sd1'){$page=22;	$tab=1;    
	$data[1]=[k_monthly,0];	
	$data[2]=[k_annual,0];
	$data[3]=[k_b_date,0];
}
if($PER_ID=='nl812s25my'){$page=23;	$tab=1;    
	$data[1]=[k_monthly,0];	
	$data[2]=[k_annual,0];
	$data[3]=[k_general_report,0];
}

if($PER_ID=='6lh9jrptmq'){$page=24;	$tab=1;    
	$data[1]=[k_monthly,0];	
	$data[2]=[k_b_date,0];
}

if($PER_ID=='vl0k1c7x9p'){$page=25;	$tab=1;    
	$data[1]=[k_monthly,0];
	$data[2]=[k_b_date,0];
}
if($PER_ID=='t0i9lw5sbj'){$page=26;	$tab=0;
    $options='<option value="0">جميع الأقسام</option>';
    foreach($clinicTypes as $k => $val){
        if(in_array($k,array(1,3,5,7))){
            $options.='<option value="'.$k.'">'.$val.'</option>';
        }
    }
    $fillter='<select>'.$options.'</select>';
    $data[0]=[k_daily_report,0];
	$data[1]=[k_monthly,0];
	$data[2]=[k_b_date,0];
}

if($PER_ID=='mitjm59ew5'){$page=27;	$tab=0;
    $options='<option value="0">جميع الأطباء</option>';    
	$sql="select * from _users where `grp_code` IN($docsGrpsQ) order by name_$lg ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$id=$r['id'];
			$name=$r['name_'.$lg];
			$options.='<option value="'.$id.'">'.$name.'</option>';
		}
	}
	foreach($clinicTypes as $k=> $val){
		if($val && $k!=2 && $k!=6){
			$options.='<option value="'.$k.'">'.$val.'</option>';
		}		
	}
	$fillter='<select>'.$options.'</select>';
    $data[0]=[k_daily_report,1];
	$data[1]=[k_monthly,1];
	$data[2]=[k_b_date,1];
}

/****prescription********/
//echo $PER_ID;
if($PER_ID=='86wtf4jtfx'){
	$page=30; $tab=1;
	$data[1]=[k_monthly_report,1];
	$data[2]=[k_annual_report,1];
	$data[3]=[k_general_report,0];
	$data[4]=[k_b_date,1];
	/*$page=30;?>	
    <!--div class="rep_header fr"><?
		$options='<option value="0">'.k_alboxs.'</option>';
        $sql="select * from _users where `grp_code` IN('buvw7qvpwq','pfx33zco65') ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			while($r=mysql_f($res)){
				$id=$r['id'];
				$name=$r['name_'.$lg];
				$options.='<option value="'.$id.'">'.$name.'</option>';
			}
		}?>
        <select id="rep_fil" class="reportList" onChange="ReloadReport();"><?=$options?></select>
    </div-->
	<input type="hidden" id="rep_fil" value="0"/>
    <div class="rep_header fl">
		<div n="n1" f="1" class="fl act" onclick="loadReport(<?=$page?>,1,0);"><?=k_monthly_report?></div>
		<div n="n2" f="1" class="fl" onclick="loadReport(<?=$page?>,2,0);"><?=k_annual_report?></div>
        <div n="n3" f="1" class="fl" onclick="loadReport(<?=$page?>,3,0);"><?=k_general_report?></div>
		<div n="n4" f="1" class="fl" onclick="loadReport(<?=$page?>,4,0);">التقرير بالتاريخ</div>
    </div><?
	$tab=1;*/
}		
if($PER_ID=='z40gvrqkvv'){
	$page=31; $tab=2;
	$data[2]=[k_annual_report,1];
}
if($PER_ID=='nf9cxz0vsl'){
	$page=32; $tab=1;
	$data[1]=[k_monthly_report,1];
	$data[2]=[k_annual_report,1];
	$data[3]=[k_general_report,0];
	$data[4]=[k_b_date,1];
}
if($PER_ID=='f4agy88cwb'){
	$page=33; $tab=1;
	$data[1]=[k_monthly_report,1];
	$data[2]=[k_annual_report,1];
	$data[3]=[k_general_report,0];
	$data[4]=[k_b_date,1];
}
if($PER_ID=='rcdq87x1i3'){
	$page=34; $tab=1;
	$data[1]=[k_monthly_report,1];
	$data[2]=[k_annual_report,1];
	$data[3]=[k_general_report,0];
	$data[4]=[k_b_date,1];
}
/**********/
echo setReportPage($code,$page,$tab,$fillter,$data,$chart,$autpLoad);?>

