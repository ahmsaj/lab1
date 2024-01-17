<? include("../../__sys/prcds/ajax_header.php");
?><div class="win_body"><?
if(isset($_POST['id'] , $_POST['p_id'] , $_POST['iteme'] , $_POST['t'])){	
	$id=pp($_POST['id']);
	$p_id=pp($_POST['p_id']);
	$type=pp($_POST['t']);
	if($type==1){$status=get_val('str_x_bill','status',$p_id);}
	if($type==2){get_val('str_x_transfers','status',$p_id);}
	if($status==0){
		$iteme=pp($_POST['iteme']);
		$data=getRec('str_m_items',$iteme);
		$ib=getItemBal($iteme,$userSubType);		
		$ibCol='';
		if($ib<$data['min_order'] && $data['min_order']!='' ){$ibCol=' class="clr5" ';}
		$qu='';
		$qt=1;
		if($id){
			if($type==1){
				$qt=0;
				$data2=getRec('str_x_bill_items',$id);
				if($data2['status']){echo 'out';exit;}		
				$qu=$data2['quantity'];
				$qu2=$data2['pac_quantity'];
				$price=$data2['unit_price'];

				if($qu2){
					$qu2_arr=explode(',',$qu2);
					$price=$qu2_arr[2];
					$qu=$qu2_arr[1];
					$qt=$qu2_arr[3];
				}
			}
			if($type==2){
				$qt=0;				
				$item_id=get_val('str_x_transfers_items','item_id',$id);				
				$qu=get_sum('str_x_transfers_items','quantity'," trans_id='$p_id' and item_id='$item_id'");				
				$ib+=$qu;
			}
		}else{
			if($type==2){				
				$data2=getRec('str_x_transfers_items',$id);
				if($data2['status']){echo 'out';exit;}		
				$qu='';
				$qt='';
				
			}
		}
		echo script('ItemBalans='.$ib.';');
		?>
		<div class="form_header">
			<div class="f1 fs18 clr1 ">
			<?
			echo splitNo($data['name']);
			if($data['brand']){ echo '<span class="f1 fs16 clr1111"> - '.splitNo(get_val('str_m_items_brands','name_'.$lg,$data['brand'])).' </span>';}
			if($data['modle']){ echo ' [ <span class="f1 fs16 clr1111">'.splitNo($data['modle']).' </span> ]';}
			?></div>
			<div class="f1 lh30 fs14">
			<?=splitNo(get_val('str_m_items_cats','name_'.$lg,$data['cat']).' / '.
			get_val('str_m_items_cats_sub','name_'.$lg,$data['scat']));?>
			</div>
		</div>
		<div class="form_body" type="">
		<? if($type==1){?>
		<form name="siaForm" id="siaForm" action="<?=$f_path?>X/str_invoice_items_save.php" method="post" cb="loadShipItems(<?=$p_id?>)" bv="">
		<?}else{?>
		<form name="siaForm" id="siaForm" action="<?=$f_path?>X/str_trans_itemes_save.php" method="post" cb="loadTransItems(<?=$p_id?>)" bv="">
		<? 
		}?>
			<input name="id" type="hidden" value="<?=$id?>" />
			<input name="p_id" type="hidden" value="<?=$p_id?>" />
			<input name="iteme" type="hidden" value="<?=$iteme?>" />
			<table class="grad_s" width="100%" cellpadding="4" cellspacing="0" type="static" over="0">
			<tr><td txt width="150"><?=k_item_balance?></td><td><ff <?=$ibCol?>><?=$ib?></ff></td></tr>
			<? if($type==1){?>
			<tr><td txt><?=k_unit_price?></td><td><input type="number" value="<?=$price?>" name="price" required/></td></tr>
			<? }
			if($data['packing']){
				$pakArr=explode('-',$data['packing']);
				$u1=get_val('str_m_items_units','name_'.$lg,$pakArr[0]);
				$u2=get_val('str_m_items_units','name_'.$lg,$pakArr[2]);
				$u3=get_val('str_m_items_units','name_'.$lg,$data['unit']);
				echo script('pac_vals[1]='.$pakArr[1].';pac_vals[2]='.$pakArr[3].';');
				echo '<tr><td txt>'.k_quantity.'</td><td>
				<div class="fl" style="width:30%"><input type="number" name="q1" value="'.$qu.'" id="pacTot" required/></div>
				<div class="fl" style="width:70%">
				<select n id="pacType" name="q2">';			
				if($pakArr[0]){echo '<option value="1">'.$u1.' '.k_contains.' [ '.$pakArr[1].' ] '.$u2.'</option>';}
				$sel='';if($qt==2){$sel='selected';}
				echo '<option value="2" '.$sel.'>'.$u2.' '.	k_contains.' [ '.$pakArr[3].' ] '.$u3.'</option>';
				$sel='';if($qt==''){$sel='selected';}
				echo '<option value="0" '.$sel.'>'.$u3.'</option>';
				echo '</select>
				</div>
				</td></tr>';
			}else{
				echo '<tr><td txt>'.k_quantity.'</td><td>
				<div class="fl" style="width:30%"><input type="number" name="q1" value="'.$qu.'" id="pacTot" required/> <input type="hidden" value="0" name="q2"/></div>
				<div class="fl f1 lh40 clr1 fs16" style="width:70%">'.get_val('str_m_items_units','name_'.$lg,$data['unit']).'</div>				
				</td></tr>';				
			}
			echo '<tr><td txt>'.k_total_quantity.'</td>
			<td>
			<div class="f1 fs14 clr1 lh20"> ( <ff id="ptt">0</ff> ) '.$u3.'</div>
			<div class="f1 clr5 hide" id="Qmasg">'.k_spec_quan_greater_balance.'</div>
			</td></tr>';
			echo script('setPacInt();');?>

		</table>
		</form>
		</div>
		<div class="form_fot fr">
			<div class="bu bu_t2 fr" onclick="<?=$wlp?>win('close','#m_info2');"><?=k_close?></div>
			<div class="bu bu_t1 fl" onclick="siaFormFormCheck();"><?=k_save?></div>
		</div><?
	}
}
	?>
</div>