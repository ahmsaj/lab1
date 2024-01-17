<?/***mAddons***/
function minButt($code){
	return '<div class="fr i30 i30_min" title="تصغير" s="1" mmb="'.$code.'"></div>';
}
function showPartDet($vis,$pat,$mood,$code){
	global $lg;	
	switch($code){
		case 'com':$out= mp_showDet($mood,$pat,1);break;
		case 'dia':$out= mp_showDet($mood,$pat,2);break;
		case 'cln':$out= mp_showDet($mood,$pat,3);break;
		case 'str':$out= mp_showDet($mood,$pat,4);break;
		case 'not':$out= mp_showDet($mood,$pat,5);break;
		case 'icd':$out= ic_showDet($mood,$pat,1);break;
		case 'icp':$out= ic_showDet($mood,$pat,2);break;		
	}
	return $out;
}
function _styleFiles($a,$dir=''){	
	global $l_dir,$logTs,$ProVer;	
	if($dir){$l_dir=$dir;}
	
	$file='addCSSr'.$a.'V'.$ProVer.'M.css';
	//if(_set_2fgiibephe){$file=$f.'CSS'.$c.$l_dir[0].'V'.$ProVer.'.css';}
    
	return $file; 
}?>