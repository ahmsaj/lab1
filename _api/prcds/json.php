<? session_start();
header('Cache-Control: no-cache, must-revalidate');
header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true ");
header("Access-Control-Allow-Methods: OPTIONS, POST");
header("Access-Control-Allow-Headers: Content-Type, Depth, User-Agent, X-File-Size,
    X-Requested-With, If-Modified-Since, X-File-Name, Cache-Control");
$PBL='../../';
if(isset($_POST['mod'])){
	include($PBL."__sys/dbc.php");
	include($PBL."__sys/f_funs.php");
	$lang_data=checkLang();
	$lg=$lang_data[0];//main languge
	$l_dir=$lang_data[1];//defult diratoin (ltr or rtl)
	$lg_s=$lang_data[2];// active lang list code ar en sp
	$lg_n=$lang_data[3];// active lang list text Arabic English
	$lg_s_f=$lang_data[4];// all lang list code ar en sp
	$lg_n_f=$lang_data[5];// all lang list text Arabic English
	$lg_dir=$lang_data[6];
	if($l_dir=="ltr"){define('k_align','left');define('k_Xalign','right');}else{define('k_align','right');define('k_Xalign','left');}
	include($PBL."__sys/cssSet.php");	
	include($PBL."__main/lang/lang_k_$lg.php");
    include($PBL."__sys/lang/lang_k_$lg.php");
	include($PBL."__sys/funs.php");
	include($PBL."__sys/funs_co.php");
	include($PBL."__main/funs.php");
	include($PBL."__sys/define.php");
	include($PBL."_api/funs.php");
    include($PBL."_api/define.php");
	include($PBL."_dts/funs.php");
	include($PBL."_gnr/funs.php");
	include($PBL."_lab/funs.php");
	include($PBL."_gnr/define.php");
    $q_id=apiQuery();
	if($q_id){
		$outInfo='';
		$mod=pp($_POST['mod'],'s');
		$token=pp($_POST['token'],'s');
		$user=pp($_POST['user'],'s');
		$uCode=pp($_POST['uCode'],'s');	
		$page=pp($_POST['page']);
		$rec_id=pp($_POST['rec_id']);
		$data=array();
		$conect=1;
		$error=0;	
		$req_no=pp($_POST['req_no'],'s');
		$data[0]=array($req_no,$conect,$error);
		if(!$req_no){$req_no=0;}
		$thisUser=get_val_con('_users','id',"un='$user' and code='$uCode' and act=1");
		if($thisUser){
			$r=getRecCon('api_module'," code='$mod'");
			if($r['r']){			
				/******************************************/			
				list($eXdata,$obj,$error)=apidataObject($mod);
				if($error==0){
					if($eXdata){$data[1]=$eXdata;}
					if($obj){$data[2]=$obj;}			
				}
			}
		}else{			
			$error=2;
		}
		if($error){$conect=0;}
		/******************************************/
		$data[0]=array($req_no,$conect,$error);
		$json=json_encode($data,JSON_UNESCAPED_UNICODE);
        apiQuery($q_id,$json);
        echo $json;
	}
}
?>