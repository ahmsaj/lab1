<? include("ajax_header.php");
if(isset($_POST['f'] , $_POST['s'] , $_POST['o'])){
	$f=pp($_POST['f'],'s');
	$s=pp($_POST['s'],'s');
	$o=pp($_POST['o'],'s');
	$pars=pp($_POST['pars'],'s');	
	$mod_code=get_val_c('_modules_items','mod_code',$f,'code');		
	$m_code=get_val_con('_modules_list','code', " type='1' and mod_code='$mod_code' ");
	$chPer=checkPer($m_code);	
	if($chPer[0]){
	$cData=getColumesData($mod,1,$f);
	$type=$cData[$f][3];
	$p_link=0;
	$link=$cData[$f][12];
	if($link){
		$l1=explode('^',$link);
		$oprC=count($l1);
		if($oprC==1){
			$lll=explode('|',$l1[0]);
			if($lll[0]==1){$p_link=$lll[1];}	
		}else{
			$lll=explode('|',$l1[1]);
			$p_link=$lll[1];
		}
	}
	if($o==0){?>
		<div class="win_body">  
		<div class="form_header f1 lh40 fs20">
		<input type="text" onkeyup="co_selbigValSer('<?=$f?>')" placeholder="<?=k_search?>" class="ser_icons" style="margin-bottom:10px;" id="list_ser_option"/> 
		</div>		
        <div class="form_body so" type="full">
            <div class="fxg" fxg="gtbf:280px|gap:10px" id="list_option"></div>
        </div>
		<div class="form_fot fr">            
            <div class="fr ic40 ic40_x icc3 ic40Txt mg10v br0" onclick="win('close','#m_info4')"><?=k_cancel?></div>
        </div>
		</div><?
	}else{
		$req=$cData[$f][7];
		$p=$cData[$f][5];
		if($type==5){
			$p=$cData[$f][5];	
			$parsObj=json_decode($p,true);		
			$table=$parsObj['table'] ?? '';
			$col_id=$parsObj['col'] ?? '';
			$col=$parsObj['view'] ?? '';
			$c_view=$parsObj['c_view'] ?? '';
			$mod_link=$parsObj['mod_link'] ?? '';
			$cond=$parsObj['cond'] ?? '';
			$evens=$parsObj['evens'] ?? '';
			
			$colm=str_replace('(L)',$lg,$col);
			$Listmod=$mod_link;
			// $colmArr=explode(',',$colm);

			$c_viewArr=availableCols($c_view);
			$q='';
			if($c_view){				
				$colsCon='';
				foreach($c_viewArr as $c){
					if($colsCon){$colsCon.="or";}
					$colsCon.=" `$c` like '%$s%' ";					
				}
				if($s){
					$q=" where $colsCon ";
				}
			}else{
				if($s){
					$q=" where `$col_id` like '%$s%' ";
				}
			}
			
			if($pars!=''){
				$parss=explode('|',$pars);
				if(count($parss)==2){
					$p_col=$parss[0];
					$p_val=$parss[1];					
					if($q!=''){$q.=" AND ";}else{$q.=" WHERE ";}
					$q.=" `$p_col`='$p_val' ";					
				}
			}
			if($cond){
				if($q){$q.=" AND ";}else{$q.=" WHERE ";}
				$cond=str_replace('[user]',$thisUser,$cond);
				$q.=readVarsInText($cond); 
			}
			
			$chPer3=checkPer($mod3);
			$mod_ord=$col_id;	
			if($chPer3[1] ){
				echo '<div class="ic40 ic40_add ic40Txt icc4" title="'.k_add_rec.'"	onclick="new_lisopto(\''.$f.'\',\''.$Listmod.'\',\''.$col.'\',\''.$pars.'\',\''.$evens.'\',\''.$col_id.'\')">'.k_add_rec.'</div>';
				// $mod_ord=get_val_c('_modules','order',$col_id,'code');
			}
			if($req==0){
				echo '<div class="bord cbg555  f1 fs14 lh40 pd10 Over2" onclick="m_lisopt_do(\''.$f.'\',\'\',\''.k_ndef_val.'\',\''.$p_link.'\',\''.$evens.'\')">إفراغ القيمة</div>';
			}
			$mod_ord=str_replace('(L)',$lg,$mod_ord);
			// if($mod_ord==$col_id){
			// 	$order_fild=$colm;
			// }else{
			// 	$order_fild=$mod_ord ?? 'id';				
			// }
			$q.=cekActColun($table,$q);

			$colmTxt=$col;
			if($c_view){				
				$colmTxt=implode('`,`',$c_viewArr);
			}
			$colmTxt=str_replace('(L)',$lg,$colmTxt);

			
			$sql="select `$col_id`,`$colmTxt` from `$table` $q order by `$col_id` ASC limit 200";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				while($r=mysql_f($res)){
					$id=$r[$col_id];                    
                    $txt='';
					if($c_view){						
						$txt=$c_view;												
						foreach($c_viewArr as $k=>$c){
							$c=str_replace('(L)',$lg,$c);
							$txt=str_replace('['.$c.']',$r[$c],$txt);
						}
					}else{
						$txt=$r[$colm];
					}

					$txt2=hlight($s,$txt);
					echo '<div class="bord cbg444  f1 fs14 lh40 pd10 Over2" onclick="m_lisopt_do(\''.$f.'\',\''.$id.'\',\''.addslashes($txt).'\',\''.$p_link.'\',\''.$evens.'\')">'.get_key($txt2).'</div>';
				}				
			}else{echo '<div class="winOprNote_err f1 col5">'.k_no_results.'</div>';}		
		}else{
			$vals=explode('|',$p);
			$rows=0;
			foreach($vals as $v){
				$vv=explode(':',$v);
				$id=$vv[0];
				$value=get_key($vv[1]);
				$ok=1;
				if($s){
					//if(strpos($value,$s)==false){
					if (!preg_match("~\b".$s."\b~",$value)){
						$ok=0;
					}
				}
				if($ok){
					$rows++;
					echo '<div class="bord cbg444  f1 fs14 lh40 pd10 Over2" 
					onclick="m_lisopt_do(\''.$f.'\','.$id.',\''.addslashes($value).'\',\''.$p_link.'\')">'.$value.'</div>';
				}
			}
			if($rows==0){
				echo '<div class="winOprNote_err f1 col5">'.k_no_results.'</div>';
			}
		}
	}	
	}else{out();}
}?>