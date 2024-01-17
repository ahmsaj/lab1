<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['type'],$_POST['val'])){
	$type=$_POST['type'];
    $val=$_POST['val'];
    $data=[];
    foreach($clinicTypes as $k=>$mood){
        if($k){
            if(!$type[$k]){$type[$k]=0;}
            if(!$val[$k]){$val[$k]=0;}
           $data[$k]=[$type[$k],$val[$k]];            
        }
    }
    $set=json_encode($data);
    mysql_q("update _settings set val='$set' where code='0ydmtuvd3x'");
}?>