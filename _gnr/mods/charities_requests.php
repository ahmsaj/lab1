<? include("../../__sys/mods/protected.php");?>
<div class="centerSideInFull of">
    <div class="fxg h100" fxg="gtc:300px 1fr|gtr:50px 1fr">   
        <div class="lh50 f1 fs18 clr1 b_bord r_bord pd10">
            <div class="fr ic30x ic30_ref icc4 mg10v" onclick="chr_ref(1)" title="<?=k_refresh?>"></div><?=$def_title?></div>
        <div class="lh50 f1 fs18 clr1 b_bord pd10">التفاصيل</div>
        <div class="ofx so r_bord pd10f"  id="chReq"></div>
        <div class="ofxy so"  id="chDet"></div>
    </div>
</div>
<script>sezPage='chr';$(document).ready(function(e){chr_ref(1);refPage(6,10000);});</script>