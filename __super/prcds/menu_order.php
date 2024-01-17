<? include("../../__sys/prcds/ajax_header.php");
?><div class="win_body"><div class="form_body so" type="full"><div class="mOrdMod"><?
if(isset($_POST['id'])){
	$id=$_POST['id'];
	$sql="select * from _modules_list where p_code='$id' order by ord ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$module_name='';
			$code=$r['code'];
			$title=$r['title_'.$lg];
			$sys=$r['sys'];				
			$icon=$r['icon'];
			$mod_code=$r['mod_code'];
			$act=$r['act'];
			$type=$r['type'];
			$ord=$r['ord'];
			$bgCol=$clr1111;
			$addCode='*';
			if($type==1){$bgCol=$clr11;$addCode='';$module_name=' ('.get_val_c('_modules','Module',$mod_code,'code').' )';}
			if($type==2){$bgCol=$clr1;$addCode='.';$module_name=' (_'.get_val_c('_modules_','Module',$mod_code,'code').' )';}
			if($type==3){$bgCol=$clr2;$addCode='';}		
			
			echo '<div class="f1 fs16 TC" no="'.$code.'" ord="'.$ord.'" style="background-color:'.$bgCol.'">'.$addCode.' '.$title.' '.$module_name.'</div>';			
		}
	}?>
    </div>
	</div>
	<div class="form_fot fr">
		<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_end?></div>
	</div>
</div>
<? }?>    