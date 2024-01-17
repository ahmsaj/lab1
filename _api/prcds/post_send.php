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
        $subs=getTotalCO('api_x_settings',"set_id='$cat'");
        
        $subsIds1=get_vals('api_x_settings','user',"user_type=1 and set_id='$cat'");
        $subsIds2=get_vals('api_x_settings','user',"user_type=2 and set_id='$cat'");
        $devices=0;
        if($subsIds1){$devices+=getTotalCO('api_notifications_push',"p_type=1 and patient IN ($subsIds1)");}
        if($subsIds2){$devices+=getTotalCO('api_notifications_push',"p_type=2 and patient IN ($subsIds2)");}
        
        ?>
        <div class="win_body">
        <div class="form_header so lh40 clr1 f1 fs18">
            <div class="fr fs16 ff"><?=date('Y-m-d',$date)?></div><?=$title?></div>
        <div class="form_body so" type="full">            
            <div class="f1 fs14 lh40 ">
                الأجهزة المسجلة للإشعارات : <ff14 class=" clr5"> ( <?=$devices?> )</ff14>
            </div><? 
            if($devices){
                echo '<div id="sendNot" >
                    <div class="fl ic30 ic30_send ic30Txt icc4" onclick="strSendNot('.$id.')">بدء الإرسال</div>
                </div>';
            }?>
        </div>
        <div class="form_fot fr">
            <div class="bu bu_t2 fr" onclick="loadModule('ocx1vr2l0k');win('close','#m_info');"><?=k_close?></div>
        </div>
        </div><?
    }
}?>