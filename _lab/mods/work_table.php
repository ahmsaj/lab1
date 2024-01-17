<? include("../../__sys/mods/protected.php");?>
<div class="centerSideInFull of">
<div class="fxg h100" fxg="gtc:280px 420px 1fr|gtr:50px 1fr">
    <div class="fl lh50 b_bord r_bord">
        <div class="fl f1 fs18 pd10 lh50 "><?=k_work_tables?><ff id="tot1">( 0 )</ff></div>
        <div class="fr i30 i30_add mg10f" addWtGrp title="<?=k_add_work_table?>"></div>
        <div class="fr i30 i30_res mg10f" onclick="wt_grp_load()"></div>
    </div>
    <div class="fl lh50 b_bord r_bord">
        <div class="fl f1 fs18 pd10 lh50"><?=k_pre_tests_list?> <ff id="tot2">( 0 )</ff></div>
        <div class="fr i30 i30_res mg10f" refAna title="<?=k_ana_update?>"></div>
    </div>
    <div class="fl lh50 b_bord pd10" id="gTitle">
        <div class="fl f1 fs18 lh50"> </div>
    </div>
    
    <div class="w100 ofx so pd10f r_bord" id="wtGrps"></div>
    <div class="w100 ofx so pd10f r_bord" id="anas"></div>
    <div class="w100 ofx so pd10f" id="gData"><div class="f1 fs16 lh40 clr1"><?=k_choose_work_table?></div></div>
</div>
<script>$(document).ready(function(e){startworkTable();});</script>