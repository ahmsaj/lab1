<? session_start(); header('Content-Type: application/json');
$file='../api_ws.php';
$id=intval($_POST['id']);
if(file_exists($file)){
    $dataArr=[];
    $myfile=fopen($file, "r");
    $data=fread($myfile,filesize($file));
    $d=explode("|",$data);
    foreach($d as $k=>$v){
        if($v){
            $recData=explode('^',$v);
            //$txt='n^'.$chat_id.'^'.$mess_id.'^'.$date.'^'.$mess.'|';
            if($recData[0]=='n'){//new message
                $recData[3]=date('A h:i:s',$recData[3]);
            }
            if($recData[1]!=$id){//delete message for other chat
                $recData[2]='';$recData[4]='';
            }
            $dataArr[]=$recData;
        }
    }
    echo json_encode($dataArr,JSON_UNESCAPED_UNICODE);
    file_put_contents($file,'');
    //fclose($myfile);
}