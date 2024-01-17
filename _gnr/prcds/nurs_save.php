<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['mood'],$_POST['vis'],$_POST['nurs'],$_POST['rate'])){
	$mood=pp($_POST['mood']);
    $vis=pp($_POST['vis']);
    $nurs=pp($_POST['nurs']);
    $rate=pp($_POST['rate']);
    $rate=min($rate,5);
    $visInfo=getRec($visXTables[$mood],$vis);
    if($visInfo['r']){
        $doc=$visInfo['doctor'];
        $clinic=$visInfo['clinic'];
        if(getTotalCo('gnr_x_nurses_rate',"mood='$mood' and vis='$vis' ")==0){
            $sql="INSERT INTO gnr_x_nurses_rate (`nurs`,`mood`,`clinic`,`vis`,`doc`,`rate`,`date`)
            values('$nurs','$mood','$clinic','$vis','$doc','$rate','$now')";
            $res=mysql_q($sql);
            if($res){
                $res=mysql_q("select AVG(`rate`) as a  from gnr_x_nurses_rate where nurs='$nurs' ");
                $nursAvrage=number_format(mysql_f($res)['a'],2);                
                mysql_q("UPDATE gnr_m_nurses SET rate=$nursAvrage where id='$nurs' ");
                echo 1;
            }
        }
    }
}?>