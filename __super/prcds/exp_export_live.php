<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['state'])){
	$catsTxt=[k_bmod,k_amod];
	$tables=['_modules','_modules_'];
	$items=['title_'.$lg,'title_'.$lg];
	$state=pp($_POST['state'],'s');
	if($state=='search'){
		if(isset($_POST['cat'],$_POST['val'])){
			$out='';
			$cat=pp($_POST['cat']);
			$val=pp($_POST['val'],'s');
			$table=$tables[$cat];			
			$q='';		
			$q.="limit 200";			
		    $sql="select * from $table where title_$lg like '%$val%'";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				while($r=mysql_f($res)){
				   	$mod_code=$r['code'];
					$mod_title=$r['title_'.$lg];
					$mod_ord=$r['ord'];
					$mod_link=$r['module'];
				 	$out.='<div class="mg10" cat_num="'.$cat.'" act mod="'.$mod_code.'" ord="'.$mod_ord.'" >'.get_key($mod_title).'   |   '.$mod_link.'</div>';
				}
			}
		}
		echo $out;
	}
	elseif($state=='wind_info'){
		if(isset($_POST['mod'],$_POST['cat_num'])){
			$mod=pp($_POST['mod'],'s');
			$cat_num=pp($_POST['cat_num']);
		?>
			<div class="win_body">
			<div class="form_header so lh40 clr1 f1 fs18"></div>
			<div class="form_body so">
		 <? 
			$cat_title=$catsTxt[$cat_num];
			$r=getRecCon($tables[$cat_num],"code='$mod'");
			if($r['r']>0){
				$code=$r['code'];
				$title=$r['title_'.$lg];
				$progs=$r['progs'];
				$exFile=$r['exFile'];
				$progs_used=$r['progs_used'];
				$count_used_pro=$count_ex_file=$count_event=0;
				$used_pro_txt=$ex_file_txt=$event_txt=$condsTxt=$linksTxt=k_not_existed;
				if($progs_used!=''){
					$progs_used=explode(',',$progs_used);
					$count_used_pro=count($progs_used);
					$used_pro_txt='<ff class="fl">'.$count_used_pro.'</ff>';
				}
				if($exFile!=''){
					$exFiles=explode(',',$exFile);
					$count_ex_file=count($exFiles);
					$ex_file_txt='<ff class="fl">'.$count_ex_file.'</ff>';
				}
				$progTxt=k_no_sel;
				if($progs!=''){$progTxt=$progs;}
				if($exFile!=''){
					$exFile=explode(',',$exFile);
				}
			?>
				<div style="border-bottom: dashed 1px;">
					<div class="fl ic40 ic40_exp_info"></div>
					<span class="f1 fs16 lh50"><?=get_key($title)?> (<?=$cat_title?>):</span>
				</div>
				<table class="fTable" cellpadding="0" cellspacing="0" border="0">
					<tbody>
					<tr>
						<td n><?=k_program?>:</td>
						<td class="fs14" ><?=$progTxt?></td>
					</tr>
					<tr>
						<td n><?=k_pro_linked?>:</td>
						<td>
							<?
							echo $used_pro_txt;
							if($count_used_pro!=0){?>
								<div class="fl fs18 clr1 B f1 pd10 Over" style="transform: rotate(90deg);" onclick="exp_file_action('#progs_used',this)">&#8810;</div>
								<div id="progs_used" class="hide cb so ofx" fix="h:85">
								<? foreach($progs_used as $prog){?>
									   <div class="TC t_bord r_bord l_bord fs14 lh30 f1 cbg111" ><?=splitNo($prog)?></div>
								 <?}?>
								</div>
							<?}?>
						</td>
					</tr>
					<tr>
						<td n><?=k_jx_fl?>:</td>
						<td>
							<?
							echo $ex_file_txt;
							if($count_ex_file!=0){?>
								<div class="fl fs18 clr1 B f1 pd10 Over" style="transform: rotate(90deg);" onclick="exp_file_action('#ex_files',this)">&#8810;</div>
								<div id="ex_files" class="hide cb so ofx" fix="h:85">
								<? foreach($exFiles as $file){
										$file_name=get_val_con('_modules_files_pro','file',"code='$file'");
									?>
									   <div class="TC t_bord r_bord l_bord fs14 lh30 f1 cbg111"><?=splitNo($file_name)?></div>
								 <?}?>
							<?}?>
						</td>
					</tr>
					<?
						if($cat_num==0){
							$conds=getTotalCO('_modules_cons',"mod_code='$mod'");
							$links=getTotalCO('_modules_links',"mod_code='$mod'");
							$events=$r['events'];
							if($events!=''){
								$events=explode('|',$events);
								$count_event=count($events);
								$eventTypes=[k_bfr_add,k_aftr_add,k_bfr_edit,k_aftr_edit,k_bfr_del,k_aftr_del];
								$event_txt='<ff class="fl">'.$count_event.'</ff>';
							}
							if($conds!=0){
								$condsTxt='<ff>'.$conds.'</ff>';
							}
							if($links!=0){
								$linksTxt='<ff>'.$links.'</ff>';
							}
						?>
						<tr>
						<td n> <?=k_events?>:</td>
						<td>
							<?
							echo $event_txt;
							if($count_event!=0){?>
								<div class="fl fs18 clr1 B f1 pd10 Over" style="transform: rotate(90deg);" onclick="exp_file_action('#event',this)">&#8810;</div>
								<div id="event" class="hide cb so ofx" fix="h:85">
								<? foreach($events as $event){
										$event=explode(':',$event);
									?>
									   <div class="TC t_bord r_bord l_bord fs14 lh30 f1 cbg111"><?=splitNo($event[1])?> (<?=$eventTypes[$event[0]-1]?>)</div>
								 <?}?>
							<?}?>
						</td>
					</tr>
						<tr>
							<td n><?=k_prog_cond_num?>:</td>
							<td><?=$condsTxt?></td>
						</tr>
						<tr>
							<td n><?=k_prog_links_num?>:</td>
							<td><?=$linksTxt?></td>
						</tr>
						<?}else{
							$file=$r['file'];
							$file_name=get_val_con('_modules_files','file',"code='$file'");?>
							<tr>
								<td n> <?=k_module_file?>:</td>
								<td class=" fs14" ><?=splitNo($file_name)?></td>
							</tr>
					<?	}
					?>
					</tbody>
				</table>
				
			<?}
		?>

			</div>
			<div class="form_fot fr">
				<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>         
			</div>
			</div>
	<?
		}
	}
	elseif($state=='enc_code'){	?>
			<div class="win_body">
			<div class="form_header so lh20 f1 fs14 fl"></div>
			<div class="form_body so">
				 <div class="lh20 f1 fs14 fl"><?=k_enter_encrypt_code_for_export?>:</div>
				 <input type='text' name='enc_code' />
			</div>
			<div class="form_fot fr">
				<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div> 
				<div class="bu bu_t3 fl" onclick="exp_mod_export_do()"><?=k_export?></div>
			</div>
			</div>
	<?}
}?>