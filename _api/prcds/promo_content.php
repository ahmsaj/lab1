<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
    $id=pp($_POST['id']); 
    $r=getRec('api_x_promotion',$id);
    if($r['r']){
        $msg_title=$r['msg_title'];
        $msg_desc=$r['msg_desc'];
        $title=$r['title'];
        $body=$r['body'];
        $url=$r['url'];
        $url_text=$r['url_text'];
        $photo=$r['photo'];
        $status=$r['status'];
        $edit=1;
        if($status>2){$edit=0;}
        if(!$msg_title){$msg_title='عنوان التنبيه';}
        if(!$msg_desc){$msg_desc='مرحبا [p] تفاصيل التنبيه';}
        if(!$title){$title='مثال للعنوان الرئيسي للمحتوى';}
        if(!$$body){$body='مرحبا [p] النص الخاص بالمحتوى النص الخاص بالمحتوى النص الخاص بالمحتوى النص الخاص بالمحتوى 
النص الخاص بالمحتوى النص الخاص بالمحتوى النص الخاص بالمحتوى ';}
        if(!$url){$url='#';}
        if(!$url_text){$url_text='زورو موقعنا';}
        ?>
        <form name="promo_form" id="promo_form" action="<?=$f_path.'X/api_promo_content_save.php'?>" method="post" cb="loadModule('wuv9f0s7zj')" bv="">
            <input type="hidden" name="id" value="<?=$id?>" required/>
            <div class="win_body">
            <div class="winButts"><div class="wB_x fr" onclick="win('close','#full_win1');"></div></div>                
                <div class="form_body of" type="pd0">
                    <? if($edit==1){
                        echo '<div class="fxg h100" fxg="gtc:2fr 1.5fr">';
                    }else{
                        echo '<div class="fxg h100" >';
                    }
                    ?>
                    <div class="pd20f r_bord h100 ofx so <? if($edit==0){echo 'hide';}?>" style="background-color: #eee">
                            <div class="pd20b">
                                <div class="f1 lh30 fs14">عنوان الترويج *</div>
                                <input type="text" name="name" value="<?=$r['name']?>" required/>
                            </div>
                            <div class="cbg4 bord pd10f br5 mg20b">
                                <div class="pd20b">
                                    <div class="f1 lh30 fs14">عنوان التنبيه *</div>
                                    <input type="text" name="msg_title" value="<?=$msg_title?>"/>
                                </div>
                                <div class="pd20b">
                                    <div class="f1 lh30 fs14">نص التنبيه *</div>
                                    <textarea name="msg_desc" class="w100" t style="height: 100px" required><?=$msg_desc?></textarea>
                                </div>
                            </div>
                            <div class="cbg4 bord pd10f br5 mg20b">
                                <div>
                                    <div class="f1 lh30 fs14">العنوان *</div>
                                    <input type="text" name="title" value="<?=$title?>" required/>
                                </div>
                                <div>
                                    <div class="f1 lh30 fs14">المحتوى *</div>                                
                                    <textarea name="body" class="w100" t required><?=$body?></textarea>
                                </div>                                
                            </div>
                            <div class="cbg4 bord pd10f br5 mg20b">                                
                                <div>
                                    <div class="f1 lh30 fs14">الصورة</div>
                                    <?=imageUpN('','photo','promo',$photo,0,0,'updatePromoPreview()').'';?>
                                </div>
                                <div>
                                    <div class="f1 lh30 fs14">الرابط المرفق</div>
                                    <input type="text" name="url" value="<?=$url?>"/>
                                </div>
                                <div>
                                    <div class="f1 lh30 fs14">عنوان الرابط</div>
                                    <input type="text" name="url_text" value="<?=$url_text?>"/>
                                </div>
                            </div>
                        </div>
                        <div class="pd20f h100 ofx so "> 
                            <div class="f1 lh30 fs14">معاينة التنبيه</div>
                            <div class="cbg444 bord pd10f br5 mg20b">                                                                    
                                <div class="f1 fs14 B" id="prv_msg_title"></div>
                                <div class="f1" id="prv_msg_desc"></div>                                
                            </div>
                            <div class="f1 lh30 fs14">معاينة المحتوى</div>
                            <div class="cbg444 bord pd10f br5 mg20b">                                                                   
                                <div class="f1 fs18 lh40 B" id="prv_title"></div>
                                <div class="f1 pd10v"  id="prv_photo"></div>
                                <div class="f1" id="prv_body"></div>
                                <div class="f1" id="prv_link"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form_fot fr ">
                    <? if($edit){?>
                    <div class="fl ic40 ic40_save icc22 ic40Txt mg10f br0" onclick="sub('promo_form');"><?=k_save?></div>	<? }?>
                    <div class="fr ic40 ic40_x icc3 ic40Txt mg10v br0" onclick="win('close','#full_win1');"><?=k_close?></div>
                </div>
            </div>
        </form><?
    }
}?>