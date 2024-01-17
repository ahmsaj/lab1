<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['val'])){
	$id=$_POST['id'];
	$val=$_POST['val'];
	$maxRows=4;
	$maxR=1;?>	
	<div class="win_body">
		<div class="form_header">
		<div class="lh40 clr1 fs18 fl f1"><?=k_toth_chos_pos_case?></div>	
		</div>
		<div class="form_body so" id="cavit">
		<table width="100%" border="0" cellspacing="0" type="static" cellpadding="4" class="grad_s holdH" >
			<tr><th width="150"><?=k_statuses?></th>
			<? foreach($cavCodes as $k=>$t){if($k){echo '<th class="uc">'.splitNo($t).'</th>';}}?>	
			</tr><? 
			$saveVals=array();
			$rr=explode('|',$val);
			foreach($rr as $k=>$v){
				$vv=explode(',',$v);
				foreach($vv as $vvv){
					$saveVals[$k+1][$vvv]=1;
				}
			}
			for($s=$maxR;$s< $maxRows;$s++){?>
				<tr id="tr<?=$s?>">
					<td txt><?=k_status?> <ff class="fs14"><?=$s?></ff></td><?
					foreach($cavCodes as $k=>$t){
						if($k){
							$ch='';
							if($saveVals[$s][$k]){$ch=' checked ';}
							echo '<td><input type="checkbox" name="c_'.$s.'_'.$k.'" '.$ch.' value="'.$k.'" par="'.$s.'" /></td>';
						}
					}?>
				</tr>
			<?}?>		
		</table>
		</div>
		<div class="form_fot fr">
			<div class="bu bu_t1 fl" onclick="saveCavsSet()"><?=k_end?></div>
			<div class="bu bu_t2 fr" onclick="win('close','#m_info')"><?=k_close?></div>
		</div>
	</div><?
}?>    