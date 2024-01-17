<? include("ajax_header.php");
if(isset($_POST['c'] , $_POST['v'] , $_POST['id']) ){
	$c=pp($_POST['c'],'s');
	$v=pp($_POST['v'],'s');
	$id=pp($_POST['id']);
	$cData=getColumesData('',1,$c);
	$data=$cData[$c];	
	$col=$data[1];
	if($col){
		$mod_id=get_val_c('_modules_items','mod_code',$c,'code');
		$table=get_val_c('_modules','table',$mod_id,'code');
		$mod_data=loadModulData($mod);
		$x=getTotalCO($table," $col='$v' and id!='$id' ");
		if($x){echo get_val_c($table,'id',$v,$col);}else{echo 0;}
	}
}?>