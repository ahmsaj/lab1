<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['vis'],$_POST['lev'],$_POST['txt'])){	
	$id=pp($_POST['id']);
    $vis=pp($_POST['vis']);
	$lev=pp($_POST['lev']);
    $txt=pp($_POST['txt'],'s');	
    $r=getRec('den_x_visits_services_levels',$lev);
    if($r['r']){
        $patient=$r['patient'];
        $service=$r['service'];
        $doc=$r['doc'];            
        $x_srv=$r['x_srv'];		
        $lev_id=$r['lev'];
        $price=$r['price'];
        $doc_percent=get_val('den_x_visits_services','doc_percent',$x_srv);		
        $doc_part=$price*$doc_percent/100;
        if($doc==$thisUser || $doc==0){
            if($id){
                mysql_q("UPDATE den_x_visits_services_levels_txt SET `txt`='$txt' where id='$id' ");
                echo $id;    
            }else{
                mysql_q("INSERT INTO den_x_visits_services_levels_txt (`x_srv`,`lev`,`x_lev`,`txt`,`date`,`vis`,`patient`,`srv`) VALUES ('$x_srv','$lev_id','$lev','$txt','$now','$vis','$patient','$service')");
                echo last_id();
            }
        }
    }
}?>