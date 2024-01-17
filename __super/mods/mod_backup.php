<div class="centerSideInFull of fxg h100" fxg="gtc:300px 1fr">
    <div class="cbg444 r_bord fxg h100 of" fxg="gtr:50px 1fr 50px 50px">
        <div class="b_bord f1 fs14 TC lh50 cbg4"><?=$def_title?></div>
        <div class="pd10 ofx so"><?
            foreach($modTablesBackup as $table){
                $total=getTotal($table);
                echo '<div class="fs14 lh40 b_bord">'.$table.' <div class="fr f1 clr5">( '.number_format($total).' )</div></div>';
            }    
            
            foreach($modTablesBackupAPI as $table){
                $total=getTotal($table);
                echo '<div class="fs14 lh40 b_bord">'.$table.' <div class="fr f1 clr5">( '.number_format($total).' )</div></div>';
            } 
        ?></div>
        <div class="icc4 f1 lh50 t_bord clrw TC fs14" onclick="modBackup(1)">توليد النسخة الاحتياطية</div>
        <div class="icc2 f1 lh50 t_bord clrw TC fs14" onclick="modBackup(2)">توليد النسخة الاحتياطية (API)</div>
    </div>
    <div class="pd20f ofxy so" dir="ltr" id="bkView"></div>
</div>