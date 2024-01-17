<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'] , $_POST['mood'])){
	$vis=pp($_POST['vis']);
	$mood=pp($_POST['mood']);
    $amount=pp($_POST['a']);
    $table=$visXTables[$mood];
    $q='';
    if($mood!=2){$q="and status in(1,2)";}    
	$sql="select * from $table where id='$vis' $q ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);	
	if($rows>0){
		if($mood==1){echo addPay1($vis,44);addPay1($vis,2);}
        if($mood==2){
            $type=2;
            if($amount<0){
                $amount=$amount*(-1);
                $type=4;
            }
            echo addPay2($vis,$type,$amount);
        }
		if($mood==3){echo addPay3($vis,44);addPay3($vis,2);}		
		if($mood==5){echo addPay5($vis,44);addPay5($vis,2);}        
		if(_set_ruqswqrrpl==0){
            payAlertBe($vis,$mood);
        }
	}
}?>