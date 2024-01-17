<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['code'])){
    $code=pp($_POST['code'],'s');    
    $val=($_POST['val']);
    if($val){$val=str_replace('\n\n','\n',$val);}
    $codeDA=explode('_',$code);
    $textDir=$l_dir;
    if(count($codeDA)==3){
        $txtLg=end($codeDA);
        if($txtLg!=$lg){
            if($l_dir=='ltr'){$textDir='rtl';}else{$textDir='ltr';}
        }
    }?>
    <div class="win_free" >
        <div class="winButts"><div class="wB_x fr" onclick="win('close','#full_win1');"></div></div>
        <div class="of w100 h100 cbg444 tpEditor">
            <div class="fxg h100" fxg="gtc:300px 1fr|gtr:50px 1fr 50px ">
                <div class=" r_bord cbg4" fxg="grs:3">
                    <div class="so h100 tp_toolList">
                        <div class="ic40 icc11 ic40Txt ic40_tp_h2 mg10f" ptType="h2">عنوان مستوى 2</div>
                        <div class="ic40 icc11 ic40Txt ic40_tp_h3 mg10f" ptType="h3">عنوان مستوى 3</div>
                        <div class="ic40 icc11 ic40Txt ic40_tp_h4 mg10f" ptType="h4">عنوان مستوى 4</div>
                        <div class="ic40 icc11 ic40Txt ic40_tp_p mg10f" ptType="p">فقرة</div>
                        <div class="ic40 icc11 ic40Txt ic40_tp_hp mg10f" ptType="hp">فقرة مع عنوان</div>
                        <div class="ic40 icc11 ic40Txt ic40_tp_img mg10f" ptType="img">صورة</div>
                    </div>
                </div> 
                <div class=" cbg444 b_bord" >
                    <div class="fl mg5f ic40 ic40_reload icc11" tpTempLoad title="قائمة النماذج"></div>
                    <div class="fl mg5f ic40 ic40_save icc22" tpTempSave title="حفظ مخطط المحتوى الحالي كنموذج"></div>
                    <div class="fr ic40 ic40_tp_c1 icc33 TC" tp_row="1" tp_t="1" title="<?=k_add?>"></div>
                    <div class="fr ic40 ic40_tp_c11 icc33 TC" tp_row="11" tp_t="11" title="<?=k_add?>"></div>
                    <div class="fr ic40 ic40_tp_c111 icc33 TC" tp_row="111" tp_t="111" title="<?=k_add?>"></div>
                    <div class="fr ic40 ic40_tp_c12 icc33 TC" tp_row="12" tp_t="12" title="<?=k_add?>"></div>
                    <div class="fr ic40 ic40_tp_c21 icc33 TC flip" tp_row="21" tp_t="21" title="<?=k_add?>"></div>
                    <div class="fr ic40 ic40_ref icc22 hide" onclick="editPageTxt('<?=$code?>','<?=$val?>');"></div>
                </div>         
                <div class="cbgw h100 ofx so">
                    <?
                        $c=explode('_',$code);    
                        if(end($c)!=$lg){
                            $contentDiv='ltr';
                            if($l_dir=='ltr'){$contentDiv='rtl';}
                            echo $dirtxt=' dir="'.$contentDiv.'" ';
                        }
                    ?>
                    <div class="tpEditorRows" code="<?=$code?>" <?=$dirtxt?>><?=showTpBlcs($val)?></div>
                </div>
                <div class=" w100 of cbg444 t_bord">
                    <div class="fl br0 mg5f  ic40 ic40_save icc2 ic40Txt" saveTpAll><?=k_save?></div>
                </div>
            </div>
        </div>
    </div>
    <div id="tpImage" class="hide">
        <?=imageUpN(0,'tp_photo','tp_photo','',1,0,"tpImgLoad('tp_photo',[data])")?>
    </div><?
}?>