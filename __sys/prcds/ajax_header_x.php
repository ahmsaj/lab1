<? session_start();header('Content-Type: text/html; charset=utf-8');
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
include($PBL."__main/funs.php");
include($PBL."__sys/funs_co.php");
include($PBL."__sys/define.php");
$chPer=1;
if($thisGrp=='s'){include($PBL."__super/funs.php");}
include("../../__main/prcds/ajax_head_add.php");?>
<!--***-->