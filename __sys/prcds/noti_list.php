<? include("../../__sys/prcds/ajax_header.php");
$sql="select * from _sys_notification where receiver='$thisUser' order by date DESC limit 20";
$res=mysql_q($sql);
$rows=mysql_n($res);
if($rows){
    ('_sys_notification_set');
    $data=getData('_sys_notification_set','','code');    
    while($r=mysql_f($res)){
        $noti_code=$r['noti_code'];
        $des=$r['description'];
        $rec_id=$r['rec_id'];
        $sender=$r['sender'];
        $status=$r['status'];
        $date=$r['date'];
        
        $title=$data[$noti_code]['title_'.$lg];
        $type=$data[$noti_code]['type'];
        $sub_type=$data[$noti_code]['sub_type'];
        $show_sender=$data[$noti_code]['show_sender'];        
        
        $senderTxt='';
        $desTxt='';
        $action='';
        if($sender && $show_sender){
            $senderTxt='<div class="f1 lh20 fs10 lh20">المرسل: '.get_val_arr('_users','name_'.$lg,$sender,'u').'</div>';
        }        
        if($type==1){// go to module
            $mod=getModNow($sub_type,1);
		    $chPer=checkPer($mod)[0];
            if($chPer){
                $link=get_val_c('modules','module',$sub_type,'code').'.'.$rec_id;
                $action= 'onclick="loc(\''.$link.'\')"';
            }else{
                $des='<span class="f1 fs10 clr5 lh20">لا يوجد صلاحيات لزيارة القسم الرجاء إخبار المسؤول عن هذا</span>';
            }
        }
        if($type==2){// go to additional module 
            $mod=getModNow($sub_type,2);
		    $chPer=checkPer($mod)[0];
            if($chPer){
                $link=get_val_c('_modules_','module',$sub_type,'code').'.'.$rec_id;
                $action= 'onclick="loc(\'_'.$link.'\')"';
            }else{
                $des='<span class="f1 fs10 clr5 lh20">لا يوجد صلاحيات لزيارة القسم الرجاء إخبار المسؤول عن هذا</span>';
            }
        }
        echo '<div class="notiBlc Over2" st="'.$status.'" '.$action.'>
            <div class="fr f1 fs10">'.k_since.' '.dateToTimeS($now-$date,1).'</div>
            <div class="f1 clr1 fs14 lh30">'.$title.'</div>
            <div class="f1 lh20 fs10 lh20 clr9">'.limitString($des,120).'</div>
            '.$senderTxt.'
        </div>';
             
    }
    mysql_q("DELETE from _sys_notification_live where id='$thisUser'");
    mysql_q("UPDATE _sys_notification set status='1' where receiver='$thisUser'");
}else{
    echo '<div class="notiBlc f1 fs12 clr5">'.k_no_results.'</div>';
}
?>
