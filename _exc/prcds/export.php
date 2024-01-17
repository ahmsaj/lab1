<? session_start();
if(isset($_POST['id'],$_POST['enc_code'])){
	include("../min/dbc.php");
	include("../__sys/f_funs.php");
	include("../__sys/funs.php");
	include("../__sys/funs_co.php");
	loginAjax();
	$temp_code=pp($_POST['id'],'s');
	$enc_code=pp($_POST['enc_code'],'s');
	$rec=getRecCon('exc_templates',"code='$temp_code'");
	if($rec['r']>0){
		$template=$rec['id'];
		$templateName=$rec['name'];
		$module=$rec['module'];
		$module_name=get_val_con('_modules','title',"code='$module'");
		$header=$rec['header_row'];
		$empty_fields=$rec['empty_fields'];
		$cols=$rec['cols'];
		$act=$rec['act'];
		$temp_user_code=getRandString(10);
		//$related_processes=$rec['related_processes'];
		$out='$sql="'."INSERT INTO `exc_templates`(`code`,`name`, `header_row`, `module`, `cols`, `empty_fields`, `act`,`addition_date`) VALUES ('$temp_user_code','$templateName',$header,'$module','$cols','$empty_fields','1','".'$now'."')\";";
		$out.='mysql_q($sql); $last_temp=last_id();';
		$sql="select * from exc_template_fields where template='$template'";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			while($r=mysql_f($res)){
				$template=$r['template'];
				$module_col=$r['module_col'];
				$type_col=$r['type_col'];
				$file_fields=$r['file_fields'];
				$out.='$sql="'."INSERT INTO `exc_template_fields`(`template`, `module_col`, `type_col`, `file_fields`) VALUES('".'$last_temp'."','$module_col','$type_col','\".'$file_fields'.\"')\";";
				$out.='mysql_q($sql);';
			}
		}
		
		$name='template_'.$temp_code.'.txt';
		//header('Pragma: public');
		header("Content-Type: text/plain; charset=UTF-8");			
		header("Content-disposition:attachment; filename= '$name' ");	
		//echo $out;
		echo Encode($out,$enc_code);
	}
}else{
	include("../../__sys/prcds/ajax_header.php");
	if(isset($_POST['state'],$_POST['temp'])){
		$id=pp($_POST['temp']);
		$state=pp($_POST['state'],'s');
		if($state=='view'){
			$code=get_val('exc_templates','code',$id);
			?>
			<div class="win_body">
			<div class="form_header so lh20 f1 fs14 fl"></div>
			<div class="form_body so">
				<div class="lh20 f1 fs14 fl"><?=k_enter_encrypt_code_for_export?>:</div>
				<form id="ex_code" name="ex_code" method="post" action="<?=$f_path?>X/exc_export.php" bv="a">
					<input type='text' name='enc_code' />
					<input type="hidden" name="id" value="<?=$code?>" />
				</form>
			</div>
			<div class="form_fot fr">
				<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div> 
				<div class="bu bu_t3 fl" onclick="doExport()"><?=k_export?></div>
			</div>
			</div>
		<?}
	}
}


?>