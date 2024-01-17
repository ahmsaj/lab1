<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['m'],$_POST['n'])){
	$chat_id=pp($_POST['id']);
    $n=pp($_POST['n']);
    $m=pp($_POST['m'],'s');
    $r=getRec('api_chat',$chat_id);
    if($r['r']){
        $pat=$r['patient'];
        $pat_type=$r['pat_type'];
        if(mysql_q("INSERT INTO api_chat_items (chat_id,mess_type,mess,date,user)value('$chat_id',2,'$m','$now','$thisUser')")){
            $mess_id=last_id();
            echo $n.'^'.$mess_id.'^'.date('A h:i:s');        
            chatNav(1,$pat,$pat_type,$mess_id,$m);
        }
    }
}?>