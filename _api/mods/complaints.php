<? include("../../__sys/mods/protected.php"); ?>
<? header_sec($def_title, ''); ?>
<div class="centerSideInFull of">
    <div class="fxg h100" fxg="gtc:300px 1fr|gtr:40px 1fr">
        <!--<div class="cbg4 r_bord b_bord lh40 pd10 f1 fs14">أبحث في الشكاوى</div>-->
        <div class="cbg444 r_bord b_bord">
            <div class="fr ic40x br0 icc1 ic40_ref" title="<?= k_refresh ?>" refCompl></div>
            <div class="pd10  lh40 f1 fs14"><?= k_list_of_cmp ?></div>
        </div>
        <div class=" h100 of fxg" fxg="grs:2|gtr:100%" cmpData>
            <? if (isset($_GET['m_id'])) {
                echo Script('showCompl(' . pp($_GET['m_id']) . ')');
            } ?>
        </div>
        <!--<div class="cbg4 r_bord pd10f ofx so">
            <div class="f1 fs14 lh30">الرقم</div>
            <div><input type="number" /></div>
        </div>-->
        <div class="cbg444 r_bord pd10f ofx so" cmpList></div>

    </div>
</div>