<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['fil'] , $_POST['p']) ||isset($_POST['vis']) || isset($_POST['pat'])){
	$pvl=pp($_POST['fil'],'s');
	$pars=explode('|',$pvl);
	$q='';	
	$v_no=0;
	$mood=0;
	if(isset($_POST['vis'])){
		$v_no=pp($_POST['vis']);		
		$mood=1;
	}else if(isset($_POST['pat'])){
		$p_no=pp($_POST['pat']);
		$mood=2;
	}else{
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
						if($cal=='p5'){if($q){$q.=" AND ";}$q.=" sex = '$val1' ";}
					}
				}
			}
		}
		if($q){$q=" where $q "; $mood=3;}
	}
	if($mood==0){
		echo '<!--***-->
		<div class="f1 fs14 clr5 lh30">'.k_notes.' : </div>
		<div class="f1 fs14 clr1 lh20">'.k_num_search_fields_ignored.'</div>
		<div class="f1 fs14 clr1 lh20">'.k_pat_search_fields_ignored.'</div>
		';
		
	}
	if($mood==1){
		$vv=explode('-',$v_no);
		if(count($vv)==2){$v_no=$vv[1];}
		echo '<!--***-->';
		$v_no=intval($v_no);
		$sql="select * from lab_x_visits where id='$v_no' ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);			
		if($rows>0){
			$r=mysql_f($res);
			$doctor=$r['doctor'];
			$patient=$r['patient'];			
			$v_status=$r['status'];
			$reg_user=$r['reg_user'];
			$print=$r['print'];
			?>				
			<div class="fl f1s fs16 lh40 Over" onclick="showPatToDelv(<?=$patient?>)"><ff>#<?=$v_no?> | </ff><?=get_p_name($patient)?>
			</div>
			<br>
			<?
			function getIntMobile($mobile,$code='963'){
				if($mobile){
					if(substr($mobile,0,1)==0){$mobile=substr($mobile,1);}
					if($mobile){$mobile=$code.$mobile;}
				}
				return $mobile;
			}
			$mobile=get_val('gnr_m_patients','mobile',$patient);
			$modD=getIntMobile($mobile);
			if($modD){
				$text=_info_7dvjz4qg9g;
				$url='https://api.whatsapp.com/send?phone='.$modD.'&text='.$text.'&source=&data=';
				echo '<a target="blanck" href="'.$url.'" class="pd10 clr6"><div class="bu bu_t4 fl cb">WhatsApp</div></a>';
			
			}?>
			<div class="ic40 icc1 ic40_ref fr" title="<?=k_refresh?>" onclick="showAnaToDelv(<?=$v_no?>)"></div>
			<div class="fr ff B fs20  lh40"></div>
			<div class="uLine cb"></div><?	
			$Vbal=get_visBal($v_no);
			echo '<div class="f1 fs18 clr1 lh30 fl">'.$lab_vis_s[$v_status];
			if($Vbal){
				echo '<div class=" f1 fs16 clr5 lh30">'.k_rmning_amnt_pd.' <ff>( '.$Vbal.' )</ff></div>';
			}else{
				echo '<div class="f1 fs16 clr6 lh30">'.k_val_tst_pd.'</div>';				
			}
			echo '</div>';
			$sql="select * , x.id as xid from lab_m_services z , lab_x_visits_services x where x.service=z.id and x.visit_id='$v_no' ";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){					
				if($rows>1 && $Vbal==0){						
					//echo '<div class="ic40 icc2 iconPrint fr" title="'.k_custm_prnt.'" onclick="customPrint('.$v_no.')"><div>'.$print.'</div></div>';
					$printClr='bu_t3';
					if($print){$printClr='bu_t4';}
					echo '<div class="bu buu '.$printClr.' fr" onclick="customPrint('.$v_no.')">'.k_custm_prnt.'<ff> ( '.$print.' ) </ff></div>';	
				}
				if((getTotalCO('lab_x_visits_services'," visit_id ='$v_no' and status=8") || $v_status!=2) && $Vbal==0){
					echo '<div class="ic40 icc4 iconDelv fr" onclick="lRepDlv(2,'.$v_no.',0)" title="'.k_sub_all_results.'"></div>';
				}
				echo '
				<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">
				<tr><th>'.k_sample.'</th><th>'.k_analysis.'</th><th>'.k_status.'</th><th width="100">'.k_operations.'</th></tr>';					
				$rrSrv=0;
				$pkg_ids='';
				$total=0;
				while($r=mysql_f($res)){
					$ser_id=$r['xid'];
					$ser_name=$r['short_name'];
					$status=$r['status'];
					$pay_net=$r['pay_net'];						
					$sample_type=$r['sample'];
					$sample_link=$r['sample_link'];
					$total+=$pay_net;
					$a_opers='';
					$printButt='<div class="ic40 icc1 iconPrint fr" title="'.k_print.'" onclick="printLabRes(1,'.$ser_id.')"></div>';
					if($status==8 && $Vbal==0){
						$a_opers=$printButt.'<div class="ic40 icc1 iconDelv fr" onclick="lRepDlv(1,'.$ser_id.','.$v_no.')" title="'.k_dlivrd.'"></div>';
					}
					if($status==1 && $Vbal==0){$a_opers=$printButt;}
					echo '<tr>
					<td class="ff fs16 B lh30">'.get_val('lab_x_visits_samlpes','no',$sample_link).'</td>
					<td class="ff fs16 B lh30">'.$ser_name.'</td>											
					<td><div class="f1" style="color:'.$anStatus_col[$status].'">'.$anStatus[$status].'</div></td>
					<td>'.$a_opers.'</td>
					</tr>';
				}					
				echo '</table>';
			}
		}else{ echo '<div class="f1 fs18 clr5 hl40">'.k_nvis_num.' <ff> ( '.$v_no.' ) </ff></div>';}
		
	}
	if($mood==2){		
		if(getTotalCO('gnr_m_patients',"id='$p_no'")>0){			
			$sql="select * from lab_x_visits where patient='$p_no' order by d_start DESC ";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			$patInfo=getPatInfo($p_no);
			echo '<!--***-->';
			echo '<div class="lh40 fs16 f1s clr1 ws uLine" >'.$patInfo['n'].' (	<span class="f1 fs16 clr1111"> '.$patInfo['s'].' </span> '.$patInfo['b'].' )</div>';
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
						<td class="f1"><div class="ic40 icc1 ic40_info" onclick="showAnaToDelv(<?=$id?>)"></div></td>
					</tr><?
				}
				?></table><?
			}else{
				echo '<div class="lh40 f1 fs18 clr5">'.k_no_pat_tests.'</div>';
			}
		}else{
			echo '<!--***--><div class="f1 fs18 clr5 hl40">'.k_pat_num_exist.' <ff> ( '.$p_no.' ) </ff></div>';
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
			<th class="fs16 f1"><?=k_patient?></th>			
			<th class="fs16 f1"><?=k_status?></th>
			<th class="fs16 f1" width="40"></th>
			</tr> <?
			while($r=mysql_f($res)){
				$p_id=$r['id'];
				$f_name=$r['f_name'];
				$l_name=$r['l_name'];
				$ft_name=$r['ft_name'];
				$time_entr=$r['d_start'];
				$con=getTotalCO('lab_x_visits'," patient='$p_id' ");
				if($con){
					$satusT='<div class="f1 fs16 clr6">'.k_vis_no.' <ff> ( '.$con.' ) </ff></div>';
				}else{
					$satusT='<div class="f1 fs16 clr5">'.k_pat_no_visits.'</div>';
				}
				?><tr>
				<td class="ff B fs16"><?=$p_id?></td>
				<td class="f1"><?=$f_name.' '.$ft_name.' '.$l_name?></td>
				<td class="f1"><?=$satusT?></td>
				<td class="f1"><? if($con){?><div class="ic40 icc1 ic40_info" onclick="showPatToDelv(<?=$p_id?>)"></div><? }?></td>
				</tr><?
			}		
		}else{
			echo '<div class="lh40 f1 fs18 clr5">'.k_no_results.'</div>';
		}
	}
	echo '<!--***-->'.$page_view;
}?>