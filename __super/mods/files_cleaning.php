<style>[actBut],[actBut]:hover{background-color: #AA3334;}</style>
<div class="centerSideInFull of">
    <div class="fl r_bord fl ofx so" fix="w:320|hp:0">
        <div class="lh50 pd10 f1 fs16 clr1 uLine"><?=$def_title?></div>
        <div class="fl w100 pd10 ofx so" >
            <div class="fl" fix="w:140"><input type="number" value="0" placeholder="Page" p/></div>
            <div class="fr" fix="w:140"><input type="number" value="100" placeholder="Recs" r/></div>
        </div>
        &nbsp;
        <div class=" pd10f" actButt="actBut">
            
            <div class="bu buu bu_t1 mg5v" onclick="viewPhMa(1)"><?=k_del_un_photos?></div>
            <div class="bu buu bu_t1 mg5v" onclick="viewPhMa(2)"><?=k_del_unav_photos?></div>
            <div class="bu buu bu_t1 mg5v" onclick="viewPhMa(3)"><?=k_del_img_not?></div>
            <div class="bu buu bu_t1 mg5v" onclick="viewPhMa(4)"><?=k_del_tem?></div>
            &nbsp;
            
            <div class="bu buu bu_t1 mg5v" onclick="viewPhMa(11)"><?=k_del_un_files?></div>
            <div class="bu buu bu_t1 mg5v" onclick="viewPhMa(12)"><?=k_del_unav_files?></div>
            <div class="bu buu bu_t1 mg5v" onclick="viewPhMa(13)"><?=k_del_not_files?></div>
            &nbsp;
            
        </div>
    
    </div>
    <div class="fl pd10 ofx so" fix="wp:321|hp:0" id="pmCont"><?
        ?>
    </div>
</div>