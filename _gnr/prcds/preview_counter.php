<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['p_id'] , $_POST['t'])){	
	$p_id=pp($_POST['p_id']);
	$t=pp($_POST['t'],'s');
	if($t==1){
		if(_set_9jfawiejb9==1){
			echo getTotalCO('lab_x_visits_requested',"patient='$p_id' and status < 3 ");
		}else{
			echo getTotalCO('cln_x_pro_analy',"p_id='$p_id' and view=0 ");
		}
	}
	if($t==2){echo getTotalCO('xry_x_visits_requested',"patient='$p_id' and view=0 ");}
	if($t==3){echo getTotalCO('cln_x_pro_x_operations',"p_id='$p_id' and status=0 ");}
	echo checkOPrEx($t,$p_id);
}?>