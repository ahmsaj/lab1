<? include("../../__sys/prcds/ajax_header.php");
include("../library/ex_reader.php");

if(isset($_POST['status'],$_POST['file'])){
	$file=pp($_POST['file']);
	$status=pp($_POST['status'],'s');
	if($status=='view'){
		if($file){
			$upFile=getUpFiles($file)[0];
			$path='../sFile/'.$upFile['folder'].$upFile['file'];
			if(file_exists($path)){
			$csv = getCsvContent($path);
			$rows=20;
			if($csv['rows']<$rows){$rows=$csv['rows'];}
			//print_r($csv);
			if(count($csv)>0){
				$out='
				<div class="ofx so"  fix="h:420">
				<table width="100%" class="grad_s" cellpadding="2" cellspacing="2" dir="ltr">';
				for($row=1;$row<$rows;$row++){
					$row_data=$csv['content'][$row];
					$out.='<tr>';
					for($col=0;$col<$csv['cols'];$col++){
						$out.='<td>'.$row_data[$col].'</td>';
					}
					$out.='</tr>';
				}
				$out.='</table>
				</div>
				<div fix="h:30|w:150" class="cbg55 clrw fs14 f1 Over lh40 TC fr" style="margin:20px;" onclick="langKeysImport('.$file.')">'.k_import.'</div>';
				echo $out;
			}
		}
		}else{
			echo '<div class="clr55 fs14 f1 lh40">'.k_csv_file_lang_keys.':</div>';
			echo upFile('ex','',1,'langKeysImportView()','ic40 icc1 ic40_add');
		}
	}elseif($status=='process'){
		$upFile=getUpFiles($file)[0];
		$path='../sFile/'.$upFile['folder'].$upFile['file'];
		if(file_exists($path)){
			$csv = getCsvContent($path);
			
			$cols=$csv['cols'];
			$rows=$csv['rows'];
			$header=$csv['content'][1];
			$ok=1;
			//أفرز الداتا إلى مفاتيح موجودة بحاجة لتحديث ومفاتيح غير موجودة بحاجة لإضافة
			$ids=array_column($csv['content'],0);
			unset($ids[0]);
			$ids="'".implode($ids,"','")."'";
			$updateRec=get_vals('_lang_keys','id',"id in($ids)",'arr');
			$table='';
			//من أجل كل سطر نحدث المفاتيح المراد تحديثها ونضيف المراد إضافتها
			$update_co=$not_found_co=0;
			for($row=2;$row<$rows;$row++){
				$sql='';
				$items=$csv['content'][$row];
				$id=$items[0];
				if(count($items)>0){
					if(in_array($id,$updateRec)){
						for($col=1;$col<$cols;$col++){
							if($sql!=''){$sql.=',';}
							$sql.="`_".$header[$col]."`='".$items[$col]."'";
						}
						$sql="update _lang_keys set $sql where id='".$id."'";
						if(!mysql_q($sql)){$ok=0;}
						if(mysql_a()>0){$update_co++;}
					}/*else{
						for($col=1;$col<$cols;$col++){
							if($f_s!=''){$f_s.=',';}
							if($v_s!=''){$v_s.=',';}
							$f_s.="`".$header[$col]."`";
							$v_s.="'".$items[$col]."'";

						}
						echo $sql="insert into _lang_keys ($f_s)values($v_s)"; echo "<br>";
						if(!mysql_q($sql)){$ok=0;}
	}*/
					else{
						$not_found_co++;
						if($table==''){
							$table.='<tr>
								<th txt width="40"></th>';
							for($col=0;$col<$csv['cols'];$col++){
								$table.='<th txt>'.$header[$col].'</th>';
							}
							$table.='</tr>';
						}
						$table.='<tr width="40"> <td class="cbg7">#'.$row.'</td>';
						for($col=0;$col<$cols;$col++){
							$table.='<td>'.$items[$col].'</td>';
						}
						$table.='</tr>';
					}
				}
			}
			$out='
				<div class="ofx so fl"  fix="hp:350|wp:0">
				<center>
				<table width="50%" class="grad_s" cellpadding="2" cellspacing="2" type="static" dir="ltr" Over="0">
					<tr>
						<td><ff>'.($rows-1).'</ff></td>
						<td width="50%" txt>'.k_file_lines.'</td>
					</tr>
					<tr>
						<td><ff>'.$update_co.'</ff></td>
						<td txt> '.k_line_updated_in_db.'</td>
					</tr>
					<tr class="cbg555">
						<td dir="rtl">
							<ff>'.$not_found_co.'</ff>';
							if($not_found_co>0){
								$out.='<div class="clr55 fs14 f1"> ('.k_expln_below.') </div>';
							}
				$out.='</td>
						<td txt>'.k_line_not_in_db.'</td>
					</tr>

				</table>
				</center>
				</div>';
			if($table!=''){
				$out.='
					<div class="ofx so fl"  fix="h:350|wp:0" style="margin-top:20px;" dir="ltr">
					<table width="100%" class="grad_s holdH" cellpadding="2" cellspacing="2"  over="0">'.$table.'</table></div>';
			}
			echo $out;
		}
	}
	
	

}


function getCsvContent($path,$first=1,$end='all',$offset=0) {
	$str='';
    $handle = fopen($path, "r") or die("ERROR OPENING DATA");
	$buffer=['content'=>[],'offset'=>$offset,'rows'=>0,'cols'=>0];
	$rowCurr=1;
	if($offset>0){
		$rowCurr=$first;
		fseek($handle, $offset);
	}
    if( $handle ) {
        while(!feof($handle)) {
		   if($end!='all' && $rowCurr>$end){break;}
		   $data=fgetcsv($handle);
		   $str.=implode(',',$data);
		   if($rowCurr>=$first){$buffer['content'][$rowCurr]=autoUTF($data);}//في حال طلب من سطر كذل الى كذا دون ادخال ازاحة
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


?>