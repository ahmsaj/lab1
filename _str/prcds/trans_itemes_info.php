<? include("../../__sys/prcds/ajax_header.php");?>
<div class="win_body"><?
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	list($sender,$reciver,$date,$ship_id,$t_status)=get_val('str_x_transfers','str_send,str_rec,date,ship_id,status',$id);
	$reciverTxt=get_val('str_m_stores','name_'.$lg,$reciver);
	if($sender){
		$senderTxt=get_val('str_m_stores','name_'.$lg,$sender);
	}else{
		$senderTxt=k_number_invoice.' <ff>'.get_val('str_x_bill','no',$ship_id).'</ff>';
	}?>	
	<div class="form_header f1 fs16 clr1 lh40">
	 <?=k_from?> ( <?=$senderTxt?> ) <?=k_to?> ( <?=$reciverTxt?> ) <?=k_date?> <ff dir="ltr"> <?=date('Y-m-d',$date)?></ff> </div>
	<div class="form_body so"><?
	$sql="select * ,s.id as s_id from str_x_transfers_items s , str_m_items i  where s.item_id=i.id and s.trans_id='$id' order by s.id ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	$strUnits=getItemsUnit();
	if($rows>0){
		echo '
		<table class="grad_s holdH" id="transTable" type="static" width="100%" cellpadding="4" cellspacing="0">
		<tr>
		<th width="30">#</th><th>'.k_item_name.'</th><th>'.k_quantity.'</th>';		
		echo '</tr>';
		$c=1;
		$totalAmount=0;
		$lastItem=0;
		$x_quantity=0;		
		$x_item_id=0;
		$x_s_id=0;
		$x_unit='';
		$x_name='';
		while($r=mysql_f($res)){
			$s_id=$r['s_id'];
			$item_id=$r['item_id'];
			$pac_quantity=$r['pac_quantity'];
			$quantity=$r['quantity'];			
			$item_name=$r['name'];
			$unit=$r['unit'];
			if($lastItem==0){$lastItem=$item_id;}
			
			if($item_id==$lastItem){				
				$x_quantity+=$quantity;
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
				</tr>';
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
		</tr>';?>
		</table><?	
	}
	?>
	</table>
	</div>
	<div class="form_fot fr">
    	<div class="bu bu_t2 fr" onclick="<?=$wlp?>win('close','#m_info');"><?=k_close?></div>
    	<? if($t_status==1 && $reciver==$userStore){?><div class="bu bu_t3 fl" onclick="transItemsEnd(<?=$id?>,2);"><?=k_receipt?></div><? }?>
    </div>
	<?

}?>
</div>