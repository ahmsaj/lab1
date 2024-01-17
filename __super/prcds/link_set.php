<? include("../../__sys/prcds/ajax_header.php");
?><div class="win_body"><div class="form_body so"><?
if(isset($_POST['id'])){
	$c_code=$_POST['id'];
	$mod_code=get_val_c('_modules_items','mod_code',$c_code,'code');
	$sql="select code,title,colum from _modules_items where mod_code='$mod_code' and type=5 and link='' and code!='$c_code'";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		echo '<div class="f1 winOprNote">'.k_sl_ch_fd.'</div>';
		while($r=mysql_f($res)){
			$col_code=$r['code'];
			$title=$r['title'];
			$colum=$r['colum'];
			echo '<div class="bu bu_t1 f1 fs18" style="width:400px"
			onclick="link_setVal(\''.$c_code.'\',\''.$col_code.'\')">'.$colum.' ( '.get_key($title).' )</div>';
		}	
	}else{
		echo '<div class="f1 winOprNote_err">'.k_nvld_fd_lnk.'</div>';
	}
}?>
</div>
<div class="form_fot fr">
	<div class="bu bu_t2 fr" onclick="win('close','#m_info2')"><?=k_close?></div>
</div>
</div>
    