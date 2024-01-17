<? include("../../__sys/prcds/ajax_header.php");
?><div class="win_body"><div class="form_body so"><?
if(isset($_POST['id'] , $_POST['opr'])){
	$code=$_POST['id'];
	$opr=$_POST['opr'];
	if($opr==1){
		$link=get_val_c('_modules_items','link',$code,'code');
		$l=explode('^',$link);
		$oprC=count($l);
		if($oprC>1){
			$ll=explode('|',$l[1]);
			$t=$ll[0];
			$d=$ll[1];	
			if($t==1){
				list($tilte,$col)=get_val_c('_modules_items','title,colum',$d,'code');
				echo '<div class="f1 B">'.k_lk_pr_fd.' ( '.$col.' | '.get_key($tilte).' )</div>';
			}
			$ll=explode('|',$l[0]);		
			$t=$ll[0];
			$d=$ll[1];	
			if($t==2){
				list($tilte,$col)=get_val_c('_modules_items','title,colum',$d,'code');
				echo '<div class="f1 B">'.k_lk_ch_fd.' ( '.$col.' | '.get_key($tilte).' )</div>';
			}
			echo '<div class="f1 winOprNote_err">'.k_ck_dt_cn_ch.'</div>';
		}else{
			$ll=explode('|',$l[0]);		
			$t=$ll[0];
			$d=$ll[1];	
			if($t==1){
				list($tilte,$col)=get_val_c('_modules_items','title,colum',$d,'code');
				echo '<div class="f1 B">'.k_lk_pr_fd.' ( '.$col.' | '.get_key($tilte).' )</div>';
				echo '<div class="f1 winOprNote_err">'.k_ps_dt_cn_lk.'</div>';
			}
		}
		
	}
	if($opr==2){
		$link=get_val_c('_modules_items','link',$code,'code');
		$l=explode('^',$link);
		$oprC=count($l);		
		if($oprC==1){
			$ll=explode('|',$l[0]);
			$t=$ll[0];
			$d=$ll[1];			
			mysql_q("UPDATE _modules_items set link='' where code='$code' ");
			$link=get_val('_modules_items','link',$d);
			$l=explode('^',$link);
			$oprC=count($l);
			if($oprC==1){$v2='';}else{$v2=$l[1];}
			mysql_q("UPDATE _modules_items set link='$v2' where code='$d' ");
		}else{
			$ll=explode('|',$l[1]);
			$t=$ll[0];
			$d=$ll[1];	
			$v1=$l[0];			
			mysql_q("UPDATE _modules_items set link='$v1' where code='$code' ");
			$link=get_val('_modules_items','link',$d);
			$l=explode('^',$link);
			$oprC=count($l);
			if($oprC==1){$v2='';}else{$v2=$l[1];}
			mysql_q("UPDATE _modules_items set link='$v2' where code='$d' ");
			
		}
	}
}?>
</div>
<div class="form_fot fr">
    <div class="bu bu_t2 fr" onclick="win('close','#m_info2')"><?=k_close?></div>
    <div class="bu bu_t3 fr" onclick="mLinkDel('<?=$code?>',2)"><?=k_delete?></div>
</div>
</div>
    