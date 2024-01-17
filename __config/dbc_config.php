<? 
if($_SERVER['HTTP_HOST']=='localhost' || substr($_SERVER['HTTP_HOST'],0,7)=='192.168'){
    //Project Folder Path    
    $_path='/mh8/';
    //Database name
    $_database='mh';
    //Database user name
    $_username='root';
    //Database user password
    $_password='';
    //The protocol used in the project
    $_ptc='http';
    //Server
    $_server='localhost';
    //Project copy number
    $_pro_id='mh45s6';    

}else{
    $_path='/';
    //Database name
    $_database='miraware_mh';
    //Database user name
    $_username='miraware_mh';
    //Database user password
    $_password='[h%{A@)5uuK3';
    //The protocol used in the project
    $_ptc='https';
    //Server
    $_server='localhost';
    //Project copy number
    $_pro_id='mh45s6';  

}
/***missing keywords */
define('k_status','_k_status');
define('k_not_specified','_k_not_specified');
define('k_norm','_k_norm');
define('k_not_norm','_k_not_norm');
define('k_extra_text','_k_extra_text');
define('k_sys_man','_k_sys_man');
define('k_note_doctor','_k_note_doctor');
define('k_th_details','_k_th_details');
define('k_video_link','_k_video_link');
define('k_youtube_link','_k_youtube_link');
define('k_choose_mod_type','_k_choose_mod_type');
define('k_template_name','_k_template_name');
define('k_totla','_k_totla');
define('k_srv_req_paym','_k_srv_req_paym');
define('k_barcode','_k_barcode');
define('k_upload_date','_k_upload_date');
define('k_sent_test','_k_sent_test');
define('k_finish','_k_finish');
define('k_st_syc','_k_st_syc');
define('k_errors','_k_errors');
















?>