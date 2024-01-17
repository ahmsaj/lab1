<? include("ajax_header.php");?>
<div class="win_body">
	<div class="form_body so" type="full">
	<div class="fmOrdMod"><?
	$sql="select * from _fav_list where user_code='$thisUserCode' order by ord ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$module_section='';
		while($r=mysql_f($res)){
			$m_code=$r['m_code'];
			$ord=$r['ord'];
			$mod_name=get_val_c('_modules_list','title_'.$lg,$m_code,'code');				
			echo '<div class="f1 fs16 TC lh40" no="'.$m_code.'" >'.$mod_name.'</div>';	
		}
	}?>
    </div>
	</div>
	<div class="form_fot fr">		
		<div class="bu bu_t3 fl" onclick="ordFavMe();"><?=k_save?></div>
		<div class="bu bu_t2 fr" onclick="win('close','#m_info5');"><?=k_cancel?></div>
	</div>
</div>
