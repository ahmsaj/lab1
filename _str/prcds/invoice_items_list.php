<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$shipStatus=get_val('str_x_bill','status',$id);
	$sql="select * , s.id as sid from str_x_bill_items s , str_m_items i  where s.item_id=i.id and s.ship_id='$id' order by s.id ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	$strUnits=getItemsUnit();
	if($rows>0){
		echo '
		<table class="grad_s holdH" type="static" width="100%" cellpadding="4" cellspacing="0">
		<tr>
		<th width="30">#</th><th>'.k_item_name.'</th><th>'.k_quantity.'</th><th>'.k_unit_price.'</th><th>'.k_total.'</th>';
		if($shipStatus==0){echo '<th width="100"></th>';}
		echo '</tr>';		
		$totalAmount=0;
		while($r=mysql_f($res)){
			$s_id=$r['sid'];
			$item_id=$r['item_id'];
			$pac_quantity=$r['pac_quantity'];
			$quantity=$r['quantity'];
			$qu_balans=$r['qu_balans'];
			$unit_price=$r['unit_price'];
			$price=$r['price'];
			$item_name=$r['name'];
			$unit=$r['unit'];
			$pac_quantity_txt='';
			if($pac_quantity){
				$pq=explode(',',$pac_quantity);
				$pac_quantity_txt=number_format($pq[1]).' '.$strUnits[$pq[0]].' '.k_with_price.$pq[2];
			}
			echo '<tr>
			<td width="30"><ff>'.($i+1).'</ff></td>
			<td class="f1">'.$item_name.'</td>
			<td class="f1 fs14"><ff>'.number_format($quantity).'</ff> '.$strUnits[$unit].'<div class="f1 clr1">'.splitNo($pac_quantity_txt).'</div></td>
			<td><ff>'.number_format($unit_price,2).'</ff></td>
			<td><ff>'.number_format($price,2).'</ff></td>';
			if($shipStatus==0){
				echo '<td><div class="ic40 icc1 ic40_edit fl" onclick="loadItem('.$item_id.','.$s_id.',1)"></div>';
				echo '<div class="ic40 icc2 ic40_del fl" onclick="delItem('.$s_id.')"></div></td>';
			}
			echo '</tr>';
			$totalAmount+=$price;
		}
		echo '<tr  bgcolor="#eee">
			<td class="f1" colspan="4">'.k_total.'</td>			
			<td><ff>'.number_format($totalAmount,2).'</ff></td>';
			if($shipStatus==0){echo '<td></td>';}
			echo '</tr>';
	?>
	</table>
<?	
	}
}?>