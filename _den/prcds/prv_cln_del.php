<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
    $r=getRec('den_x_prv_clinical',$id);
    if($r['r']){
        $doc=$r['doc'];
        if($doc=$thisUser){
            mysql_q("delete from den_x_prv_clinical where id='$id' ");
            mysql_q("delete from den_x_prv_clinical_items where p_id='$id' ");
            echo 1;
        }
    }
}?>