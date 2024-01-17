<? include("../../__sys/prcds/ajax_header.php");
$rrOprs=[
	['خدمات الزيارات','cln_x_visits_services','service','','R'],
	['أسعار التأمين','gnr_m_insurance_prices','service',' and  type=1 ','D'],
	['أسعار مخصصة','gnr_m_services_prices','service',' and mood=1 ','D'],
	['بنود العروض','gnr_m_offers_items','service',' and mood=1 ','D'],
	['خدمات العروض المنفذة','gnr_x_offers_items','service',' and mood=1 ','D'],
	['خدمات العروض المنفذة 2','gnr_x_offers_oprations','service',' and mood=1 ','D'],
	['سجل التأمين','gnr_x_insurance_rec','service',' and mood=1 ','R'],
];
if(isset($_POST['clnc'],$_POST['t'])){
	$clnc=pp($_POST['clnc']);
	$t=pp($_POST['t']);
	$r=getRecCon('gnr_m_clinics'," id='$clnc' and linked!=0 ");
	if($r['r']){
		$type=$r['type'];
		$linked=$r['linked'];
		$table=$srvTables[$type];
		if($t==1){			
			$sql="select * from $table where clinic='$clnc' order by name_$lg ASC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			echo '<div class="f1 fs18 clr1 lh40">الخدمات <ff> ( '.$rows.' )</ff></div>';
			while($r=mysql_f($res)){
				$srv_id=$r['id'];
				$name=$r['name_'.$lg];
				echo '<div class="lh30 cbg1 clrw TC mg5v pd5 fs14 f1 Over" onclick="rr_selsrv('.$srv_id.')">'.$name.'</div>';
			}
		}
		if($t==2){
			$srv_id=$_POST['srv'];
			$r=getRec($table,$srv_id);
			if($r['r']){
				$name=$r['name_'.$lg];
				$hos_part=$r['hos_part'];
				$doc_part=$r['doc_part'];
				echo '<div class="cbg4 lh30 f1 fs14 b_bord pd10f">'.$name.'</div>
				<div fix="hp*:10" class=" pd10 ofx so">';
				$rows=getTotalCO($table," clinic='$linked' ");				
				/****************/
				$sql="select * from $table where clinic='$linked' and name_$lg='$name'  order by name_$lg ASC";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows){echo '<div class="lh30 fs14 f1">مطابق</div>';}
				while($r=mysql_f($res)){
					$srv_id=$r['id'];
					$name=$r['name_'.$lg];
					echo '<div class="lh30 cbg5 clrw TC mg5v pd5 fs14 f1 Over" onclick="rr_selsrv2('.$srv_id.')">'.$name.'</div>';
				}
				/****************/
				
				$hos_part=$r['hos_part'];
				$doc_part=$r['doc_part'];
				$sql="select * from $table where clinic='$linked' and hos_part='$hos_part' and doc_part='$doc_part' order by name_$lg ASC";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows){echo '<div class="lh30 fs14 f1">مطابق بالسعر <ff>(  '.$rows. ')</ff></div>';}
				while($r=mysql_f($res)){
					$srv_id=$r['id'];
					$name=$r['name_'.$lg];
					echo '<div class="lh30 cbg66 clrw TC mg5v pd5 fs14 f1 Over" onclick="rr_selsrv2('.$srv_id.')">'.$name.'</div>';
				}
				/****************/
				$sql="select * from $table where clinic='$linked'  order by name_$lg ASC";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows){echo '<div class="lh30 fs14 f1">كل الخدمات <ff>( '.$rows.' )</ff></div>';}
				while($r=mysql_f($res)){
					$srv_id=$r['id'];
					$name=$r['name_'.$lg];
					echo '<div class="lh30 cbg1 clrw TC mg5v pd5 fs14 f1 Over" onclick="rr_selsrv2('.$srv_id.')">'.$name.'</div>';
				}
				/****************/
				echo '</div>';
			}
		}
		if($t==3){
			$srv_id=$_POST['srv'];
			$srv_id2=$_POST['srv2'];
			$r=getRec($table,$srv_id);
			$r2=getRec($table,$srv_id2);
			if($r['r'] && $r2['r']){
				echo '<div class="f1 fs16 lh30 clr1"> من '.get_val('gnr_m_clinics','name_'.$lg,$clnc).' - '.$r['name_'.$lg].' 
				<ff>( '.number_format($r['hos_part']+$r['doc_part']).' ) - ['.$srv_id.']</ff></div>';
				echo '<div class="f1 fs16 lh30 clr6"> إلى '.get_val('gnr_m_clinics','name_'.$lg,$r2['clinic']).' - '.$r2['name_'.$lg].' 
				<ff>( '.number_format($r2['hos_part']+$r2['doc_part']).' ) - ['.$srv_id2.']</ff></div>';
				echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static" >
				<tr><th width="250">القسم</th><th width="30">عدد السجلات</th><th width="90">الإجراء</th>';				
				echo'</tr>';
				$total=0;
				foreach($rrOprs as $mo){
					echo '<tr><td class="f1 fs14 TL">'.$mo[0].'</td>';					
					$n=getTotalCO($mo[1],$mo[2]."='$srv_id' ".$mo[3]);
					$opr='تعديل';
					if($mo[4]=='D'){$opr='حذف';}
					$total+=$n;
					echo '<td><ff>'.$n.'</ff></td>
					<td class="f1 fs16">'.$opr.'</td></tr>';					
				}
				echo '<tr fot><td class="f1 fs14">المجموع</td>
				<td><ff>'.$total.'</ff></td><td></td></tr></table>
				<div class="bu bu_t3 fl" onclick="rr_curr()">تصحيح</div>';				
			}
		}
		if($t==4){
			$srv_id=$_POST['srv'];
			$srv_id2=$_POST['srv2'];
			$r=getRec($table,$srv_id);
			$r2=getRec($table,$srv_id2);
			if($r['r'] && $r2['r']){
				$total=0;
				foreach($rrOprs as $mo){
					$s_table=$mo[1];
					$s_col=$mo[2];
					$s_cond=$mo[3];
					$s_opr=$mo[4];
					if($s_opr=='D'){
						$sql="DELETE from $s_table where $s_col='$srv_id' $s_cond ";
					}
					if($s_opr=='R'){
						$sql="UPDATE $s_table SET $s_col='$srv_id2' where $s_col='$srv_id' $s_cond ";
					}
					$res=mysql_q($sql);										
				}
				mysql_q("DELETE from $table where id='$srv_id' ");
			}
		}
	}
}?>