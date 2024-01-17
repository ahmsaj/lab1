<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
    $r=getRec('api_x_posts',$id);
    if($r['r']){
        $cat=$r['cat'];
        $photo=$r['photo'];
        $title=$r['title_'.$lg];
        $desc=$r['desc_'.$lg];
        $user=$r['user'];
        $date=$r['date'];
        $views=$r['views'];
        $status=$r['status'];
        $catTxt=get_val('api_m_settings','name_'.$lg,$cat);
        $subs=getTotalCO('api_x_settings',"set_id='$cat'")?>
        <div class="win_body">
        <div class="form_header so lh40 clr1 f1 fs18">
            <div class="fr fs16 ff"><?=date('Y-m-d',$date)?></div><?=$title?></div>
        <div class="form_body so" type="full">
            <div class="f1 fs14 lh30 uLine">
                <?=k_cat.': '.$catTxt?>
                <span class="f1 clr5"> ( عدد المشتركين : <ff14><?=$subs?></ff14> )</span>
            </div>
            <? if($photo){?>
                <div class="fl w100 uLine">
                    <?=viewPhotos_i($photo,1,440,300)?>
                </div>
            <? }?>
            <div class="lh20"><?=nl2br($desc)?></div>
        </div>
        <div class="form_fot fr">
            <div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
        </div>
        </div><?
    }
}?>