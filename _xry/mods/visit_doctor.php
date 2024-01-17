<? include("../../__sys/mods/protected.php");?>
<?
$mood=3;
$clinc_name=get_vals('gnr_m_clinics','name_'.$lg," id IN ($userSubType) ",' :: ');
list($doc,$Ugrp,$sex,$doc_photo)=get_val('_users','name_'.$lg.',grp_code,sex,photo',$thisUser);
if($Ugrp=='nlh8spit9q'){$docDet=$sex_txt[$sex];}
if($Ugrp=='1ceddvqi3g'){$docDet=$sex_txt_tec[$sex];}
$width=array(33,0,33,34);
echo getEditorSet();
if(chProUsed('dts')){$width=array(25,25,25,25);}?>
<header>
	<div class="top_txt_sec fl cbg44">
    	<div class="fl docPhoto"><?=viewPhotos_i($doc_photo,0,50,60,'css','nophoto'.$sex.'.png')?></div>
        <div class="fl">
			<div class="f1 fs16 lh30"><?=$docDet.' '.$doc;?></div>
			<div class="fs12 f1 lh30"><?=$clinc_name?> <span id="d1"></span></div>
        </div>
    </div>
    <div class="top_icons fr" type="list"></div>
</header>
<div class="centerSideInFull of cbg444">
	<div class="fx h100 w100">		
		<div class="w100 r_bord">
			<div class="f1 fs16  lh50 pd10 b_bord"><?=k_waiting?></div>
			<div class="ofx so pd10f h100" id="d2" ></div>
		</div>		
		<? if(chProUsed('dts')){?>
		<div class="w100 r_bord">
			<div class="f1 fs16  lh50 pd10 b_bord"><?=k_appointments?></div>
			<div class="ofx so pd10f h100" id="d3"></div>
		</div>
		<? }?>
		<div class="w100 r_bord">
			<div class="f1 fs16  lh50 pd10 b_bord"><?=k_alerts?></div>
			<div class="ofx so pd10f h100" id="d4"></div>
		</div>	
		<div class="w100">
			<div class="f1 fs16  lh50 pd10 b_bord"><?=k_th_reports?></div>
			<div class="ofx so pd10f h100" id="d5"></div>
		</div>
	</div>
</div>
<script>sezPage='vis_<?=$clinicCode[$mood]?>';
$(document).ready(function(e){<?=$clinicCode[$mood]?>_vit_d_ref(1);refPage('xry2',10000);});</script>