<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['fil'] , $_POST['p'])){
	$pars=explode('|',pp($_POST['fil'],'s'));
	$q='';
	$q_p=$q_p2='';
	foreach($pars as $p){
		if($p!=''){
			$pp=explode(':',$p);
			$cal=$pp[0];
			$val1=$pp[1];
			$val2=$pp[2];
			if($cal=='p2'){$q_p.=" id = '$val1' ";}
			if($cal=='p3'){if($q_p){$q_p.=" AND ";}$q_p.=" f_name like '%$val1%' ";}
			if($cal=='p4'){if($q_p){$q_p.=" AND ";}$q_p.=" l_name like '%$val1%' ";}
			if($cal=='p5'){if($q_p){$q_p.=" AND ";}$q_p.=" ft_name like '%$val1%' ";}
		}
	}
	$doc_q='';
	if($q_p){
		$q_p=" where patient IN(select id from gnr_m_patients where $q_p )";
	}	
	$res=mysql_q("select count(*)c from gnr_m_patients_balance $q_p ");
	$r=mysql_f($res);
	$pagination=pagination('','',25,$r['c']); 
	$page_view=$pagination[0];
	$q_limit=$pagination[1];	
	echo ' '.$all_rows=$pagination[2].' <!--***-->';
	$sql="select * from gnr_m_patients_balance $q_p  $q_limit";
	$res=mysql_q($sql);
	$rows=mysql_n($res);	
	if($rows>0){?>
		<table width="100%" border="0"  class="grad_s holdH" type="static" cellspacing="0" cellpadding="4" over="0" >
		<tr>
		<th class="fs16 f1" width="80"><?=k_pat_num?></th>
        <th class="fs16 f1"><?=k_patient?></th>
		<th class="fs16 f1"><?=k_val_srvs?></th>
		<th class="fs16 f1"><?=k_comp_srv_val?></th>
 		<th class="fs16 f1"><?=k_payms?></th>
		<th class="fs16 f1"><?=k_balance?></th>
        <th class="fs16 f1" width="40"></th>
        </tr> <?
		while($r=mysql_f($res)){			
			$doctor=$r['doctor'];		
			$patient=$r['patient'];
			$den_pay=$r['den_pay'];
			$den_service=$r['den_service'];
			$den_service_done=$r['den_service_done'];
			$den_balance=$r['den_balance'];
			$balanc_col='clr1';
			if($den_balance<0){$balanc_col='clr6';}
			if($den_balance>0){$balanc_col='clr5';}
			?><tr>						
            <td class="f1"><ff><?=$patient?></ff></td>
            <td class="f1"><?=get_p_name($patient)?></td>
			<td><ff class="clr9"><?=number_format($den_service)?></ff></td>
			<td><ff class="clr1"><?=number_format($den_service_done)?></ff></td>
			<td><ff class="clr1"><?=number_format($den_pay)?></ff></td>
			<td><ff class="<?=$balanc_col?>"><?=number_format($den_balance)?></ff></td>
			<td class="f1"><div class="ic40 icc1 ic40_info" onclick="accStat(<?=$patient?>)"></div></td>
			</tr><?
		}		
	}else{
		echo '<div class="lh40 f1 fs18 clr5">'.k_no_results.'</div>';
	}
	echo '<!--***-->'.$page_view;	
	}
?>

	