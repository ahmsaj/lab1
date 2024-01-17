<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);	
	$r=getRec('den_x_visits_services_levels',$id);
	if($r['r']){
		$x_srv=$r['x_srv'];
		$vis=$r['vis'];
		$lev=$r['lev'];
		$doc=$r['doc'];
		$service=$r['service'];
		$lev_status=$r['status'];
		$docName='';
		if($doc){$docName=get_val('_users','name_'.$lg,$doc);}
		$srvName=get_val('den_m_services','name_'.$lg,$service);		
		$levName=get_val('den_m_services_levels','name_'.$lg,$lev);?>
		<div class="win_body">
		<div class="form_header"><? 
			if($lev_status!=2){echo '<div class="fr ic40 ic40_c4 ic40_add" onclick="addLevDen('.$lev.','.$service.')"></div>';}
			if($docName){echo '<div class="lh30 clr5 f1 fs18">الطبيب : '.$docName.'</div>';}?>
			<div class="lh30 clr1 f1 fs16"><?=$srvName?> | <?=$levName?></div>
			
		</div>
		<div class="form_body so"><?
			$sql="select * from den_x_visits_services_levels_w where x_lev='$id' order by date ASC ";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				$data.='<table class="grad_s" width="100%" cellpadding="4" cellspacing="0" type="static" over="0">		
				<tr>
					<th width="120">التاريخ</th>					
					<th>التفاصيل</th>					
					<th width="40"></th>
				</tr>';
				
				while($r=mysql_f($res)){
					$l_id=$r['id'];
					$date=$r['date'];					
					$val=$r['val'];					
					$desTxt=get_val_arr('den_m_services_levels_text','des',$val,'des');
					$data.='<tr>
					<td valign="top" class="lh50"><ff>'.date('Y-m-d',$date).'</ff></td>					
					<td><div class="fs14 lh30 f1 TJ">'.nl2br($desTxt).'</div></td>					
					<td valign="top">';
					if($doc==$thisUser && $vis==$_SESSION['denVis'] && $lev_status!=2){
						$data.='<div class="fr ic40 ic40_c2 ic40_del" onclick="delLevDen('.$l_id.')" title="حذف"></div>';
					}
					$data.='</td></tr>';					
				}			
				$data.='</table>';
			}else{
				$data.='<div class="f1 fs16 clr5 lh40">لايوجد إدخالات ضمن هذه المرحلة </div>';
			}?>
		<?=$data?></div>
		<div class="form_fot fr">
			<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div><?
			if($doc==$thisUser && $lev_status==1){?>
				<div class="bu bu_t3 fl" onclick="closeDenLevel(<?=$id?>);"><?=k_end?></div>
			<? }?>
		</div>
		</div><?
	}
}?>