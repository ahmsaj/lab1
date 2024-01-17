<? session_start();
header('Content-Type: text/html; charset=utf-8');
include("../../__sys/dbc.php");
include("../../__main/define.php");
include("../../__sys/f_funs.php");
if(file_exists("../../__sys/mods/protected.php")){
	include("../../__sys/mods/protected.php");
}

$lang_data=checkLang();
$lg=$lang_data[0];
$l_dir=$lang_data[1];
$lg_s=$lang_data[2];
$lg_n=$lang_data[3];
$lg_s_f=$lang_data[4];
$lg_n_f=$lang_data[5];
$lg_dir=$lang_data[6];
if($l_dir=="ltr"){define('k_align','left');	define('k_Xalign','right');}else{define('k_align','right');define('k_Xalign','left');}
include("../../__sys/cssSet.php");
include("../../__main/lang/lang_k_$lg.php");
include("../../__sys/lang/lang_k_$lg.php");
include("../../__sys/funs.php");
include('../../__main/funs.php');
include("../../__sys/funs_co.php");
include("../../__sys/define.php");
$MO_Type=2;
list($proAct,$proUsed)=proUsed('rkzmllzcn');
foreach($proUsed as $p){
	$inc_file1='../../_'.$p.'/funs.php';
	$inc_file2='../../_'.$p.'/define.php';
	if(file_exists($inc_file1)){include_once($inc_file1);}
	if(file_exists($inc_file2)){include_once($inc_file2);}
}
loginAddon();
$addons=loadAddons();
include_once("../../addons/_define.php");
include_once("../../addons/_funs.php");
foreach($addons as $a){
	if(file_exists("../../addons/$a/_funs.php")){
		include_once("../../addons/$a/_define.php");
		include_once("../../addons/$a/_funs.php");
	}
}?>
<!--***-->