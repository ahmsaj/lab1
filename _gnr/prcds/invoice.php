<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['fil'] , $_POST['p']) ||isset($_POST['vis']) || isset($_POST['pat'])){
	$pvl=pp($_POST['fil'],'s');
	$pars=explode('|',$pvl);
	$q='';	
	$v_no=0;
	$mood=0;
	foreach($pars as $p){
		if($p!=''){
			$pp=explode(':',$p);
			$cal=$pp[0];
			$val1=$pp[1];
			$val2=$pp[2];
			if($cal=='v1'){$mood=1;$v_no=$val1;}
			if($mood!=1){
				if($cal=='p1'){$mood=2;$p_no=$val1;}
				if($mood!=2){
					if($cal=='p2'){if($q){$q.=" AND ";}$q.="f_name like '%$val1%' ";}
					if($cal=='p3'){if($q){$q.=" AND ";}$q.="ft_name like '%$val1%' ";}
					if($cal=='p4'){if($q){$q.=" AND ";}$q.="l_name like '%$val1%' ";}
				}
			}
		}
	}
	
	if($q){$q=" where $q "; $mood=3;}	
	if($mood==0){
		echo '<!--***-->
		<div class="f1 fs14 clr5 lh30">'.k_notes.' : </div>
		<div class="f1 fs14 clr1 lh20">'.k_num_search_fields_ignored.'</div>
		<div class="f1 fs14 clr1 lh20">'.k_pat_search_fields_ignored.'</div>
		';		
	}
	$patMood=0;
	$typeAct=0;
	if($mood==2 || $mood==1){
		echo '<!--***-->';
		if($mood==2){
			if(getTotalCO('gnr_m_patients',"id='$p_no'")>0){
				$q=" where patient='$p_no' ";
				$patMood=1;
			}else{
				echo '<div class="f1 fs18 clr5 hl40">'.k_no_patient_number.' <ff> ( '.$p_no.' ) </ff></div>';
			}
		}else{
			$vv_no=explode('-',$v_no);
			if(count($vv_no)==2){$v_no=$vv_no[1];$typeAct=$vv_no[0];}
			$q=" where id='$v_no' ";
		}				
		$res=array();
		$rows=array();
		$allRows=0;
		for($i=1;$i<=7;$i++){
			
			if($typeAct==0 || $typeAct==$i){
				$table=$visXTables[$i];
				// if($q){$q=" where $q ";}
				$sql="select * from $table $q order by d_start DESC ";			
				$res[$i]=mysql_q($sql);
				$rows[$i]=mysql_n($res[$i]);
				$allRows+=$rows[$i];
			}
		}
		if($patMood){
			$patInfo=getPatInfo($p_no);
			echo '
			<div class="lh40 fs16 f1s clr1 ws uLine" >'.$patInfo['n'].' (	<span class="f1 fs16 clr1111"> '.$patInfo['s'].' </span> 	'.$patInfo['b'].' )</div>';
		}
		if($allRows){?>
			<table width="100%" border="0"  class="grad_s holdH" type="static" cellspacing="0" cellpadding="4" over="0" >		
				<tr>
				<th class="fs16 f1">#</th>
				<th class="fs16 f1">القسم</th>
				<? if($patMood==0){?><th class="fs16 f1"><?=k_patient?></th><?}?>
				<th class="fs16 f1"><?=k_start_date?></th>
				<th class="fs16 f1"><?=k_status?></th>
				<th class="fs16 f1" width="40"></th>
				</tr> <?
				for($i=1;$i<=7;$i++){
					if($typeAct==0 || $typeAct==$i){
						while($r=mysql_f($res[$i])){
						$id=$r['id'];					
						$status=$r['status'];
						$d_start=$r['d_start'];						
						$pay_type=$r['pay_type'];
						$patient=$r['patient'];
						$visType='';
						if($pay_type){$visType='<span class="f1 clr5"> ( '.$pay_types[$pay_type].' )</span>';}?>
						<tr>
							<td class="ff B fs16"><?=$id?></td>
							<td class="fs16 f1"><?=$clinicTypes[$i].$visType?></td>
							<? if($patMood==0){?><td class="fs16 f1"><?=get_p_name($patient)?></td><?}?>
							<td><ff><?=dateToTimeS3($d_start);?></ff></td>
							<td><div class="f1" style="color:<?=$stats_arr_col[$status]?>"><?=$stats_arr[$status]?></div></td>
							<td class="f1"><div class="ic40 icc1 ic40_print" onclick="print_inv(<?=$id?>,<?=$i?>)"></div></td>
						</tr><?
					}
					}
				}
			?></table><?
		}else{
			if($patMood){
				echo '<div class="lh40 f1 fs18 clr5">'.k_pat_no_visits.'</div>';
			}else{
				echo '<div class="lh40 f1 fs18 clr5">'.k_no_results.'</div>';
			}
		}
		
	}
	
	if($mood==3){		
		$res=mysql_q("select count(*)c from gnr_m_patients  $q ");
		$r=mysql_f($res);
		$pagination=pagination('','',10,$r['c']);
		$page_view=$pagination[0];
		$q_limit=$pagination[1];	
		$all_rows=$pagination[2];
		echo ' '.number_format($all_rows).' <!--***-->';
		$sql="select * from gnr_m_patients $q order by id DESC $q_limit";
		$res=mysql_q($sql);
		$rows=mysql_n($res);	
		if($rows>0){?>
			<table width="100%" border="0"  class="grad_s holdH" type="static" cellspacing="0" cellpadding="4" over="0" >		
			<tr>
			<th class="fs16 f1">#</th>
			<th class="fs18 f1"><?=k_patient?></th>			
			<th class="fs16 f1"><?=k_status?></th>
			<th class="fs16 f1" width="40"></th>
			</tr> <?
			while($r=mysql_f($res)){
				$p_id=$r['id'];
				$f_name=$r['f_name'];
				$l_name=$r['l_name'];
				$ft_name=$r['ft_name'];
				$time_entr=$r['d_start'];
				$con=intval(get_val('gnr_m_patients_evaluation','visits',$p_id));
				if($con!=''){
					$satusT='<div class="f1 fs16 clr6">'.k_vis_no.' <ff> ( '.$con.' ) </ff></div>';
				}else{
					$satusT='<div class="f1 fs14 clr5">'.k_pat_no_visits.'</div>';
				}
				?><tr>
				<td class="ff B fs16"><?=$p_id?></td>
				<td class="f1"><?=$f_name.' '.$ft_name.' '.$l_name?></td>
				<td class="f1"><?=$satusT?></td>
				<td class="f1"><div class="ic40 icc1 ic40_info" onclick="serSelPat(<?=$p_id?>)"></div></td>
				</tr><?
			}		
		}else{
			echo '<div class="lh40 f1 fs18 clr5">'.k_no_results.'</div>';
		}
	}
	echo '<!--***-->'.$page_view;
}?>