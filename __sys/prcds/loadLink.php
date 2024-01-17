<? include("ajax_header.php");
if(isset($_POST['l'] , $_POST['v'])){
	$l=pp($_POST['l'],'s');
	$v=pp($_POST['v'],'s');
	$s=pp($_POST['s'],'s');
	$d=pp($_POST['d'],'s');
	$mod=get_val_c('_modules_items','mod_code',$l,'code');
	//echo $mod=get_val_c('_modules','module',$mod_id,'code');	
	$cData=getColumesData($l,1);
	echo co_getFormInput_link($l,$v,$s,$d);	
}?>