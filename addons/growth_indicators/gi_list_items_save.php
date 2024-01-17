<? include("../header.php");
if(isset($_POST['id'],$_POST['pat'],$_POST['vis'])){
	$id=pp($_POST['id']);
	$pat=pp($_POST['pat']);
	$vis=pp($_POST['vis']);	
	$age=pp($_POST['age'],'f');
	$weight=pp($_POST['weight'],'f');
	$Length=pp($_POST['Length'],'f');
	$head=pp($_POST['head'],'f');
	$r=getRecCon('cln_x_visits'," id='$vis' and patient='$pat' and doctor='$thisUser'");
	if($r['r']){
		$visStatus=$r['status'];
		if($visStatus==1 || _set_whx91aq4mx){
			if($weight && $Length){
				if(!$id){
					$sql="INSERT INTO gnr_x_growth_indicators (`date`,`patient`,`user`,`age`,`weight`,`Length`,`head`) values ('$now','$pat','$thisUser','$age','$weight','$Length','$head')";
					$res=mysql_q($sql);
					$id=last_id();	
				}else{
					$res=mysql_q("UPDATE gnr_x_growth_indicators SET `age`='$age' ,`weight`='$weight' ,`Length`='$Length',`head`='$head' where id='$id' and user='$thisUser'");
				}
				echo $id;
			}
		}		
	}else{
		exit; out();	
	}
}?>
