<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['val'])){
	$id=pp($_POST['id'],'s');
	$val=pp($_POST['val'],'s');
	$maxRows=5;
	$maxR=0;
?><div class="win_body">
	<div class="form_header">
	<div class="lh40 clr1 fs18 fl f1"><?=k_ent_lst_val?></div>
	<div title="<?=k_add?>" class=" fr List_add_butt" onclick="modLiAdd()"></div>
	</div>
	<div class="form_body so" type="pd0" >
	<table width="100%" border="0" cellspacing="0" type="static" cellpadding="4" class="grad_s mlord holdH" >
		<tr><th width="40"></th><th width="40"><?=k_val?></th><th><?=k_txt?></th><th width="30"></th></tr><? 
		$rr=explode('|',$val);
		foreach($rr as $r){
			$vv=explode(':',$r);
			$rand=rand(1111,9999);
			echo '<tr ml id="tr'.$rand.'">
			<td><div class="mover"></div></td>
			<td><input type="text" value="'.$vv[0].'" v/></td>
			<td><input type="text" value="'.$vv[1].'" t/></td>
			<td><div class="i30 i30_del" onclick="delmodLi('.$rand.')"></div></td>
			</tr>';
			$maxR++;
		}
		for($s=$maxR;$s< $maxRows;$s++){			
			$rand=rand(1111,9999);
			echo '<tr ml id="tr'.$rand.'">
			<td><div class="mover"></div></td>
			<td><input type="text" value="" v/></td>
			<td><input type="text" value="" t/></td>
			<td><div class="i30 i30_del" onclick="delmodLi('.$rand.')"></div></td>
			</tr>';
		}?>		
	</table>


	
	</div>
	<div class="form_fot fr">
		<div class="bu bu_t1 fl" onclick="saveListVals()"><?=k_end?></div>
		<div class="bu bu_t2 fr" onclick="win('close','#m_info')"><?=k_close?></div>
	</div>
</div>  <?
}?>    