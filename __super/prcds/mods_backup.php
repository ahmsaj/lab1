<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['type'])){
    $type=pp($_POST['type']);
    $out=[];
    $files=$modTablesBackup;
    $filename='mira-mod-';
    if($type==2){$files=$modTablesBackupAPI;$filename='mira-api-';}
    foreach($files as $table){
        $data=backUpTable($table);
        $out[]=$data;
    }    
    echo $out=json_encode($out,JSON_UNESCAPED_UNICODE);
    $dir='../../__super_backup/';
    if(!file_exists($dir)){mkdir($dir,0777);}
    $files=glob($dir.'*');
    //foreach($files as $file){if(is_file($file)){unlink($file);}}foreach($files as $file){if(is_file($file)){unlink($file);}}
    file_put_contents($dir.$filename.date('YmdHis',$now).'.mwb', $out);
}
?>