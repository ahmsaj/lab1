<? include("ajax_header.php");
if(isset($_POST['f'] , $_POST['s'] , $_POST['o'])){
	$f=pp($_POST['f'],'s');
	$type=substr($f,0,3);
	$s=pp($_POST['s'],'s');
	$o=pp($_POST['o'],'s');	
	$val=pp($_POST['v'],'s');
	if($type=='cof'){
		$f=str_replace('cof_','',$f);
		list($mod_code,$colum,$pars)=get_val_c('_modules_items','mod_code,colum,prams',$f,'code');
		$m_code=get_val_con('_modules_list','code', " type='1' and mod_code='$mod_code' ");
		$chPer=checkPer($m_code);
		$ch=$chPer[0];		
	}
	if($type=='set'){
		$f=str_replace('set_','',$f);
		$pars=get_val('_settings','pars',$f);
		$m_code=get_val_con('_modules_list','code', " type='1' and mod_code='$mod_code' ");
		$chPer=checkPer($m_code);
		$ch=$chPer[0];
	}
	if($ch){
		$p=explode('|',$pars);
		$parsObj=json_decode($pars,true);		
		$table=$parsObj['table'] ?? '';
		$col_id=$parsObj['col'] ?? '';
		$colum=$parsObj['view'] ?? '';
		$p_c_view=$parsObj['c_view'] ?? '';
		$linkMod=$parsObj['mod_link'] ?? '';
		$cond=$parsObj['cond'] ?? '';
		$evnts=$parsObj['evens'] ?? '';

		if(!$col_id){$col_id='id';}
		$colum=str_replace('(L)',$lg,$colum);
		$cData=getColumesData($mod,1,$f);
        $colmArr=explode(',',$colum);
		$tot=0;
		if($val){					
			$tt=explode(',',$val);
			$tot=count($tt);
		}	
		if($o==0){?>
			<div class="win_body">  
			<div class="form_header f1 lh40 fs20">

			</div>
			<div class="form_body of" type="full_pd0" >
                <div class="h100 fxg" fxg="gtc:1fr 1fr|gtr:60px 1fr">
                    <div class="b_bord r_bord pd10f">
                        <input type="text" omleSer="<?=$f?>"  placeholder="<?=k_search?>" class="ser_icons" style="margin-bottom:10px;" id="list_ser_option"/>
                    </div>
                    <div class="b_bord pd10f lh40 f1 fs18 clr1"><?=k_selc_itms?> <ff id="omlT">(<?=$tot?>)</ff></div>
                    <div class="ofx so pd5 r_bord pd10f" id="list_option"></div>
                    <div class="ofx so pd5 pd10f">
                        <table width="100%" border="0" cellspacing="0" cellpadding="4" type="static" class="grad_s" id="selMalTab"><?
                        if($val){
                            $val="'".str_replace(',',"','",$val)."'";
                            $q=" WHERE  `$col_id` IN ($val)";

                            if($cond){$q.=" AND $cond ";}
                            $columTxt=str_replace(',','`,`',$colum);
                            $sql="select `$col_id`,`$columTxt` from $table $q ORDER BY FIELD($col_id,$val)";
                            $res=mysql_q($sql);
                            while($r=mysql_f($res)){
                                $r_id=$r[$col_id];
                                //$r_txt=$r[$colum];
                                $txt='';
                                foreach($colmArr as $c){
                                   if($txt!=''){$txt.=' - ';}
                                    $txt.=$r[$c];
                                }
                                echo '<tr olMr="'.$r_id.'" olmrn="'.$txt.'"><td width="30"><div class="mover"></div></td><td class="fs14">'.$txt.'</td><td width="30"><div class="ic40x icc2 ic40_del" onclick="delOLM(\''.$r_id.'\')"></div></td></tr>';
                            }
                        }
                    ?>
                    </table>
                    </div>
                    
                </div>
			</div>
			<div class="form_fot fr">
				<div class="fr ic40 ic40_x icc3 ic40Txt mg10v br0" onclick="win('close','#m_info4')"><?=k_cancel?></div>
				<div class="fr ic40 ic40_save icc22 ic40Txt mg10f br0" onclick="saveMLOM()"><?=k_save?></div>
			</div>
			</div><?
		}else{
			$c_viewArr=availableCols($p_c_view);
			$columTxt=$colum;
			if($p_c_view){				
				$columTxt=implode('`,`',$c_viewArr);
			}

			if($chPer[1]){
				echo '<div class="add_but w-auto" style="margin:0px; margin-bottom:10px" title="'.k_add_rec.'"	onclick="addToListMulti(\''.$f.'\',\''.$linkMod.'\',\''.$col_id.'\',\''.$colum.'\',\''.$add_par.'\')"></div>';
			}	
			$q='';
            
			if($cond){$q=" WHERE $cond ";}

			$q='';
			if($p_c_view){				
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

			// if($s){	if($q){$q.=' AND ';}else{$q.=' WHERE ';}$q.=" `$colum` like '%$s%'";}
            // if($s){
            //     $qc='';
            //     foreach($colmArr as $c){
            //         if($qc){$qc.=' oR ';}
            //         $qc.=" `$c` like '%$s%'";
            //     }
            //     $q=" where ( $qc)";
            // }
			$q.=cekActColun($table,$q);
			
			$sql="select `$col_id`,`$columTxt` from `$table` $q order by `$colmArr[0]` ASC limit 200";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				while($r=mysql_f($res)){
					$id=$r[$col_id];
					$txt=$r[$colum];					
					if($p_c_view){				
						$txt=$p_c_view;												
						foreach($c_viewArr as $k=>$c){
							$txt=str_replace('['.$c.']',$r[$c],$txt);
						}
					}
					/************************ */					
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
	
}?>