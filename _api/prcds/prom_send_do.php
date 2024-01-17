<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
    $r=getRec('api_x_promotion',$id);
    $s=1;
    if($r['r']){
        $cat=$r['cat'];        
        $photo=$r['photo'];
        $msg_title=$r['msg_title'];
        $msg_desc=$r['msg_desc'];
        $status=$r['status'];
        $total=$r['total'];
        if($status==2){
            mysql_q("UPDATE api_x_promotion set status=3 where id='$id'");
        }
        $n=5;
        $err=0;
        if($status<4){
            $key=get_val_c('api_users','notf_code','pg08256dz2','code');                   
            $send_ok=getTotalCo('api_x_promotion_msg',"status=1");
            $send_err=getTotalCo('api_x_promotion_msg',"status=2");
            if($p!=''){
                $sql="select * from api_x_promotion_msg where status=0 Limit $n";
                $res=mysql_q($sql);
                $rows=mysql_n($res);
                if($rows){
                    while($r=mysql_f($res)){
                        $msg_id=$r['id'];
                        $pat=$r['patient'];
                        $pat_info=getRec('gnr_m_patients',$pat);
                        $token=$pat_info['token'];
                        $pat_name=$pat_info['f_name'];
                        $tokens=get_vals('api_notifications_push','token',"p_type=1 and patient = $pat ",'arr');
                        if(count($tokens)){
                            $data=['p'=>$pat_name];
                            $title=promoReplaceData($msg_title,$data);
                            $body=promoReplaceData($msg_desc,$data);
                            $message=array('title'=>$title,'body'=>$body);
                            $notData=array(
                                'title'=>$title,
                                'body'=>$body,		
                                'sound'=>$rSet['sound'],
                                'icon'=>$rSet['icon'],
                                'color'=>$rSet['color'],
                                'priority'=>$rSet['priority'],
                                'android_channel_id'=>$rSet['channal'],
                                'type'=>200,
                                'id'=>$id,            
                                'notification_id'=>0,
                            );   

                            $out = send_single_notification($key,$tokens,$message,$notData);
                            $out=json_decode($out,true);
                            //$out=array('success'=>1,'failure'=>0);
                            if(count($out)){
                                $msgStatus=0;
                                if($out['success']){
                                    $send_ok++;
                                    $msgStatus=1;
                                }else{
                                    $send_err++;
                                    $msgStatus=2;
                                }
                                if($msgStatus){
                                    mysql_q("UPDATE api_x_promotion_msg set status='$msgStatus' where id ='$msg_id' ");
                                    syncProm($id);
                                }
                            }
                        }
                        /*******************/
                        if($send_ok){$wOk=($send_ok/$total)*100;}
                        if($send_err){$wErr=($send_err/$total)*100;}
                        $send_all=$send_ok+$send_err;  
                        $view='
                        <div class="fs18 lh30 ff B">'.$total.'/'.$send_all.'</div>
                        <div class="fl SNPrograss">
                            <div class="fl clr6" o fix="wp%:'.$wOk.'"></div>
                            <div class="fl clr5" e fix="wp%:'.$wErr.'"></div>
                        </div>
                        <div class="fs14 f1 lh40 loadeText">جاري عملية الإرسال يرجى الانتظار</div>';
                    }
                }else{                                
                    $view='
                    <table width="100%" border="0" class="grad_s" type="static" cellspacing="0" cellpadding="4">
                        <tr><td txt>مجموعة</td><td><ff class="clr1">'.number_format($total).'</ff></td></tr>
                        <tr><td txt>الناجح</td><td><ff class="clr6">'.number_format($send_ok).'</ff></td></tr>
                        <tr><td txt>الفاشل</td><td><ff class="clr5">'.number_format($send_err).'</ff></td></tr>
                    </table>
                    <div class="fs14 f1 clr5 lh30">تم أنهاء عملية الإرسال</div>';
                    if($status==3){
                        mysql_q("UPDATE api_x_promotion set status=4 where id='$id'");
                    }
                    $s=0;
                }
                
            }
            if($err){
                $view='<div class="fs14 f1 clr5 lh30">'.$err.'</div>';
            }
        }
    }else{$s=0;}
    echo $s.'^'.$view;    

}?>