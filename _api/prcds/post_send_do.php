<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
    //$p=pp($_POST['d'],'s');
    $s=1;
    $rePerSend=5;    
    $r=getRec('api_x_posts',$id);
    if($r['r']){        
        $cat=$r['cat'];
        $catName=get_val('api_m_settings','name_'.$lg,$cat);
        $send=$r['send'];
        $title=$r['title_'.$lg];
        $desc=strip_tags($r['desc_'.$lg]);
        $desc=limitString($desc,100,0,0);
        $desc=strip_tags($desc);
        $status=$r['status'];
        $subsIds1=get_vals('api_x_settings','user',"user_type=1 and set_id='$cat'");
        $subsIds2=get_vals('api_x_settings','user',"user_type=2 and set_id='$cat'");
        $devices=0;
        if($subsIds1){$devices+=getTotalCO('api_notifications_push',"p_type=1 and patient IN ($subsIds1)");}
        if($subsIds2){$devices+=getTotalCO('api_notifications_push',"p_type=2 and patient IN ($subsIds2)");}
        
        $total=$devices;
        $send_ok=0;
        $send_err=0;
        $wOk=$wErr=0;
        $push_id=0;
        //$sendNoti=$rePerSend;
        if($send){
            $sData=explode(',',$send);
            $send_ok=$sData[1];
            $send_err=$sData[2];
            $push_id=$sData[3];
            //$allSend=$send_o+$send_err;
            //$sendNoti=" $allSend , $rePerSend ";
        }
        $q='';
        if($subsIds1){$q=" (p_type=1 and patient IN ($subsIds1)) ";}
        if($subsIds2){if($q){$q.=' OR ';}$q.=" (p_type=2 and patient IN ($subsIds2)) ";}
        
        $tokens=[];
        if($p!=''){
            $sql="select * from api_notifications_push where ( $q )
            and id>'$push_id' order by id ASC Limit $rePerSend";
            $res=mysql_q($sql);
            $rows=mysql_n($res);
            if($rows){
                while($r=mysql_f($res)){
                    $push_id=$r['id'];
                    $app=$r['app'];
                    $tokens[]=$r['token'];
                }
                $key=get_val_c('api_users','notf_code',$app,'code');
                //list($message,$notData)=getTxtNotType(100,$id,$title,$desc,$cat);
                //$rSet=getRecCon('api_noti_set'," user ='$thisUser' ");
                //if($rSet['r']){
                //echo $title.'-'.$desc;
                $message=array(
                    'title'=>$catName,
                    'body'=>$title,		
                    //'sound'=>'',
                    //'icon'=>'',
                    //'color'=>'',
                    //'priority'=>'',
                    //'android_channel_id'=>''
                );
                $notData=array(
                    'type'=>100,
                    'id'=>$id,
                    'cat'=>$cat,
                );
                //}
                
			    $out = send_single_notification($key,$tokens,$message,$notData);
                $out=json_decode($out,true);
                //$out=array('success'=>1,'failure'=>0);
                if(count($out)){
                    $send_ok+=$out['success'];
                    $send_err+=$out['failure'];
                    $sendData=$total.','.$send_ok.','.$send_err.','.$push_id;
                    mysql_q("UPDATE api_x_posts SET `send`='$sendData' where id= '$id' ");
                }else{
                    $s=0;
                    $err='يوجد خطأ بعملية الإرسال';
                }
            }
        }
        if($send_ok){$wOk=($send_ok/$total)*100;}
        if($send_err){$wErr=($send_err/$total)*100;}
        $send_all=$send_ok+$send_err;
        if($total<=$send_all){
            $s=0;
            mysql_q("UPDATE api_x_posts SET `publish`='2' where id= '$id' ");            
            $view='
            <table width="100%" border="0" class="grad_s" type="static" cellspacing="0" cellpadding="4">
                <tr><td txt>مجموعة</td><td><ff class="clr1">'.number_format($total).'</ff></td></tr>
                <tr><td txt>الناجح</td><td><ff class="clr6">'.number_format($send_ok).'</ff></td></tr>
                <tr><td txt>الفاشل</td><td><ff class="clr5">'.number_format($send_err).'</ff></td></tr>
            </table>
            <div class="fs14 f1 clr5 lh30">تم أنهاء عملية الإرسال</div>';
        }else{
            $view='
            <div class="fs18 lh30 ff B">'.$total.'/'.$send_all.'</div>
            <div class="fl SNPrograss">
                <div class="fl clr6" o fix="wp%:'.$wOk.'"></div>
                <div class="fl clr5" e fix="wp%:'.$wErr.'"></div>
            </div>
            <div class="fs14 f1 lh40 loadeText">جاري عملية الإرسال يرجى الانتظار</div>';
        }
        //$view.='<div class="fl ic30 ic30_send ic30Txt icc4" onclick="strSendNot('.$id.')">بدء الإرسال</div>';
        if($err){
            $view='<div class="fs14 f1 clr5 lh30">'.$err.'</div>';
        }
    }else{$s=0;}
    echo $s.'^'.$view;    
}?>