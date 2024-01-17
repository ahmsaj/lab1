<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'],$_POST['pat'])){
	$vis=pp($_POST['vis']);
	$pat=pp($_POST['pat']);	
	$sql="select * from den_x_visits_services where patient ='$pat' and ( status in(0,1) OR (status=2 and d_finish>$ss_day )) and (doc=0 OR doc='$thisUser' )  order by  status DESC, d_start ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);?>
	<div class="fl r_bord of" fix="wp%:40|hp:0">
		<div class="lh40 cbg444 b_bord fl w100">
			<div class="fl ic40x icc4 ic40_add br0" addSrv title="<?=k_add_proced?>" onclick="addNewSrv()"></div>
			<div class="fl lh40 f1 fs18 pd10 of"><?=k_current_procedures?> <ff>( <?=$rows?> )</ff></div>
		</div>
		<div class="fl pd10f ofx so " id="oprStus" fix="wp:0|hp*:0"><?
		if($rows){?>
			<div class="oprDen" actButt="act"><?
			while($r=mysql_f($res)){
				$id=$r['id'];
				$service=$r['service'];
				$d_start=$r['d_start'];
				$status=$r['status'];
				$teeth=$r['teeth'];
				$serDoc=$r['doc'];
				$serDoc_add=$r['doc_add'];
				$end_percet=$r['end_percet'];				 $serviceTxt=get_val_arr('den_m_services','name_'.$lg,$service,'srv');
				if($status==0 && $serDoc==0){$status=4;}
				list($s_ids,$subServ,$percet)=get_vals('den_m_services_levels','id,name_'.$lg.',percet'," service=$service",'arr');
				$teethTxt='';
				if($teeth){
					$tt=explode(',',$teeth);
					$teethTxt.='<div t class="pd10">';
					foreach($tt as $ttt){$teethTxt.='<div>'.$ttt.'</div>';}
					$teethTxt.='</div>';
				}?>
				<div class="cbg41 bord" no="<?=$id?>" style="background-color:<?=$denSrvSCol[$status]?>">
					<div s><?=splitNo($serviceTxt)?></div>
					<div><div d><?=date('Y-m-d',$d_start)?></div><?=$teethTxt?></div>
					<div class="b_bord lh1 cb"></div>
					<div class=" f1 w100 pd10 lh30 <?=$denSrvSCol[$status1]?>"><?=$denSrvS[$status]?></div>
				</div><?
			}?>
			</div><?
		}else{?><div class="f1 fs14 lh40 clr5"><?=k_no_ctin?></div><? }?>
		</div>
	</div>
	<div class="fl " fix="wp%:60|hp:0" id="denOprInfo">
		<div class="f1 fs14 pd10f lh30 clr5">
		- <?=_info_s7qaiyrnr8?> <br>- 
			<?=_info_6o979xxp21?>

		</div>
	</div><?
}?>
