<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['fil'] , $_POST['p']) ||isset($_POST['vis']) || isset($_POST['pat'])){
	echo '<!--***-->';
	$pvl=pp($_POST['fil'],'s');
	$pars=explode('|',$pvl);
	$q='';	
	$s_no=0;
	$mood=0;
	$anaQ='';
	$datQ='';
	foreach($pars as $p){
		if($p!=''){
			$pp=explode(':',$p);
			$cal=$pp[0];
			$val1=$pp[1];
			$val2=$pp[2];
			if($cal=='cn_bc'){$mood=1;$s_no=intval($val1);}
			if($cal=='v1' && $mood==0){$mood=2;$v_no=$val1;$vv=explode('-',$v_no);if(count($vv)==2){$v_no=$vv[1];}}
			if($cal=='p1' && $mood==0){$mood=3;$p_no=$val1;}
			
			if($mood==0){				
				if($cal=='ana'){$anaQ=" service in( select id from lab_m_services where short_name like '%$val1%' ) ";$ana=$val1;}
				if($cal=='p6'){if($anaQ){$anaQ.=" AND ";}$anaQ=" fast ='$val1'" ;}
				if($cal=='p2'){if($q){$q.=" AND ";}$q.="f_name like '%$val1%' ";$p2=$val1;}
				if($cal=='p3'){if($q){$q.=" AND ";}$q.="ft_name like '%$val1%' ";$p3=$val1;}
				if($cal=='p4'){if($q){$q.=" AND ";}$q.="l_name like '%$val1%' ";$p4=$val1;}	
				if($cal=='p5'){if($q){$q.=" AND ";}$q.=" sex = '$val1' ";}				
				if($cal=='d1'){
					if($val1){$datQ.=" d_start > ".strtotime($val1);}
					if($val2){
						if($datQ){$datQ.=' AND ';} 
						$datQ.=" d_start < ".(strtotime($val2)+86400);
					}
					if($datQ){$q2=" visit_id IN( select id from lab_x_visits where $datQ )";}
				}
			}
		}
	}
	if($q && $mood==0){$mood=4;}	
	/************************************************/
	if($mood==1){
		echo '<div class="f1 fs18 lh40 clr1 uLine ">'.k_sample_no.' <ff> ( '.$s_no.' )</ff></div>';
	}else if($mood==2){
		echo '<div class="f1 fs18 lh40 clr1 uLine ">'.k_visit_num.'  <ff> ( '.$v_no.' )</ff></div>';
		$q_limit='';
	}else if($mood==3){
		echo '<div class="f1 fs18 lh40 clr1 uLine ">'.k_num_pats.' <ff> ( '.$p_no.' )</ff></div>';
		$q=" id= '$p_no' ";
		$q_limit='';
	}else if($mood==4){
		$total=getTotalCO('gnr_m_patients'," $q ");		
		$pagination=pagination('','',100,$total);
		$page_view=$pagination[0];
		$q_limit=$pagination[1];	
		$all_rows=$pagination[2];
		echo '<div class="f1 fs18 lh40 clr1 uLine ">'.k_num_pats.' <ff> ( '.number_format($total).' )</ff></div>';
		
	}else{
		$q="status IN(5,6,9)";		
		if($anaQ){ $q.= ' AND '.$anaQ;}
		if($q2=='' && $mood==0 && $anaQ==''){$q.=" and d_start >".($now-(86400*2))." "; }
		if($q2){$q2=' AND '.$q2;}
		$total=getTotalCO('lab_x_visits_services',"  $q $q2");		
		$pagination=pagination('','',100,$total);
		$page_view=$pagination[0];
		$q_limit=$pagination[1];	
		$all_rows=$pagination[2];
		echo '<div class="f1 fs18 lh40 clr1 uLine ">'.k_number_of_tests.' : <ff>'.number_format($total).'</ff></div>';
	}
	echo '<!--***-->';
	/************************************************/
	if($mood==1){
		list($vis_id,$patient,$status)=get_val_c('lab_x_visits_samlpes','visit_id,patient,status',$s_no,'no');
		if($vis_id){ 		
			if($status==2 || $status==3){				
				$patInfo=getPatInfo($patient);
				echo '
				<div class="uLine lh50 fl w100">
					<div class="f1 fs16 fl">
						'.$patInfo['n'].' (
						<span class="f1 fs16 clr1111" dir="ltr"> '.$patInfo['s'].' </span> '.$patInfo['b'].' )
					</div>';
					if(getTotalCO('lab_x_visits_services'," status IN (5,6,9) and visit_id='$vis_id' ")){
					echo '<div class="ic40 icc4 ic40_lab_vis fr " title="'.k_vis_reports_enter.'" onclick="showLReport('.$vis_id.',3)"></div>';

					}					
				echo '</div>';

				$sql="select * , x.id as x_id , x.fast as x_fast from lab_x_visits_services x , lab_m_services z where x.service=z.id and  x.visit_id='$vis_id'and  status IN(1,5,6,7,9,8,10) order by x.sample_link ASC ";
				
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">';
				if($rows>0){
					$act_sample=0;

					while($r=mysql_f($res)){
						$s_id=$r['x_id'];
						$name=$r['short_name'];
						$outlab=$r['outlab'];
						$status=$r['status'];
						$fast=$r['x_fast'];
						$sample=$r['sample'];
						$sample_link=$r['sample_link'];
						$no=get_val('lab_x_visits_samlpes','no',$sample_link);
						$fastTxt='';
						if($fast){$fastTxt='<div class="f1 clr5 lh20 cb"> '.k_emergency.' </div>';}

						if($act_sample!= $sample_link){				
							$s=getRec('lab_x_visits_samlpes',$sample_link);
							$bg='cbg4';
							if($no==$s_no){$bg='cbg6';}

							echo '<tr class="'.$bg.'">
							<td class="ff B fs16"><div class="fl lh50">
								'.get_samlpViewC('x',$s['pkg_id'],1).'</div>
								<div class="fl f1 fs20 lh50"> '.get_val('lab_m_samples_packages','name_'.$lg,$s['pkg_id']).' <ff> ( '.$s['no'].' )</ff></div>								
							</td>
							<td>
								<div class="cb f1 clr1111 fs14 lh30 mg10">'.$lrStatus[$s['status']].' : <ff>'.dateToTimeS2($now-$s['take_date']).'</ff></div>
							</td>
							<td width="30" >';
							if(getTotalCO('lab_x_visits_services'," status IN (5,6,9) and sample_link='$sample_link' ")){
								echo '<div class="ic40 icc2 ic40 ic40_lab_sam fr mg5" title="'.k_sample_reports_enter.'" onclick="showLReport('.$sample_link.',2)"></div>';
							}
							echo '</td>
							</tr>';
							$act_sample=$sample_link;
						}
						$outTxt='';
						if($outlab){$outTxt='<div class="f1 clr1 lh20">'.k_out_test.'</div>';}
						$pors='';
						if(in_array($status,array(5,6,9,10,1)) ){ 
							$pors='<div class="ic40 icc1 ic40_det fr" title="'.k_ent_rep_val.'" onclick="showLReport('.$s_id.',1)"></div>';
						}
						if(in_array($status,array(7,8,9,10,1))){
							$pors='<div class="ic40 icc2 ic40_ref fr" title="'.k_result_recheck.'" onclick="returnReport('.$s_id.','.$no.')"></div>';
						}
						echo '<tr>
						<td class="ff B fs16">'.$name.$outTxt.$fastTxt.'</td>
						<td><div class="f1">'.$anStatus[$status].'</div></td>
						<td>'.$pors.'</td>
						</tr>';
					}
					echo '</table>';
				}
			}else{
				if($status==4){
					echo '<div class="f1 fs18 clr5"> '.k_sample_canceled.' <ff> ( '.$no.' )</ff></div>';
				}else if($status==5){
					echo '<div class="f1 fs18 clr5"> '.k_sample_destroyed.' <ff> ( '.$no.' )</ff></div>';
				}else{
					echo '<div class="f1 fs18 clr5"> '.k_sample_not_reach_factory.' <ff> ( '.$no.' )</ff></div>';
				}
			}

		}else{
			echo '<div class="f1 fs18 clr5"> '.k_no_sample_number.' <ff>( '.$s_no.' )</ff></div>';
		}
		echo '<!--***-->1'.$page_view;
	}else if($mood==3 || $mood==4){		
		if($q){$q="where $q";}		
		$sql="select * from gnr_m_patients $q order by id DESC $q_limit";
		$res=mysql_q($sql);
		$rows=mysql_n($res);	
		if($rows>1){?>
			<table width="100%" border="0"  class="grad_s holdH" type="static" cellspacing="0" cellpadding="4" over="0" >		
			<tr>
			<th class="fs16 f1">#</th>
			<th class="fs16 f1"><?=k_patient?></th>			
			<th class="fs16 f1" width="100"><?=k_status?></th>			
			</tr> <?
			while($r=mysql_f($res)){
				$p_id=$r['id'];
				$f_name=$r['f_name'];
				$l_name=$r['l_name'];
				$ft_name=$r['ft_name'];
				$time_entr=$r['d_start'];
				$con=getTotalCO('lab_x_visits'," patient='$p_id' ");
				if($con){
					$satusT='<div class="bu2 buu bu_t1 fl" onclick="sw2pat('.$p_id.')"> '.k_vis_no.' <ff> ( '.$con.' ) </ff></div>';
				}else{
					$satusT='-';
				}
				?><tr>
				<td class="ff B fs16"><?=$p_id?></td>
				<td class="f1"><?=hlight($p2,$f_name).' '.hlight($p3,$ft_name).' '.hlight($p4,$l_name)?></td>
				<td class="f1"><?=$satusT?></td>				
				</tr><?
			}		
			?></table><?
		}else if($rows==1){
			$r=mysql_f($res);
			$p_id=$r['id'];
			$f_name=$r['f_name'];
			$l_name=$r['l_name'];
			$ft_name=$r['ft_name'];
			$sex=$r['sex'];
			$birth_date=$r['birth_date'];
			$b=birthCount($birth_date,$ar);			
			
			$sql="select * from lab_x_visits where patient='$p_id' order by d_start DESC ";
			$res=mysql_q($sql);
			$rows=mysql_n($res);			
			echo '<div class="f1 fs18 clr5 lh40">'.$f_name.' '.$ft_name.' '.$l_name.' (	<span class="f1 fs16 "> '.$sex_types[$sex].' </span> <ff>'.$b[0].'</ff> <span class="f1 fs14">'.$b[1].'</span> )</div>';
			if($rows>0){?>
				<table width="100%" border="0"  class="grad_s holdH" type="static" cellspacing="0" cellpadding="4" over="0" >		
				<tr>
				<th class="fs16 f1">#</th>
				<th class="fs16 f1"><?=k_start_date?></th>
				<th class="fs16 f1"><?=k_status?></th>
				<th class="fs16 f1" width="40"></th>
				</tr> <?
				while($r=mysql_f($res)){
					$id=$r['id'];					
					$status=$r['status'];					
					$time_entr=$r['d_start'];?>
					<tr>
						<td class="ff B fs16"><?=$id?></td>
						<td><ff><?=dateToTimeS3($time_entr);?></ff></td>
						<td><div class="f1"><?=$lab_vis_s[$status]?></div></td>
						<td class="f1"><div class="ic40 icc1 ic40_info" onclick="sw2vis(<?=$id?>)"></div></td>
					</tr><?
				}
				?></table><?
			}else{
				echo '<div class="lh40 f1 fs18 clr5">'.k_no_pat_tests.'</div>';
			}
		}else{
			echo '<div class="lh40 f1 fs18 clr5">'.k_no_results.'</div>';
		}
		echo '<!--***-->'.$page_view;
	}else if($mood==2 || $mood==0){
		$q="status IN(5,6,9)";
		if($mood==2){
			$q=" visit_id='$v_no' ";
		}else{
			if($anaQ){ $q.= ' AND '.$anaQ;}
		}
		if($q2=='' && $mood==0 && $anaQ==''){$q.=" and d_start >".($now-(86400*2))." "; }
		$sql="select * from lab_x_visits_services where $q $q2 order by fast DESC , id DESC $q_limit ";		
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$anasCounts=array();
			if($total> $rows){
				$rows= $rows.' / '.number_format($total);	
			}?>
			<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static">
			<tr><th><?=k_visit_num?></th><th><?=k_test_no?></th><th><?=k_date?></th><th><?=k_patient?></th><th><?=k_analysis?></th><th><?=k_status?></th><th width="150"></th></tr><?
				while($r=mysql_f($res)){
					$s_id=$r['id'];
					$vis_id=$r['visit_id'];
					$patient=$r['patient'];
					$service=$r['service'];
					$d_start=get_val('lab_x_visits','d_start',$vis_id);
					$status=$r['status'];
					$fast=$r['fast'];
					$ana_type=$r['type'];
					$sample_link=$r['sample_link'];
					$fastTxt='';
					if($fast){$fastTxt='<div class="f1 clr5">'.k_emergency.'</div>';}					
					list($ana_name,$ana_type)=get_val('lab_m_services','short_name,type',$service);
					
					if(!array_key_exists($service,$anasCounts)){
						$anasCounts[$service]=getTotalCO('lab_m_services_items'," serv='$service' ");
					}
					?>
					<tr>
					<td><ff>#<?=$vis_id?></ff></td>
					<td><ff>#<?=$s_id?></ff></td>
					<td><ff dir="ltr"><?=date('Y-m-d A h:i:s',$d_start)?></ff></td>
					<td class="f1"><?=get_p_name($patient)?></td>
					<td><? 
					if($anasCounts[$service]==1 && $ana_type==1 && in_array($status,array(5,6,9))){
						?><ff class="clr5 Over" onclick="showLReport(<?=$service?>,4)"><?=hlight($ana,$ana_name).$fastTxt?></ff></td><?
					}else{
						?><ff><?=hlight($ana,$ana_name).$fastTxt?></ff></td><?
					}?>
					<td><div class="f1 fs12" style="color:<?=$anStatus_col[$status]?>"><?=$anStatus[$status]?></div></td>
					<td><?					
					$edtebal=editebalAna($status);
					if($edtebal){	
						echo '<div class="ic40 icc1 ic40_det fl" title="'.k_ent_rep_val.'" onclick="showLReport('.$s_id.',1)"></div>';
						if(($ana_type==1 || $ana_type==4) && $anasCounts[$service]==1){
							echo '<div class="ic40 icc2 ic40_lab_sam fl mg5" title="'.k_sample_reports_enter.'" onclick="showLReport('.$sample_link.',2)"></div>
							<div class="ic40 icc4 ic40_lab_vis fl" title="'.k_vis_reports_enter.'" onclick="showLReport('.$vis_id.',3)"></div>';
						}
					}?>
					</td>
					</tr><?
				}?>
			</table><?

		}else{
			echo '<div class="f1 fs18 lh40 clr5">'.k_no_reports.'</div>';
		}
		/************************************************/
		echo '<!--***-->'.$page_view;
	}	
}?>