<? include("../../__sys/mods/protected.php");?>
<header>
<div class="top_icons fr" type="list">
<div class="top_icon sStatus fr cbg1111 labStatus" id="a1" title="<?=k_totl?>">0</div>
<div class="top_icon sStatus fr cbg6 labStatus" id="a2" title="<?=k_recieved?>">0</div>
<div class="top_icon sStatus fr cbg5 labStatus" id="a3" title="<?=k_incoming?>">0</div>

</div>
</header>
<div class="centerSideIn h100 fxg" fxg="gtc:33% 67%|gtr:1fr">
	<div class="of" id="sContent"></div>
	<div class="of" id="sampGrpDet">
    
    </div>
</div>
<script>
sezPage='vis_l_r';$(document).ready(function(e){r_samples_ref(1);$('#cn_bc').focus();refPage(9,5000);});
</script>