<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$t=pp($_POST['t']);
	$r=getRec('xry_x_visits_services',$id);
	if($r['r']){
		$doc=$r['doc'];
		$status=$r['status'];
		$pat=$r['patient'];
		$srv=$r['service'];
		if($status==0 && ($doc==$thisUser || $doc==0)){
			$srvTxt=get_val('xry_m_services','name_'.$lg,$srv);
			if($t){
				$report=get_val('xry_m_pro_radiography_report_templates','content',$t);
			}else{
				$report=get_val('xry_x_pro_radiography_report','report',$id);
			}?>
			<div class="win_body">
			<div class="form_header so lh40 clr1 f1 fs16">			
			<?=get_p_name($pat).' <span class="f1 fs14 clr5"> ( '.$srvTxt.' )</span>'?></div>
			<div class="form_body of" type="pd0">
				<div class="fl r_bord of" fix="w:300|hp:0">
					<div class="fl w100 lh40 b_bord ">
						<div class="fl ic40x br0 icc4 ic40_add " onclick="addXryTmpRep()"></div>
						<div class="fl f1 fs18 lh40 pd10"><?=k_reports_temps?></div>
					</div>
					<div class="fl ofx so pd10f w100" fix="hp:40"><?
						if($thisGrp=='nlh8spit9q' && $status==0){
							$sql="select * from xry_m_pro_radiography_report_templates where doc='$thisUser' and srv='$srv' order by def DESC , id ASC";
							$res=mysql_q($sql);
							$rows=mysql_n($res);							
							if($rows>0){				
								while($r=mysql_f($res)){
									$r_id=$r['id'];
									$def=$r['def'];
									$title=$r['title'];
									$content=$r['content'];
									$sel='';
									if($selTemp==$r_id){$sel=' selected ';$def_txt=$content;}
									echo '<div class="bu buu bu_t1 mg5v" onclick="XeditReport('.$r_id.')">'.$title.'</div>';
								}			
							}else{
								echo '<div class="f1 fs14 lh40 clr5">'.k_no_forms_ser.'</div>';
							}
						}?>
					</div>
				</div>
				<div class="fl ofx so " fix="wp:300|hp:0">
					<textarea class="m_editor" id="report_txt"><?=$report?></textarea>
				</div>
			</div>
			<div class="form_fot fr">
				<div class="bu bu_t3 fl" onclick="saveXRep()"><?=k_save?></div>
				<div class="bu bu_t2 fr" onclick="win('close','#full_win5');"><?=k_close?></div>
			</div>
			</div><?	
		}
	}
}?>