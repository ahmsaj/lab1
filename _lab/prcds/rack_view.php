<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$no=pp($_POST['id'],'s');
	$sql="select * , r.id as rid from lab_m_racks r , lab_m_racks_cats c where r.no='$no' and r.cat=c.id";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows){
		$r=mysql_f($res);
		$r_id=$r['rid'];
		$code=$r['code'];
		$no=$r['no'];
		$type=$r['type'];
		$color=$r['color'];
		$cat_name=$r['name'];
		$size=$r['size'];
		$x_type=$r['x_type'];
		$x=$r['x'];
		$y_type=$r['y_type'];
		$y=$r['y'];
		$position=$r['position'];
		$out_lab=$r['out_lab'];
		echo script('rx='.$x.';ry='.$y.';');
		$allS=$x*$y;
		$allN=getTotalCO('lab_x_visits_samlpes','rack',$r_id);
		$sql2="select id , pkg_id , rack_pos ,no ,services from lab_x_visits_samlpes  where rack='$r_id'";
		$res2=mysql_q($sql2);
		$rows2=mysql_n($res2);
		$r_sam=array();
		if($rows2>0){
			while($r2=mysql_f($res2)){
				$rack_pos=$r2['rack_pos'];
				$r_sam[$rack_pos]['id']=$r2['id'];
				$r_sam[$rack_pos]['pg']=$r2['pkg_id'];
				$r_sam[$rack_pos]['no']=$r2['no'];
				$r_sam[$rack_pos]['srv']=$r2['services'];
			}
		}
		if($out_lab){echo '<div class="f1 fs14 clr5 cb lh30"> '.k_snd_rack_out.' ( '.get_val('lab_m_external_Labs','name_'.$lg,$out_lab).' )</div>';}

		echo '
		<div class="hideINput"><input type="number" id="rsno" onkeyup="resvLSNo()"/></div>
		<div class="rackCo" style="background-color:'.$color.'">
		<div class="fl lh30" txt><ff><span class="ff">'.$cat_name.' ( '.$allS.' / '.$allN.' )</span> | '.$code.'-'.$no.' 
		</ff></div>
		<div class="fr lh30 rackTool">
			<div a title="'.k_details.'" onclick="rackInfo('.$r_id.')"></div>
			<div b title="'.k_print.'" onclick="rackPrint('.$r_id.')"></div>
			<div c title="'.k_destruction.'" onclick="rackSDel('.$r_id.')"></div>
			<div d title="'.k_send_outlab.'" onclick="rackSOut('.$r_id.')"></div>
		</div>
		<div class="uLine cb"></div>';
		
		$TRdir='ltr';
		$loopS=1;
		$loopE=$y;
		$headPos='top';
		if($position==1 || $position==3 ){$TRdir='rtl';}
		if($position==4 || $position==3 ){$headPos='bottom';$loopS=$y*(-1);$loopE=-1;}
		$rtHead= '<tr><td m></td>';		
		for($xx=1;$xx<=$x;$xx++){
			$Yt=$yy;if($y_type==2){$Yt=$CHL[$yy];}
			$Xt=$xx;if($x_type==2){$Xt=$CHL[$xx];}
			$rtHead.='<td class="TC" m>'.$Xt.'</td>';
		}
		$rtHead.='</tr>';
		
		echo '<table class="rackTable" dir="'.$TRdir.'" x="'.$x.'">';
		if($headPos=='top'){echo $rtHead;}
		for($yy=$loopS;$yy<=$loopE;$yy++){
			$Yt=$yy;if($y_type==2){$Yt=$CHL[abs($yy)];}
			echo '<tr><td class="TC" m>'.$Yt.'</td>';
			for($xx=1;$xx<=$x;$xx++){				
				$Xt=$xx;if($x_type==2){$Xt=$CHL[$xx];}
				$r_order=(intval($xx)+intval(str_replace('-','',$yy))*100);
				$in='';
				$no=0;
				$title='';
				$bordrr="#ccc";
				if($r_sam[$xx.'_'.abs($yy)]){
					$no=$r_sam[$xx.'_'.abs($yy)]['no'];
					$srv=$r_sam[$xx.'_'.abs($yy)]['srv'];
					$pg=$r_sam[$xx.'_'.abs($yy)]['pg'];
					if(getTotalCO('lab_m_services'," id IN($srv) and outlab=1")){$out='<div class="outAna"></div>';}
					$in=get_rs_Icon($r_sam[$xx.'_'.abs($yy)]['id'],$pg,$no);					
					$title=' title="'.$no.'" ';
					$ss=explode(',',$srv);
					$outSrv=getTotalCO('lab_m_services'," id IN( select service from lab_x_visits_services where id IN($srv) and outlab=1 )");
					if($outSrv>0){
						$bordrr="#666";
						if(count($ss)==$outSrv){$bordrr="#f33";}
					}
				}
				
				echo '<td s >
					<div class="rtt">'.$Yt.'.'.$Xt.'</div>
					<div class="rts" style="border-bottom:5px '.$bordrr.' solid;" x="'.$x.'" y="'.$y.'" no="'.$no.'" sw="off" id="S'.$xx.'_'.abs($yy).'" '.$action.' '.$title.' ord="'.$r_order.'">'.$in.'</div>
					
				</td>';
			}
			echo '</tr>';
		}
		if($headPos=='bottom'){echo $rtHead;}
		echo '</table>
		</div>
		';
		//echo script('AutoSelectRack();');
	}else{
		echo '<div class="f1 fs16 clr5 lh40">'.k_no_rack_num.' <ff> ( '.$no.' ) </ff></div>';
	}
}?>