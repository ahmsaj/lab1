<? session_start();
header('Content-Type: text/html; charset=utf-8');
include("../../__sys/dbc.php");
include("../../__main/define.php");
include("../../__sys/f_funs.php");
$lang_data=checkLang();
$lg=$lang_data[0];
$l_dir=$lang_data[1];
$lg_s=$lang_data[2];
$lg_n=$lang_data[3];
$lg_s_f=$lang_data[4];
$lg_n_f=$lang_data[5];
$lg_dir=$lang_data[6];
if($l_dir=="ltr"){define('k_align','left');	define('k_Xalign','right');}else{define('k_align','right');define('k_Xalign','left');}
include("../../__sys/cssSet.php");
include("../../__main/lang/lang_k_$lg.php");
include("../../__sys/lang/lang_k_$lg.php");
if($thisGrp=='s'){include("../../__super/lang/lang_k_$lg.php");}
include("../../__sys/funs.php");
include('../../__main/funs.php');
include("../../__sys/funs_co.php");
include("../../__sys/define.php");
include("../../_gnr/define.php");
if(isset($_POST['mod'])){	
	$mod=pp($_POST['mod'],'s');
	loginAjax();
	list($proAct,$proUsed)=proUsed($mod);
	foreach($proUsed as $p){	
		$inc_file1='../../_'.$p.'/funs.php';
		$inc_file2='../../_'.$p.'/define.php';
		if(file_exists($inc_file1)){include_once($inc_file1);}
		if(file_exists($inc_file2)){include_once('../_'.$p.'/define.php');}
	}
	$ms=pp($_POST['ms'],'s');
	$msd=pp($_POST['msd'],'s');
	$fil=pp($_POST['fil'],'s');
	$sptl=pp($_POST['sptl'],'s');	
	$ex_type=pp($_POST['ex_type'],'s');
	$ex_date=pp($_POST['ex_date'],'s');
	$ex_title=pp($_POST['ex_title'],'s');
	$sub_title=pp($_POST['sub_title'],'s');
	$filed=pp($_POST['fileds'],'s');
	$ex_rec=pp($_POST['ex_rec']);
	$fileds=explode(',',$filed);	
	$limit='';
	if($ex_rec){$limit =" limit $ex_rec ";}
	$mod_data=loadModulData($mod);
	$cData=getColumesData($mod);
	$cData_id=getColumesData($mod,1);
	$cDaTotal=count($cData);
	$co_title='';
    if($sptl!='^'){
        $sptl=Decode($sptl,_pro_id);
        $co_title=getCondetionTilte($mod_data['c'],$sptl);
    }
	if($mod_data[15]){
		if($ex_type==1){
			$style_file=styleFiles('P');
			echo '<head><link rel="stylesheet" type="text/css" href="'.$m_path.$style_file.'"></head>
			<body dir="'.$l_dir.'" style="margin:1cm">';
		}else{
			header('Content-Type: text/csv; charset=utf-8');
			header('Content-Disposition: attachment; filename='.$mod.'_'.$now.'.csv');
			$output = fopen('php://output', 'w');
			fputs($output, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
		}
		$sort_data=check_Sort($ms,$msd,$mod_data[3],$mod_data[4]);	
		$sort=$sort_data[0];
		$sort_dir=$sort_data[1];
		$sort_text='';
		if($sort){$sort_text= " order by `$sort` $sort_dir ";}
		if($cDaTotal>0){
			$condtion=sqlFilterCondtions($mod,$fil);
			$condtion.=sqlModuleCondtions($sptl,$condtion);			
			if($condtion)$condtion=' where '.$condtion;
			$table=$mod_data[1];			
			//------------------------------------------------------------------------------------------------
			$sql="select * from $table $condtion $sort_text $limit";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				if($ex_type==1){?>
					<div class="lh40 fs18 f1 TC"><? if($ex_title){echo $ex_title;}?></div>
                	<div class="lh30 fs14 f1 TC"><? if($sub_title){echo $sub_title;}?></div>
					<table width="100%" border="0" cellspacing="0" cellpadding="4" class="export_tab">
					<thead>
					<tr>
					<th width="30"></th><?
				}else{
					if($ex_title){fputcsv($output,array($ex_title));}
                    if($sub_title){fputcsv($output,array($sub_title));}					
					$coloumTitle=array('');
				}
			/// Table header -----------------------							
			for($i=0;$i<$cDaTotal;$i++){
				if(in_array($cData[$i][0],$fileds) && $cData[$i][3]!=12 && $cData[$i][3]!=13 
				&& !($cData[$i][1]==$mod_data[3] && $mod_data[12]==1)){//show 
					$wid='';
					//------Sort-------------
					$so_act='';$so_dir='';$sort_no='';				
					$sort_files=0;
					if(in_array($cData[$i][3],array(1,2,3,5,6,7,9,11))){
						$so_dir='so_up';						
						if($sort==$cData[$i][1]){$so_act='so_act';if($sort_dir=='DESC')$so_dir='so_down';}											
						$sort_no=' title="'.k_press_sort.'" so_no="'.$cData[$i][0].'';
						$sort_files=1;
					}					
					if($cData[$i][3]==3){$wid=' width="50" ';}					
					
					if(($cData[$i][3]==1 || $cData[$i][3]==7 )&& $cData[$i][9]){
						$col_l=str_replace('(L)','',$cData[$i][1]);
						if($col_l=='_'){
							for($ll=0;$ll<count($lg_s);$ll++){
								$addLangText='';if(count($lg_s)>1)$addLangText='<b>('.$lg_n[$ll].')</b> ';
								if($sort_files){
									$so_dir='so_up';$so_act='so_act';if($sort_dir=='DESC')$so_dir='so_down';
								}else{
									$so_dir='so_up';$so_act='';
								}
								if($ex_type==1){
									echo '<th '.$wid.' '.$sort_no.'_'.$lg_s[$ll].'" '.$so_dir.' '.$so_act.' >
									'.get_key($cData[$i][2]).' '.$addLangText.'</th>';
								}else{
									array_push($coloumTitle,$cData[$i][2]);
								}
							}							
						}else{
							if($ex_type==1){
								echo '<th '.$wid.' '.$sort_no.'_'.$lg_s[$lg].'" '.$so_dir.' '.$so_act.' >'.get_key($cData[$i][2]).'</th>';
							}else{
								array_push($coloumTitle,get_key($cData[$i][2]));
							}
						}
					}else{
						if($ex_type==1){
							echo '<th '.$wid.' '.$sort_no.'_" '.$so_dir.' '.$so_act.'>'.get_key($cData[$i][2]).'</th>';
						}else{
							array_push($coloumTitle,get_key($cData[$i][2]));
						}
					}
				}
			}
			if($ex_type==2){
				fputcsv($output,$coloumTitle);
			}else{?>			
			</tr>
			</thead><tbody><?
			}
			/// Table rows -----------------------
			$sort_color_class='td_sort_act';			
			$rr=0;
			$static_per='';
			while($r=mysql_f($res)){
				$l_id=$r['id'];
				$total=$r[$total_par[3]];
				if($ex_type==2){
					$coloumTitle[$rr]=array(($rr+1));
				}else{?>
					<tr>				
					<td><?=($rr+1)?></td><?
				}
				for ($i=0;$i<$cDaTotal;$i++){
					$sort_color='';
					$vall='';
					if($sort==$cData[$i][1]){$sort_color=$sort_color_class;}
					if(in_array($cData[$i][0],$fileds) && $cData[$i][3]!=12 && $cData[$i][3]!=13 
					&& !($cData[$i][1]==$mod_data[3] && $mod_data[12]==1)){//show  				
						if($cData[$i][9]){//lang						
							if($col_l=='_'){
								if($cData[$i][3]==14){
									$cName=str_replace('(L)',$lg,$cData[$i][1]);
									$vall=$r[$cName];
									$vvvv=co_list($cData[$i],$vall,$l_id,1);
									if($ex_type==2){
										array_push($coloumTitle[$r],strip_tags($vvvv));
									}else{
										echo '<td class="'.$sort_color.'">'.$vvvv.'</td>';
									}
								}else{		
									for($ll=0;$ll<count($lg_s);$ll++){								
										$cName=str_replace('(L)',$lg_s[$ll],$cData[$i][1]);
										$vall=$r[$cName];												
										if($sort==str_replace('(L)',$lg_s[$ll],$cData[$i][1])){
										$sort_color=$sort_color_class;}else{$sort_color='';}
										$vvvv=co_list($cData[$i],$vall,$l_id,1);
										if($ex_type==2){
											array_push($coloumTitle[$rr],strip_tags($vvvv));
										}else{
											echo '<td class="'.$sort_color.'">'.$vvvv.'</td>';
										}
									}
								}
							}else{
								$cName=str_replace('(L)',$lg,$cData[$i][1]);					
								$vall=$r[$cName];
								$vvvv=co_list($cData[$i],$vall,$l_id,1);
								if($ex_type==2){
									array_push($coloumTitle[$rr],strip_tags($vvvv));
								}else{
									echo '<td class="'.$sort_color.'">'.$vvvv.'</td>';
								}
							}					
						}elseif($cData[$i][3]==15){
							$vvvv=getCustomFiled_m($l_id,$cData[$i][5],$r);
							if($ex_type==2){
								array_push($coloumTitle[$rr],strip_tags($vvvv));
							}else{
								echo '<td class="'.$sort_color.'">'.$vvvv.'</td>';
							}
						}else{
							if($cData[$i][3]==10){
								$vall=get_key($cData[$i][1]);
							}else{
								$vall=$r[$cData[$i][1]];
							}
							$vvvv=co_list($cData[$i],$vall,$l_id,1);
							if($ex_type==2){
								array_push($coloumTitle[$rr],strip_tags($vvvv));
							}else{
								echo '<td class="'.$sort_color.'">'.$vvvv.'</td>';
							}
						}
					}
				}          
				if($ex_type==2){
					fputcsv($output,$coloumTitle[$rr]);
				}else{
					?></tr><? 
				}
				$rr++;
			}
			if($ex_type==1){?>
				</tbody>        
				</table><? 
			}
		}
		}
	}
}?>