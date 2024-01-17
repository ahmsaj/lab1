<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	list($date,$status,$patient,$mood)=get_val('dts_x_dates','date,status,patient,type',$id);
	if($status==0){ 
        echo delDate($id,$mood);        
	}
}?>