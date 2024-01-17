<? session_start();
include("../__sys/mods/protected.php");
header('Content-Type: text/html; charset=UTF-8');
$PBL='../../';
include($PBL."__sys/dbc.php");
include($PBL."__main/define.php");
include($PBL."__sys/f_funs.php");
$lang_data=checkLang();
$lg=$lang_data[0];
$l_dir=$lang_data[1];
$lg_s=$lang_data[2];
$lg_n=$lang_data[3];
$lg_s_f=$lang_data[4];
$lg_n_f=$lang_data[5];
$lg_dir=$lang_data[6];
if($l_dir=="ltr"){define('k_align','left');	define('k_Xalign','right');}else{define('k_align','right');define('k_Xalign','left');}
include($PBL."__sys/cssSet.php");
include($PBL."__main/lang/lang_k_$lg.php");
include($PBL."__sys/lang/lang_k_$lg.php");
if($thisGrp=='s'){include($PBL."__super/lang/lang_k_$lg.php");}
include($PBL."__sys/funs.php");
include($PBL."__main/define.php");
include($PBL."__main/funs.php");
include($PBL."__sys/funs_co.php");
include($PBL."__sys/define.php");
loginAjax();list($proAct,$proUsed)=proUsed($mod);
//$proActStr="'".implode("','",$proAct)."'";
foreach($proUsed as $p){
	$inc_file1=$PBL.'_'.$p.'/funs.php';
	$inc_file2=$PBL.'_'.$p.'/define.php';
	if(file_exists($inc_file1)){include_once($inc_file1);}
	if(file_exists($inc_file2)){include_once($inc_file2);}
}
$chPer=checkPer($PER_ID);