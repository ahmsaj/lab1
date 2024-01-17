<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['pat'],$_POST['id'],$_POST['t'],$_POST['cat'])){
	$pat=pp($_POST['pat']);
	$id=pp($_POST['id']);
	$t=pp($_POST['t']);	
	$doc=pp($_POST['doc'],'s');	
	$cat=pp($_POST['cat']);	
	$title=pp($_POST['title'],'s');
	$des=pp($_POST['des'],'s');
	$doc_date=pp($_POST['doc_date'],'s');
	$careator=pp($_POST['careator'],'s');
	
	if($pat && $t && $doc && $doc_date){
		$doc_date=convDate2Strep($doc_date);
		if($id){
			$r=getRec('gnr_x_patients_docs',$id);			
			$t=$r['type'];
			$patient=$r['patient'];			
			if($patient!=$pat){exit;}
			$sql="UPDATE gnr_x_patients_docs SET cat='$cat' , doc='$doc', title='$title', des='$des', doc_date='$doc_date', careator='$careator' where id='$id'";
		}else{
			$sql="INSERT INTO gnr_x_patients_docs (`patient`,`doc`,`type`,`cat`,`user`,`date`,`title`,`des`,`doc_date`,`careator`)
			values('$pat','$doc','$t','$cat','$thisUser','$now','$title','$des','$doc_date','$careator')";
		}
		if(mysql_q($sql)){echo 1;}
	}
}?>