<? include("../../__sys/mods/protected.php");?>
<? list($clinc_name,$clinc_code,$mood)=get_val('gnr_m_clinics','name_'.$lg.',code,type',$userSubType);
list($doc,$sex,$doc_photo)=get_val('_users','name_'.$lg.',sex,photo',$thisUser);
$width=array(50,0,50);
if(chProUsed('dts')){$width=array(33,34,33);}?>
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
	</div>
</div>
<script>sezPage='vis_<?=$clinicCode[$mood]?>';$(document).ready(function(e){<?=$clinicCode[$mood]?>_vit_d_ref(1);refPage(1,10000);});</script>