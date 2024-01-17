<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['s'] , $_POST['d'] , $_POST['bc'])){
$storage=pp($_POST['s']);
$data=pp($_POST['d'],'s');
$bc=pp($_POST['bc'],'s');
$bc2=str_replace('[data]',"''",$bc);
if($bc){$bc=str_replace('[data]','[1]',$bc);$cb_txt='cb="'.$bc.'" bv="data"';}
if($storage==0){$storage=$userStore;}
?>
<div class="winButts"><div class="wB_x fr" onclick="win('close','#full_win1');"></div></div>
	<div class="win_body">
	<div class="form_body so" type="static"><?
	$id=pp($_POST['id']);
	$str_rec=get_val('str_x_transfers','str_rec',$id);
	list($name,$part,$s_part)=get_val('str_m_stores','name_'.$lg.',part,s_part',$str_rec);
	?>
	<div class="shItTree fl">
		<div class="strItitle lh50"><input type="text" id="treeSer" onkeyup="treeSear(3)"/></div>
		<div id="itreeD"><div class="loadeText"><?=k_loading?></div></div>
	</div>
	<div class="shItDet fl ofx so" id="consItems">		
	<form name="cons" id="cons" action="<?=$f_path.'X/str_consumption_item_save.php'?>" method="post" <?=$cb_txt?> >
		<input type="hidden" id="cons_ids" name="itemsIds"/>
		<input type="hidden" name="s" value="<?=$storage?>"/>
		<input type="hidden" name="bc" value="<?=$bc?>"/>
		<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH " type="static" id="consTable">
		<tr><th><?=k_item_name?></th><th><?=k_quantity?></th><th><?=k_balance?></th><th width="30"></th></tr><? 
		$h='hide';
		$recs=0;
		if($data){
			$d=explode('|',$data);
			foreach($d as $r){
				$r2=explode(':',$r);
				$bal=getItemBal($r2[0],$storage);
				if($bal>=$r2[1]){
					$recs++;
					echo '<tr it="'.$r2[0].'"><td class="f1 fs14">'.get_val('str_m_items','name',$r2[0]).'</td>
					<td><input cons name="i'.$r2[0].'" no="'.$r2[0].'" value="'.$r2[1].'" type="number" required min="1" max="'.$bal.'" value="1" name="i'.$r2[0].'" /></td><td><ff>'.$bal.'</ff></td><td><div class="ic40 icc2 ic40_del fl" onclick="delConRec('.$r2[0].')"></div></td></tr>';
				}
			}			
			if($recs==0){$h='';}
		}?>
		</table> 
		</form>
	</div>
	</div>
	<div class="form_fot fr">
	    <div class="bu bu_t3 fl" onclick="save_cons();"><?=k_save?></div>
	    <? if($data){?><div id="endConsButt" class="bu bu_t1 fl w-auto <?=$h?>" 
	    onclick="win('close','#full_win1'); <?=$bc2?>"><?=k_there_no_consumed_items?></div><? }?>
		<div class="bu bu_t2 fr" onclick="win('close','#full_win1');"><?=k_close?></div>
	</div>
</div><?
}?>