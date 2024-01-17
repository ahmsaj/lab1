<?/***SUPER***/
$t_array=array('','User ID','GET ID','POST ID','GET','POST','Variable','Static Value','Custom');
$columsTypes=array(1=>'Text',2=>'Date',3=>'Act',4=>'Photo',5=>'Parent',6=>'List',7=>'Textarea',8=>'File',9=>'Lang',11=>'Static',12=>'Pass',13=>'editor',16=>'Text page',14=>'Custom');
$columsTypesCustom=array(10=>'Chiled',15=>'Custom');
$columsTypesLang=array(1=>'Text',7=>'Textarea',13=>'editor',16=>'Text page',4=>'Photo',14=>'Custom');
/*****/
$sysTableArr=['_groups','_users','_information','_settings'];
$main_mods=['jpov2uu45','4x7m8yfnu','c6rw6om76p','3qzmn1xuwa','1hcolcc4ko'];
$main_mods_add=['m7jytbjgq8','8vf2oiahnp','g11klcci2q','vu4qotp6cw','4pxdf726mq','9m9d3fo47c','45vqjpq2iu'];
$sysSittings=['adldd2qmz8','14jk4yqz3w','g6t04uxz0n','50wxlrujf','76nyqowzwb'];
/*****/
$sysTableArr_site=['sit_v_referer','sit_v_sess','sit_v_sess_his','_settings_web','sit_m_pages','sit_m_seo'];
$main_mods_site=['1ar32gq41j','sscyqmuih9','w8w3ulfn6t','3574tvkr5g','0grdqnykmz','yklntj3acx','ev7ccznfk3','9om4jmlj3n','bt764f9ehw'];
$main_mods_add_site=['vr6vj0nvw3','mioj6y1c20','4zsol4553r','','','',''];
$sysSittings_site=['2jaj4f43vd'];

$modTablesBackup=['_modules','_modules_' ,'_modules_butts', '_modules_cons', '_modules_files', '_modules_files_pro', '_modules_items', '_modules_links', '_modules_list'];
$modTablesBackupAPI=['api_module','api_modules_items_in' ,'api_modules_items_out','api_noti_list','api_errors'];
//$modTablesBackup=['_modules_items'];
/***********************************************************/
$sysTableArr= array_merge($sysTableArr,$sysTableArr_site);
$main_mods= array_merge($main_mods,$main_mods_site);
$main_mods_add= array_merge($main_mods_add,$main_mods_add_site);
$sysSittings= array_merge($sysSittings,$sysSittings_site);
?>