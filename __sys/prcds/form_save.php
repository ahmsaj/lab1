<? include("ajax_header.php");
if(isset($_POST['encData'])){
	$encData=Decode($_POST['encData'],_pro_id);
	$data=explode('^*^',$encData);
	$mod=pp($data[0],'s');
	$id=pp($data[1],'s');
	$sub=pp($data[2],'s');
	$fil=pp($data[3],'s');
	$col=pp($data[4],'s');
	$type=pp($data[5],'s');
	$bc=pp($data[6],'s');
	if(($id==0 && $chPer[1])||($id!=0 && $chPer[2])){
	echo co_saveForm($id,$mod,$sub,$type,$fil,$col,$bc);
	}else{out();}
}?>