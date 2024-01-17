<? include("../__sys/mods/protected.php");?>
<link href="<?=$m_path?>library/jquery/css/jq-ui.css" rel="stylesheet" type="text/css"/>
<link href="<?=$m_path?>library/jquery/css/jquery.datetimepicker.css" rel="stylesheet" type="text/css"/>
<link href="<?=$m_path?>library/jquery/css/select2.min.css" rel="stylesheet" type="text/css"/>
<? $style_file=styleFiles();?>
<link href="<?=$m_path?>library/pp/css/prettyPhoto.css" rel="stylesheet" type="text/css"/>
<link href="<?=$m_path?>sys<?=$style_file?>" rel="stylesheet" type="text/css" />
<link href="<?=$m_path?>__sys/css/flex.css" rel="stylesheet" type="text/css" />

<? foreach($proUsed as $p){
	echo '<link href="'.$m_path.$p.$style_file.'" rel="stylesheet" type="text/css" />'; 
}?>
<? $fileName=$fileName='Lg'.$lg.'Mv'.$ProVer.'.js';?>
<script src="<?=$m_path.$fileName?>"></script>
<? $fileName=$fileName='Lg'.$lg.'Sv'.$ProVer.'.js';?>
<script src="<?=$m_path.$fileName?>"></script><?
if($thisGrp=='s'){
    $fileName=$fileName='Lg'.$lg.'Su'.$ProVer.'.js';?>
    <script src="<?=$m_path.$fileName?>"></script><? 
}?>
<script>var k_Xalign='<?=k_Xalign?>';var k_align='<?=k_align?>';</script>
<script src="<?=$m_path?>library/jquery/jq3.6.js"></script>
<script src="<?=$m_path?>library/jquery/jq-ui.js"></script>
<script src="<?=$m_path?>library/jquery/jquery.form.min.js"></script>
<script src="<?=$m_path?>library/jquery/jquery.datetimepicker.js"></script>
<script src="<?=$m_path?>library/jquery/jquery.ui.touch-punch.js"></script>
<script src="<?=$m_path?>library/jquery/select2.min.js"></script>
<script src="<?=$m_path?>__main/funs.js"></script>
<script src="<?=$m_path?>__sys/funsJS_co.js"></script>
<script src="<?=$m_path?>__sys/flex.js"></script>
<script src="<?=$m_path?>library/pp/js/jquery.prettyPhoto.js"></script>
<script src="<?=$m_path?>sysJSv<?=$ProVer?>.js"></script><? 
foreach($proUsed as $p){   
    echo '<script src="'.$m_path.$p.'JSv'.$ProVer.'.js"></script>';
}?>
<script>
	var clr1='<?=$clr1?>';var clr11='<?=$clr11?>';var clr111='<?=$clr111?>';var clr1111='<?=$clr1111?>';
	var clr2='<?=$clr2?>';var clr3='<?=$clr3?>';var clr4='<?=$clr4?>';var clr44='<?=$clr44?>';
	var clr5='<?=$clr5?>';var clr55='<?=$clr55?>';var clr555='<?=$clr555?>';
	var clr6='<?=$clr6?>';var clr66='<?=$clr66?>';var clr666='<?=$clr666?>';
	var clr7='<?=$clr7?>';var clr77='<?=$clr77?>';var clr777='<?=$clr777?>';
	var clr8='<?=$clr8?>';var clr88='<?=$clr88?>';var clr888='<?=$clr888?>';
	var sezPage='';var f_path='<?=$f_path?>';var m_path='<?=$m_path?>';	
	var lg='<?=$lg?>';var l_dir='<?=$l_dir?>';
	var lg_s=new Array('<?=implode("','",$lg_s)?>');
	var lg_n=new Array('<?=implode("','",$lg_n)?>');
	var lg_s_f=new Array('<?=implode("','",$lg_s_f)?>');
	var lg_n_f=new Array('<?=implode("','",$lg_n_f)?>');
	fixPage();
	var logTimer=<?=$logTime?>;
	var langs_count=<?=count($lg_s)?>;
	var langs_count_f=<?=count($lg_s_f)?>;
	var PER_ID='<?=$PER_ID?>';
	var proUsed=new Array();
    var pageN='<?=rand()?>';	
	<? foreach($proUsed as $p){"proUsed.push('".$p."')";}?>
</script>
<? include($folderBack."__main/headSet.php");?>
<? 
if($thisGrp=='s'){
	if(file_exists($folderBack."__super/inc.php")){
		include($folderBack."__super/inc.php");
        $style_file=styleFiles();
        echo '<link href="'.$m_path.'spr'.$style_file.'" rel="stylesheet" type="text/css" />';
        //echo '<link href="'.$m_path.'sprCSS'.$l_dir[0].'M.css" rel="stylesheet" type="text/css" />';        
	}	
}?>