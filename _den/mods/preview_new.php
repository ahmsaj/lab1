<? include("../../__sys/mods/protected.php");?>
<? $mood=4;
$visit_id=pp($_GET['m_id']);
$r=getRec('den_x_visits',$visit_id);
if($r['r']){?>
	<script src="<?=$m_path?>library/Highcharts/highcharts.src.js"></script>
	<script src="<?=$m_path?>library/Highcharts/highcharts-more.js"></script><?
	$_SESSION['denVis']=$visit_id;
	$status=$r['status'];
	$type=$r['type'];
	if($status==0){
		if(mysql_q("UPDATE den_x_visits SET status=1 where status=0 and id='$visit_id' and doctor='$thisUser'")){$status=1;}
	}            
	$patient_id=$r['patient'];
	$clinic=$r['clinic'];
    list($sex,$birth)=get_val('gnr_m_patients','sex,birth_date',$patient_id);
	$birthCount=birthCount($birth);
	$age=birthByTypes($birth);
	$years=$age[0];
	$scType=2;
    $actSection=2;
	if($years>6){$scType=1;}	
	if($status==2 || $status==3){
		mysql_q("UPDATE gnr_x_roles set status=4 where vis='$visit_id' and mood=$mood");
		delTempOpr($mood,$visit_id,'a');
		if($status==3){
			loc('_Visit-Den');
			exit;
		}
	}
    /****************************************/
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
    $teethSubSt=get_arr('den_m_set_teeth_sub','id','status_id,name_'.$lg,"id>0");
    /********************************************/
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
    $teethSubSt=get_arr('den_m_set_teeth_sub','id','status_id,name_'.$lg,"id>0");
    /****************************************/?>
    <div class="inWinD fl h100 w100" fix="hp:0|wp:0">
        <div h class="fl">
            <div class="fr ic30x icc2 ic30_x mg5f" title="<?=k_close?>" id="exWinD"></div>
            <div class="fl f1 fs16 pd10" id="iwT"></div>
        </div>
        <div b class="fl ofxy so cbg4" fix="hp:40|wp:0" id="iwB"></div>
    </div>
    <div class="theethMsg" fix="wp:0">
        <div class="fl f1 fs14 pd10">حدد الأسنان المستهدمة من نوع ( <span class="f1 fs14"></span> )</div>
        <div class="fr ic40x br0 ic40_x icc2" closeTee></div>        
    </div>
    <div class="centerSideInFull of fxg" viewType="1">
        <div class="cbg2 d_c1 fxg w100" fxg="gtr:auto auto auto auto 1fr">
            <div class=" w100 lh40 cbg3 clrw f1 fxg" prvVisTool fxg="gtc:1fr 40px 40px ">
            <div class="fl ic40x icc11 ic40_vedio br0 hide" help title="مساعدة"></div>
            <div class="Over cbg2" title="المرضى بالانتظار" id="patWs" <?=$swAction?>>
                <div class="fl patsIco"></div>
                <div class="fl pd10 ff lh40 fs18" id="patNo">0</div>
            </div>
            <div class="fr ic40x icc33 ic40_ref br0" back title="رجوع للزيارات"></div> 
            <div class="fr ic40x icc2 ic40_done br0" finish title="إنهاء الزيارة"></div>
            </div>
            <div class="cbg3  Over clrw pd10v patBlc" onclick="editPat(<?=$patient_id?>,2)">
                <div class="f1s fs16 lh30 pd10">
                    <ff><?=$patient_id?></ff> | <?=get_p_name($patient_id,0)?> <ff>
                </div>
                <div class="fs12 lh20 pd10">
                    ( <?=$birthCount[0]?> </ff> <?=$birthCount[1]?> )
                </div>
            </div>
            <div class="d_c1_b1" actButt="act">
                <div class="f1 fxg" act dOpr="1" fxg="gtc:50px 1fr 25px;">
                    <div dIc></div>
                    <div class="f1 fs16">إجراءات الأسنان</div>
                    <div class="flip" arr></div>
                </div>
                <div class="f1 fxg" dOpr="2" fxg="gtc:50px 1fr 25px;">
                    <div dIc></div>
                    <div class="f1 fs16">تشريح الأسنان</div>
                    <div class="flip" arr></div>
                </div>
                <? if(getTotalCo('den_m_prv_clinical',"act=1 ")){?>
                    <div class="f1 fxg" dOpr="3" fxg="gtc:50px 1fr 25px;">
                        <div dIc></div>
                        <div class="f1 fs16">الفحص السريري</div>
                        <div class="flip" arr></div>
                    </div>
                <? }?>
            </div>
            <div id="timeSecDen" class="fl w100"></div>
        </div>
        <div class="fxg h100 r_bord " sc="1" fxg="gtr:40px 40px 1fr|gtc:100%">
            <div class="fxg dListTit dListT1 b_bord" fxg="gtc:40px 1fr 40px">
                <div dIc></div>
                <div class="f1 fs16 pd10">إجراءات الأسنان</div>
                <div class="ic40x ic40_add icc22 Over br0" addOprD ></div>
            </div>
            <div class="lh40 cbg4" >
                <div class="cbg4" >
                    <select class="cbg444" t oprList><? 
                        foreach($den_oprList as $k=> $v){
                            if($k){
                                $sel='';
                                if($k==$viewType){ $sel=' selected ';}
                                echo '<option value="'.$k.'" '.$sel.'>'.$v.'</option>';
                            }
                        }?>
                    </select>
                </div>
            </div>
            <div class=" cbg4 ofx so t_bord " id="denListSec"></div>
        </div>
        
        <div class="fl of hide" id="denDetiaSec" sc="1"></div>
        <div class="fl of hide" theethMap="1" sc="2" id="teethDetiaSec">
            <div class="r_bord b_bord f1 pd10 lh40 cbg4 fs14" hPart>حالات الأسنان</div>
            <div class="b_bord fxg" fxg="gtc:40px 1fr ">                    
                <div class="ic40x ic40_sw br0 icc22" teethSw title="تبديل مخطط الأسنان"></div>
                <div>
                    <div class="lh40 f1 fs14 tt_ic tt_ic_c b_bord" tt="1"><?=k_permanent_teeth?></div>
                    <div class="lh40 f1 fs14 tt_ic tt_ic_a b_bord hide" tt="2"><?=k_deciduous_teeth?></div>
                </div>
            </div>
            <div class="r_bord ofx so tToolH pd10 pd5v cbg444" hPart><? 
                $t=1;
                foreach($oprDataArr as $r){			
                    $icon=$r['icon'];
                    $use_by=$r['use_by'];
                    $type=$r['type'];
                    $opr_type=$r['opr_type'];
                    if($type==$t && $opr_type==1){
                        $ph_src=viewImage($icon,1,25,25,'img','clinic.png');

                        $subDat='';
                        foreach($teethSubSt as $k=>$v){
                            if($v['status_id']==$r['opr']){
                                $subDat.='<div class="f1 b_bord" txt="'.$v['name_'.$lg].'" partType="'.$t.'" noS="'.$k.'" pno="'.$r['opr'].'" style="background-color:'.$r['color'].'">'.$v['name_'.$lg].'</div>';
                            }
                        }
                        $att='no';
                        if($subDat){$att='noP';}
                        echo '<div class="bord" '.$att.'="'.$r['opr'].'" partType="'.$t.'" clr="'.$r['color'].'"  txt="'.$r['name'].'" style="background-color:'.$r['color'].'">
                             <div class="" i >'.$ph_src.'</div>
                             <div class="f1 pd10" t>'.$r['name'].'</div>
                        </div>';                            


                        if($subDat){
                            echo '<div class="bord " subTee="'.$r['opr'].'" style="background-color:'.$r['color'].'">'.$subDat.'</div>';
                        }
                    }
                }
                $t=2;
                foreach($oprDataArr as $r){			
                    $icon=$r['icon'];
                    $use_by=$r['use_by'];
                    $type=$r['type'];
                    $opr_type=$r['opr_type'];
                    if($type==$t && $opr_type==1){
                        $ph_src=viewImage($icon,1,25,25,'img','clinic.png');

                        $subDat='';
                        foreach($teethSubSt as $k=>$v){
                            if($v['status_id']==$r['opr']){
                                $subDat.='<div class="f1 b_bord" txt="'.$v['name_'.$lg].'" partType="'.$t.'" noS="'.$k.'" pno="'.$r['opr'].'" style="background-color:'.$r['color'].'">'.$v['name_'.$lg].'</div>';
                            }
                        }
                        $att='no';
                        if($subDat){$att='noP';}
                        echo '<div class="bord" '.$att.'="'.$r['opr'].'" partType="'.$t.'" clr="'.$r['color'].'"  txt="'.$r['name'].'" style="background-color:'.$r['color'].'">
                             <div class="" i >'.$ph_src.'</div>
                             <div class="f1 pd10" t>'.$r['name'].'</div>
                        </div>';                            


                        if($subDat){
                            echo '<div class="bord " subTee="'.$r['opr'].'" style="background-color:'.$r['color'].'">'.$subDat.'</div>';
                        }
                    }
                }
                ?>
            </div>
            <div class="" id="teethMap" selMood="0"></div>
            <div class="of fxg t_bord" fxg="gcs:2|gtc:1fr 3fr|gtr:40px 1fr">
                <div class="theethMsgS" fix="wp:0">                    
                    <div class="fl f1 fs14 pd10">حدد الأجزاء المستهدمة من نوع ( <span class="f1 fs14"></span> )</div>
                    <div class="fr ic40x br0 ic40_x icc1" closeTeeS></div>
                </div>
                <div class="r_bord b_bord f1 pd10 lh40 fs12 cbg66 clrw TC">الحالات الفرعية</div>
                <div class=" b_bord  lh40 cbg66 clrw">
                    <div class="fl f1 fs12 pd10" teethTitle></div>
                    <div class="fr ic40x br0 ic40_x icc2" closeTeeth></div>
                </div>
                <div class="r_bord ofx so cbg444">
                    <div>                        
                        <div class="tToolHS pd10 pd5v cbg444 hide" teethSub="1"><?
                            $t=1;
                            foreach($oprDataArr as $r){			
                                $icon=$r['icon'];
                                $use_by=$r['use_by'];
                                $type=$r['type'];
                                $opr_type=$r['opr_type'];
                                if($type==$t && $opr_type==2){
                                    $ph_src=viewImage($icon,1,25,25,'img','clinic.png');
                                    $subDat='';
                                    foreach($teethSubSt as $k=>$v){
                                        if($v['status_id']==$r['opr']){
                                            $subDat.='<div class="f1 b_bord" txt="'.$v['name_'.$lg].'" partType="'.$t.'" noS="'.$k.'" pno="'.$r['opr'].'" style="background-color:'.$r['color'].'">'.$v['name_'.$lg].'</div>';
                                        }
                                    }
                                    $att='no';
                                    if($subDat){$att='noP';}
                                    echo '<div class="bord" '.$att.'="'.$r['opr'].'" partType="'.$t.'" clr="'.$r['color'].'"  txt="'.$r['name'].'" style="background-color:'.$r['color'].'">
                                         <div class="" i >'.$ph_src.'</div>
                                         <div class="f1 pd10" t>'.$r['name'].'</div>
                                    </div>';                            


                                    if($subDat){
                                        echo '<div class="bord " subTee="'.$r['opr'].'" style="background-color:'.$r['color'].'">'.$subDat.'</div>';
                                    }
                                }
                            }?>
                        </div>
                        <div class="tToolHS pd10 pd5v cbg444 hide" teethSub="2"><?
                            $t=2;
                            foreach($oprDataArr as $r){			
                            $icon=$r['icon'];
                            $use_by=$r['use_by'];
                            $type=$r['type'];
                            $opr_type=$r['opr_type'];
                            if($type==$t && $opr_type==2){
                                $ph_src=viewImage($icon,1,25,25,'img');
                                $subDat='';
                                /*foreach($teethSubSt as $k=>$v){
                                    if($v['status_id']==$r['opr']){
                                        $subDat.='<div class="f1 b_bord" txt="'.$v['name_'.$lg].'" partType="'.$t.'" noS="'.$k.'" pno="'.$r['opr'].'" style="background-color:'.$r['color'].'">'.$v['name_'.$lg].'</div>';
                                    }
                                }*/
                                $att='no';
                                if($subDat){$att='noP';}
                                echo '<div class="bord" '.$att.'="'.$r['opr'].'" partType="'.$t.'" clr="'.$r['color'].'"  txt="'.$r['name'].'" style="background-color:'.$r['color'].'">
                                     <div class="" i >'.$ph_src.'</div>
                                     <div class="f1 pd10" t>'.$r['name'].'</div>
                                </div>';                            


                                if($subDat){
                                    echo '<div class="bord " subTee="'.$r['opr'].'" style="background-color:'.$r['color'].'">'.$subDat.'</div>';
                                }
                            }
                        }
                        ?>
                        </div>
                    </div>
                </div>
                <div class="of" teethInfo selMoodS="0"></div>            
            </div>    
        </div>
        <div class="fl of hide fxg h100 cbg4 r_bord" fxg="gtr:40px 1fr"  sc="3" >
            <div class="f1 fs14 lh40 pd10 b_bord denCliTi">الفحص السريري </div>
            <div class="clinicDenList ofx so" actButt="act">
                <?
                $sql="select * from den_m_prv_clinical where act=1 order by ord ASC";
                $res=mysql_q($sql);
                $rows=mysql_n($res);
                if($rows){
                    echo '<div n="0" act><div i></div><div t>كل التفاصيل</div><div arr class="flip"></div></div>';
                    while($r=mysql_f($res)){
                        $id=$r['id'];
                        $name=$r['name_'.$lg];
                        $icon=$r['icon'];
                        $iconView='';
                        if($icon){
                            $iconView=viewImage($icon,0,40,40,'img');
                        }
                        echo '<div n="'.$id.'"><div i>'.$iconView.'</div><div t>'.$name.'</div><div arr class="flip"></div></div>';
                    }
                }?>
            </div>
        </div>
        <div class="fl ofx so hide pd10f h100" id="denClinicaDet" sc="3" ></div>
        <div class="fl cp_s4 cbg2 ofx so">
            <div class="prvOprList"><?                
                echo clnOprList('أرشيف الإجراءات','prvTop_denOpr','denHisN('.$patient_id.','.$visit_id.')');
                if(chProUsed('dts')){
                    echo clnOprList(k_appointments,'prvTop_dts','selDtSrvs('.$clinic.',0,'.$patient_id.')');
                }				
                if(modPer('b8kpe202f3','0')){
                    echo clnOprList('المستندات','prvTop_doc','patDocs('.$patient_id.',1)');		
                }
                echo clnOprList('السجل الطبي','prvTop_rec','pat_hl_rec(1,'.$patient_id.',\''.$patName.'\')');
                $oprSt=checkOPrEx('prc',$patient_id);
                echo clnOprList(k_precpiction,'prvTop_pre','prescrs('.$mood.',0)',$oprSt,'prc');                
                $oprSt=checkOPrEx('ana',$patient_id);
                echo clnOprList(k_tests,'prvTop_ana','AnalysisN(0,'.$anType.')',$oprSt,'ana');
                if(chProUsed('xry')){
                    $oprSt=checkOPrEx('xry',$patient_id);
                    echo clnOprList(k_radiograph_s,'prvTop_xry','m_xphotoN(0)',$oprSt,'xry');
                }?>
            </div>
        </div>
    </div>
    <script>
		sezPage='denPrvNew';
		visit_id=<?=$visit_id?>;
		patient_id=<?=$patient_id?>;		
	</script><?
}
/*?>
	<header>
		<div class="top_txt_sec fl">
					
			<? 
			if($type==2){ echo '<div class="fl f1 fs14  clr5 pd10 lh30 " >'.k_consultation.'</div>';}
			if($pay_type==2){				
				$name_ch=get_val('gnr_m_charities','name_'.$lg,$ch_id);
				echo '<div class="fl f1 fs12 pd10 lh20 clr5 lh30">'.$name_ch.'</div>';
			}?>
		</div>
		<div class="top_icons"><?
			echo topIconCus(k_end,'cbg5 ti_77 fr','finshDenVis()');			
			echo topIconCus(k_med_rec,'ti_card fr','pat_hl_rec(1,'.$patient_id.',\''.$patName.'\')');
			if(modPer('b8kpe202f3','0')){
				echo topIconCus(k_documents,'ti_docs fr','patDocs('.$patient_id.',1)');		
			}
			if(chProUsed('dts')){
				echo topIconCus(k_appointments,'ti_date fr','selDtSrvs('.$clinic.',0,'.$patient_id.')');
			}
			echo topIconCus(k_precpiction,'ti_1 fr','prescrs('.$mood.',0)');			
			echo topIconCus(k_teeth_status,'ti_mouth fr','teethStatus('.$patient_id.')');
			echo topIconCus(k_dental_procedures,'ti_opr_den fr','denHis('.$patient_id.','.$visit_id.')');
			//echo topIconCus(k_consumables,'cost_icon fr','newCons('.$userStore.',\'\',\'docCostAdd([data])\',\'\');');
			?>
		</div>
	</header>
	<div class="centerSideInFull of">
	<div class="denInfo fl cbg3 ofx so" fix="w:200|hp:0">
		<div class="cb f1 w100 of" fix="" id="timeBar"></div>
		<div class="fl butDen w100 mg10v" actButt="act">
			<div den_i1 n="1" act><?=k_dental_anatomy?></div>
			<div den_i2 n="2"><?=k_dental_procedures?></div>			
		</div>		
	</div>
	<div class="fl of" fix="wp:200|hp:0" id="denData"></div>		
	</div>
	<script>
		sezPage='';
		visit_id=<?=$visit_id?>;
		patient_id=<?=$patient_id?>;
		$(document).ready(function(e){			
			denPrvSet(<?=$scType?>);
			//den_prv(1);
			//setDenOpr();
			//setOPeSrvDen();
			refPage('den2',12000);
			
		});
	</script><?
}*/?>