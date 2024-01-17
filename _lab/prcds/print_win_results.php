<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);?>
    <div class="win_body">
    <div class="form_body so" id="lab_print"><?
		$sql="select * , x.id as x_id from lab_m_services z , lab_x_visits_services x where x.service=z.id and x.visit_id='$id' ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){			
			echo '<form id="lp">
			<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">
			<tr><th width="30"><input type="checkbox" par="check_all" value="0" name="a" checked /></th><th>'.k_analysis.'</th><th>'.k_status.'</th></tr>';			
			$rrSrv=0;
			$pkg_ids='';
			$total=0;
			while($r=mysql_f($res)){
				$ser_id=$r['x_id'];
				$ser_name=$r['short_name'];
				$status=$r['status'];
				$pay_net=$r['pay_net'];						
				$sample_type=$r['sample'];
				$total+=$pay_net;
				$a_opers='';				
				if($status==1){$a_opers=$printButt;}
				echo '<tr>
				<td>';
				if(in_array($status,array(1,8,10))){
					echo '<input type="checkbox" par="grd_chek" name="al_'.$ser_id.'" value="'.$ser_id.'" checked/>';
				}else{echo '-';}
				
				echo '</td>
				<td class="ff fs16 B lh30">'.$ser_name.'</td>			
				<td><div class="f1" style="color:'.$anStatus_col[$status].'">'.$anStatus[$status].'</div></td>
				</tr>';
			}					
			echo '</table></form>';					
		}?>

    </div>
    <div class="form_fot fr">
        <div class="bu bu_t3 fl" onclick="printAnCostom(2);"><?=k_print?></div>
		<!--<div class="bu bu_t3 fl" onclick="printAnCostom(3);">PDF</div>-->
        <div class="bu bu_t2 fr" onclick="win('close','#m_info');showAnaToDelv(<?=$id?>);"><?=k_close?></div>
    </div>
    </div><? 
}?>
