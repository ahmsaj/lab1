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
			if($cal=='p1'){$q.=" AND ";$q.="id = '$val1' ";}
			if($cal=='p2'){$q.=" AND ";$q.="f_name like '%$val1%' ";}
			if($cal=='p3'){$q.=" AND ";$q.="l_name like '%$val1%' ";}
			if($cal=='p4'){$q.=" AND ";$q.="ft_name like '%$val1%' ";}
			if($cal=='p5'){$q.=" AND ";$q.="sex = '$val1' ";}
			if($cal=='p6'){$doc=$val1;}
			/*if($cal=='p5'){				
				if($val1 && $val2){
					$val11=date('U',strtotime($val1));
					$val22=date('U',strtotime($val2));
					
					if($val11 <= $val22){
						$val22+=86400;
						$q.=" AND c.date >= '$val11' AND c.date <= '$val22' ";
					}else{						
						$val11+=86400;
						$q.=" AND c.date >= '$val22' AND c.date <= '$val11' ";
					}
					
				}else{
					if($val1){$val11=date('U',strtotime($val1));$q.=" AND c.date >= '$val11' ";}
					if($val2){$val22=date('U',strtotime($val2))+86400;$q.=" AND c.date <= '$val22' ";}
				}
			}*/
		}
	}
	$q_doc='';
	$docType=1;
	if($thisGrp=='hrwgtql5wk'){		
		if($doc){
			$docGrp=get_val('_users','grp_code',$doc);			
			if($docGrp=='7htoys03le'){
				$docType=1;
				$q_doc="and id IN(select patient from cln_x_visits where doctor='$doc' )";
			}
			if($docGrp=='nlh8spit9q'){
				$docType=3;
				$q_doc="and id IN(select patient from cln_x_visits where doctor='$doc' )";
			}
			if($thisGrp=='fk590v9lvl'){
				$docType=4;
				$q_doc="and id IN(select patient from den_x_visits where doctor='$doc' )";
			}
			if($docGrp=='9yjlzayzp'){
				$docType=5;
				$q_doc="and id IN(select patient from bty_x_visits where doctor='$doc' )";
			}
			if($docGrp=='66hd2fomwt'){
				$docType=6;
				$q_doc="and id IN(select patient from bty_x_laser_visits where doctor='$doc' )";
			}
			if($thisGrp=='9k0a1zy2ww'){
				$docType=7;
				$q_doc="and id IN(select patient from osc_x_visits where doctor='$doc' )";
			}
		}
	}else{
		if($thisGrp=='7htoys03le'){
			$docType=1;
			$q_doc="and id IN(select patient from cln_x_visits where doctor='$thisUser' )";
		}
		if($thisGrp=='nlh8spit9q'){
			$docType=3;
			$q_doc="and id IN(select patient from cln_x_visits where doctor='$thisUser' )";
		}
		if($thisGrp=='fk590v9lvl'){
			$docType=4;
			$q_doc="and id IN(select patient from den_x_visits where doctor='$thisUser' )";
		}
		if($thisGrp=='9yjlzayzp'){
			$docType=5;
			$q_doc="and id IN(select patient from bty_x_visits where doctor='$thisUser' )";
		}
		if($thisGrp=='66hd2fomwt'){
			$docType=6;
			$q_doc="and id IN(select patient from bty_x_laser_visits where doctor='$thisUser' )";
		}
		if($thisGrp=='9k0a1zy2ww'){
			$docType=7;
			$q_doc="and id IN(select patient from osc_x_visits where doctor='$thisUser' )";
		}
	}
	$sql="select count(*)c from gnr_m_patients where id>0 $q_doc $q ";
	$res=mysql_q($sql);
	$r=mysql_f($res);
	$pagination=pagination('','',10,$r['c']); 
	$page_view=$pagination[0];
	$q_limit=$pagination[1];
	
	echo ' '.$all_rows=$pagination[2].' <!--***-->';
	$sql="select * from gnr_m_patients  where id>0 $q_doc $q $q_limit";
	$res=mysql_q($sql);
	$rows=mysql_n($res);	
	if($rows>0){?>
		<table width="100%" border="0"  class="grad_s holdH" type="static" cellspacing="0" cellpadding="4" over="0" >		
		<tr>
       	<th class="fs16 f1"><?=k_num?></th>
        <th class="fs16 f1"><?=k_full_name?></th>
		<th class="fs16 f1"><?=k_mobile?></th>
        <th class="fs16 f1"><?=k_age?></th>
        <th class="fs16 f1" width="40"></th>
        </tr> <?
		while($r=mysql_f($res)){
			$id=$r['id'];
			$f_name=$r['f_name'];			
			$l_name=$r['l_name'];
			$ft_name=$r['ft_name'];
			$birth_date=$r['birth_date'];
			$mobile=$r['mobile'];
			$birthCount=birthCount($birth_date);
			?><tr>
			<td class="ff B fs16"><?=$id?></td>
			<td class="f1 fs14"><?=$f_name.' '.$ft_name.' '.$l_name?></td>
			<td><ff><?=$mobile?></ff></td>
			<td class="f1"><div class="fl f1 fs12"><ff><?=$birthCount[0]?> </ff><?=$birthCount[1]?></div></td>
			<td class="f1"><div class="info_icon" onclick="loadHistory(<?=$id?>,<?=$docType?>)"></div></td>
			</tr><?
		}		
	}else{
		echo '<div class="lh40 f1 fs18 clr5">'.k_no_results.'</div>';
	}
	echo '<!--***-->'.$page_view;	
	}
?>

	