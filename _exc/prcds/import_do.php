<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['state'],$_POST['id'])){
	$state=pp($_POST['state'],'s');
	$id_process=pp($_POST['id']);
	$file_id=$start_l=$end_l=$end_imp=$empty_fields=$module=0;
	$rec=getRecCon('exc_import_processes',"id=$id_process");
	if($rec['r']){
		$file_id=$rec['file_id'];
		$count_rows=$rec['count_rows'];
		$end_imp=$rec['imported_end'];
		$empty_fields=$rec['empty_fields'];
		$module=$rec['module'];
		$start_req=$rec['start_line'];
		$end_req=$rec['end_line'];
		$rowTotalReq=$end_req-$start_req+1;
		if($state=='view' && isset($_POST['newImport'])){
			$newImport=pp($_POST['newImport']);
			if($newImport==1){
				mysql_q("update exc_import_processes set imported_end=0 where id=$id_process");
			}
			list($file_id,$rowImp)=get_val("exc_import_processes",'file_id,imported_end',$id_process);
			$file_name=getUpFiles($file_id)[0]['name'];
			$donePer=100*$rowImp/$rowTotalReq; 
	?>
			<div class="win_body">
			<div class="form_header so lh40 clr1 f1 fs18"><?=k_file_import_start?><?=splitNo($file_name)?>
				<div class="fr ic40x icc2 ic40_ref" title="<?=k_import_restart?>" onclick="getimportStartView(<?=$id_process?>,1)"></div>
			</div>
			<div class="form_body of" type="full">	
				<div class="fl w100 uLine" fix="h:60">
					<div class="fl" fix="wp:50">
						<div class="clr1 f1 fs12 lh30"><?=k_imported_recs?> <ff class="fs14" id="counter_exc"><?='( '.$rowImp.' / '.$rowTotalReq.' )'?></ff>  </div>
						<div class="snc_prog fl">
							<div exc_progress class="fl" style="width:<?=$donePer?>%"></div>
						</div>
					</div>   
					<div id="ssb" e class="fr ic40x icc3 ic40_pus" ></div>
				</div>

				<div class="cb" fix="hp:60">
					<div class="clr6" fix="h:40">
						<div class="f1 fs14 fl lh40 " ><?=k_predicted_end_time?>: </div>
						<div class="fl mg10" style="border:1px solid; padding:5px;">
						<ff  id="expected_time">00:00:00</ff>
						</div>
					</div>
					
					<div class="cb f1 fs14 lh30 clr5" fix="h:30"><?=k_declined_recs?>(<ff class="fs14" reject>0</ff>): </div>
					<div reject_table class="ofx so hide" fix="hp:70|wp:0">
						<table id="tableContent" class="grad_s holdH"  width="100%" cellpadding="4"  type="static">
								<tr>
									<th width="10%"><?=k_line_num?></th>
									<th> <?=k_decline_reason?></th>
								</tr>
							<tbody> </tbody>
						</table>
					</div>
				</div>

			</div>
			<div class="form_fot fr">
				<div imp_close class="bu bu_t2 fr" onclick="closeImportDo(<?=$id_process?>)"><?=k_close?></div>  &nbsp;   
			</div>
			</div>
			<link href="../__sys/excel/css.php?d=<?=$l_dir?>" rel="stylesheet" type="text/css" />

		<?}
		elseif($state=='process' && (isset($_POST['first_opr']))){
			$jump=_set_2j0qptvj0p;//عدد الأسطر المسموحة لكل عملية استيراد
            $offset=pp($_POST['offset']);
			$first_opr=pp($_POST['first_opr']);
			//تحديد بدء ونهاية كل عملية استيراد
			$start=$start_req; 
			if($end_imp>0 && $end_imp<$end_req){
				$start=$end_imp+1;
			}
			$end=$start+$jump-1;
			if($end>$end_req){$end=$end_req;}
			//من أجل العداد
			if($first_opr){
				$_SESSION["start_opr"]=$now;
				$_SESSION['start_row']=$start;
				//$test=1;
			}
			//جلب الملف
			$objFile=getUpFiles($file_id)[0];
			$file=$objFile['file'];
			$file_name=$objFile['name'];
			$empty_fields=explode(',',$empty_fields);
			$path='../sFile/'.$objFile['folder'].$file;
			
			//تنفيذ الاستيراد
			$res=importDone2($id_process,$path,$end,$start,$empty_fields,$module,$end_req,$offset);
			//نسبة الاستيراد
			$rowDo=$res['do'];
			$rowReject=$res['reject'];
            $offset=$res['offset'];
			
			$rowImp=$end-$start_req+1;//الاسطر التي تم استيرادها الى الان
			$donePer=100*$rowImp/$rowTotalReq; 
			echo '^ ( '.$rowImp.' / '.$rowTotalReq.' )
				^'.number_format($donePer,2);
			
			//من أجل العداد
			$start_time=$_SESSION["start_opr"];
			if($start_time!=0){
				$impTime=$now-$start_time;
				$realRowsTotal=$end_req-$_SESSION['start_row']+1;
				$realRowsImp=$end-$_SESSION['start_row']+1;
				$totalTime=$impTime*$realRowsTotal/$realRowsImp;
				$waitTime=intval($totalTime-$impTime);
				$waitTime=dateToTimeS2($waitTime);
			}
			//------------------
			if($rowImp==$rowTotalReq){
				//mysql_q("update exc_import_processes set reject_rows='$rowReject' where id=$id_process");
				echo "^complete";
			} else{echo "^not_complete";}
			echo "^$rowReject ^ $rowTotalReq ^ $count_rows ^ $offset ^ $waitTime";
			
						
		}
	}
}?>


