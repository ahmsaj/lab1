<? include("../../__sys/prcds/ajax_header.php");
if( isset($_POST['c'] , $_POST['d'] , $_POST['p']) ){	
	$c=pp($_POST['c']);
	$d=pp($_POST['d']);
	$p=pp($_POST['p']);
	$srvs='';
	$srvs_arr=[];
	$c_type=0;
	if($thisGrp=='7htoys03le' || $thisGrp=='fk590v9lvl'){
		$sql="select * from dts_x_dates where patient='$p' and status=0 limit 1";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$r=mysql_f($res);
			$d_id=$r['id'];	
			$doctor=$r['doctor'];
			$patient=$r['patient'];						
			?>
			<div class="win_body">
			<div class="form_header" type="full">        
				<div class="fl f1 fs18 clr1 lh40"><?=$c_name?></div>
			</div>
			<div class="form_body so">
				<div class="f1 fs18 clr5">يوجد موعد غير مكتمل خاص بالمريض : <?=get_p_name($patient)?></div>
				
			</div>
			<div class="form_fot fr">
				<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_cancel?></div>
				<div class="bu bu_t1 fl" onclick="selDate(<?=$d_id?>)">إكمال</div>
				<div class="bu bu_t3 fl" onclick="dtsDel(<?=$d_id?>)">حذف</div>
			</div>
			</div><?
			exit;
		}
	}
	if($d){
		list($c,$doctor,$c_type)=get_val('dts_x_dates','clinic,doctor,type',$d);		
		$srvs=get_vals('dts_x_dates_services','service'," dts_id ='$d' ");
		$srvs_arr=explode(',',$srvs);
		
	}
	$m_clinic=getMClinic($c);
	if($c_type==4){
		$c_name='أسنان';
	}else{
		list($c_name,$photo,$c_type)=get_val('gnr_m_clinics','name_'.$lg.',photo,type',$c);
	}?>
	<div class="win_body">
	<div class="form_header">
		<div class="fl f1 fs18 clr1 lh40"><?=$c_name?></div>
		<? if($c_type!=4){?>
		<div class="lh50"><input type="text" placeholder="<?=k_search?>" id="servSelSrch"/></div>
		<? }?>
    </div>
	<div class="form_body so" type="">
		<form name="n_date" id="n_date" action="<?=$f_path?>X/dts_new_service_save.php" method="post"  cb="selDate([1]);" bv="id">
		<input type="hidden" name="d" value="<?=$d?>"/>
		<input type="hidden" name="p" value="<?=$p?>"/><?
		if($c_type==4){
			echo '<input type="hidden" name="c" value="0"/>';
			if($d || $thisGrp=='pfx33zco65'){
				
			}else{
				if($thisGrp=='fk590v9lvl'){
					$doctor=$thisUser;
				}
				echo '<div class="f1 fs18 clr1 uLine lh40">الطبيب : '.get_val('_users','name_'.$lg,$doctor).'</div>';
				echo '<input type="hidden" name="teeth_doc" value="'.$doctor.'"/>';
			}
			echo '<div class="f1 fs18 clr5 lh40">أختر مدة الموعد</div>
			<input type="hidden" name="teethTime" id="teethTime" value="0" />';			
			//echo '< par="teeth">';			
			foreach($denDateTimes as $dd){
				$bg='bu_t1';
				if($dd==30){$bg='bu_t4';}
				echo '<div class="bu fl '.$bg.'" teethTime="'.$dd.'" ><ff>'.minToHour($dd).'</ff></div>';
			}		
		}else if($c_type==1){?>
			<input type="hidden" name="c" value="<?=$c?>"/>
			<table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s holdH">
			<tr><th width="30">#</th><th><?=k_service?></th><th><?=k_price?></th><?
			$serv_data=[];		
			$sql="select * from cln_m_services where clinic='$m_clinic' and act=1 order by ord ASC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				while($r=mysql_f($res)){
					$s_id=$r['id'];				
					$name=$r['name_'.$lg];
					$def=$r['def'];
					$price=$r['hos_part']+$r['doc_part'];
					$ch='';
					if(in_array($s_id,$srvs_arr) || ( $d=='' && $def==1) ){$ch=' checked ';}
					echo '<tr serName="'.$name.'" no="'.$s_id.'">
					<td><input type="checkbox" name="ser_'.$s_id.'" '. $ch.'  par="ceckServDt" value="1" /></td>
					<td class="f1 fs14">'.$name.'</td>
					<td class="f1 fs14"><ff>'.number_format($price).'</ff></td>
					</tr>';
				}
			}?>
			</table><? 
		}else if($c_type==3){?>
			<input type="hidden" name="c" value="<?=$c?>"/>
			<table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s holdH">
			<tr><th width="30">#</th><th><?=k_service?></th><th><?=k_price?></th><?
			$serv_data=array();			
			$sql="select * from xry_m_services where clinic='$m_clinic' and act=1 order by ord ASC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				while($r=mysql_f($res)){
					$s_id=$r['id'];				
					$name=$r['name_'.$lg];
					$cat=$r['cat'];
					$catTxt=get_val_arr('xry_m_services_cat','name_'.$lg,$cat,'cats');
					$price=$r['hos_part']+$r['doc_part'];
					$def=$r['def'];
					$ch='';
					if(in_array($s_id,$srvs_arr) || ( $d=='' && $def==1) ){$ch=' checked ';}
					echo '<tr serName="'.$name.'" no="'.$s_id.'">
					<td><input type="checkbox" name="ser_'.$s_id.'" '. $ch.'  par="ceckServDt" value="1" /></td>
					<td class="f1 fs14"><ff class="clr1 f1 fs14">'.$catTxt.' : </ff>'.$name.' </td>
					<td class="f1 fs14"><ff>'.number_format($price).'</ff></td>
					</tr>';
				}
			}
			?>
			</table><? 
		}else if($c_type==5 || $c_type==6){
			?>
			<input type="hidden" name="c" value="<?=$c?>"/>
			<table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s holdH">
			<tr><th width="30">#</th><th><?=k_service?></th><th><?=k_price?></th><?
			$serv_data=array();		
			$sql="select * from bty_m_services where cat IN(select id from bty_m_services_cat where clinic='$m_clinic') and act=1 order by ord ASC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				while($r=mysql_f($res)){
					$s_id=$r['id'];				
					$name=$r['name_'.$lg];					
					$cat=$r['cat'];
					$cat_name=get_val('bty_m_services_cat','name_'.$lg,$cat);
					$price=$r['hos_part']+$r['doc_part'];
					$ch='';
					if(in_array($s_id,$srvs_arr) || ( $d=='' && $def==1) ){$ch=' checked ';}
					echo '<tr serName="'.$name.'" no="'.$s_id.'">
					<td><input type="checkbox" name="ser_'.$s_id.'" '. $ch.'  par="ceckServDt" value="1" /></td>
					<td class="f1 fs14">'.$cat_name.' : '.$name.'</td>
					<td class="f1 fs14"><ff>'.number_format($price).'</ff></td>
					</tr>';
				}
			}?>
			</table><?
			
		}else if($c_type==7){?>
			<input type="hidden" name="c" value="<?=$c?>"/>
			<table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s holdH">
			<tr><th width="30">#</th><th><?=k_service?></th><th><?=k_price?></th><?
			$serv_data=array();		
			$sql="select * from osc_m_services where clinic='$m_clinic' and act=1 order by ord ASC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				while($r=mysql_f($res)){
					$s_id=$r['id'];				
					$name=$r['name_'.$lg];
					$def=$r['def'];
					$price=$r['hos_part']+$r['doc_part'];
					$ch='';
					if(in_array($s_id,$srvs_arr) || ( $d=='' && $def==1) ){$ch=' checked ';}
					echo '<tr serName="'.$name.'" no="'.$s_id.'">
					<td><input type="checkbox" name="ser_'.$s_id.'" '. $ch.'  par="ceckServDtOSC" value="1" /></td>
					<td class="f1 fs14">'.$name.'</td>
					<td class="f1 fs14"><ff>'.number_format($price).'</ff></td>
					</tr>';
				}
			}?>
			</table><? 
		}?>
		</form>
		
	</div>
	<div class="form_fot fr">
	<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_cancel?></div>
	<div class="bu bu_t3 fl hide" id="saveButt" onclick="sub('n_date');"><?=k_next?></div>
	</div>
	</div><?
	
}?>