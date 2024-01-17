<? include("../../__sys/prcds/ajax_header.php");?>
<div class="win_body"><?
if(isset($_POST['id'] , $_POST['t'])){
	$id=pp($_POST['id']);
	$t=pp($_POST['t']);
	$title=get_val('str_m_items','name',$id).'<ff> ( '.getItemBal($id).' ) ';	
	?>
	<div class="form_header f1 fs16 clr1 lh40"><?=$title?></div>
	<div class="form_body so"><?	
	if($t==1){
		$sql="select * from str_m_stores  order by part ASC , s_part ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);	
		if($rows>0){ 
			echo '
			<table class="grad_s holdH" type="static" width="100%" cellpadding="4" cellspacing="0">
			<tr><th>'.k_store.'</th><th>'.k_balance.'</th></tr>';
			$totalQu=0;
			while($r=mysql_f($res)){
				$s_id=$r['id'];
				$name=$r['name_'.$lg];
				$type=$r['type'];
				$part=$r['part'];
				$s_part=$r['s_part'];			
				$bal=getItemBal($id,$s_id);
				$totalQu+=$bal;
				if($bal){
					echo '<tr>				
					<td class="f1">'.$name.'</td>					
					<td><ff>'.number_format($bal).'</ff></td></tr>';
				}
			}
			echo '<tr  bgcolor="#eee"><td class="f1">'.k_total.'</td>			
				<td><ff>'.number_format($totalQu).'</ff></td></tr></table>';
		}?>
		</table><? 
	}
	if($t==2){?>
	<table class="grad_s holdH" type="static" width="100%" cellpadding="4" cellspacing="0" over="0">
		<tr><th><?=k_purchases?></th><th><?=k_consumption?></th></tr>
		<tr><td valign="top"><?
		$sql="select * from str_x_bill_items where item_id='$id' order by date DESC ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);	
		if($rows>0){ 
			echo '
			<table class="grad_s holdH" type="static" width="100%" cellpadding="4" cellspacing="0">
			<tr><th>'.k_date.'</th><th>'.k_price.'</th><th>'.k_quantity.'</th><th>'.k_balance.'</th></tr>';			
			$q1=0;
			$q2=0;
			while($r=mysql_f($res)){
				$s_id=$r['id'];				
				$date=$r['date'];
				$quantity=$r['quantity'];
				$unit_price=$r['unit_price'];
				$qu_balans=$r['qu_balans'];				
				$q1+=$quantity;
				$q2+=$qu_balans;
				
				echo '<tr>				
				<td><ff>'.date('Y-m-d',$date).'</ff></td>
				<td><ff>'.number_format($unit_price,2).'</ff></td>
				<td><ff>'.number_format($quantity).'</ff></td>
				<td><ff>'.number_format($qu_balans).'</ff></td>';
			}
			echo '<tr  bgcolor="#eee"><td class="f1">'.k_total.'</td><td></td>		
				<td><ff>'.number_format($q1).'</ff></td><td><ff>'.number_format($q2).'</ff></td></tr></table>';
		}?>
		
		</td><td  valign="top">
		<?		
		$sql="select * from str_m_stores  order by part ASC , s_part ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);	
		if($rows>0){ 
			echo '
			<table class="grad_s holdH" type="static" width="100%" cellpadding="4" cellspacing="0">
			<tr><th>'.k_store.'</th><th>'.k_consumption.'</th></tr>';			
			$totalQu=0;
			while($r=mysql_f($res)){
				$s_id=$r['id'];
				$name=$r['name_'.$lg];
				$type=$r['type'];
				$part=$r['part'];
				$s_part=$r['s_part'];			
				$bal=getItemCons($id,$s_id);
				$totalQu+=$bal;
				if($bal){
					echo '<tr>				
					<td class="f1">'.$name.'</td>					
					<td><ff>'.number_format($bal).'</ff></td></tr>';
				}
			}
			echo '<tr bgcolor="#eee"><td class="f1">'.k_total.'</td>			
				<td><ff>'.number_format($totalQu).'</ff></td></tr></table>';
		}?>
		</table>
		</td></tr>
		</table><?
	}?>
	</div>
	<div class="form_fot fr">
    	<div class="bu bu_t2 fr" onclick="<?=$wlp?>win('close','#m_info');"><?=k_close?></div>        
    </div>
	<?

}?>
</div>