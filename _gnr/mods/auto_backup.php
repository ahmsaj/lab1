<? session_start();
include("min/dbc.php");
include("__sys/f_funs.php");
$lang_data=checkLang();
$lg=$lang_data[0];//main languge
$l_dir=$lang_data[1];//defult diratoin (ltr or rtl)
$lg_s=$lang_data[2];// active lang list code ar en sp
$lg_n=$lang_data[3];// active lang list text Arabic English
$lg_s_f=$lang_data[4];// all lang list code ar en sp
$lg_n_f=$lang_data[5];// all lang list text Arabic English
include("__main/lang/lang_k_$lg.php");
include("__sys/lang/lang_k_$lg.php");
include("__sys/funs.php");
include("__sys/funs_co.php");
include("__sys/define.php");
if(SysBackUp("backup/"))echo 'OK';