<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$vis=pp($_POST['vis']);
	if(isset($_POST['type'])){
		$type=pp($_POST['type']);
		$sub_id=pp($_POST['vis']);
        $q='';
        if($sub_id){$q=" and x_srv='$sub_id'" ;}
        $sql="select * from den_x_visits_services_levels where patient='$id' $q order by date ASC";
        $res=mysql_q($sql);
        $rows=mysql_n($res);
        $levelsArr=array();
        while($r=mysql_f($res)){
            $l_id=$r['id'];
            $levelsArr[$l_id]=$r;
        }	
		if($type==1){
			$oprsArr=array();
			$sql="select * from den_x_visits_services where patient ='$id'  order by d_start DESC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows){
				$out.='<div class="denOpsL">';
				while($r=mysql_f($res)){
					$s_id=$r['id'];
					$service=$r['service'];
					$d_start=$r['d_start'];
					$status=$r['status'];
					$teeth=$r['teeth'];
					$doctor=$r['doc'];
					$end_percet=$r['end_percet'];
                    $note=$r['note'];
					$serviceTxt=get_val_arr('den_m_services','name_'.$lg,$service,'srv');
					if($doctor){
						$doctorTxt='<div class="f1 lh30 clr5 ">'.k_dr.' : '.get_val_arr('_users','name_'.$lg,$doctor,'doc').'</div>';
					}
					$oprsArr[$s_id]=$r;
					$oprsArr[$s_id]['srvName']=$serviceTxt;
					$teethTxt='';
                    if($teeth){
                        $tt=explode(',',$teeth);
                        $teethTxt.='<div t class="teethNo">';
                        foreach($tt as $ttt){$teethTxt.='<div>'.$ttt.'</div>';}
                        $teethTxt.='</div>';
                    }
					$priceButt='';
					if($doctor==$thisUser && $status==0 && $PER_ID=='afoxbse28f'){ 
						$priceButt='<div class="fr i30 i30_price" title="'.k_edit_price.'" ></div>';
					}
					$end_percet_txt='';
					if($end_percet){$end_percet_txt.='<div class="fr ff B fs14 cbg66 pd5 clrw">%'.$end_percet.'</div>';}
					list($s_ids,$subServ,$percet)=get_vals('den_m_services_levels','id,name_'.$lg.',percet'," service=$service",'arr');					
                    $out.='
                    <div class="fl w100 mg5v pd20 pd10v br5" oprNo1="'.$s_id.'" '.$act.' onclick="loadHisMoodN('.$type.','.$s_id.')">
                        <div class="f1 lh20 clr2 fs14">'.splitNo($serviceTxt).'</div>'.$doctorTxt.'
                        <div class="f1" dSta="'.$status.'">'.$denSrvS[$status].'</div>
                        <div class="mg10v t_bord ph10v">
                            <div d class="fr lh30"><ff14>'.date('Y-m-d',$d_start).'</ff14></div>
                            <div class="fl lh30 ">'.$teethTxt.'</div>
                        </div>
                    </div>';
				}
				$out.='</div>';
			}else{$out.='<div class="f1  lh40">'.k_no_ctin.'</div>';}
			echo $out;
			echo '^';
			foreach($oprsArr as $k=>$o){
				$teethTxt='';                
				if($sub_id==$k || $sub_id==0){
					$teeth=$o['teeth'];	
					$status=$o['status'];
					$srv_doc=$o['doc'];
                    $note=$o['note'];
					$teethTxt='';
                    if($teeth){
                        $tt=explode(',',$teeth);
                        $teethTxt.='<div t class="teethNo">';
                        foreach($tt as $ttt){$teethTxt.='<div>'.$ttt.'</div>';}
                        $teethTxt.='</div>';
                    }
					?>
                    <div class="fl w100 bord cbg444 br5 mg5v pr">
                        <div class="fl w100 pd20 pd10v cbg4 b_bord">
                            <div d class="fr lh30">
                                <ff14><?=date('Y-m-d',$d_start)?></ff14>
                                <div class="lh30 "><?=$teethTxt?></div>
                            </div>
                            <div class="f1 lh20 clr2 fs14"><?=splitNo($o['srvName'])?> 
                                <ff class="lh30 fs14 B clr5" dir="ltr"> ( £ <?=number_format($o['total_pay'])?> )</ff>
                            </div><? 
                            if($srv_doc){?>
                                <div class="lh30 fs12 f1 clr66 ">
                                    <?=k_dr.' : '.get_val_arr('_users','name_'.$lg,$srv_doc,'doc')?>
                                </div><?
                            }?>
                            <div class="f1" dSta="<?=$status?>">
                                <?=$denSrvS[$status]?> 
                                <ff class="TR lh20 ff fs14 B clr6" title="<?=k_complete_percent?>">
                                    ( %<?=$o['end_percet']?> )
                                </ff>
                            </div>
                        </div><? 
                        if(count($levelsArr)>0){?>
                            <div class="fl w100  pd10f">
                                <div class="f1 clr1 fs14"><?=$note?></div><?
                                foreach($levelsArr as $kk=>$l){
                                    if($l['x_srv']==$k){
                                        $l_id=$l['id'];
                                        $l_status=$l['status'];
                                        $l_date_e=$l['date_e'];
                                        $lev_perc=$l['lev_perc'];
                                        if($l_status==2){$dateS=$l_date_e;}
                                        $dateSTxt='';
                                        $dateS=intval($dateS);
                                        if($dateS){$dateSTxt=' <ff dir="ltr" class="fs12"> (  '.date('Y-m-d',$dateS). ')</ff>';}
                                        $levName=get_val_arr('den_m_services_levels','name_'.$lg,$l['lev'],'ln');?>
                                        <div class="ofx pd10v cbgw mg10v w100 br5 bord">
                                            <div class="fl w100 lh30 pd10 ">
                                                <div class="fl lh30 f1  fs14">
                                                    <?=splitNo($levName)?><ff14> (%<?=$lev_perc?>)</ff14>
                                                    <div class="f1 fs12 pd5 lh20  clr9 cb"><?=$denlevS[$l_status].$dateSTxt?></div>
                                                </div>								
                                            </div><? 
                                            $lTxt='';
                                            $notes='';
                                            $sql2="select * from den_x_visits_services_levels_txt where  x_lev='$kk' order by date ASC ";
                                            $res2=mysql_q($sql2);
                                            $rows2=mysql_n($res2);
                                            if($rows2>0){        
                                                $lTxt='';
                                                while($r2=mysql_f($res2)){                                                    
                                                    $l_id=$r2['id'];
                                                    $date=$r2['date'];
                                                    $txt=$r2['txt'];
                                                    $l_status=$r['status'];
                                                    $lTxt.='<div class="levTxt w100 lh30" levTxt="'.$l_id.'">
                                                        <div d><ff14>'.date('Y-m-d',$date).' |</ff14></div>
                                                        <div t class="f1 fs14">'.$txt.'</div>
                                                    </div>';
                                                }
                                            }
                                            if($l_status!=2){                                                
                                                $notes.='<div levTxts class="pd10">'.$lTxt.'</div>';
                                            }else{
                                                if($lTxt){$notes.='<div levTxts>'.$lTxt.'</div>';}
                                            }
                                            if($notes){echo '<div class=" fr w100 t_bord">'.$notes.'</div>';}?>	
                                        </div><?
                                    }
                                }?>
                            </div><?
                        }?>
                    </div><?
				}
			}
		}
		if($type==2){
			$oprsArr=array();
			$sql="select * from den_x_visits where patient ='$id'  order by d_start DESC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows){
				$out.='<div>';
				while($r=mysql_f($res)){
					$s_id=$r['id'];					
					$d_start=$r['d_start'];
					$doctor=$r['doctor'];
					$docName=get_val_arr('_users','name_'.$lg,$r['doctor'],'dl');
					$cls='cbg444';
					if($sub_id==$s_id){$cls='cbg666';}
					$out.='<div class="'.$cls.' br5 cbgw bord uLine Over"  onclick="loadHisMoodN('.$type.','.$s_id.')">
						<div class="lh40 f1  pd10 b_bord"><ff14>#'.$r['id'].' | </ff14>'.$docName.'</div>
						<div class="fs14 ff B lh30 pd10">'.date('Y-m-d',$d_start).'</div>
					</div>';
					$oprsArr[$s_id]=$r;
				}
				$out.='</div>';
			}else{$out.='<div class="f1 lh40">'.k_no_ctin.' </div>';}
			echo $out;
			echo '^';
			$q='';
			if($sub_id){$q=" and vis='$sub_id'" ;}			
			foreach($oprsArr as $k=>$o){
				if($sub_id==$k || $sub_id==0){					
					if($o['doctor']){$docName=get_val_arr('_users','name_'.$lg,$o['doctor'],'dl');}				
					echo '
                    <div class="fl w100 bord cbg444 br5 mg5v pr">
                        <div class="fl w100 pd20 pd10v cbg4 b_bord f1">
                            <ff14>'.$k.' | </ff14>'.$docName.' <ff14 dir="ltr"> ( '.date('Y-m-d',$o['d_start']).' ) </ff14>
                        </div>
                        <div class="fl w100 bord b_bord3 pd10">';
                        foreach($levelsArr as $kk=>$l){
                            if($l['vis']==$k){
                                $levName=get_val_arr('den_m_services_levels','name_'.$lg,$l['lev'],'ln');
                                $srvName=get_val_arr('den_m_services','name_'.$lg,$l['srv'],'sn');
                                $levwork=get_val_arr('den_m_services_levels_text','des',$l['val'],'lw');

                                echo '<div class="f1 fs14 clr1111 lh40">
                                    '.$srvName.' <span class="f1 fs14 clr111 lh30"> ( '.$levName.' )</span>
                                </div>';

                                ?><div class="fl mg10vf pd5 levDes" fix="wp:0">
                                    <div class="cb f1 fs12x lh30 pd5v"><?=nl2br($levwork)?></div>
                                </div><?
                            }
                        }
                        echo '</div>
                    </div>';
				}
			}
		}
	}else{?>
        <div class="h100 fxg of" fxg="gtc:300px 1fr|gtr:100%">
            <div class="fl r_bord cbg4 fxg of" fxg="gtr: 1fr">
                <div class="b_bord hide">
                    <select t id="dHisType" class="br0 b_bord" onChange="loadHisMoodN(this.value,0)">
                        <option value="1"><?=k_srt_by_proc?></option>
                        <option value="2"><?=k_srt_by_visit?></option>
                    </select>
                </div>
                <div class="ofx so pd10f" id="hisList"></div>
            </div>
            <div class="fl ofx pd10 pd5v so" id="hisDes"></div>
            <div class="hide">
                <? $doctor=get_val('den_x_visits','doctor',$vis);
                $denPrv='_Preview-Den.'.$vis;
                if(_set_7h5mip7t6n){$denPrv='_Preview-Den-new.'.$vis;}
                //if($doctor==$thisUser && $PER_ID=='hj0wkb3z83'){?>
                    <div class="bu bu_t1 fl" onclick="loc('<?=$denPrv?>');"><?=k_edit?></div>
                <? //}
                //if($thisGrp=='hrwgtql5wk' && $chPer[3]){?>
                    <div class="bu bu_t3 fl" onclick="delVisAcc(<?=$vis?>,4,0);"><?=k_delete?></div>
                <? //}?>			
            </div>
        </div><?
	}
}?>