<? include("../header.php");
if(isset($_POST['vis'],$_POST['pat'],$_POST['id'])){
	$id=pp($_POST['id']);
	$vis=pp($_POST['vis']);
	$pat=pp($_POST['pat']);
	$r=getRecCon('cln_x_visits'," id='$vis' and patient='$pat' and doctor='$thisUser'");
	if($r['r']){
		$visStatus=$r['status'];
		if($visStatus==1 || _set_whx91aq4mx){
			mysql_q("delete from cln_x_vital where id='$id' and doc='$thisUser'");
			if(mysql_a()){
				mysql_q("delete from cln_x_vital_items where session_id ='$id' ");
				if(mysql_a()){echo 1;}
			}
		}
	}
}?>