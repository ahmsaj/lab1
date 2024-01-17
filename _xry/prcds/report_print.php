<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['fil'] , $_POST['p'])){
	$pvl=pp($_POST['fil'],'s');
	$pars=explode('|',$pvl);
	$q='';
	$q2='';
	if(in_array($thisGrp,array('nlh8spit9q'))){$q.=" (doctor = '$thisUser' or ray_tec='$thisUser') ";}	
	//if(in_array($thisGrp,array('1ceddvqi3g'))){$q.=" ray_tec = '$thisUser' and doctor =0 ";}
	foreach($pars as $p){
		if($p!=''){
			$pp=explode(':',$p);
			$cal=$pp[0];
			$val1=$pp[1];
			$val2=$pp[2];			
			if($cal=='p2'){if($q2){$q2.=" AND ";}$q2.="f_name like '%$val1%' ";}
			if($cal=='p3'){if($q2){$q2.=" AND ";}$q2.="ft_name like '%$val1%' ";}
			if($cal=='p4'){if($q2){$q2.=" AND ";}$q2.="l_name like '%$val1%' ";}			
			if($cal=='p5'){if($q2){$q2.=" AND ";}$q2.=" sex = '$val1' ";}
			if($cal=='d1'){
				if($val1){
					if($q){$q.=" AND ";}
					$q.=" date > ". strtotime($val1);
				}
				if($val2){
					if($q){$q.=" AND ";}
					$q.=" date < ".(strtotime($val2)+86400);
				}
			}
			
			if($cal=='p6'){if($q){$q.=" AND ";}$q.=" doc = '$val1' ";}
			if($cal=='p7'){if($q){$q.=" AND ";}$q.=" ray_tec='$val1' ";}
			
		}
	}
	if($q2){if($q){$q.=" AND ";}
	$q.=" patient IN( select id from gnr_m_patients where $q2 ) ";}
	
	if($q){$q=" where $q ";}
	$sql="select count(*)c from xry_x_pro_radiography_report  $q ";
	$res=mysql_q($sql);
	$r=mysql_f($res);
	$pagination=pagination('','',10,$r['c']); 
	$page_view=$pagination[0];
	$q_limit=$pagination[1];	
	$all_rows=$pagination[2];
	echo ' '.number_format($all_rows).' <!--***-->';
	$sql="select * from xry_x_pro_radiography_report $q order by date DESC $q_limit";
	$res=mysql_q($sql);
	$rows=mysql_n($res);	
	if($rows>0){?>
		<table width="100%" border="0"  class="grad_s holdH" type="static" cellspacing="0" cellpadding="4" over="0" >		
		<tr>
       	<th class="fs16 f1">#</th>
		<th class="fs16 f1"><?=k_date?></th>
        <th class="fs16 f1"><?=k_patient?></th>         
        <th class="fs16 f1"><?=k_dr?></th>        
        <th class="fs16 f1" width="40"></th>
        </tr> <?
		$cType=3;
		while($r=mysql_f($res)){
			$id=$r['id'];
			$doc=$r['doc'];
			$ray_tec=$r['ray_tec'];
			$patient=$r['patient'];
			$date=$r['date'];
			?><tr>
			<td class="ff B fs16"><?=$id?></td>
			<td class="f1 ff B fs14"><?=date('Y-m-d Ah:i',$date);?></td>
			<td class="f1"><?=get_p_name($patient)?></td>            
            <td class="f1"><?=get_val('_users','name_'.$lg,$doc);
			if($ray_tec){echo '<div class="f1 clr1">'.k_technician.' : '.get_val('_users','name_'.$lg,$ray_tec).'</div>';}?></td>
			<td class="f1">
			<div class="ic40 icc2 ic40_print" onclick="x_report_print(<?=$id?>)"></div>
			</td>
			</tr><?
		}		
	}else{
		echo '<div class="lh40 f1 fs18 clr5">'.k_no_results.'</div>';
	}
	echo '<!--***-->'.$page_view;	
	}
?>
