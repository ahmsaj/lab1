<? include("../../__sys/mods/protected.php");?>
<?
$mood=7;
list($clinc_name,$clinc_code,$mood)=get_val('gnr_m_clinics','name_'.$lg.',code,type',$userSubType);
list($doc,$sex,$doc_photo)=get_val('_users','name_'.$lg.',sex,photo',$thisUser);
$width=array(50,0,50);
if(chProUsed('dts')){$width=array(33,34,33);}?>
<header>
	<div class="top_txt_sec fl cbg44">
    	<div class="fl docPhoto"><?=viewPhotos_i($doc_photo,0,50,60,'css','nophoto'.$sex.'.png')?></div>
        <div class="fl">
			<div class="f1 fs16 lh30"><?=$sex_txt[$sex].' '.$doc;?></div>
			<div class="fs12 f1"><?=$clinc_name?><ff> ( <?=$clinc_code?> ) </ff><span id="d1"></span></div>
        </div>
    </div>	
    <div class="top_icons fr" type="list"></div>    
</header>
<div class="centerSideInFull of cbg444">
	<div class="fl" fix="wp:0|hp:0">		
		<div class="fl r_bord" fix="hp:0|wp%:<?=$width[0]?>">
			<div class="f1 fs16 lh50 pd10 b_bord"><?=k_waiting?></div>
			<div class="ofx so pd10f" fix="hp:55" id="d2"></div>
		</div>
		<? if(chProUsed('dts')){?>
		<div class="fl " fix="hp:0|wp%:<?=$width[1]?>">
			<div class="f1 fs16 lh50 pd10 b_bord"><?=k_appointments?></div>
			<div class="ofx so pd10f"fix="hp:55" id="d3"></div>
		</div>
		<? }?>
		<div class="fl l_bord" fix="hp:0|wp%:<?=$width[2]?>">
			<div class="f1 fs16 lh50 pd10 b_bord"><?=k_alerts?></div>
			<div class="ofx so pd10f"fix="hp:55" id="d4"></div>
		</div>		
	</div>
</div>
<script>sezPage='vis_<?=$clinicCode[$mood]?>';$(document).ready(function(e){<?=$clinicCode[$mood]?>_vit_d_ref(1);refPage('osc1',10000);});</script>