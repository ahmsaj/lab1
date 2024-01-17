<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['fil'] , $_POST['p'])){
	$pars=explode('|',$_POST['fil']);
	$q='';
	$q2='';
	if(in_array($thisGrp,array('7htoys03le','nlh8spit9q'))){$q.=" doctor = '$thisUser' ";}
	foreach($pars as $p){
		if($p!=''){
			$pp=explode(':',$p);
			$cal=$pp[0];
			$val1=$pp[1];
			$val2=$pp[2];			
			if($cal=='p1'){if($q){$q.=" AND ";}$q.="iteme= '$val1' ";}
			if($cal=='p2'){if($q){$q.=" AND ";}$q.="clinic= '$val1' ";}
			if($cal=='p3'){if($q){$q.=" AND ";}$q.="doc= '$val1' ";}
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
			
		}
	}
	if($q2){if($q){$q.=" AND ";}$q.=" ";}
	
	if($q){$q=" where $q ";}
	$sql="select sum(r_qunt)rq from cln_x_services_items  $q  ";
	$res=mysql_q($sql);	
	$r=mysql_f($res);
	$all_total=$r['rq'];

	$pagination=pagination('','',10,$rows); 
	$page_view=$pagination[0];
	$q_limit=$pagination[1];	
	$all_rows=$pagination[2];

	echo ' '.number_format($all_total).' <!--***-->';?>
	 <form name="cons_t" id="cons_t" method="post" action="<?=$f_path?>X/gnr_total-cons_export.php" target="_blank">
     	<input type="hidden" name="pars_cons_t" value="<?=$_POST['fil']?>"/>
     </form>
    <?
	$sql="select sum(r_qunt)rq,iteme,clinic,doc from cln_x_services_items $q group by iteme,clinic,doc ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);	
	if($rows>0){?>
		<table width="100%" border="0"  class="grad_s holdH" type="static" cellspacing="0" cellpadding="4" over="0" >		
      	<tr> 
        <th class="fs16 f1"><?=k_item_code?></th> 
        <th class="fs16 f1"><?=k_item_name?></th>
        <th class="fs16 f1"><?=k_tclinic?></th>
        <th class="fs16 f1"><?=k_doctor?></th>
		<th class="fs16 f1"><?=k_consumption?> </th>
        </tr> <?				
		while($r=mysql_f($res)){
			$item=$r['iteme'];
			$clinc=$r['clinic'];
			$doc=$r['doc'];
			$total_sum=$r['rq'];
			$clinic_name=get_val('gnr_m_clinics','name_'.$lg,$clinc);			
			$doc_name=get_val('_users','name_'.$lg,$doc);
			list($item_name,$item_code)=get_val('str_m_items','name,code',$item);			
			
			if($total_sum!=0){?>
			<tr>
			<td class="ff fs16"><ff><?=$item_code?></ff></td>
            <td class="f1 fs14"><?=$item_name?></td>
            <td class="f1 fs14"><?=$clinic_name?></td>
            <td class="f1 fs14"><?=$doc_name?></td>
            <td class=" fs18 " style=""><ff><?=$total_sum?></ff></td>
			</tr><?
			}
			$i++;
		}
		echo'</tabel>';
	}else{
		echo '<div class="lh40 f1 fs18 clr5">'.k_no_results.'</div>';
	}
	echo '<!--***-->'.$page_view;	
	}
?>

	