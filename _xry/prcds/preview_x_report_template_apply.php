<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['pat'])){
	$id=pp($_POST['id']);
	$pat=pp($_POST['pat']);
	echo replacRepVals($pat,get_val('xry_m_pro_radiography_report_templates','content',$id));
}?>