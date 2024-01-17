<? include("../../__sys/mods/protected.php");?>
<div class="fxg h100" fxg="gtc:300px 1fr">
    <div class="h100 cbg444 r_bord ofx pd10 so ">
        <div class="f1 fs16 lh50 uLine"><?=$def_title?></div>
        <div>
            <div class="f1 lh40 fs14">القسم :</div>
            <select id="mood"><?
                foreach($clinicTypes as $k => $val){
                    if(in_array($k,array(1,3,4,5,7))){
                        echo '<option value="'.$k.'">'.$val.'</option>';
                    }
                }?>
            </select>
            <div class="f1 lh40 fs14">رقم الزيارات :</div>
            <input type="number" id="vis"/>
            <div class="ic40 icc2 ic40Txt ic40_send mg20v" send>إرسال</div>
        </div>
    </div>
    <div class="h100 ofx so pd10f" id="vis_info">
        
    </div>
</div>