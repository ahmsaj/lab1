<? include("../library/ex_reader.php");

function getActID2($v,$table,$f,$key){
	global $lg;
	if(strpos($f,'_(L)')!==false){$f=str_replace('(L)',$lg,$f);}
	if($v){
		$sql="select $key from $table where `$f`='$v' limit 1"; 
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			return mysql_f($res)["$key"];
		}else{
			$res=mysql_q("INSERT INTO $table (`$f`) value('$v')");
			if($res){
				return last_id();	
			}

		}
	}
}

function countinue($id){
	$level=get_val('exc_import_processes','level',$id);
	if($level==4){$text=k_template_use; $bu='bu_t1';}
	else{$text=k_template_complete;; $bu='bu_t3';}
	return '<div style="width:30%;" class=" fr bu '.$bu.'"  onclick="">'.$text.'</div>';
}

function multipleSelect($field,$list,$sel=''){
	if($sel!=''){$sel_arr=explode(',',$sel);}
	$out='<div style=" max-height:350px;" class="radioBlc so fl " name="'.$field.'" req="0">';
	foreach($list as $k=> $it){
		$ch="off";
		if(in_array($k,$sel_arr)){$ch="on";}
		$out.='<div class="radioBlc_each fl" ri_name="col_'.$k.'" ri_val="'.$k.'" set="1" ch="'.$ch.'" onclick="setUpMultipleSel(\'col_'.$k.'\',\''.$field.'\')">
			<div class="form_radio fl">
				<div>
					<div></div>
				</div>
			</div>
			<div class="ri_labl fl">'.$it.'</div>
		</div>';
	}
	
			$out.='<input type="hidden" name="'.$field.'" id="ri_'.$field.'" value="">';
		$out.='</div>';
	if($sel!=''){
			$out.="<script>setUpMultipleSel('','$field','$sel');</script>";
		}
	return $out;
}

function selectFromArrayWithVal2($filed,$fieldId,$array,$req=-1,$start=0){
	$out='';
	if(is_array($array)){		
		$out.='<select style="width:60px;" name="'.$filed.'" id="'.$fieldId.'">';
		if($req==-1)$out.='<option value=""></option>';
		else{
			$det=explode(":",$array[$req]);
			$val=$det[0];
			$txt=$det[1];
			$out.='<option value="'.$val.'">'.get_key($txt).'</option>';
		}
		for($i=$start;$i<count($array);$i++){
			if($i!=$req){
				$det=explode(":",$array[$i]);
				$val=$det[0];       
				$txt=$det[1];
				$out.='<option value="'.$val.'">'.get_key($txt).'</option>';
			}
		}
		$out.='</select>';
	}
	return $out;
}

function str_split_unicode($str, $l = 0) {
    if ($l > 0) {
        $ret = array();
        $len = mb_strlen($str, "UTF-8");
        for ($i = 0; $i < $len; $i += $l) {
            $ret[] = mb_substr($str, $i, $l, "UTF-8");
        }
        return $ret;
    }
    return preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
}

function fixFieldImported($fileFields,$col_type,$choosenFields,$col){
	global $line,$comma;
	$value='';
	$choosenFields=explode($line,$choosenFields);
	foreach($choosenFields as $props){
		$props=explode($comma,$props);
		$field=$props[0];
		if($field!='not_field'){ //custom or date or fields or field
			if($col_type==2){//date
				$dateChar=$props[1];
				$format=[$props[2],$props[3],$props[4]];
				$year=array_search('yyyy',$format);
				$mon=array_search('mm',$format);
				$day=array_search('dd',$format);
				$date=$fileFields[$field];//الصيغة كما هي في الملف
				$dateFieldArr=explode($dateChar,$date);
				
				$newFormat=$dateFieldArr[$year].'-'.$dateFieldArr[$mon].'-'.(intVal($dateFieldArr[$day])-1);
				$dateType=get_val('_modules_items','prams',"code='$col'");
				if($dateType==0){//تاريخ عادي
					$value=$newFormat;
				}else{
					$value=strtotime($newFormat);
				}
			}
			else{
				$part_type=$props[1];
				if($part_type==6){//custom
					$input=$fileFields[$field];
					$output='';
					$code=$props[2];
					$code=stripcslashes($code);
					eval($code.' $value.=$output;');
				}else{
					$index_s=$props[2];
					$part_num=$props[3];
					$elems=[]; $temp='';
					if($part_type==1){
						$temp.=$fileFields[$field];
					}else{
						$start=$end=0; $isWord=0;
						if($part_type==3 || $part_type==5){//محارف
							$elems=str_split_unicode($fileFields[$field]);
						}else{//كلمات
							$elems=explode(' ',$fileFields[$field]);
							$isWord=1;
						}

						if($part_type==3 || $part_type==2){//الحروف او الكلمات الاخيرة
							$start=count($elems)-$part_num;
						}
						else{ //الحروف او الكلمات عند دليل معين
							$start=$index_s-1;
						}
						$end=$start+$part_num;
						$temp='';
						for($i=$start;$i<$end;$i++){
							if($temp!='' && $isWord){$temp.=' ';}
							$temp.=$elems[$i];
						
						}
					}
					$value.=$temp;
				}
			}
		}else{//non field (seperator)
			$notField_txt=$props[1];
			if($notField_txt==''){$notField_txt=' ';}
			$value.=$notField_txt;
		}
	}
	
	return $value;
}

function getFileFields($process_id){
	$arrFields=[];
	$fieldsStr=get_val('exc_import_processes','cols',$process_id);
	if($fieldsStr!=''){$fieldsArr=explode(',',$fieldsStr);}
	foreach($fieldsArr as $field){
		$fieldTemp=explode(':',$field);
		$rank=$fieldTemp[0];
		$name=$fieldTemp[1];
		$arrFields[$rank]=$name;
	}
	return $arrFields;
}

function getFieldContentStart($part_type,$index_s,$part_num){
	global $contentTxt,$startTxt;
	$content=$start='';
	$start=$startTxt[$part_type];
	if($part_type!=6){
		if($part_type>3){$start=' <ff class="fs16">'+$index_s+"</ff>";}
		if($part_type!=1){$content='<ff class="fs16">'+$part_num+"</ff> ";}
		$content.=' '.$contentTxt[$part_type];
		return [$content,$start];
	}
}

function importDone2($id_process,$path,$end,$start,$empty_fields,$module,$end_req,$offset){
	global $now;
	if(file_exists($path)){
		$fields_arr=getFileFields($id_process);
		$csv=getCsvcontent($path,$start,$end,$offset);
		//print_r($csv);
		$csvInfo=getCsvInfo($path);
		$cols=$csvInfo['cols'];
		$rows=$csvInfo['rows'];
	
		$dd=array(0);
		$y=0;
		$x=0;
		for($row=$start;$row<=$end;$row++){
			$ok=1;
			for($field=1;$field<=$cols;$field++){
				$val=autoUTF($csv['content'][$row][$field-1]);
				
				if((!$val || $val=='') && in_array($field,$empty_fields)){
					$ok=0; 
					$reject_field=$field;
					break;
				}
				else{
					//if(mb_detect_encoding($val)=='UTF-8'){$val= iconv('UTF-16LE','UTF-8',$val);}
					$val=str_replace('\\','/',$val);
					$dd[$field]=trim($val);
				}
			}
			$sql='';
			if($ok){	
				$y++;
				$p1=$p2='';
				$table=get_val_con('_modules','table',"code='$module'");
				$sql="select * from exc_import_process_fields where process=$id_process";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows>0){
					while($r=mysql_f($res)){
						$col=$r['module_col'];
						$col_type=$r['type_col'];
						$fields=$r['file_fields'];	
						${'col_'.$col}=fixFieldImported($dd,$col_type,$fields,$col);
						list($parms,$colum)=get_vals("_modules_items",'prams,colum',"code='$col'");
						
						if($col_type==5){//parent
						    $parmsArr=explode('|',$parms);
							$tableParent=$parmsArr[0];
							$v=${'col_'.$col};
							$f=$parmsArr[2];
							$key=$parmsArr[1];
							
							${'col_'.$col}=getActID2($v,$tableParent,$f,$key);
							
						}
							if($p1!=''){$p1.=", ";}
							if($p2!=''){$p2.=", ";}
							$p1.="`".$colum."`";
							$p2.="'".${'col_'.$col}."'";
						
					}
				}
			   $sql="INSERT INTO `$table`($p1) VALUES ( $p2 )"; //echo $sql."<br>";
				if(!mysql_q($sql)){
					$x++;
					echo '<tr><td width="10%" ff>'.$row.'</td><td>'.k_incompatiable_with_database.'</td></tr>';
				} //مرفوض بسبب عدم توافق البيانات مع الداتابيز
			}
			else{
				$x++;
				echo '<tr><td width="10%" ff>'.$row.'</td><td> '.k_column.' <span class="clr5">('.$fields_arr[$reject_field].')</span> '.k_empty.'</td></tr>';
			}//مرفوض بسبب الحقول الفارغة
		}
		if($end==$end_req){$end=0;}
		mysql_q("update exc_import_processes set imported_end=$end,last_import_date='$now' ,reject_rows=`reject_rows`+$x where id=$id_process");
	}
	
	return ['done'=>$y,'reject'=>$x,'offset'=>$csv['offset']];
}

function templateSave($process,$name){
	global $now;
	$ok=1;
	$process_rec=getRecCon('exc_import_processes',"id=$process");
	$header_row=$process_rec['header_row'];
	$cols=$process_rec['cols'];
	$code=getRandString(10);
	$sql="INSERT INTO `exc_templates`(`code`,`name`,`header_row`,`cols`,`addition_date`) values('$code','$name','$header_row','$cols','$now')";
	if(mysql_q($sql)){
		$template=last_id();
		if(isset($_POST['emptyFields'],$_POST['selModule'],$_POST['start_row'],$_POST['end_row'])){
			$fields_empty=pp($_POST['emptyFields'],'s');
			$module=pp($_POST['selModule'],'s');
			setDataLevel_3($module,$fields_empty,'exc_templates','exc_template_fields',$template);
		}

	}else{$ok=0;}

	if($ok){return 1;}
	else{
		mysql_q("delete from exc_templates where id=$template");
		return 0;
	}
}	

function setDataLevel_3($module,$fields_empty,$table1,$table2,$id_relate,$start=0,$end=0){
	global $comma,$line;
	$sql="select code,type from _modules_items where mod_code='$module' ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	$vals='';
	if($rows>0){
		while($r=mysql_f($res)){
			$col=$r['code'];
			$col_type=$r['type'];
			if(isset($_POST['selFileCols_'.$col])){
				$fileField=pp($_POST['selFileCols_'.$col],'s');
				$str='';
				if($fileField){
					$dataArr[$col]['type']=$col_type;
					$props='';
					if($col_type==2){
						if(isset($_POST['dateChar_'.$col],$_POST['date_1_'.$col],$_POST['date_2_'.$col],$_POST['date_3_'.$col])){

							$dateChar=pp($_POST['dateChar_'.$col],'s');
							$date_1=pp($_POST['date_1_'.$col],'s');
							$date_2=pp($_POST['date_2_'.$col],'s');
							$date_3=pp($_POST['date_3_'.$col],'s');
							$dataArr[$col]['fields'][$fileField]=[
									'dateChar'=>$dateChar,
									'format'=>[$date_1,$date_2,$date_3]
							];
							$str=$fileField.$comma.$dateChar.$comma.$date_1.$comma.$date_2.$comma.$date_3;
						}
					}else 
					if($fileField=='join' && isset($_POST['join_prop_'.$col])){
						$join_prop=$_POST['join_prop_'.$col];
							if($join_prop){
								foreach($join_prop as $vv){
									foreach($vv as $field=>$elem){
										if($str!=''){$str.=$line;}
										if($field=='not_field'){
											$str.=$field.$comma.$elem;
										}else{
											$str.=$field.$comma.implode($comma,$elem);
										}
									}

								}
							}
					}else if(isset($_POST['part_type_'.$col])){
						$part_type=pp($_POST['part_type_'.$col]);
						if(isset($_POST['custom_'.$col])){
							$codeCustom=pp($_POST['custom_'.$col],'s');
							$str=$fileField.$comma.$part_type.$comma.$codeCustom; 
						}
						else if(isset($_POST['index_s_'.$col],$_POST['part_num_'.$col])){
							$index_s=pp($_POST['index_s_'.$col]);
							$part_num=pp($_POST['part_num_'.$col]);
							$dataArr[$col]['fields'][$fileField]=[
								'part_type'=>$part_type,
								'index_s'=>$index_s,
								'part_num'=>$part_num
								];
							$str=$fileField.$comma.$part_type.$comma.$index_s.$comma.$part_num;
						}
					}
					if($vals!=''){$vals.=',';}
					$vals.="(\"$id_relate\",\"$col\",\"$col_type\",\"$str\")"; 
				}	

			}

		}
	}
	$ok=0;
	$q='';
	if($table2=='exc_import_process_fields'){
		$q=",start_line='$start',end_line='$end'";
		$field_relate='process';
	}else{
		$field_relate='template';
	}
	$s="update `$table1` set `module`='$module',empty_fields='$fields_empty' $q where id=$id_relate";
	mysql_q($s);
	if(mysql_a()>0){$ok=$id_relate;}
	if($vals){
		mysql_q("delete from `$table2` where $field_relate=$id_relate ");
		$sql="INSERT INTO `$table2`(`$field_relate`,`module_col`, `type_col`, `file_fields`) VALUES $vals";
		if(mysql_q($sql)){
			$ok=$id_relate;//importDone2($dataArr,$id_process,$module);
		}
	}
	return $ok;
}

function getImportSetting($table,$id_related,&$changTable){
	$cols=$arrCols=$empty_fields=$module=0;
	$r=getRecCon($table,"id=$id_related");
	if($r){
		$cols=$r['cols'];//أعمدة الملف المرتبطة بأعمدة الموديول
		$empty_fields=$r['empty_fields'];
		$module=$r['module'];
		if($table!='exc_templates'){
			if(isset($_POST['module'])){
				$module=pp($_POST['module'],'s'); $changTable=1;
			}
		}
		if($cols!=''){
			$arrCols=explode(',',$cols);
			$cols=[];
			foreach($arrCols as $col){
				$fieldTemp=explode(':',$col);
				$rank=$fieldTemp[0];
				$name=$fieldTemp[1];
				$cols[$rank]=$name;
			}
		}
		array_push($arrCols,'join:'.k_merge_fields,'custom: '.k_custom_field);
	}
	$res=[
		'cols'=>$cols,
		'arrCols'=>$arrCols,
		'empty_fields'=>$empty_fields,
		'module'=>$module
		/*'countRows'=>$countRows*/
	];
	return $res;
}

function templateDown($template,$id_process){
	list($cols,$header)=get_vals('exc_templates','cols,header_row',"id=$template");
	$prev_cols=get_val('exc_import_processes','cols',$id_process);
	if($cols){
		if($prev_cols!=$cols){
			$sql="update `exc_import_processes` set `cols`='$cols', `header_row`='$header' where id=$id_process";
			mysql_q($sql);
			if(mysql_a()>0){ return $id_process;}
		}else{
			return $id_process;
		}
	}
}
/********NEW****************/
function fixFileAdd($id,$event_no){
	if($event_no==1){
		$out= Script("$('#cof_xa3rhuufiq').closest('div').attr('cb','check_type_file(\'#cof_xa3rhuufiq\')'); $('#opr_form0 .form_fot').find('div:last').remove();");
	}else if($event_no==2){
		global $now;
		$out=0;
		if($event_no==2){
			$file=get_val('exc_import_processes','file_id',$id);
			$upFile=getUpFiles($file)[0];
			$path='../sFile/'.$upFile['folder'].$upFile['file'];
			if(file_exists($path)){
				$csv=getCsvInfo($path);
				$countRows=$csv['rows'];
				$countCols=$csv['cols'];
			}

			$sql="update exc_import_processes set level=1, start_line='1',end_line='$countRows',count_rows='$countRows',count_cols='$countCols',p_start_date='$now' where id=$id";

			mysql_q($sql);
			if(mysql_a()>0){$out=1;}
		}
	}
	return $out;
}

function getTempTool($id){
	$out='
	<center>
	<div style="width:95px;">
		<div class="ic40 icc4 ic40_info fl" title="'.k_props.'" onclick="getTemplateProp('.$id.')"></div>
		<div class="ic40 icc2 ic40_exc_export fl" title="'.k_export.'" onclick="get_enc_code('.$id.')"></div> 
	</div>
	</center>';
	return $out;
}

function getFieldsProp($id,$opr,$filed,$val,$state){
	$fieldsNo=0;
	$clr='icc3 ';
	$func='';
	if($val!=''){
		$items_val=explode(',',$val);
		$fieldsNo=count($items_val);
		$clr=' icc2 ';
		$func='getFieldsProp('.$id.',\''.$val.'\','.$state.')';
	}
	$out='
	<center>
	<div class="fr ic40 '.$clr.' ic40_info" title="'.k_th_details.'" onclick="'.$func.'">
		<div n="a'.$fieldsNo.'">'.$fieldsNo.'</div>
	</div>
	</center>';
	return $out;
}

function getIconImport($id){
	$out='
	<center><div class="ic40 icc1 ic40_save fl" onclick="getSettingWin('.$id.')" title="'.k_import.'" style="width:40px"></div></center>
	<center><div class="ic40 icc2 ic40_del fl" id="rec_'.$id.'" onclick="delProcess('.$id.',\'o\')" title="'.k_delete.'" style="width:40px"></div></center>';
	return $out;
}

function getIconStatus($id){
	global $clr44;
	list($last_import_date,$imp_end)=get_val('exc_import_processes','last_import_date,imported_end',$id);
	$txt=k_import_not; $clr='#ffeded';
	if($last_import_date>0 && $imp_end==0 ){
		$txt=k_imported; $clr=$clr44;//'#b3cde0';
	}else if($last_import_date>0 && $imp_end>0){
		$txt=k_pse; $clr='#e7ffe2';
	}
	$out=' 
	<div class="f1 lh40  fs14">'.$txt.'</div>
	<center> <div   class="f1 clr5 Over fs12 U" onclick="getDetailsProcess_client('.$id.')">التفاصيل</div></center>';
	$out.=Script("$('#rec_$id').closest('tr').css('background-color','$clr'); 
	$('table').attr('over','0');
	");
	return $out;
}

function getCsvContent($path,$first=1,$end='all',$offset=0) {
	$str='';
    $handle = fopen($path, "r") or die("ERROR OPENING DATA");
	$rowCurr=1;
	if($offset==0 && $first>1){ 		//في حال طلب من سطر كذل الى كذا دون ادخال ازاحة
		$temp=getCsvContent($path,1,$first-1);
		$offset=$temp['offset'];
	}
	if($offset>0){
		$rowCurr=$first;
		fseek($handle, $offset);
	}
	$buffer=['content'=>[],'offset'=>$offset,'rows'=>0,'cols'=>0];
    if( $handle ) {
        while(!feof($handle)) {
		   if($end!='all' && $rowCurr>$end){break;}
		   $data=fgetcsv($handle,0,',',chr(8));//chr(8) is code backspace =>$enclosure parameter is no thing
		    $str.=implode(',',$data);
			
		   if($rowCurr>=$first){$buffer['content'][$rowCurr]=$data;}

			$rowCurr++;
		   $count=count($data);
		   if($count>$buffer['cols']){ $buffer['cols']=$count; }
		   
        }
		if($end=='all'){$end=$rowCurr;}
		$rowsReq=$end-$first+1;
		$buffer['offset']+=mb_strlen($str)+(2*$rowsReq);//2 محرف نهاية السطر في 
		$buffer['rows']=$rowsReq;
    }
    fclose($handle);
    return($buffer);
}	
	
function getCsvInfo($path){
	$handle = fopen($path,"r") or die("ERROR OPENING DATA");
	$rows=$cols=0;
	
	if( $handle ) {
		 while(!feof($handle)){
			$data=fgetcsv($handle);
			if($data!==false){$rows++;}
			$count=count($data);
			if($count>$cols){ $cols=$count; }
		}
		fclose($handle);
	}
	return ['rows'=>$rows,'cols'=>$cols];
}

function autoUTF($s){
	if(mb_detect_encoding($s)=='UTF-8'){
		$ar=iconv('windows-1256', 'UTF-8', $s);// detect WINDOWS-1256 arabic
		if(preg_match("/[\x{0600}-\x{06FF}\x]{1,32}/u",$ar)){
			return $ar;
		}/*elseif (preg_match('#[\x7F-\x9F\xBC]#', $s)){// detect WINDOWS-1250
       		 return iconv('WINDOWS-1250', 'UTF-8', $s);
		}*/
   		else{
			return iconv('UTF-16LE','UTF-8',$s);
		}
	}
	return $s;
}

function num_to_letters($num, $uppercase = true) {
    $letters = '';
    while ($num > 0) {
        $code = ($num % 26 == 0) ? 26 : $num % 26;
        $letters .= chr($code + 64);
        $num = ($num - $code) / 26;
    }
    return ($uppercase) ? strtoupper(strrev($letters)) : strrev($letters);
}

function check_type_file($file,$types,$exs){
	list($thisType,$ex)=get_val('_files','type,ex',$file);
	foreach($types as $type){
		if(strpos($thisType,$type)!==false && in_array($ex,$exs)){ return 0;}//not error
	}
	deleteFiles($file);
	return 1;//error
};

function file_get_contents_utf8($fn) {
	//$content =file_get_contents($fn);
	$content =Decode(file_get_contents($fn),_pro_id);
	if(mb_detect_encoding($content)=='UTF-8'){return iconv('UTF-16LE','UTF-8',$content);}
}

					