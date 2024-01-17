<? include("../../__sys/prcds/ajax_header.php");
?><div class="win_body"><?
if(isset($_POST['id'] , $_POST['v_id'] , $_POST['c'])){
	?><div class="form_body of"><?
	$id=pp($_POST['id']);
	$v_id=pp($_POST['v_id']);
	$c=pp($_POST['c']);
	$p=get_val('cln_x_visits','patient',$vis);
	$p_name=get_p_name($p);	
    $diagnosis='';
    if($id){list($v_sataus,$diagnosis)=get_val('xry_x_visits_requested','status,diagnosis',$id);}
    if(!$diagnosis){
        $diagnosis=get_vals('cln_x_prev_dia','val',"visit=$v_id",' , ');
    }
	$type=pp($_POST['t']);
	if($type==1){
		$all_x_arra=explode(',',$all_x);
		echo '<div class="cb f1 fs18 clr1 lh40">'.k_select_medical_photo.'</div>
		<section  w="60" m=32" c_ord>';
		$sql="select * from gnr_m_clinics where type=3 and act=1 order by ord ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		$bf='../';
		if($rows>0){
			while($r=mysql_f($res)){
				$c_id=$r['id'];
				$photo=$r['photo'];
				$code=$r['code'];				
				$name=$r['name_'.$lg];				
				$ph_src=viewImage($photo,1,150,150,'img','clinic.png');
				echo '<div class="dashBloc dbOver fl TC" c_ord  onclick="new_xphoto('.$id.','.$c_id.',2,\''.$name.'\')">
					<div b>'.$ph_src.'</div>
					<div tt>'.$name.'</div>				
				</div>';
				echo '';
			}
			echo '</section>';
		}
	
	}else{
		/*if($id==0){
			$cancel=1;
			$sql="INSERT INTO xry_x_pro_radiography (v_id,p_id,c_id,date)values('$v_id','$p_id','$c','$now')";
			if($res=mysql_q($sql)){
				$id=last_id();
			}
		}else{
			$c=get_val('xry_x_pro_radiography','c_id',$id);
		}*/
		//$_SESSION['act_x_clinic']=$c;
		$c_name=get_val('gnr_m_clinics','name_'.$lg,$c);
		$photo=get_val('gnr_m_clinics','photo',$c);
		$ph_src=viewImage($photo,1,35,35,'css','clinic.png');	
		?>
		<div class="fxg h100" fxg="gtc:400px 1fr|gtr:100%">
			<div class="r_bord pd10 fl fxg" fxg="gtr:40px 40px 1fr" >
				<div class="f1 blc_win_title bwt_icon3" ><?=k_sel_reqmage?></div>
				<div class="lh40"><input type="text" placeholder="<?=k_search?>" onkeyup="serServIN(this.value)" id="ssin"/></div>
				<div class="of">
					<div class="fxg h100 " fxg="gtc: 50% 50%|gtr:1fr">
						<div class="ana_list so h100"><?=get_xx_cats($c)?></div>
						<div class="ana_list so h100"><?=get_xx($id,$c)?></div>          	
					</div>
				</div>
			</div>
			<div class="fl pd10" fix="wp:400|hp:40">
				<div class="f1 blc_win_title bwt_icon2"><?=k_sel_imgs?></div>
				<div id="anaSelected" class="so">
				<form name="l_xp" id="l_xp" action="<?=$f_path?>X/gnr_preview_radiology_save.php" method="post" cb="win('close','#m_info2');m_xphotoN([1])" bv="a">
				<div class="f1 fs16 lh40 clr1 pd10f" inputHolder><?=k_diagnoses?> :
					<input class="lh30 w100 pd10" type="text" name="dia" value="<?=$diagnosis?>" required/>
				</div>
				<input type="hidden" name="id" value="<?=$id?>">				
				<input type="hidden" name="vis" value="<?=$v_id?>">
				<input type="hidden" name="c" value="<?=$c?>">
				<? if($v_sataus==1){ echo '<div class="f1 fs14 lh40 clr5">'.k_request_edit_resend.'</div>';}?>
				<table width="100%" id="srvData" border="0" cellspacing="0" cellpadding="6" class="grad_s holdH" type="static">
					<th><?=k_pho_sett?></th><th width="30"></th>				
				</table>
				</form>					
				</div>
			</div>
		</div>
	<? 
	}?>
    </div>
		
    <div class="form_fot fr">
		<div class="bu bu_t2 fr" onclick="win('close','#m_info2')"><?=k_cancel?></div>            
		<? if($type==2){?>	        
			<div class="bu bu_t3 fl hide " id="saveButt" onclick="sub('l_xp')"><?=k_save?></div>
		<? }?>
	</div> 
	<?
	$script='';
	if($id){
		$sql="select * from xry_x_visits_requested_items where r_id='$id' ";
		$res=mysql_q($sql);
		while($r=mysql_f($res)){
			$a_id=$r['xphoto'];						
			$script.='drowXPRow('.$a_id.');';
		}
	}
	echo script($script);
}?>
</div>