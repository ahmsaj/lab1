<?/***XRY***/
$levelsTxt=[
	1=>k_upload_to_import,
	2=>k_upload_file_and_choose_cols,
	3=>k_upld_file_specify_proc,
];

$contentTxt=[
	1=>k_all_content,
	2=>k_words,
	3=>k_letters,
	4=>k_words,
	5=>k_letters
];

$startTxt=[
	2=>k_last_word,
	3=>k_last_char,
	4=>k_start_word,
	5=>k_start_letter
];
$films=array('','Kodak 8 * 10','Fuji 14 * 17');
$comma='_ox2c_';
$line='_ox7c_';

$dcm_server='http://'.$_SERVER['HTTP_HOST'].':8042'; //_set_aq9qizbvd7;
$dcm_max_sync_files_count=1;
$dcm_max_up_files_count=1;
$req_attr_studies=['RequestedProcedureDescription'];
$req_attr_series=['PerformedProcedureStepDescription','BodyPartExamined'];
$stableTxt=[k_unstable,k_stable];
$mod_study='md59xtxplt';

?>