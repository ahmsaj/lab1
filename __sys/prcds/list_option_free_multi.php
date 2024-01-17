<? include("ajax_header.php");
if(isset($_POST['f'] , $_POST['s'] , $_POST['o'], $_POST['pars'])){
	$f=pp($_POST['f'],'s');
	$s=pp($_POST['s'],'s');
	$o=pp($_POST['o'],'s');
	$req=pp($_POST['req']);
	$pars=pp($_POST['pars'],'s');
	$p=explode('|',$pars);
	if(count($p)==5){
		$cb=$p[0];
		$cond=stripslashes($p[1]);
		$col_id=$p[2];
		$add_par=$p[3];
		$val=$p[4];		
		if(!$col_id){$col_id='id';}
		
		list($mod_code,$colum)=get_val_c('_modules_items','mod_code,colum',$f,'code');
		$colum=str_replace('(L)',$lg,$colum);
		$table=get_val_c('_modules','table',$mod_code,'code');
		$m_code=get_val_con('_modules_list','code', " type='1' and mod_code='$mod_code' "); 
		
		$chPer=checkPer($m_code);	
		if($chPer[0]){
			$cData=getColumesData($mod,1,$f);
			$tot=0;
			if($val){					
				$tt=explode(',',$val);
				$tot=count($tt);
			}	
			if($o==0){?>
				<div class="win_body">  
				<div class="form_header f1 lh40 fs20">
				   
				</div>
				<div class="form_body of" type="full" >
					<div class="fl r_bord pd10" fix="wp%:50|hp:0">
						<div class="b_bord lh60 uLine">
							<input type="text" onkeyup="co_selbigValSerFreeMulti('<?=$f?>')" placeholder="<?=k_search?>" class="ser_icons" 	style="margin-bottom:10px;" id="list_ser_option"/>
						</div>
						<div class="ofx so pd5" fix="hp:70" id="list_option"></div>
					</div>
					<div class="fl pd10" fix="wp%:50|hp:0">
						<div class="b_bord lh60 pd10 uLine f1 fs18 clr1"><?=k_selc_itms?><ff id="omlT">( <?=$tot?> )</ff></div>
						<div class="ofx so pd5" fix="hp:70" >
						<table width="100%" border="0" cellspacing="0" cellpadding="4" type="static" class="grad_s" id="selMalTab"><?
							if($val){								
								$q=" WHERE  `$col_id` IN ($val)";
								if($cond){$q.=" AND $cond ";}
								$sql="select `$col_id`,`$colum` from $table $q ORDER BY FIELD($col_id,$val)";
								$res=mysql_q($sql);
								while($r=mysql_f($res)){
									$r_id=$r[$col_id];
									$r_txt=$r[$colum];
									echo '<tr olMr="'.$r_id.'" olmrn="'.$r_txt.'" ><td width="30"><div class="mover"></div></td><td class="fs14" >'.$r_txt.'</td><td width="30"><div class="ic40x icc2 ic40_del" onclick="delOLM('.$r_id.')"></div></td></tr>';
								}
							}
						?>
						</table></div>
					</div>
				</div>
				<div class="form_fot fr">
					<div class="bu bu_t2 fr" onclick="win('close','#m_info4')"><?=k_cancel?></div>
					<div class="bu bu_t3 fl" onclick="saveLOM(<?=$req?>)"><?=k_save?></div>
				</div>
				<script>
					function OLMcbDo(data,txt=''){
						<? 
						$nCb= stripslashes($cb);
						$nCb=str_replace("'[id]'",'data',$nCb);
						$nCb=str_replace("[id]",'data',$nCb);
						$nCb=str_replace("'[txt]'",'txt',$nCb);
						$nCb=str_replace("[txt]",'txt',$nCb);
						
						echo $nCb;
						?>
					}
				</script>
				</div><?
			}else{
				if($chPer[1]){
					echo '<div class="add_but w-auto" style="margin:0px; margin-bottom:10px" title="'.k_add_rec.'"	onclick="addToFreeListMulti(\''.$f.'\',\''.$mod_code.'\',\''.$col_id.'\',\''.$colum.'\',\''.$add_par.'\')"></div>';
				}	
				$q='';
				if($cond){$q=" WHERE $cond ";}
				if($s){	if($q){$q.=' AND ';}else{$q.=' WHERE ';}$q.=" `$colum` like '%$s%'";}
				$q.=cekActColun($table,$q);
				$sql="select `$col_id`,`$colum` from `$table` $q order by `$colum` ASC limit 200";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows>0){
					while($r=mysql_f($res)){
						$id=$r[$col_id];
						$txt=$r[$colum];
						$txt=get_key($txt);
						$txt2=hlight($s,$txt);
						$cb=stripslashes($cb);
						$cb2=str_replace('['.$col_id.']',$id,$cb);
						$cb2=str_replace('['.$colum.']',$txt,$cb2);
						$action=";".$cb2;
						echo '<div class="listOptbutt" addOLM="'.$id.'" addOLMTxt="'.$txt.'">'.$txt2.'</div>';
					}				
				}else{echo '<div class="winOprNote_err f1 col5">'.k_no_results.'</div>';}
			}	
		}else{
			echo '<div class="f1 fs18 clr5 lh60 TC">'.k_no_perms_for_sec.'</div>';//out();			
		}
	}
}?>