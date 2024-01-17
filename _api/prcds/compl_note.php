<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
    $type=pp($_POST['type']);
    $manager=$chPer[2];
    $q=" status=2 and follower='$thisUser'";
    if($manager){
        $q=" status <3 and ( user=0 or user='$thisUser') ";
    }
    $r=getRecCon('api_x_complaints',"id='$id' and $q");
    if($r['r']){
        $id=$r['id'];
        $patient=$r['patient'];
        $complaint=$r['complaint'];
        $solution=$r['solution'];
        $date=$r['date'];
        $user=$r['user'];
        $follower=$r['follower'];
        if($thisUser==$user || $thisUser==$follower){?>
            <div class="win_body">
                <div class="form_header so lh40 clr1 f1 fs18"><?=$id?> | <?=get_p_name($patient)?></div>
                <div class="form_body so">
                    <div><textarea class="w100" id="c_noteIn" t></textarea></div>        
                </div>
                <div class="form_fot fr">
                    <? if($type==3){?>
                        <div class="fl ic40 ic40_save icc22 ic40Txt mg10f br0" onclick="addCNoteSave(3);"><?=k_save?></div>
                    <? }else if($type==4){?>
                        <div class="fl ic40 ic40_save icc33 ic40Txt mg10f br0" onclick="addCNoteSave(4,1);">تم حل الشكوى </div>
                        <div class="fl ic40 ic40_save icc22 ic40Txt mg10f br0" onclick="addCNoteSave(4,2);">لم تحل الشكوى </div>
                    <?}?>
                    <div class="fr ic40 ic40_x icc3 ic40Txt mg10v br0" onclick="win('close','#m_info');"><?=k_close?></div>
                </div>
            </div><?
        }
    }
}?>