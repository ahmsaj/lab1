<? include("../../__sys/prcds/ajax_header.php");?>
<div class="win_body"><?
if(isset($_POST['id'])){
	$id=pp($_POST['id']);?>	
	<div class="form_header f1 fs16 clr1 lh40"><?=k_number_invoice?> <ff> #<?=get_val('str_x_bill','no',$id)?> </ff></div>
	<div class="form_body so"><?
	$shipStatus=get_val('str_x_bill','status',$id);
	$sql="select * from str_x_bill_items s , str_m_items i  where s.item_id=i.id and s.ship_id='$id' order by s.id ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	$strUnits=getItemsUnit();
	if($rows>0){
		echo '
		<table class="grad_s holdH" type="static" width="100%" cellpadding="4" cellspacing="0">
		<tr><th width="30">#</th><th>'.k_item_name.'</th><th>'.k_quantity.'</th><th>'.k_balance.'</th>
		<th>'.k_unit_price.'</th><th>'.k_total.'</th></tr>';		
		$totalAmount=0;
		while($r=mysql_f($res)){
			$s_id=$r['s.id'];
			$item_id=$r['item_id'];
			$pac_quantity=$r['pac_quantity'];
			$quantity=$r['quantity'];
			$qu_balans=$r['qu_balans'];
			$unit_price=$r['unit_price'];
			$price=$r['price'];
			$item_name=$r['name'];
			$unit=$r['i.unit'];
			$pq=explode(',',$pac_quantity);
			if($pac_quantity){				
				$pac_quantity_txt=number_format($pq[1]).' '.$strUnits[$pq[0]].' '.k_with_price.$pq[2];
			}
			if($qu_balans){				
				//$pac_quantity_bal_txt=number_format($pq[1]).' '.$strUnits[$pq[0]];
			}
			echo '<tr>
			<td width="30"><ff>'.($i+1).'</ff></td>
			<td class="f1">'.$item_name.'</td>
			<td class="f1 fs14"><ff>'.number_format($quantity).'</ff> '.$strUnits[$unit].'<div class="f1 clr1">'.splitNo($pac_quantity_txt).'</div></td>
			<td class="f1 fs14"><ff>'.number_format($qu_balans).'</ff> '.$strUnits[$unit].'<div class="f1 clr1">'.splitNo($pac_quantity_bal_txt).'</div></td>
			<td><ff>'.number_format($unit_price,2).'</ff></td>
			<td><ff>'.number_format($price,2).'</ff></td>';			
			echo '</tr>';
			$totalAmount+=$price;
			$i++;
		}
		echo '<tr  bgcolor="#eee"><td class="f1" colspan="5">'.k_total.'</td>			
			<td><ff>'.number_format($totalAmount,2).'</ff></td></tr></table>';
	}
	?>
	</table>
	</div>
	<div class="form_fot fr">
    	<div class="bu bu_t2 fr" onclick="<?=$wlp?>win('close','#m_info');"><?=k_close?></div>        
    </div>
	<?

}?>
</div>