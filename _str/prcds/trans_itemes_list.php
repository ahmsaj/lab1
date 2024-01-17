<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$transStatus=get_val('str_x_transfers','status',$id);
	$sql="select * , s.id as sid from str_x_transfers_items s , str_m_items i  where s.item_id=i.id and s.trans_id='$id' order by s.id ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	$strUnits=getItemsUnit();	
	if($rows>0){
		echo '
		<table class="grad_s holdH" id="transTable" type="static" width="100%" cellpadding="4" cellspacing="0">
		<tr>
		<th width="30">#</th><th>'.k_item_name.'</th><th>'.k_quantity.'</th><th>'.k_unit_price.'</th><th>'.k_total.'</th>';
		if($transStatus==0){echo '<th width="100"></th>';}
		echo '</tr>';
		$c=1;
		$totalAmount=0;
		$lastItem=0;
		$x_quantity=0;
		$x_unit_price=0;
		$x_price=0;
		$x_item_id=0;
		$x_s_id=0;
		$x_unit='';
		$x_name='';
		while($r=mysql_f($res)){
			$s_id=$r['sid'];
			$item_id=$r['item_id'];
			$pac_quantity=$r['pac_quantity'];
			$quantity=$r['quantity'];			
			$unit_price=$r['unit_price'];
			$price=$r['price'];
			$item_name=$r['name'];
			$unit=$r['unit'];
			if($lastItem==0){$lastItem=$item_id;}			
			if($item_id==$lastItem){
				$x_unit_price=priceAvrage($unit_price,$quantity,$x_unit_price,$x_quantity);
				$x_quantity+=$quantity;				
				$x_price+=$price;
				$x_name=$item_name;
				$x_item_id=$item_id;
				$x_unit=$unit;
				$x_s_id=$s_id;
			}else{
				$lastItem=$item_id;
				echo '<tr it="'.$x_item_id.'">
				<td width="30"><ff>'.$c.'</ff></td>
				<td class="f1 fs16">'.splitNo($x_name).'</td>
				<td class="f1 fs14"><ff>'.number_format($x_quantity).'</ff> '.$strUnits[$x_unit].'
				<div class="f1 clr1">'.fixBalansPac($x_quantity,get_val('str_m_items','packing',$x_item_id),$strUnits,$x_unit).'</div></td>
				<td><ff>'.number_format($x_unit_price,2).'</ff></td>
				<td><ff>'.number_format($x_price,2).'</ff></td>';
				if($transStatus==0){
					echo '<td><div class="ic40 icc1 ic40_edit fl" onclick="loadItem('.$x_item_id.','.$x_s_id.',2)"></div>';
					echo '<div class="ic40 icc2 ic40_del fl" onclick="delItem('.$x_s_id.')"></div></td>';
				}
				echo '</tr>';
				$x_unit_price=$unit_price;
				$x_quantity=$quantity;				
				$x_price=$price;
				$x_name=$item_name;				
				$x_item_id=$item_id;
				$x_unit=$unit;
				$x_s_id=$s_id;
				$c++;
			}			
			$totalAmount+=$price;
		}
		echo '<tr it="'.$x_item_id.'">
		<td width="30"><ff>'.$c.'</ff></td>
		<td class="f1 fs16">'.splitNo($x_name).'</td>
		<td class="f1 fs14"><ff>'.number_format($x_quantity).'</ff> '.$strUnits[$x_unit].'
		<div class="f1 clr1">'.fixBalansPac($x_quantity,get_val('str_m_items','packing',$x_item_id),$strUnits,$x_unit).'</div></td>
		<td><ff>'.number_format($x_unit_price,2).'</ff></td>
		<td><ff>'.number_format($x_price,2).'</ff></td>';
		if($transStatus==0){
			echo '<td><div class="ic40 icc1 ic40_edit fl" onclick="loadItem('.$x_item_id.','.$x_s_id.',2)"></div>';
			echo '<div class="ic40 icc2 ic40_del fl" onclick="delItem('.$x_s_id.')"></div></td>';
		}
		echo '</tr>';
		echo '<tr  bgcolor="#eee">
			<td class="f1" colspan="4">'.k_total.'</td>			
			<td><ff>'.number_format($totalAmount,2).'</ff></td>';
			if($transStatus==0){echo '<td></td>';}
			echo '</tr>';?>
		</table><?	
	}
}?>