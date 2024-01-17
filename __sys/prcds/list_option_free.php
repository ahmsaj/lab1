<? include("ajax_header.php");

if(isset($_POST['f'] , $_POST['s'] , $_POST['o'], $_POST['pars'])){
	$f=pp($_POST['f'],'s');
	$s=pp($_POST['s'],'s');
	$o=pp($_POST['o'],'s');
	$pars=pp($_POST['pars'],'s');
	$p=explode('|',$pars);
	if(count($p)>=4){
		$cb=$p[0];
		$cond=$p[1];
		$col_id=$p[2];
		$add_par=$p[3];
		if(!$col_id){$col_id='id';}		
		
		list($mod_code,$colum,$colType,$prams)=get_val_c('_modules_items','mod_code,colum,type,prams',$f,'code');		
		$colum=str_replace('(L)',$lg,$colum);
		if($colType!=6){
			list($table,$order)=get_val_c('_modules','table,order',$mod_code,'code');			
		}
		$m_code=get_val_con('_modules_list','code', " type='1' and mod_code='$mod_code' "); 
		$chPer=checkPer($m_code);
		if($chPer[0]){
			$cData=getColumesData($mod,1,$f);
			if($o==0){?>
				<div class="win_body">  
				<div class="form_header f1 lh40 fs20">
				<input type="text" onkeyup="co_selbigValSerFree('<?=$f?>')" placeholder="<?=k_search?>" class="ser_icons cbgw" style="margin-bottom:10px;" id="list_ser_option"/>    
				</div>
				<div class="form_body so" type="full">
                    <div class="fxg" fxg="gtbf:280px|gap:10px" id="list_option"></div>
                </div>
				<div class="form_fot fr">
                    <div class="fr ic40 ic40_x icc3 ic40Txt mg10v br0" onclick="win('close','#m_info4')"><?=k_cancel?></div>
                </div>
				</div><?
			}else{
				if($colType!=6){
					if($chPer[1]){
						echo '<div class="ic40 ic40_add ic40Txt icc4"	onclick="addToFreeList(\''.$mod_code.'\',\''.$col_id.'\',\''.$colum.'\',\'win(\\\'close\\\',\\\'#m_info4\\\');'.$cb.'\',\''.$add_par.'\')">'.k_add_rec.'</div>';
					}
					$q='';
					$ord=$colum;
					$mod_ord=str_replace('(L)',$lg,$mod_ord);
					if($order=='ord'){$ord='ord';}
					if($cond){$q=" WHERE $cond ";}
					if($s){	if($q){$q.=' AND ';}else{$q.=' WHERE ';}$q.=" `$colum` like '%$s%'";}
					$q.=cekActColun($table,$q);
					$sql="select `$col_id`,`$colum` from `$table` $q order by `$ord` ASC limit 200";
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					if($rows>0){
						while($r=mysql_f($res)){
							$id=$r[$col_id];
							$txt=$r[$colum];
							$txt2=hlight($s,$txt);
							$cb=stripslashes($cb);
							$cb2=str_replace('['.$col_id.']',$id,$cb);
							$cb2=str_replace('['.$colum.']',$txt,$cb2);
							$action="win('close','#m_info4');".$cb2;
							echo '<div class="bord cbg444  f1 fs14 lh40 pd10 Over2" onclick="'.$action.'">'.nl2br(get_key($txt2)).'</div>';
						}				
					}else{echo '<div class="fl winOprNote_err f1 col5">'.k_no_results.'</div>';}
				}
				if($colType==6){			
					$p=explode('|',$prams);
					foreach($p as $v ){
						$d=explode(':',$v);
						$id=$d[0];
						$txt=$d[1];
						$txt2=hlight($s,$txt);
						$cb=stripslashes($cb);
						$cb2=str_replace('['.$col_id.']',$id,$cb);
						$cb2=str_replace('['.$colum.']',$txt,$cb2);
						$action="win('close','#m_info4');".$cb2;						
						if(strstr($txt,$s) || !$s){							
                            echo '<div class="bord cbg444  f1 fs14 lh40 pd10 Over2" onclick="'.$action.'">'.nl2br(get_key($txt2)).'</div>';
						}
					}
				}
			}	
		}else{
			echo '<div class="f1 fs18 clr5 lh60 TC">'.k_no_perms_for_sec.'</div>';//out();	
		}
	}
}?>