<? session_start();
include("../__sys/mods/protected.php");
$folderBack='';
if($_GET['root']){
    $folderBack=intval($_GET['root']);
    $folderBack=str_repeat('../',$folderBack);
}

include($folderBack."__main/define.php");
include($folderBack."__sys/f_funs.php");
$lang_data=checkLang();
$lg=$lang_data[0];//main languge
$l_dir=$lang_data[1];//defult diratoin (ltr or rtl)
$l_dirX=$lang_data[7];
$lg_s=$lang_data[2];// active lang list code ar en sp
$lg_n=$lang_data[3];// active lang list text Arabic English
$lg_s_f=$lang_data[4];// all lang list code ar en sp
$lg_n_f=$lang_data[5];// all lang list text Arabic English
$lg_dir=$lang_data[6];
if($l_dir=="ltr"){define('k_align','left');	define('k_Xalign','right');}else{define('k_align','right');define('k_Xalign','left');}
include($folderBack."__sys/cssSet.php");
login();
list($proAct,$proUsed)=proUsed();
$proActStr="'".implode("','",$proAct)."'";
include($folderBack."__main/lang/lang_k_$lg.php");
include($folderBack."__sys/lang/lang_k_$lg.php");
if($thisGrp=='s'){include($folderBack."__super/lang/lang_k_$lg.php");}
include($folderBack."__sys/funs.php");
include($folderBack."__sys/funs_co.php");
include($folderBack.'__main/funs.php');
include($folderBack."__sys/define.php");
foreach($proUsed as $p){
	$inc_file1=$folderBack.'_'.$p.'/funs.php';
	$inc_file2=$folderBack.'_'.$p.'/define.php';
	if(file_exists($inc_file1)){include($inc_file1);}
	if(file_exists($inc_file2)){include($inc_file2);}	
}
list($def_title,$def_icon)=getThisModInfo();?>