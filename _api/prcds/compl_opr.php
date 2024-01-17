<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['co'],$_POST['t'])){
	$compl=pp($_POST['co']);
    $type=pp($_POST['t']);
    $text=pp($_POST['text'],'s');
    
    $data=$_POST['data'];
    $r=getRec('api_x_complaints',$compl);
    $status=0;
    $msg='';
    $reLoad=1;
    if($r['r']){
        $c_user=$r['user'];
        $c_follower=$r['follower'];
        switch($type){
            case 1:// sel the responsable
                if($c_user==0){
                    mysql_q("UPDATE api_x_complaints SET user='$thisUser' , status=1 where id='$compl' ");
                    addCoplintsAction($compl,$type,$thisUser);
                }else{
                    $msg='تم تحديد المسؤول بالفعل';
                }
            break;
            case 2:// sel follower
                $f_user=$thisUser;
                $f_type=pp($data['type']);                
                if($f_type==2){
                    $f_user=pp($data['user']);
                    sysNotiSend('ii6atk9qkw',$compl,$thisUser,$f_user,$text);
                }
                mysql_q("UPDATE api_x_complaints SET follower='$f_user' , status=2 where id='$compl' ");
                addCoplintsAction($compl,$type,$thisUser,$text);
            break;
            case 3:// add note
                if($thisUser==$c_user || $thisUser==$c_follower){
                    if( $c_user!=$c_follower){
                        if($thisUser==$c_user){
                            sysNotiSend('ii6atk9qkw',$compl,$c_user,$c_follower,$text);
                        }else{
                            sysNotiSend('ii6atk9qkw',$compl,$c_follower,$c_user,$text);
                        }
                    }
                    addCoplintsAction($compl,$type,$thisUser,$text);                    
                }                
            break;
            case 4:// close
            if($thisUser==$c_user){                
                //sysNotiSend('ii6atk9qkw',$compl,$c_user,$c_follower,$text); 
                $solve=pp($data['solve']);
                mysql_q("UPDATE api_x_complaints SET status=3 , solve=$solve where id='$compl' ");
                addCoplintsAction($compl,$type,$thisUser,$text);                    
            }                
            break;
        }
    }
    
    if($err==0){
        echo $status.'^'.$msg.'^'.$reLoad;
    }
}?>