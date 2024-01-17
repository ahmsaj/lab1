<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);

    $r=getRec('api_x_promotion',$id);
    if($r['r']){
        $status=$r['status'];
        if($status!=3){        
            $name=pp($_POST['name'],'s');        
            $msg_title=pp($_POST['msg_title'],'s');
            $msg_desc=pp($_POST['msg_desc'],'s');
            $title=pp($_POST['title'],'s');
            $body=pp($_POST['body'],'s');
            $url=pp($_POST['url'],'s');
            $url_text=pp($_POST['url_text'],'s');
            $photo=pp($_POST['photo']);
            if($url==''){$url_text='';}
            if($url_text==''){$url='';}
             
            if($name && $msg_title && $msg_desc && $title && $body && $url && $url_text){
                $sql="UPDATE api_x_promotion set `name`='$name', `photo`='$photo', `msg_title`='$msg_title', `msg_desc`='$msg_desc', `title`='$title', `body`='$body' ,`url`='$url', `url_text`='$url_text', status=1 where id='$id' ";
                $res=mysql_q($sql);
                if($res){
                    logOpr($id,2,'wuv9f0s7zj');
                    echo 1;
                }
            }
        }
    }
}?>