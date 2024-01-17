<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['code'] , $_POST['type'])){
	$id=$_POST['id'];
	$type=$_POST['type'];
	$data=$_POST['code'];    
    if($type==1){
        $table='_modules_files';
        $folder='mods';
    }else if($type==2){
        $table='_modules_files_pro';
        $folder='prcds';
    }
    $r=getRec($table,$id);
    if($r['r']){
        $file=$r['file'];
        $prog=$r['prog'];
        $filePath=getModFolder($prog).$folder.'/'.$file.'.php';        
        $myfile = fopen($filePath, "w") or die("Unable to open file!");			
        fwrite($myfile,$data);
        //fclose($myfile);
        echo 1;
    }
}?>