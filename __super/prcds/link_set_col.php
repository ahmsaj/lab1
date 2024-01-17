<? include("../../__sys/prcds/ajax_header.php");
?><div class="win_body"><div class="form_body so"><?
if(isset($_POST['p_id'] , $_POST['s_id'])){
	$p_id=$_POST['p_id'];
	$s_id=$_POST['s_id'];
	list($s_col,$title,$prams)=get_val_c('_modules_items','colum,title,prams',$s_id,'code');
	$par=explode('|',$prams);
	$table=$par[0];
	$col=convLangCol($par[2]);
	$winTilte=k_sl_lk_fd.' ( '.$s_col.' | '.get_key($title).' )';
	$ch = mysql_q("SHOW TABLES LIKE '$table'");
	if(mysql_n($ch)){	
		$sql="show fields from `".$table."`";
		$res=mysql_q($sql);
		$tCount=mysql_n($res);
		$options='';
		while ($fields = mysql_f($res)){	
			$filde=$fields['Field'];
			$filde_txt=$filde;			
			$filde_txt=strtoupper(str_replace('_',' ',$filde_txt));	
			$langStatus=ColLangChek($filde);
			if($langStatus=='x' && $filde!='id'){			
				$options.='<div class="bu bu_t1 f1 fs18" style="width:400px"
				onclick="link_setSave(\''.$p_id.'\',\''.$s_id.'\',\''.$filde.'\')">'.$filde_txt.'</div>';	
			}
		}
		if($options!=''){
			echo '<div class="f1 winOprNote">'.$winTilte.'</div>'.$options;
		
		}else{
			echo '<div class="f1 winOprNote_err">'.k_nvld_fd_lnk.'</div>';
		}
	}
}?>
</div>
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="win('close','#m_info2')"><?=k_close?></div>
    </div>
    </div>
    