<? include("../../__sys/prcds/ajax_header.php");
if($thisGrp!='s'){
    $pn=pp($_POST['pn']);
    $out=1;
    $msg='';
    $sql=" select * from _log where `mod` ='fgz4ysqwd1' and `min`=1";
    $res=mysql_q($sql);
    $rows=mysql_n($res);    
    if($rows){
        $out=0;
        $r=mysql_f($res);
        $user=$r['user'];
        $status=$r['status'];
        if($status==1){
            $msg='ستكون الصفحة متاحة قريبا';
        }else{
            if($user==$thisUser){
                if(getTotalCO('_log',"`mod` ='fgz4ysqwd1'")==1){
                    mysql_q("UPDATE _log SET `pn`='$pn' where `mod` ='fgz4ysqwd1' ");
                    $out=1;
                }
                $msg='صفحة المحادثة مفتوحة سابقا يرجى الانتظار';
            }else{
                $userName=get_val('_users','name_'.$lg,$user);
                $msg='الصفحة مستخدمة من قبل '.$userName;
            }
        }
    }else{
         mysql_q("UPDATE _log SET `min`=1 where `mod` ='fgz4ysqwd1' and pn='$pn' ");        
    }
   
}else{
   $out=0;
   $msg='لا يمكن فتحوه من السوبر أمين';
}
if($out==1){
    $msg=loadChats();
    $file='../api_ws.php';
    if(file_exists($file)){        
        $myfile=fopen($file, "r");
        file_put_contents($file,'');
        //fclose($myfile);
    }
}
echo $out.'^'.$msg;
?>