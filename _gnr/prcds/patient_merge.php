<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['fil'] , $_POST['p'])){
	$pars=explode('|',pp($_POST['fil'],'s'));
	$q='';
	$doc='';
	foreach($pars as $p){
		if($p!=''){
			$pp=explode(':',$p);
			$cal=$pp[0];
			$val1=$pp[1];
			$val2=$pp[2];
			if($cal=='p1'){$p1=$val1;$q.=" AND id IN($val1)";}
			if($cal=='p2'){$p2=$val1;$q.=" AND f_name like '%$val1%' ";}
			if($cal=='p3'){$p3=$val1;$q.=" AND l_name like '%$val1%' ";}
			if($cal=='p4'){$p4=$val1;$q.=" AND ft_name like '%$val1%' ";}
			if($cal=='p5'){$p5=$val1;$q.=" AND mobile like '%$val1%' ";}
			if($cal=='p6'){$p6=$val1;$q.=" AND phone like '%$val1%' ";}			
			if($cal=='p7'){$p7=$val1;$q.=" AND sex = '$val1' ";}
		}
	};
	if($q){
		$sql="select count(*)c from gnr_m_patients where id>0 $q ";
		$res=mysql_q($sql);
		$r=mysql_f($res);
		$pagination=pagination('','',30,$r['c']); 
		$page_view=$pagination[0];
		$q_limit=$pagination[1];

		echo ' '.$all_rows=$pagination[2].' <!--***-->';
		$sql="select * from gnr_m_patients  where id>0 $q_d1 $q_d5 $q_d6 $q order by 
		f_name ASC , 
		ft_name ASC , 
		l_name ASC 
		$q_limit";
		$res=mysql_q($sql);
		$rows=mysql_n($res);	
		if($rows>0){?>
			<div class="f1 fs16 clr1 lh30"><?=k_only_thrty_results_shown?> </div>
			<div class="f1 fs14 clr1 lh30"><?=k_sel_atleast_two_pats_to_merge?></div>
			<table width="100%" border="0" id="mpat" class="grad_s holdH" type="static" cellspacing="0" cellpadding="4" over="0" >		
			<tr>
			<th width="30"></th>
			<th class="fs16 f1"><?=k_num?></th>
			<th class="fs16 f1"><?=k_full_name?></th>
			<th class="fs16 f1"><?=k_age?></th>
			<th class="fs16 f1"><?=k_mobile?></th>
			<th class="fs16 f1"><?=k_phone?></th>
			<th class="fs16 f1"><?=k_nat_num?></th>
			</tr> <?
			while($r=mysql_f($res)){
				$id=$r['id'];
				$f_name=$r['f_name'];			
				$l_name=$r['l_name'];
				$ft_name=$r['ft_name'];
				$birth_date=$r['birth_date'];
				$mobile=$r['mobile'];
				$phone=$r['phone'];
				$no=$r['no'];
				$birthCount=birthCount($birth_date);
				?><tr>
				<td class="ff B fs16"><input type="checkbox" value="<?=$id?>" name="p_<?=$id?>"/></td>
				<td class="ff B fs16"><?=$id?></td>
				<td class="f1 fs14"><?=hlight($p2,$f_name).' '.hlight($p4,$ft_name).' '.hlight($p3,$l_name)?></td>
				<td class="f1"><div class="fl f1 fs12"><ff><?=$birthCount[0]?> </ff><?=$birthCount[1]?></div></td>
				<td><ff><?=hlight($p5,$mobile)?></ff></td>
				<td><ff><?=hlight($p6,$phone)?></ff></td>
				<td class="f1"><ff><?=$no?></ff></td>
				</tr><?
			}
			?></table>
			<script>loadFormElements('#mpat');</script><?
		}else{
			echo '<div class="lh40 f1 fs18 clr5">'.k_no_results.'</div>';
		}
		echo '<!--***-->'.$page_view;
		
	}else{
		echo number_format(getTotal('gnr_m_patients')).'<!--***-->
		<div class="f1 fs16 clr1">'._info_r1i1bwcvhw.' <ff class="clr5"> 350,465 </ff></div>
		<!--***-->';
	}
}?>