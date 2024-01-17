<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$vis=pp($_POST['id']);
	$c_type=pp($_POST['t']);
    $m_table=$visXTables[$c_type];
    $m_table2=$srvXTables[$c_type];
    $m_table3=$srvTables[$c_type];
	$sql="select * from $m_table where id='$vis' ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$doctor=$r['doctor'];
		$patient=$r['patient'];
		if($c_type==2){$clinic=get_val_c('gnr_m_clinics','id',2,'type');}else{$clinic=$r['clinic'];}
		$type=$r['type'];
		$d_start=$r['d_start'];
		$d_check=$r['d_check'];
		$d_finish=$r['d_finish'];
		$pay_type=$r['pay_type'];
		$status=$r['status'];
		?>
		<div class="win_body">
		<div class="form_header">
			<div class="fl f1 fs16 clr1 lh40"><?=get_p_name($patient)?></div>
            <div class="fr ff B fs20  lh40">#<?=$vis?></div>
        </div>
        <div class="form_body so"><?
			if($c_type==6){
				echo '<div class="f1 fs16 clr5 lh50 ">هل تود إلغاء الخدمة</div>';
			}else{
            if($status<2){
				echo '<div class="f1 fs14 lh40">'.k_inf_ent_snc.' : <ff>'.dateToTimeS2($now-$d_start).'</ff></div>';
				$sql="select * from $m_table3 z, $m_table2 x where z.id=x.service and x.visit_id='$vis' order by z.ord ASC";
				if($c_type!=4 && $c_type!=2){
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					if($rows>0){
						?>
						<table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s" over="0">
						<tr><th><?=k_service?></th><th width="80"><?=k_price?></th>
						<?
						$pay_net_totoal=0;
						while($r=mysql_f($res)){
							$s_id=$r['id'];
							$name=$r['name_'.$lg];
							$pay_net=$r['pay_net'];
							$pay_net_totoal+=$pay_net;
							echo '<tr>						
							<td class="f1">'.$name.'</td>
							<td><ff>'.number_format($pay_net).'<ff></td>
							</tr>';
						}?>
							<tr bgcolor="#f5f5f5">			
							<td class="f1"><?=k_amnt_rtrnd?></td>
							<td><ff><?=number_format($pay_net_totoal)?><ff></td>
							</tr>
						</table><?
					}
				}else if($c_type==2){
					$payIN=get_sum('gnr_x_acc_payments','amount'," vis='$vis' and mood='2' and type IN(1,2,7,11) ");
					$payOUT=get_sum('gnr_x_acc_payments','amount'," vis='$vis' and mood='2' and type IN(3,4) ");
					$amount=$payIN-$payOUT;					
					echo '<div class="f1 fs16 clr5 lh30 ">المبلغ الواجب إرجاعه  : <ff>'.$amount.'</ff> '.k_sp.'</div>';
				}else{
					//if($type==1){
						$amount=get_sum('gnr_x_acc_payments','amount'," `vis`='$vis' and `type`='1' and mood='$c_type' ");
						echo '<div class="f1 fs16 clr5 lh30 ">قيمة الاستشارة : <ff>'.$amount.'</ff> '.k_sp.'</div>';
					//}
				}
			}
			if($status==2){				
				echo '<div class="f1 fs16">'.k_prv_cmpt_snc.' : <ff>'.dateToTimeS2($now-$s_start).'</ff></div>';
			}
			}?>
		</div>
		<div class="form_fot fr">
		    <div class="bu bu_t2 fr" onclick="win('close','#m_info2');"><?=k_close?></div>
			<? if($c_type==6){
				?><div class="bu bu_t3 fl w-auto" onclick="v_back_do(<?=$vis?>,<?=$c_type?>);"><?=k_delete?></div><?
			}else{?>
            	<div class="bu bu_t1 fl w-auto" onclick="v_back_do(<?=$vis?>,<?=$c_type?>);"><?=k_rfnd_md?></div>
			<? }?>
		</div>
		</div><?
	}else{echo '<div class="f1 fs14 clr5 lh40">'.k_nvis_num.' '.$vis.'</div>';}
}
?>