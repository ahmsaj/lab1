<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
    $manager=$chPer[2];
    $q=" status=2 and follower='$thisUser'";
    if($manager){
        $q=" ( user=0 or user='$thisUser') ";
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
        $solve=$r['solve'];        
        $status=$r['status'];
        $userText='غير محدد';
        if($user){
            $userText=get_val('_users','name_'.$lg,$user);
        }
        $followerTxt='غير محدد';
        if($follower){
            $followerTxt=get_val('_users','name_'.$lg,$follower);
        }else{
            $usersList=get_vals('_users','id','name_'.$lg," act=1");
        }?>
        <div class="fxg h100" fxg="gtr:40px 1fr auto">
            <div class="b_bord pd10 cbg444">
                <div class="fr lh40"><ff>#<?=$id?></ff></div>
                <div class="f1 fs14 lh30 clr1 lh40">
                    <?=get_p_name($patient)?> 
                    <? if($manager){ echo '( '.$complStatus[$status].' )'; }?>
                </div>
            </div>
        <div class="ofx so pd10f">            
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="grad_s2 holdH pdd10" Over="0">
                <tr>
                    <td class="f1 fs14" width="120">رقم الشكوى:</td>
                    <td class="ff B fs16">#<?=$id?></td>
                </tr>
                <tr>
                    <td class="f1 fs14" width="120">التاريخ:</td>
                    <td class="ff B fs16">
                        <?=date('Y-m-d Ah:i:s',$date)?> 
                        <span class="f1 fs12 clr5">( <?=dateToTimeS($now-$date,1)?> )</span></div>
                    </td>
                </tr>
                <? if($user){?><tr><td class="f1 fs14">المسؤول:</td><td><div class="f1 fs14 clr1"><?=$userText?></div></td></tr><? }?>
                <? if($follower && $manager){?><tr><td class="f1 fs14">المتابع:</td><td><div class="f1 fs14 clr1"><?=$followerTxt?></div></td></tr><? }?>
                <tr>
                    <td class="f1 fs14">الشكوى:</td>
                    <td class="cbg555 pd20"><div class="f12 f1 pd5v"><?=nl2br($complaint)?></div></td>
                </tr>
                <? if($solution && $manager){?>
                    <tr>
                        <td class="f1 fs14">الحل المقترح:</td>
                        <td class="cbg666 pd20 "><div class="f12 f1 pd5v"><?=nl2br($solution)?></div></td>
                    </tr>
                <? }?>
            </table><?
            if(!$user){?>
                <div class="f1 clr5 fs14 pd10v">
                    حتى تتمكن من متابعة الشكوى وكتابة الملاحظات واسناد مهام لأشخاص لمتابعة الشكوى وحلها يجب أن تكون مسؤول عن هذه
                </div>
                <div class="fl bu2 bu_t3 " c_resp>سأكون المسؤول عن هذه الشكوى</div><? 
            }else{
                if(!$follower){?>
                    <div class="f1 clr1 fs14 pd10v">
                        هل ستقول بمتابعة الشكوى بنفسك اما ستسندها لشخص أخر ليقوم بأجراءات لحل المشكلة
                    </div>
                    <div class="fl bu2 bu_t1 " c_foll="1">أنا سأتابع الشكوى بنفسي</div>
                        
                    <div class="bord pd10f br5 cb w100 cbg444">
                        <div class="f1 fs14 clr1 lh40">أختر المتابع</div>                                
                        <div><?=make_Combo_box('_users','name_'.$lg,'id',"where act=1",'c_user',1,'','sel2');?></div>
                        <div class="f1 fs14 clr1 lh40">يمكنك إضافة بعض الملاحظات لتوجيه المتابع</div>
                        <div><textarea class="w100" id="c_note" t></textarea></div>
                        <div class="in ic40 ic40_save ic40Txt icc2 mg10v" c_foll="2">حفظ / إرسال تنبيه</div>
                    </div><?
                }
            }?>
            <div><? 
                $sql="select * from api_x_complaints_actions where complaint_id='$id'  order by date ASC";
                $res=mysql_q($sql);
                if(mysql_n($res)){
                    echo '<div class="f1 clr1 fs16 g10v lh40">الإجراءات</div>';
                    while($r=mysql_f($res)){
                        $type=$r['type'];
                        $user=get_val_arr('_users','name_'.$lg,$r['user'],'u');
                        $description=$r['description'];
                        $date=$r['date'];
                        if($description){$note='<div class="fl f1 w100 t_bord pd10v">'.nl2br($description).'</div>';}
                        $solveTxt='';
                        if($type==4){
                            $solveTxt='<span class="f1 clr5"> ( لم تحل الشكوى )</span>';
                            if($solve==1){$solveTxt='<span class="f1 clr6"> ( تم حل الشكوى )</sapn>';}
                        }
                        echo '<div class="fl w100 bord mg5v pr br5 pd10f cbg444">
                            <div class=" f1 fs14  ">
                                <div class="fl f1 fs14 clr1">
                                    '.$complActionsStatus[$type].' '.$solveTxt.'
                                    <br>
                                    <span class="f1 clr6 fs10">'.$user.'</span>
                                </div>
                                <div class="fr clr11">
                                    <ff14>'.date('Y-m-d Ah:i ',$date).'</ff14><br>
                                    <span class="f1">'.k_since.' '.dateToTimeS($now-$date,1).'</span>
                                </div>                                
                            </div>                            
                            '.$note.'
                        </div>';
                    }
                }?>&nbsp; 
            </div> 
        </div>        
        <? if($status==2){?>
            <div class="t_bord cbg444">
                <? if($status==2){echo '<div class="ic40 ic40Txt icc1 ic40_note fl" addNote>إضافة إجراء</div>';}?>
                <? if($status==2 && $manager){echo '<div class="ic40 ic40Txt icc2 ic40_done fr" addNote2>إغلاق</div>';}?>
            </div><?
        }
    }
}?>