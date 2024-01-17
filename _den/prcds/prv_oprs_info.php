<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'],$_POST['pat'],$_POST['id'])){
	$vis=pp($_POST['vis']);
	$pat=pp($_POST['pat']);
	$srv=pp($_POST['id']);	
	$r=getRec('den_x_visits_services',$srv);		
	if($r['r']){
		$service=$r['service'];
		$teeth=$r['teeth'];
		$d_start=$r['d_start'];
		$status=$r['status'];
		$serDoc=$r['doc'];
		$serDoc_add=$r['doc_add'];
		$end_percet=$r['end_percet'];
		$price=$r['total_pay'];
        $note=$r['note'];
		$serviceTxt=get_val_arr('den_m_services','name_'.$lg,$service,'srv');
		if($status==0 && $serDoc==0){$status=4;}
		$editOpr=1;
		if(_set_nukjs8og6f==0){$editOpr=0;}
		if(_set_nukjs8og6f==1){if($d_start<$ss_day){$editOpr=0;}}		
		$deOpr=1;
		if($d_start<$ss_day  && $status!=4){ $deOpr=0;}
		$teethTxt='';
		if($teeth){
			$selTeeth=$teeth;
			$tt=explode(',',$teeth);
			$teethTxt.='<div class="teethNo">';
			foreach($tt as $ttt){$teethTxt.='<div>'.$ttt.'</div>';}
			$teethTxt.='&nbsp;</div>';
		}
		if($serDoc==$thisUser || $serDoc==0){?>
            <div class="fl f1 fs16 h100 w100 fxg" fxg="gtr: auto 1fr">
                <div class="fl cbg444 orpInfoTi fxg-als-s b_bord">    
                    <div class="fl lh30 fs14 f1 pd10 pd5v w100">
                        <ff14>#<?=$srv?> | </ff14>
                        <?=splitNo($serviceTxt)?>
                        <ff14 class=" clr6 ff fs16 lh30" dir="ltr" title="<?=k_price_serv?>"> (£ <?=number_format($price)?>)</ff14>
                        <div class="fr"><?=$teethTxt?></div>
                    </div>
                    <div class="fl w100 pd5 lh40">
                        <div class="fl f1  fs12 lh40 " dSta="<?=$status?>"><?=$denSrvS[$status]?> <ff14 title="<?=k_completed_percent?> ">(%<?=$end_percet?>)</ff14></div><? 			
                        if($status==1){?>
                            <div class="fr ic30 ic30_done ic30Txt icc4 mg5" endAll><?=k_term_levels?></div><?
                        }
                        if(($status==1 || ($status==4 && $serDoc_add==$thisUser)) && $deOpr){?>
                            <div class="fr ic30 ic30_del ic30Txt icc2 mg5" srvDel><?=k_del_proce?></div><?
                        }
                        if($status==1 && $editOpr){?>
                            <div class="fr ic30 ic30_price ic30Txt icc1 mg5" srvPrice><?=k_edit_price?></div><?
                        }?>                        
                    </div>
                </div>
                <div class="of">
                    <div class="fl w100 h100 pd20f ofx so fxg-als-s"><?
                        if($status==4){
                            echo '<div class="cbg444 bord pd20f br5">
                                <div class="f1 lh40 fs14 clr3"> '.k_planned_at.' <ff class="fs16" dir="ltr">'.date('Y-m-d',$d_start).'</ff></div>
                                <div class="f1 lh30 fs14 clr3">'.k_planned_by.': '.get_val('_users','name_'.$lg,$serDoc_add).'</div>

                                <div class="f1 lh40 fs16 clr3">'.k_price.': <ff class="clr1">'.number_format($price).'</ff></div>';
                                if($note){
                                    echo '<div class="f1 lh30 fs16 clr3">'.k_note.':<br> <span class="clr5 f1 fs14 lh30">'.$note.'</span></div>';
                                }
                                echo '<div class="fl ic40 ic40_save ic40Txt icc4" startSrv>'.k_start_proce.'</div>
                                <div class="cb"></div>
                            </div>';
                        }else{
                            if($note){
                                echo '<div class="f1 clr5 fs14 uLine lh30">'.k_note.': '.$note.'</div>';
                            }
                            $levData=array();
                            $sql="select * from den_x_visits_services_levels where x_srv='$srv' order by id ASC";
                            $res=mysql_q($sql);
                            $rows=mysql_n($res);
                            if($rows){
                                $i=1;
                                while($r=mysql_f($res)){
                                    $id=$r['id'];
                                    $lev=$r['lev'];
                                    $lev_perc=$r['lev_perc'];
                                    $l_status=$r['status'];
                                    $l_date=$r['date'];
                                    $l_date_e=$r['date_e'];
                                    list($levTxt,$levReq)=get_val('den_m_services_levels','name_'.$lg.',req',$lev);
                                    $dateS=$l_date;
                                    if($l_status==2){$dateS=$l_date_e;}
                                    if($dateS){$dateS=' <ff dir="ltr" class="fs12"> (  '.date('Y-m-d',$dateS). ')</ff>';}?>
                                    <div class="fl w100 cbg444 mg10v pd10f bord br5 oprlS<?=$l_status?>" lev="<?=$id?>" mlev="<?=$lev?>" srv="<?=$service?>"><?
                                        $lTxt='';
                                        $notes='';
                                        $sql2="select * from den_x_visits_services_levels_txt where x_srv='$srv' and x_lev='$id' order by date ASC ";
                                        $res2=mysql_q($sql2);
                                        $rows2=mysql_n($res2);?>
                                        <div class="fl w100 lh30">
                                            <div class="fl  w100">
                                                <div class="fl">
                                                    <div class="lh20 f1 fs14">
                                                        <?=splitNo($levTxt)?> <ff14> (%<?=$lev_perc?>)</ff14>
                                                    </div>
                                                    <div class="f1 fs12 pd5 lh30 fl clr9"><?=$denlevS[$l_status].$dateS?></div>
                                                </div><?
                                                if($l_status!=2){
                                                    $h='hide';
                                                    if($levReq==0 || $rows2>0){$h='';}?>
                                                    <div class="fr ic30 icc4 ic30_done <?=$h?>" title="<?=k_end_level?>" req="<?=$levReq?>" levDone></div><?
                                                }else{
                                                    if(inThisDay($l_date_e)){?>
                                                        <div class="fr ic30 icc1 ic30_ref" title="<?=k_reopen_level?>" levRes></div><?
                                                    }
                                                }?>
                                            </div><?
                                           
                                            if($rows2>0){        
                                                $lTxt='';
                                                while($r2=mysql_f($res2)){                                                    
                                                    $l_id=$r2['id'];
                                                    $date=$r2['date'];
                                                    $txt=$r2['txt'];
                                                    $l_status=$r['status'];
                                                    $butts='';
                                                    if($l_status!=2){
                                                        $butts='
                                                        <div class="i30 i30_del" title="'.k_delete_note.'" levDel butt></div>
                                                        <div class="i30 i30_edit" title="'.k_edit.'" levEdit butt></div>
                                                        <div class="cbg5 f1 clrw" levDelCnc >تراجع</div>';
                                                    }
                                                    $lTxt.='<div class="levTxt w100" levTxt="'.$l_id.'">
                                                        <div d><ff14>'.date('Y-m-d',$date).' |</ff14></div>
                                                        <div t class="f1 fs14">'.$txt.'</div>
                                                        '.$butts.'
                                                    </div>';
                                                }
                                            }
                                            if($l_status!=2){                                                
                                                $notes.='<div levTxts>'.$lTxt.'</div>
                                                <div noteInput></div>
                                                <div class=" ic30 ic30_add ic30Txt icc22 w100 br2 fl" levAdd> '.k_add_note.'</div>';
                                            }else{
                                                if($lTxt){$notes.='<div levTxts>'.$lTxt.'</div>';}
                                            }
                                            if($notes){
                                                echo '<div class=" fr w100 t_bord">'.$notes.'</div>';
                                            }?>
                                        </div>
                                    </div><?
                                    $i++;
                                }
                            }
                        }?>
                    </div>
                </div>
            </div><?
		}else{
			echo '<div class="f1 fs14 lh40 clr5 pd10">الخدمة مسجلة باسم طبيب أخر</div>';
		}
	}				
}?>