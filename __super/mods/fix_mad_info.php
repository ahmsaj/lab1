<?=header_sec($def_title,'');
$p_mid_table_arr=array('','a___z_allergies','a___z_operations','a___z_diseases','a___z_lastMedic');
$p_mid_types=array('',k_allergies,k_operations,k_ch_diseases,k_medicines);?>
<div class="centerSideInHeader lh50"></div>
<div class="centerSideIn so"><?
$total=getTotal('a___x_mad_info');
echo '<div class="ff fs18 B lh50 b_bord">'.number_format($total).'</div>';
$sql="select pationt_id from a___x_mad_info group by pationt_id  order by pationt_id ASC limit 1000";
$res=mysql_q($sql);
$rows=mysql_n($res);
echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" >
<tr><th>'.k_patient.'</th><th>'.k_old_inf.'</th><th>'.k_new_inf.'</th><th></th></tr>';
while($r=mysql_f($res)){
	$pat=$r['pationt_id'];
	$vals_old=array();
	$vals_new=array();
	echo '<tr>
	<td><div class="f1 fs16 clr1">'.get_p_name($pat).'</div></td>
	<td>';
	/********************/
	$sql2="select * from a___x_mad_info where pationt_id='$pat' order by type ASC";
	$res2=mysql_q($sql2);
	$rows2=mysql_n($res2);
	$i=0;	
	while($r2=mysql_f($res2)){
		$v_id=$r2['id'];
		$type2=$r2['type'];
		$val2=$r2['val'];
		$table=$p_mid_table_arr[$type2];
		$valTxt=get_val_arr($table,'name_ar',$val2,'s'.$type2);
		$vals_old[$i]=[$v_id,$valTxt,$type2];
		echo '<div class="f1 fs12 lh30">'.$p_mid_types[$type2].' : '.$valTxt.'</div>';
		$i++;
	}
	/********************/
	echo '</td><td>';
	/********************/
	$sql2="select * from cln_x_medical_his where patient='$pat' order by cat ASC";
	$res2=mysql_q($sql2);
	$rows2=mysql_n($res2);
	$i=0;
	while($r2=mysql_f($res2)){
		$v_id=$r2['id'];
		$cat=$r2['cat'];
		$med_id=$r2['med_id'];		
		$valTxt=get_val_arr('cln_m_medical_his','name_ar',$med_id,'s2'.$cat);
		$vals_new[$i]=[$v_id,$valTxt,$type2];
		echo '<div class="f1 fs12 lh30">'.$p_mid_types[$cat].' : '.$valTxt.'</div>';
		$i++;
	}
	/********************/	
	echo '<td>';
	$x=0;
	if(count($vals_new)==0){mysql_q("DELETE from a___x_mad_info where pationt_id='$pat'");}
	if(count($vals_new)==count($vals_old)){
		foreach($vals_old as $k=>$v){		
			$clr='clr5';
			$name='';
			$type=$v[2];
			$name_old=stripcslashes($v[1]);
			$name_new=stripcslashes($vals_new[$k][1]);
			if(str_replace(' ','',$name_old)==str_replace(' ','',$name_new)){
				$clr='clr6';
				mysql_q("DELETE from a___x_mad_info where id='".$v[0]."'");
			}else{
				list($newId,$name)=get_val_con('cln_m_medical_his','id,name_ar'," cat='$type' and  name_ar='".$name_old."'");
				//echo '['.$newId.'-'.$name.']';
				$name=stripcslashes($name);
				if($newId){
					mysql_q("UPDATE cln_x_medical_his SET med_id='$newId' where id='".$vals_new[$k][0]."'");
				}else{

				}
				$x++;
			}		
			echo '<div class="f1 f1 '.$clr.' lh30">
			<ff14>'.$v[0].'</ff14>'.$name_old.'<br>
			<ff14>'.$vals_new[$k][0].'</ff14>-'.$name_new.'<br>
			('.$name.')</div>';
		}
	}else{
		foreach($vals_old as $k=>$v){		
			$clr='clr5';
			$name='';
			$type=$v[2];
			$name_old=stripcslashes($v[1]);
			foreach($vals_new as $k=>$v2){
				if(str_replace(' ','',$name_old)==str_replace(' ','',$v2[1])){
					mysql_q("DELETE from a___x_mad_info where id='".$v[0]."'");
				}
			}
		}
		echo '<div class="f1 f1 '.$clr.' lh30">
			<ff14>'.$v[0].'</ff14>'.$name_old.'<br>
			<ff14>'.$vals_new[$k][0].'</ff14>-'.$name_new.'<br>
			('.$name.')</div>';
	}
	//echo $x;
	if($x==0){
		//mysql_q("DELETE from a___x_mad_info where pationt_id='$pat'");
	}
	echo '</td>';
	/********************/
	echo '</tr>';
	unset($vals_old);
	unset($vals_new);
}
echo '</table>';
?></div>
<script>//sezPage='';$(document).ready(function(e){f(1);});</script>