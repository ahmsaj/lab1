<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['m'],$_POST['opr'])){
	$chat_id=pp($_POST['id']);
    $mess_id=pp($_POST['m']);
    $opr=pp($_POST['opr']);
    if($opr==1){//set message as readed
        mysql_q("UPDATE api_chat_items SET status=1 where chat_id='$chat_id' and  id='$mess_id' and status=0 ");
        echo $mess_id;
        chatNav(2,0,$chat_id,$mess_id,'');         
    }
    /*if($opr==2){//set message ass readed from visitor
        $date=$mess_id;
        $q="chat_id='$chat_id' and date <$date and status=0 and mess_type='2' ";
        echo $ids=get_vals('api_chat_items','id',$q);
        //mysql_q("UPDATE api_chat_items SET status=1 where $q ");
        
    }*/
}?>