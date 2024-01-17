<? include("../../__sys/mods/protected.php");?>
<? $vis=pp($_GET['m_id']);
$anType=_set_9jfawiejb9;
$mood=1;
$r=getRec('cln_x_visits',$vis);
if($r['r']){ 
	$addons=loadAddons();
    
	include_once("../../addons/_define.php");    
	include_once("../../addons/_funs.php");    
	echo '<link href="'.$m_path.'addCSS'.$l_dir[0].'v_'.$ProVer.'.css" rel="stylesheet" type="text/css" />';
    echo '<script src="'.$m_path.'addJSv_'.$ProVer.'.js"></script>';
	foreach($addons as $a){
		if(file_exists("../../addons/$a/_funs.php")){
			include_once("../../addons/$a/_define.php");
			include_once("../../addons/$a/_funs.php");	
            			
			//echo '<link href="'.$m_path.'addCSSl'.$a.'V'.$l_dir[0].'M.css" rel="stylesheet" type="text/css" />';
            //echo '<link href="'.$m_path.'addCSS'.$l_dir[0].$a.'V'.$ProVer.'M.css" rel="stylesheet" type="text/css" />';
            echo '<script src="'.$m_path.'addJS'.$a.'V'.$ProVer.'.js"></script>';

            $style_file=_styleFiles($a);        
	        echo '<link rel="stylesheet" type="text/css" href="'.$m_path.$style_file.'">';
		}		
	}
	$doc=$r['doctor'];
	$pat=$r['patient'];
	$d_start=$r['d_start'];
	$d_check=$r['d_check'];
	$type=$r['type'];
	$sub_type=$r['sub_type'];
	$status=$r['status'];
	$clinic=$r['clinic'];
	$ref=$r['ref'];
	$ref_no=$r['ref_no'];
	$ref_date=$r['ref_date'];
	$pay_type=$r['pay_type'];
	$pay_type_link=$r['pay_type_link'];
	$r2=getRec('gnr_m_patients',$pat);
	$sex=$r2['sex'];
	$birth=$r2['birth_date'];
	$birthCount=birthCount($birth);
	$blood=$r['blood'];
	$p_title=$r2['title'];
	if($p_title){
		$col=getColumesData('',0,'h4ljv9q3qf');		
		$p_titleTxt=viewRecElement($col[0],$p_title);
	}
	if($doc==0){
		mysql_q("UPDATE cln_x_visits SET doctor='$thisUser' where id='$vis' ");
		mysql_q("UPDATE cln_x_visits_services SET doc='$thisUser' where visit_id='$vis' ");
		$doc=$thisUser;
	}
	if($doc==$thisUser){
		if($d_check==0){
			mysql_q("UPDATE cln_x_visits set d_check='$now' where id='$vis' ");
		}
		mysql_q("UPDATE gnr_x_roles set doctor='$thisUser' where vis='$vis' and mood=1");
		if($status==2 || $status==3){
			mysql_q("UPDATE gnr_x_roles set status=4 where vis='$vis' and mood=1");
			delTempOpr($mood,$vis,'a');
			if($status==3){
				loc('_Visits');
				exit;
			}
		}
		list($m_pat,$clinicTxt)=get_val('gnr_m_clinics','m_patients,name_'.$lg,$clinic);
		$swAction='';
		if($m_pat){$swAction='prvSw';}
        echo getEditorSet();?>
		<script src="<?=$m_path?>library/Highcharts/highcharts.src.js"></script>
		<script src="<?=$m_path?>library/Highcharts/highcharts-more.js"></script>
		<div class="centerSideInFull of pr h100">
            <div class="inWin fl h100 w100 fxg" fxg="gtr:50px 1fr|gtc:1fr-600px" inWin="1" >
                <div h class="fl">
                    <div class="fr ic30x icc2 ic30_x mg10v" title="<?=k_close?>" id="exWin"></div>
                    <div class="fl f1 fs16 " id="iwT"> </div>		
                </div>
                <div b class="fl ofxy so cbg1" fix="hp:50|wp:0" id="iwB" ></div>
            </div>
            <div class="fxg h100" fxg="gtc:280px 320px 1fr 50px|gtr:100%">
                <div class="h100 cp_s1 fxg fxg-al-s" fxg="gtr:74px 40px 80px 50px 1fr ">
                    <div class="cp_s1_b2 fl w100 f1 fs16">
                        <div class="fl">
                            <div class="fs16" tit1><?=k_clinic.' : '.$clinicTxt?></div>
                            <div class="fs12" tit2>إضغط هنا لعرض الخدمات</div>
                        </div>
                        <div r></div>
                    </div>
                    <div class="prvLoader"><?=k_loading?></div>
                    <div class="fl w100 lh40 cbg2 clrw f1 ">
                        <div class="fl cbg3" title="المرضى بالانتظار" id="patWs" <?=$swAction?>>
                            <div class="fl patsIco"></div>
                            <div class="fl pd10 ff lh40 fs18" id="patNo">0</div>
                        </div>
                        <div class="fr ic40x icc2 ic40_done br0" finish title="إنهاء الزيارة"></div>
                        <div class="fr ic40x icc33 ic40_ref br0" back title="رجوع للزيارات"></div>
                        <div class="fl ic40x icc11 ic40_vedio br0" help title="مساعدة"></div>
                    </div>
                    <div id="timeSec" class="fl w100"></div>				
                    <div class="cp_s1_b3 fl w100 f1 fs16" addSet>
                        <div class="fr cp_s1_b3_icon wh50"></div><?=k_inp_sett?></div>
                        <div class="ofx so h100" id="addons"></div>
                    </div>

                <div class="fl cp_s2 of r_bord h100" id="listSec"></div>
                <div class="fl cp_s3 fxg h100" fxg="gtr:auto 1fr">
                    <div class=" cbg2 lh40 w100">					
                        <div class="fl lh40 pd10 fs18 clrw cbg3 ff">#<?=$pat?></div>
                        <div class="fl lh40 pd10 fs16x clr4 f1s Over" paInfo><?=$p_titleTxt.' '.get_p_name($pat)?></div>
                        <div class="fl lh20 fs12 clrw lh40">(<ff class="fs14"><?=$birthCount[0]?> </ff><?=$birthCount[1]?>)</div>
                        <div class="fr i30 i30_min cbg4 pd5f minmize40" title="تصغير" s="1" mmbA></div>
                        <div class="fr ic40x br0 ic40_ref icc1 " onclick="loadPrvDetails()"></div>
                    </div>
                    <div class=" pd10f ofx so" id="desSec"></div>                    
                </div>
                <div class="cp_s4 cbg2 ofx so l_bord h100" >
                    <div class="prvOprList"><?
                    //echo clnOprList(k_consumables,'fr cost_icon','newCons('.$userStore.',\'\',\'docCostAdd([data])\',\'\')');
                    if(chProUsed('dts')){
                        echo clnOprList(k_appointments,'prvTop_dts','selDtSrvs('.$clinic.',0,'.$pat.')');
                    }				
                    if(modPer('b8kpe202f3','0')){
                        echo clnOprList('المستندات','prvTop_doc','patDocs('.$pat.',1)');		
                    }
                    echo clnOprList('السجل الطبي','prvTop_rec','pat_hl_rec(1,'.$pat.',\''.$patName.'\')');
                    $oprSt=checkOPrEx('prc',$pat);
                    echo clnOprList(k_precpiction,'prvTop_pre','prescrs('.$mood.',0)',$oprSt,'prc');
                    $oprSt=checkOPrEx('ana',$pat);
                    //echo clnOprList(k_tests,'prvTop_ana','Analysis(0,'.$anType.')',$oprSt,'ana');
                    echo clnOprList(k_tests,'prvTop_ana','AnalysisN(0,'.$anType.')',$oprSt,'ana');
                    $oprSt=checkOPrEx('xry',$pat);
                    echo clnOprList(k_radiograph_s,'prvTop_xry','m_xphotoN(0)',$oprSt,'xry');
                    $oprSt=checkOPrEx('opr',$pat);
                    echo clnOprList(k_operations,'prvTop_opr','operations(0)',$oprSt,'opr');
                    echo clnOprList(k_med_report,'prvTop_rep','med_report()');				
                    echo clnOprList(k_referral,'prvTop_ass','assignment(0)');			
                    ?>
                    </div>
                </div>
            </div>
		</div>
		<script>
			var visit_id=<?=$vis?>;var patient_id=<?=$pat?>;
			$(document).ready(function(e){startPrv();});
			sezPage='Preview-Clinic';
            actAddons='';
            <? if(is_array($addons)){?>
			    actAddons='<?=implode(',',$addons)?>';
            <? } ?>
		</script>
	<?
	}else{
		if($status==2 || $status==3){delTempOpr($mood,$vis,'a');}
		loc('_Visits');
	}
}else{loc('_Visits');}?>