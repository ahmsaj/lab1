<? include("../../__sys/mods/protected.php");?>
<div class="centerSideInFull of">
    <div class="fxg h100" fxg="gtc:280px 280px 1fr|gtr:50px 1fr">
        <div class="lh50 f1 fs18 clr1 b_bord r_bord pd10">
            <div class="fr ic30x ic30_ref icc4 mg10v" onclick="ins_ref(1)" title="<?=k_refresh?>"></div><?=$def_title?>
        </div>
        <div class="lh50 f1 fs18 clr1 b_bord r_bord pd10">بالانتظار</div>
        <div class="lh50 f1 fs18 clr1 b_bord pd10">التفاصيل</div>

        <div class="ofx so pd10f r_bord" id="inReq"></div>	
        <div class="ofx so pd10f r_bord" id="inReqW"></div>
        <div class="ofxy sopd10f " id="insDet"></div>	
    </div>
</div>
<script>sezPage='ins';$(document).ready(function(e){ins_ref(1);refPage('gnr1',10000);});</script>