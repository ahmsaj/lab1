<? include("../../__sys/prcds/ajax_header.php");if(isset($_POST['fil'] , $_POST['p']) ||isset($_POST['vis']) || isset($_POST['pat'])){
	echo '<!--***-->';
	$pvl=pp($_POST['fil'],'s');
	$pars=explode('|',$pvl);
	$q='';	
	$s_no=0;
	$mood=0;
	$anaQ='';
	foreach($pars as $p){
		if($p!=''){
			$pp=explode(':',$p);
			$cal=$pp[0];
			$val1=$pp[1];
			$val2=$pp[2];
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
	if($mood==2){
		echo '<div class="f1 fs18 lh40 clr1 uLine ">'.k_visit_num.' <ff> ( '.$v_no.' )</ff></div>';
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
		echo '<div class="f1 fs18 lh40 clr1 uLine ">'.k_num_pats.'  <ff> ( '.number_format($total).' )</ff></div>';
		
	}else{
		$q="status IN(6,7,10)";
		if($anaQ){ $q.= ' AND '.$anaQ;}
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
	if($mood==3 || $mood==4){		
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
		$q="status IN(6,7,10)";
		if($mood==2){
			$q=" visit_id='$v_no' ";
		}else{
			if($anaQ){ $q.= ' AND '.$anaQ;}
		}
		$anasCounts=array();
		//echo $sql="select * from lab_x_visits_services where $q order by fast DESC , id DESC $q_limit ";
		$sql="select * , x.id as x_id , x.fast as x_fast from  lab_x_visits_services x , lab_m_services z where x.service=z.id and $q $q2 order by x.fast DESC , x.id ASC  $q_limit ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			if($total> $rows){
				$rows= $rows.' / '.number_format($total);	
			}
			echo '
			<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static">
			<tr><th>'.k_visit_num.'</th><th>'.k_analysis.'</th><th>'.k_patient.'</th><th>'.k_tester.'</th><th>'.k_status.'</th><th width="30"></th></tr>';
			while($r=mysql_f($res)){
				$id=$r['x_id'];
				$visit_id=$r['visit_id'];
				$report_wr=$r['report_wr'];
				$service=$r['service'];
				$status=$r['status'];
				$fast=$r['x_fast'];
				$ana_type=$r['type'];
				$ser_name=$r['short_name'];
				
				if(!array_key_exists($service,$anasCounts)){
					$anasCounts[$service]=getTotalCO('lab_m_services_items'," serv='$service' ");
				}
				$fastTxt='';
				if($fast){$fastTxt='<br><span class="f1 font10 clr5"> ( '.k_emergency.' ) </span>';}
				$p_id=get_val('lab_x_visits','patient',$visit_id);
				$colr=1;
				$opr='';
				if($status==7){$colr=4;}
				if($status==7 || $status==6 || $status==10){
					$opr='<div class="fl ic40 icc'.$colr.' ic40_info	" ';
					if($s_status==0){$opr.= ' onclick="reviweRep('.$id.',1)" ';}
					$opr.= '></div>';
				}
				echo '<tr>
				<td class="ff fs16 B">#'.$visit_id.'</div>
				<td class="ff fs16 B">';
				if($anasCounts[$service]==1 && $ana_type==1){
					echo '<ff class="clr5 Over" onclick="reviweRep('.$service.',2)">'.hlight($ana,$ser_name).$fastTxt.'</ff></td>';
				}else{
					echo '<ff>'.hlight($ana,$ser_name).$fastTxt.'</ff></td>';
				}
				echo '<td class="f1">'.get_p_name($p_id).'</td>
				<td class="f1">'.get_val('_users','name_'.$lg,$report_wr).'</td> 		
				<td ><div class="f1 fs12" style="color:'.$anStatus_col[$status].'">'.$anStatus[$status].'</div></td>
				<td>'.$opr.'</td>
				</tr>';
			}		
			echo '</table>';

		}else{
			echo '<div class="f1 fs18 lh40 clr5">'.k_no_results.'</div>';
		}
		/************************************************/
		echo '<!--***-->'.$page_view;
	}	
}?>