<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['n'] , $_POST['vis'] , $_POST['t'])){
	$n=pp($_POST['n']);
	$vis=pp($_POST['vis']);
	$t=pp($_POST['t']);
	$rNo=pp($_POST['r']);
	$lastCavNo=0;
	list($patient,$doctor)=get_val('den_x_visits','patient,doctor',$vis);
	if($doctor=$thisUser){	list($pos,$t_type,$no,$t_code,$cavities)=get_val_c('den_m_teeth','pos,t_type,no,t_code,cavities',$n,'no');
		$t_code=strtolower($t_code);
		$codes=str_split($t_code);
		$f_center=$codes[1];
		if($pos==1){$f_top=$codes[0];$f_right='m';$f_bot=$codes[2];$f_left='d';}
		if($pos==2){$f_top=$codes[0];$f_right='d';$f_bot=$codes[2];$f_left='m';}
		if($pos==3){$f_top=$codes[2];$f_right='d';$f_bot=$codes[0];$f_left='m';}
		if($pos==4){$f_top=$codes[2];$f_right='m';$f_bot=$codes[0];$f_left='d';}

		$cData=getColumesData('',0,'clzno1c30h');
		$type_txt=viewRecElement($cData[0],$pos);
		$cData=getColumesData('',0,'zb7ayskkvd');
		$teethName=viewRecElement($cData[0],$t_type);
		
        $last_oprArr=array();
        if($t==1){                  
            $oprDataArr=array();		
            $sql="select * from den_m_set_teeth where act =1 order by ord ASC";		
            $res=mysql_q($sql);
            $rows=mysql_n($res);
            if($rows){
                while($r=mysql_f($res)){				
                    $id=$r['id'];
                    $oprDataArr[$id.'-1']['type']=1;
                    $oprDataArr[$id.'-1']['opr']=$id;				
                    $oprDataArr[$id.'-1']['icon']=$r['icon'];
                    $oprDataArr[$id.'-1']['name']=$r['name_'.$lg];
                    $oprDataArr[$id.'-1']['color']=$r['color'];
                    $oprDataArr[$id.'-1']['opr_type']=$r['opr_type'];
                    $oprDataArr[$id.'-1']['use_by']=$r['use_by'];
                }
            }
            $teethSubSt=get_arr('den_m_set_teeth_sub','id','status_id,name_'.$lg,"id > 0");
        }else{            
            $sql="select * from den_m_set_roots where act =1  order by ord ASC";
            $res=mysql_q($sql);
            $rows=mysql_n($res);
            if($rows){			
			while($r=mysql_f($res)){
				$id=$r['id'];
				$oprDataArr[$id.'-2']['type']=2;
				$oprDataArr[$id.'-2']['opr']=$id;
				$oprDataArr[$id.'-2']['icon']=$r['icon'];
				$oprDataArr[$id.'-2']['name']=$r['name_'.$lg];
				$oprDataArr[$id.'-2']['color']=$r['color'];
				$oprDataArr[$id.'-2']['opr_type']=$r['opr_type'];
				$oprDataArr[$id.'-2']['use_by']=$r['use_by'];
			}
		}
        }
        /***********History*****************/
        $hisData='';
        $sql="select * from den_x_opr_teeth where teeth_no='$n' and teeth_part='$t' and patient='$patient' and teeth_part_sub!=0  order by date DESC";
        $res=mysql_q($sql);
        $oprRows=mysql_n($res);
        while($r=mysql_f($res)){
            $opr_id=$r['id'];
            $opr=$r['opr'];
            $opr_sub=$r['opr_sub'];
            $part_sub=$r['teeth_part_sub'];
            $opr_part=$r['opr_part'];
            $teeth_part=$r['teeth_part'];
            $doctor=$r['doctor'];
            $last_opr=$r['last_opr'];
            $cav_no=$r['cav_no'];
            if($teeth_part==2 && $rNo==0){$lastCavNo=$cav_no;}
            $bordClr=$oprDataArr[$opr.'-'.$teeth_part]['color'];
            $oprTxt=$oprDataArr[$opr.'-'.$teeth_part]['name'];
            if($last_opr && $t==$teeth_part){
                $last_oprArr[$part_sub]['color']=$bordClr;
                $last_oprArr[$part_sub]['name']=$oprTxt;
                $last_oprArr[$part_sub]['a']=$opr;
                
            }
            $opr_part_txt='';						
            if($opr_sub){
                if($teeth_part==1){$opr_subV=get_val_arr('den_m_set_teeth_sub','name_'.$lg,$opr_sub,'ts');}
                if($teeth_part==2){$opr_subV=get_val_arr('den_m_set_roots_sub','name_'.$lg,$opr_sub,'ts');}
                $opr_part_txt=' <span class="f1 clr1">| '.$opr_subV.' </span>';
            }
            $part_subTxt='';
            if($part_sub){
                if($teeth_part==1){
                    $subTxt=$facCodes[$part_sub];								
                }else{
                    $subTxt=$cavCodes[$part_sub];
                }
                $part_subTxt='<ff14 class=" uc clr5 TC lh30">'.$subTxt.' | </ff14>';
            }
            $delButt='';
            /*if($doctor==$thisUser){
                $delButt='<div class="fr i30 i30_x" title="'.k_del_status.'" onclick="teethOprDel('.$opr_id.')"></div>';
            }*/
            $hisData.='
            <div class="fl bs w100 cbgw mg5v bord br5" part_'.$teeth_part.' style="" n="'.$opr_id.'" >
                <div class="f1  lh40 pd10 b_bord">
                '.$part_subTxt.''.$oprTxt.' '.$opr_part_txt.' 
                </div>
                <div>
                    <div class="fl ff B  lh30  pd10">'.date('Y-m-d',$r['date']).'</div>'.$delButt.'
                </div>
            </div>';
        }
        /****************************************/?>
        <ff14><?=$no?>-</ff14> <?=$teethName.' - '.$type_txt;?>^
        <div class="h100 fxg" fxg="gtc:2fr 200px ">
            <div class="of h100 fxg" fxg="1fr"><? 
                if($t==1){//Tooth Parts                      
                    $opeType=$firstRec['opr_type'];
                    $bg2=array();
                    $parSt=array();						$parSt['f']=$parSt['m']=$parSt['i']=$parSt['d']=$parSt['l']=$parSt['b']=$parSt['p']=$parSt['o']='0';
                    if($opeType){                        
                        //$bgColr=' background-color:'.$oprDataArr[$firstRec['opr']]['color'].';';
                        if($opeType==1){$bg=$bgColr;}
                        if($opeType==2){
                            $oprSub=$firstRec['opr_part'];
                            if($oprSub){
                                $oprSubArr=str_split($oprSub);
                                foreach($oprSubArr as $osa){							
                                    $bg2[$osa]=$bgColr;
                                    $parSt[$osa]='on';
                                }
                            }
                        }
                    }?>
                    <div class=" tBoxHold "><?
                        $t_ad=$l_ad=$r_ad=$b_ad=$b_st='';
                        if($last_oprArr[0]){
                            $t_st=$l_st=$r_st=$b_st=$c_st=$last_oprArr[0];
                        }else{
                            $t_st=$last_oprArr[getArrKey($facCodes,$f_top)];
                            $l_st=$last_oprArr[getArrKey($facCodes,$f_left)];
                            $r_st=$last_oprArr[getArrKey($facCodes,$f_right)];
                            $b_st=$last_oprArr[getArrKey($facCodes,$f_bot)];
                            $c_st=$last_oprArr[getArrKey($facCodes,$f_center)];
                        }
                        $styTxt='background-color:';
                        $t_a=$l_a=$r_a=$b_a=$c_a='0';
                        if($t_st){$t_ad='style="'.$styTxt.$t_st['color'].'" title="'.$t_st['name'].'"';$t_a=$t_st['a'];}
                        if($l_st){$l_ad='style="'.$styTxt.$l_st['color'].'" title="'.$l_st['name'].'"';$l_a=$l_st['a'];}
                        if($r_st){$r_ad='style="'.$styTxt.$r_st['color'].'" title="'.$r_st['name'].'"';$r_a=$r_st['a'];}
                        if($b_st){$b_ad='style="'.$styTxt.$b_st['color'].'" title="'.$b_st['name'].'"';$b_a=$b_st['a'];}
                        if($c_st){$c_ad='style="'.$styTxt.$c_st['color'].'" title="'.$c_st['name'].'"';$c_a=$c_st['a'];}
                        ?>
                        <div></div>
                        <div dir="ltr" style="<?=$t_ad?>" class="mainTeeth cbg444" tB<?=$pos?> >
                            <div></div>
                            <div p face="<?=$f_top?>" tsp="<?=getArrKey($facCodes,$f_top)?>" a="<?=$t_a?>" <?=$t_ad?>><?=$f_top?></div>
                            <div></div>
                            <div p face="<?=$f_left?>" tsp="<?=getArrKey($facCodes,$f_left)?>" a="<?=$l_a?>" <?=$l_ad?>><?=$f_left?></div>
                            <div p face="<?=$f_center?>" tsp="<?=getArrKey($facCodes,$f_center)?>" a="<?=$c_a?>" <?=$c_ad?>><?=$f_center?></div>
                            <div p face="<?=$f_right?>" tsp="<?=getArrKey($facCodes,$f_right)?>" a="<?=$r_a?>" <?=$r_ad?>><?=$f_right?></div>
                            <div></div>
                            <div p face="<?=$f_bot?>" tsp="<?=getArrKey($facCodes,$f_bot)?>" a="<?=$b_a?>" <?=$b_ad?>><?=$f_bot?></div>
                            <div></div>
                        </div>
                        <div></div>
                        <table width="100%" height="100%" border="0" class="tInfoTable hide" dir="ltr" style="<?=$t_ad?>">		
                            <tr>
                            <td width="25%" height="25%" x></td>								
                            <td face="<?=$f_top?>" tsp="<?=getArrKey($facCodes,$f_top)?>" a="<?=$parSt[$f_top]?>" <?=$t_ad?>><?=$f_top?></td>
                            <td width="25%" x></td>
                            </tr>
                            <tr>
                            <td face="<?=$f_left?>" tsp="<?=getArrKey($facCodes,$f_left)?>" a="<?=$parSt[$f_left]?>" <?=$l_ad?>><?=$f_left?></td>
                            <td face="<?=$f_center?>" tsp="<?=getArrKey($facCodes,$f_center)?>" class="ff B" a="<?=$parSt[$f_center]?>" <?=$c_ad?>><?=$f_center?></td>
                            <td face="<?=$f_right?>" tsp="<?=getArrKey($facCodes,$f_right)?>" a="<?=$parSt[$f_right]?>" <?=$r_ad?>><?=$f_right?></td>
                            </tr>
                            <tr>
                            <td height="25%" x></td>
                            <td face="<?=$f_bot?>" tsp="<?=getArrKey($facCodes,$f_bot)?>" a="<?=$parSt[$f_bot]?>" <?=$b_ad?>><?=$f_bot?></td>
                            <td x></td>
                            </tr>				
                        </table>						
                    </div><?
                }else{// Roots Parts 					
                    $rootStatusArr=array();
                    if($last_oprArr[0]){
                        $lopa=$last_oprArr[0];
                        $rootFukkClr=' style="background-color:'.$lopa['color'].'" title="'.$lopa['name'].'" ';
                    }else{
                        foreach($last_oprArr as $k => $lopa){						
                            $rootStatusArr[$k]=' style="background-color:'.$lopa['color'].'" title="'.$lopa['name'].'" ';
                        }
                    }?>
                    <div class="fxg" fxg="gtr:40px 1fr">
                        <div class="fs18 fl lh40 w100 cbg44 b_bord "><?					
                            $rSel=$rNo;
                            $actRootType='';			
                            if($rNo==0 && $lastCavNo==0){$rNo=1;}
                            if($cavities){
                                $roots=explode('|',$cavities);
                                echo '<div class="fr">';
                                foreach($roots as $k=>$r){
                                    $rr=explode(',',$r);
                                    $rn=$k+1;
                                    $class=3;
                                    if(($rn==$rNo && $lastCavNo==0) || ($lastCavNo==count($rr)) ){
                                        $class=1;
                                        $actRootType=$r;									
                                        echo script("actCavOrd=".$rn.";");
                                    }
                                    $n=pp($_POST['n']);
                                    $action =' crn="'.$rn.'" onclick1="actCavOrd='.$rn.';teethInfo('.$n.',2,1)"';
                                    echo '<div class="fr ic30x icc'.$class.' ic30n mg5f" '.$action.'>'.count($rr).'</div>';
                                }
                                echo '</div>';
                            }?>							
                        </div>  
                        <div class="fl w100 pd10f ">
                            <div class=" mainRoot cb cbg444" tB<?=$pos?>><?
                                if($actRootType){										
                                    $rRoot=explode(',',$actRootType);
                                    $rrRs=count($rRoot);
                                    $posN=substr($n,0,1);
                                    echo '<table border="0" width="100%" class="tRooTab" cellpadding="5" cellspacing="5"  '.$rootFukkClr.'><tr>';
                                    if($rrRs==1){
                                        $rn1=$rRoot[0];
                                        echo '<td><div class="rrr" tsp="'.$rn1.'" p '.$rootStatusArr[$rn1].'>'.$cavCodes[$rn1].'</div></td>';
                                    }							
                                    if($rrRs==2){
                                        $rn1=$rRoot[0];
                                        $rn2=$rRoot[1];
                                        $r1=$cavCodes[$rn1];
                                        $r2=$cavCodes[$rn2];									
                                        if($f_left==$r1 || $f_left==$r2){
                                            if($posN==1 || $posN==4){													
                                                $r1=$cavCodes[$rn2];
                                                $r2=$cavCodes[$rn1];
                                                $rn1=$rRoot[1];
                                                $rn2=$rRoot[0];
                                            }
                                            echo '
                                            <td><div class="rrr" tsp="'.$rn2.'" p '.$rootStatusArr[$rn2].'>'.$r2.'</div></td>
                                            <td><div class="rrr" tsp="'.$rn1.'" p '.$rootStatusArr[$rn1].'>'.$r1.'</div></td>';
                                        }else{
                                            echo '
                                            <td><div class="rrr" tsp="'.$rn2.'" p '.$rootStatusArr[$rn2].'>'.$r2.'</div></td></tr><tr><td><div class="rrr" tsp="'.$rn1.'" p '.$rootStatusArr[$rn1].'>'.$r1.'</div></td>';
                                        }
                                    }
                                    if($rrRs==3){
                                        $rn1=$rRoot[0];
                                        $rn2=$rRoot[1];
                                        $rn3=$rRoot[2];											
                                        $r1=$cavCodes[$rn1];
                                        $r2=$cavCodes[$rn2];
                                        $r3=$cavCodes[$rn3];
                                        if(($posN==2 || $posN==3) && ($f_top==$r1 || $f_bot==$r1) ){
                                            $rn2=$rRoot[2];
                                            $rn3=$rRoot[1];
                                            $r3=$cavCodes[$rn3];
                                            $r2=$cavCodes[$rn2];
                                        }											
                                        if($f_top==$r1){
                                            echo '
                                            <td colspan="2"><div class="rrr" tsp="'.$rn1.'" p '.$rootStatusArr[$rn1].'>'.$r1.'</div></td>
                                            </tr><tr>
                                            <td><div class="rrr" tsp="'.$rn2.'" p '.$rootStatusArr[$rn2].'>'.$r2.'</div></td>
                                            <td><div class="rrr" tsp="'.$rn3.'" p '.$rootStatusArr[$rn3].'>'.$r3.'</div></td>';
                                        }
                                        if($f_bot==$r1){
                                            echo '
                                            <td><div class="rrr" tsp="'.$rn2.'" p '.$rootStatusArr[$rn2].'>'.$r2.'</div></td>
                                            <td><div class="rrr" tsp="'.$rn3.'" p '.$rootStatusArr[$rn3].'>'.$r3.'</div></td>
                                            </tr><tr>
                                            <td colspan="2"><div class="rrr" tsp="'.$rn1.'" p '.$rootStatusArr[$rn1].'>'.$r1.'</div></td>';
                                        }											
                                        if($f_right==$r1){
                                            echo '
                                            <td><div class="rrr" tsp="'.$rn2.'" p '.$rootStatusArr[$rn2].'>'.$r2.'</div></td>
                                            <td rowspan="2"><div class="rrr" tsp="'.$rn1.'" p '.$rootStatusArr[$rn1].'>'.$r1.'</div></td>
                                            </tr><tr>												
                                            <td><div class="rrr" tsp="'.$rn3.'" p '.$rootStatusArr[$rn3].'>'.$r3.'</div></td>';
                                        }
                                        if($f_left==$r1){
                                            echo '
                                            <td rowspan="2"><div class="rrr" tsp="'.$rn1.'" p>'.$r1.'</div></td>
                                            <td><div class="rrr" tsp="'.$rn2.'" p '.$rootStatusArr[$rn2].'>'.$r2.'</div></td>
                                            </tr><tr>
                                            <td><div class="rrr" tsp="'.$rn3.'" p '.$rootStatusArr[$rn3].'>'.$r3.'</div></td>';
                                        }
                                    }
                                    if($rrRs==4){
                                        $rn1=$rRoot[0];
                                        $rn2=$rRoot[1];
                                        $rn3=$rRoot[2];
                                        $rn4=$rRoot[3];
                                        $r1=$cavCodes[$rn1];
                                        $r2=$cavCodes[$rn2];
                                        $r3=$cavCodes[$rn3];
                                        $r4=$cavCodes[$rn4];
                                        if(strlen($r1)==1){
                                            if(($posN==2 || $posN==3) && ($f_top==$r1 || $f_bot==$r1) ){
                                                $rn2=$rRoot[2];
                                                $rn3=$rRoot[1];
                                                $r3=$cavCodes[$rn3];
                                                $r2=$cavCodes[$rn2];
                                            }
                                            $rr1='<div class="rrr" tsp="'.$rn1.'" p '.$rootStatusArr[$rn1].'>'.$r1.'</div>';
                                            $rr2='<div class="rrr" tsp="'.$rn2.'" p '.$rootStatusArr[$rn2].'>'.$r2.'</div>';
                                            $rr3='<div class="rrr" tsp="'.$rn3.'" p '.$rootStatusArr[$rn3].'>'.$r3.'</div>
                                                  <div class="rrr" tsp="'.$rn4.'" p '.$rootStatusArr[$rn4].'>'.$r4.'</div>';

                                            if(($posN==2 || $posN==3) && ($f_top==$r1 || $f_bot==$r1) ){
                                                $rr3='<div class="rrr" tsp="'.$rn3.'" p '.$rootStatusArr[$rn3].'>'.$r3.'</div>';
                                                $rr2='<div class="rrr" tsp="'.$rn2.'" p '.$rootStatusArr[$rn2].'>'.$r2.'</div>
                                                      <div class="rrr" tsp="'.$rn4.'" p '.$rootStatusArr[$rn4].'>'.$r4.'</div>';
                                            }
                                            if($f_top==$r1){
                                                echo '<td colspan="2">'.$rr1.'</td></tr>
                                                <tr><td>'.$rr2.'</td><td>'.$rr3.'</td>';
                                            }
                                            if($f_bot==$r1){
                                                echo '<td>'.$rr2.'</td><td>'.$rr3.'</td></tr>
                                                <tr><td colspan="2" >'.$rr1.'</td>';
                                            }
                                            if($f_right==$r1){
                                                echo '<td>'.$rr2.'</td><td rowspan="2">'.$rr1.'</td></tr>
                                                <tr><td>'.$rr3.'</td>';
                                            }
                                            if($f_left==$r1){
                                                echo '<td rowspan="2">'.$rr1.'</td><td>'.$rr2.'</td></tr>
                                                <tr><td>'.$rr3.'</td>';
                                            }
                                        }else{
                                            $rr1='<div class="rrr" tsp="'.$rn1.'" p '.$rootStatusArr[$rn1].'>'.$r1.'</div>';
                                            $rr2='<div class="rrr" tsp="'.$rn2.'" p '.$rootStatusArr[$rn2].'>'.$r2.'</div>';
                                            $rr3='<div class="rrr" tsp="'.$rn3.'" p '.$rootStatusArr[$rn3].'>'.$r3.'</div>';
                                            $rr4='<div class="rrr" tsp="'.$rn4.'" p '.$rootStatusArr[$rn4].'>'.$r4.'</div>';
                                            if(($posN==1 || $posN==4) ){
                                                $rr1='<div class="rrr" tsp="'.$rn2.'" p '.$rootStatusArr[$rn2].'>'.$r2.'</div>';
                                                $rr2='<div class="rrr" tsp="'.$rn1.'" p '.$rootStatusArr[$rn1].'>'.$r1.'</div>';
                                                $rr3='<div class="rrr" tsp="'.$rn4.'" p '.$rootStatusArr[$rn4].'>'.$r4.'</div>';
                                                $rr4='<div class="rrr" tsp="'.$rn3.'" p '.$rootStatusArr[$rn3].'>'.$r3.'</div>';
                                            }
                                            echo '<td>'.$rr1.'</td><td>'.$rr2.'</td></tr>
                                            <tr><td>'.$rr4.'</td><td>'.$rr3.'</td>';
                                        }
                                    }
                                    echo '</tr></table>';
                                }?>
                            </div>
                        </div>
                    </div><?
                }?>				
            </div>
            <div class="ofx so l_bord cbg444 fxg" fxg="gtr:40px 1fr">                
                <div class="fl f1  lh40 b_bord w100 cbg4 TC"><?=k_prev_stats?></div>                
                <div class="cb ofx so pd10f">
                    <?=$hisData?>
                </div>				
            </div>
        </div><?
	}
}?>