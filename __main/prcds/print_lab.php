<? include("../../__sys/prcds/ajax_header.php");
if(isset($_GET['type'] , $_GET['id'])){?>
	<? $style_file=styleFiles('P');?>
	<head><link rel="stylesheet" type="text/css" href="<?=$m_path.$style_file?>"></head>
	<body dir="<?=$l_dir?>"><?
	$type=pp($_GET['type']);
	$id2=pp($_GET['id'],'s');
	$id=pp($_GET['id']);		  
	$id_no=convTolongNo($id,7);
	$thisCode=$type.'-'.$id;
	
	if($type==1 && $thisGrp=='5j218rxbn0'){	
		$sql="select pkg_id , count(pkg_id) c from lab_x_visits_samlpes where grp='$id' group by pkg_id order by c DESC ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$i=0;				
			$thisP=0;				
			while($r=mysql_f($res)){
				$c=$r['c'];					
				$pkg_id=$r['pkg_id'];	
				$total_samples.=get_val('lab_m_samples_packages','name_'.$lg,$pkg_id).' '.$c.' | ';
			}
		}		
		$rec=getRec('lab_x_visits_samlpes_group',$id);
		
		echo '<div class="print_page4"><div style="margin:0.5cm">';										
		echo '
		<div class="f1 fs18 lh30">'._info_7dvjz4qg9g.'</div>
		<div class="f1 fs14 lh30">'.k_dc_sm_snt.' : <ff dir="ltr">'.date('Y-m-d / A h:i',$rec['date']).'</ff> </div>
		<div class="f1 fs14 lh30">الدفعة : '.splitNo($rec['name']).'</div>
		<div class="uLine"> </div>
		<div class="lh50 fl w100 f1 fs16">'.splitNo($total_samples).'</div>';
		
		$id_no=convTolongNo($id,7);
		$sql="select * from lab_x_visits_samlpes where grp='$id' order by visit_id ASC ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_print grad_print2" >
			<tr>
				<th rowspan="2">#</th>
				<th colspan="3">'.k_sample.'</th>
				<th rowspan="2">'.k_patient.'</th>
				<th rowspan="2">'.k_tests.'</th>
				<th rowspan="2" width="8%">'.k_notes.'</th>
			</tr>			
			<tr>
				<th>باركود</th>
				<th>'.k_sample.'</th>
				<th>السحب</th>
			</tr>';
			$thisP=0;
			$c=1;
			while($r=mysql_f($res)){
				$visit_id=$r['visit_id'];
				$pkg_id=$r['pkg_id'];
				$services=$r['services'];
				$no=$r['no'];
				$s_taker=$r['s_taker'];
				$date=$r['date'];
				$p=$r['patient'];
				$status=$r['status'];				
				$p_data=get_p_name($p,3);
				
				$trSty='';
				if($p!=$thisP){
					$trSty=' style="border-top:3px #333 solid " ';
				}
				echo '<tr >
				<td '.$trSty.'><ff>'.$c.'</ff></td>	
				<td '.$trSty.'><div class="baarcode3"><img src="'.$f_path.'bc/'.$no.'"/></div></td>
				<td class="f1 fs12" '.$trSty.'>'.get_val('lab_m_samples_packages','name_'.$lg,$pkg_id).'<ff> ('.$no.')</ff></td>
				<td '.$trSty.'><ff>'.date('A h:i',$date).'</ff></td>';
				
				if($p!=$thisP){
					$pT=getTotalCO('lab_x_visits_samlpes'," visit_id ='$visit_id' and grp='$id' and patient='$p'");
					echo '					
					<td '.$trSty.' class="ws" rowspan="'.$pT.'" '.$trSty.'>
						<div class="f1 lh20 fs12"> 
							'.$p_data[0].'<br> 
							<ff dir="ltr" class="fs12">#'.get_val_con('gnr_x_roles','no'," vis='$visit_id' and mood=2 ").'</ff> -
							'. $sex_types[$p_data[4]].' ('.$p_data[1].')
						</div>
					</td>';
				}
				echo '
				<td dir="ltr" '.$trSty.'>'.PrintAnal($services).'</td>
				<td '.$trSty.'> </td></tr>';
				$thisP=$p;
				$c++;
			}
			echo '</table>';
		}
		echo '</div></div>';	
	}
	/******************************************************************************************/
	if($type==2 && $thisGrp=='b3pfukslow'){
		echo '<div class="print_page4"><div style="margin:0.5cm">';
		echo '
		<div class="f1 fs18 lh30">'._info_7dvjz4qg9g.'</div>
		<div class="f1 fs14 lh30">'.k_dc_dm_rk.'  : 
		<ff dir="ltr">( '.get_val('lab_m_racks','no',$id).' )</ff> '.k_b_date.' : <ff dir="ltr">'.date('Y-m-d / A h:i',$now).'</ff></div>
		<div class="uLine"> </div>';	
		mysql_q("update lab_x_racks_alert SET status=1 , date='$now' where rack='$id' and status=0 ");
		$sql="select * from lab_x_visits_samlpes where rack='$id' order by rack_ord ASC ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_print grad_print2" type="static">
			<tr><th>#</th><th>'.k_num.'</th><th>'.k_sample.'</th><th>'.k_patient.'</th><th>'.k_tests.'</th><th>'.k_rst.'</th></tr>';
			$thisP=0;
			while($r=mysql_f($res)){
				$visit_id=$r['visit_id'];
				$pkg_id=$r['pkg_id'];
				$services=$r['services'];
				$no=$r['no'];
				$s_taker=$r['s_taker'];
				$date=$r['date'];
				$take_date=$r['take_date'];
				$status=$r['status'];
				$p=$r['patient'];
				$rack_pos=$r['rack_pos'];
				$sub_s=$r['sub_s'];
				$per_s=$r['per_s'];
				$fast=$r['fast'];
				
				$p_data=get_p_name($p,3);
				$perTxt='';
				if($per_s){
					$per_s_no=get_val('lab_x_visits_samlpes','no',$per_s);		
					$perTxt='<div class="f1 clr5 fs12">'.k_bu_sm_sm.' <ff>( '.$per_s_no.' )</ff></div>';
				}
				$RXY=getSAddrXY($id);
				$serv=getLinkedAna(2,0,$services,2);
				$cspan=count($serv);
				for($s=0;$s<$cspan;$s++){
					echo '<tr>';
					$tdRs='';
					if($s==0){
						$tdRs='b';
						$sty='';
						if($units>=14){$sty='p_Hprice pd5';}
						if($fast){$sty='p_emrg pd5';}
				
						echo '						
						<td '.$tdRs.'  rowspan="'.$cspan.'" valign="top">
						<ff  class="ff fs24 B">'.getSAView($rack_pos,$RXY[0],$RXY[1]).'</ff></td>
						
						<td '.$tdRs.' rowspan="'.$cspan.'" valign="top">
						<div class="baarcode3"><img src="'.$f_path.'bc/'.$no.'"/></div></td>
						
						<td '.$tdRs.' rowspan="'.$cspan.'" valign="top" class="f1 lh20">
						'.get_val('lab_m_samples_packages','name_'.$lg,$pkg_id).'<br><ff> ('.$no.')</ff>'.$perTxt.'</td>
						
						<td '.$tdRs.' rowspan="'.$cspan.'" valign="top">
						<div class="f1 lh20">'.$p_data[0].'<br>'.$sex_types[$p_data[4]].' ( '.$p_data[1].' )</div></td>';		
					}
					echo '<td '.$tdRs.'><div>'.$serv[$s].'</div></td><td '.$tdRs.' width="25%"></td>';
					echo '</tr>';
				}
			}
			echo '</table>';
			
		}
		echo '</div>';
	}
	if($type==3 && $thisGrp=='b3pfukslow'){
		list($rack,$sample)=get_val('lab_x_racks_alert','rack,sample',$id);
		echo '<div class="print_page4"><div style="margin:0.5cm">';
		echo '
		<div class="f1 fs18 lh30">'._info_7dvjz4qg9g.'</div>
		<div class="f1 fs14 lh30">'.k_dc_dm_rk.' ( ملحق ) : 
		<ff dir="ltr">( '.get_val('lab_m_racks','no',$rack).' )</ff> '.k_b_date.' : <ff dir="ltr">'.date('Y-m-d / A h:i',$now).'</ff></div>
		<div class="uLine"> </div>';	
		mysql_q("update lab_x_racks_alert SET status=1 , date='$now' where id='$id' and status=0 ");
		$sql="select * from lab_x_visits_samlpes where rack='$rack' and id='$sample' order by rack_ord ASC ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_print grad_print2" type="static">
			<tr><th>#</th><th>'.k_num.'</th><th>'.k_sample.'</th><th>'.k_patient.'</th><th>'.k_tests.'</th><th>'.k_rst.'</th></tr>';
			$thisP=0;
			while($r=mysql_f($res)){
				$visit_id=$r['visit_id'];
				$pkg_id=$r['pkg_id'];
				$services=$r['services'];
				$no=$r['no'];
				$s_taker=$r['s_taker'];
				$date=$r['date'];
				$take_date=$r['take_date'];
				$status=$r['status'];
				$p=$r['patient'];
				$rack_pos=$r['rack_pos'];
				$sub_s=$r['sub_s'];
				$per_s=$r['per_s'];
				$p_data=get_p_name($p,3);
				$perTxt='';
				if($per_s){
					$per_s_no=get_val('lab_x_visits_samlpes','no',$per_s);		
					$perTxt='<div class="f1 clr5 fs12">'.k_bu_sm_sm.' <ff>( '.$per_s_no.' )</ff></div>';
				}
				$RXY=getSAddrXY($id);
				$serv=getLinkedAna(2,0,$services,2);
				$cspan=count($serv);
				for($s=0;$s<$cspan;$s++){
					echo '<tr>';
					$tdRs='';
					if($s==0){
						$tdRs='b';
						echo '
						<td '.$tdRs.'  rowspan="'.$cspan.'" valign="top">
						<ff class="ff fs24 B">'.getSAView($rack_pos,$RXY[0],$RXY[1]).'</ff></td>
						
						<td '.$tdRs.' rowspan="'.$cspan.'" valign="top">
						<div class="baarcode3"><img src="'.$f_path.'bc/'.$no.'"/></div></td>
						
						<td '.$tdRs.' rowspan="'.$cspan.'" valign="top" class="f1 lh20">
						'.get_val('lab_m_samples_packages','name_'.$lg,$pkg_id).'<br><ff> ('.$no.')</ff>'.$perTxt.'</td>
						
						<td '.$tdRs.' rowspan="'.$cspan.'" valign="top">
						<div class="f1 lh20">'.$p_data[0].'<br>'.$sex_types[$p_data[4]].' ( '.$p_data[1].' )</div></td>';		
					}
					echo '<td '.$tdRs.'>'.$serv[$s].'</td><td '.$tdRs.' width="25%"></td>';
					echo '</tr>';
				}
			}
			echo '</table>';
			
		}
		echo '</div>';
	}
	if($type==5){
		echo '<div class="print_page4"><div style="margin:0.5cm">';										
		echo '
		<div class="f1 fs18 lh30">'._info_7dvjz4qg9g.'</div>
		<div class="f1 fs14 lh30">تاريخ الطباعة : <ff dir="ltr">'.date('Y-m-d / A h:i',$now).'</ff></div>
		<div class="uLine"> </div>';
		
		/*$ana_prices=array();
		$anas=get_vals('lab_x_visits_services','service'," id IN($id2) ");
		if($anas){
			$sql="select * from lab_m_external_labs_price where lab='$lab_id' and ana IN($anas)";
			$res=mysql_q($sql);
			while($r=mysql_f($res)){
				echo $ana_prices[$r['ana']]=$r['price'];				
			}
		}*/
		$sql="select * ,x.id as x_id  from lab_x_visits_services x ,lab_m_services m where 
		x.service=m.id and x.id in ($id2) order by x.id ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_print grad_print2" type="static">
			<tr><th width="40">#</th><th width="40">الزيارة</th><th width="150">المريض</th><th width="250">التحليل</th><th>النتيجة</th></tr>';
			$i=1;
			while($r=mysql_f($res)){
				$s_id=$r['x_id'];
				$visit_id=$r['visit_id'];
				$sample_link=$r['sample_link'];
				$service=$r['service'];
				$p=$r['patient'];
				$code=$r['code'];
				$short_name=$r['short_name'];
				$price=$r['total_pay'];				list($pkg_id,$no,$samplDate,$status)=get_val('lab_x_visits_samlpes','pkg_id,no,date,status',$sample_link);
				if($samplDate){$samplDate=date('Y-m-d',$samplDate);}
				$p_data=get_p_name($p,3);
				$service_id=$r['service'];
				//$lab_price=$ana_prices[$service];
				
				echo'<tr>
					<td><ff>'.$i.'</ff></td>
					<td><ff>'.$visit_id.'</ff></td>
					<td><div class="f1 lh20 ws">'.$p_data[0].' - '.$sex_types[$p_data[4]].' ( '.$p_data[1].' )</div></td>
					<td>'.$short_name.'</td>
					<td></td>										
				</tr>';
				$i++;
			}
			echo'</table>';
			
		}
	}
?>
    </body><?
}?>
<script>window.print();setTimeout(function(){window.close();},1000);</script>