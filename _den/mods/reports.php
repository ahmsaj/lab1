<? include("../../__sys/mods/protected.php");?>
<? $code='den';$tab=0;$fillter='';$chart='';$data=array();//echo $PER_ID;
/**********/
if($PER_ID=='10jfcaspit'){$page=1;$tab=1;
	$options='<option value="0">'.k_aldrs.' </option>';
	$sql="select * from _users where `grp_code` IN('fk590v9lvl') order by name_$lg ";
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
	$data[3]=[k_annual_report,1];
	$data[4]=[k_general_report,1];
	$data[5]=[k_b_date,0];
}
if($PER_ID=='q2av9r1use'){$page=2;$tab=1;
	$options='<option value="0">'.k_aldrs.' </option>';
	$sql="select * from _users where `grp_code` IN('fk590v9lvl') order by name_$lg ";
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
}
if($PER_ID=='pc1kuvth6d'){$page=3;$tab=1;    
	$options='<option value="0">'.k_aldrs.' </option>';
	$sql="select * from _users where `grp_code` IN('fk590v9lvl') order by name_$lg ";
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
    $data[1]=[k_daily_report];
	$data[2]=[k_monthly_report,1];
}
if($PER_ID=='sqxchh7k5w'){$page=4;$tab=1;
	$options='<option value="0">'.k_aldrs.' </option>';
	$sql="select * from _users where `grp_code` IN('fk590v9lvl') order by name_$lg ";
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
if($PER_ID=='ep4dj00m6o'){$page=5;$tab=1;
	$options='<option value="0">'.k_aldrs.' </option>';
	$sql="select * from _users where `grp_code` IN('fk590v9lvl') order by name_$lg ";
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
/**********/
echo setReportPage($code,$page,$tab,$fillter,$data,$chart);