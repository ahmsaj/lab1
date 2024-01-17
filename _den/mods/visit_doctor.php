<? include("../../__sys/mods/protected.php");?>
<?
$mood=4;
list($clinc_name,$clinc_code)=get_val('gnr_m_clinics','name_'.$lg.',code',$userSubType);
list($doc,$sex,$doc_photo)=get_val('_users','name_'.$lg.',sex,photo',$thisUser);
$width='1fr 1fr';
if(chProUsed('dts')){$width='1fr 1fr 1fr';}?>
<header>
	<div class="top_txt_sec fl cbg44">		
    	<div class="fl docPhoto"><?=viewPhotos_i($doc_photo,0,50,60,'css','nophoto'.$sex.'.png')?></div>
        <div class="fl">
			<div class="f1 fs16 lh40" fix="h:35"><?=$sex_txt[$sex].' '.$doc;?></div>
			<div class="fs14 f1 lh30" fix="h:25"><?=$clinc_name?><ff> ( <?=$clinc_code?> ) </ff><span id="d1"></span></div>
        </div>
    </div>	
    <div class="top_icons fr" type="list"></div>    
</header>
<div class="centerSideInFull of cbg444">

	<div class="fxg h100" fxg="gtc:<?=$width?>|gtr:1fr">
		<div class="of fxg" fxg="gtr:50px 1fr">
			<div class="f1 fs16 lh50 pd10 b_bord"><?=k_waiting?></div>
			<div class="ofx so pd10f" id="d2"></div>
		</div>
		<? if(chProUsed('dts')){?>
			<div class="of l_bord fxg" fxg="gtr:50px 1fr">
				<div class="f1 fs16 lh50 pd10 b_bord"><?=k_appointments?></div>
				<div class="ofx so pd10f" id="d3"></div>
			</div>
		<? }?>
		<div class="of l_bord fxg" fxg="gtr:50px 1fr">
			<div class="f1 fs16 lh50 pd10 b_bord"><?=k_alerts?></div>
			<div class="ofx so pd10f" id="d4"></div>
		</div>	
	</div>

</div>
<script>sezPage='vis_<?=$clinicCode[$mood]?>';$(document).ready(function(e){<?=$clinicCode[$mood]?>_vit_d_ref(1);refPage('den1',10000);});</script>