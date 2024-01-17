<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['vis'])){
	$id=pp($_POST['id']);
	$vis=pp($_POST['vis']);
	list($status,$doc)=get_val('xry_x_visits','status,doctor',$vis);	
	if($doc==$thisUser && $status==1){
		list($price,$percent)=get_val('xry_m_osc_add_service','price,percent',$id);
		if($price!=''){
			if(mysql_q("INSERT INTO xry_x_osc_add_service(`vis`,`add_srv`,`price`,`percent`)values('$vis','$id','$price','$percent')")){echo 1;}
		}
	}
}?>