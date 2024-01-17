<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$mood=pp($_POST['mod']);
	if($mood==2){$clinic=getDoc_Clinic();}else{$clinic=$userSubType;}
	$sql="select * from gnr_x_roles where  clic in ($clinic) and mood='$mood' AND id='$id' order by no ASC limit 1";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$r_id=$r['id'];
		$pat=$r['pat'];
		$status=$r['status'];
		$mood=$r['mood'];
		$fast=$r['fast'];
		$vis=$r['vis'];
		if($status==1){
			if($r_id==$id){if($status==0){mysql_q("UPDATE gnr_x_roles SET status=1 where id ='$id' ");}}
			$text=k_start_pre;
			if($mood==2){$text=k_tk_sams;}
			if($mood==5 || $mood==6){$text=k_start_proce;}
		?>
		<div class="win_body">
		<div class="form_body so">
			<div class="f1s fs18 TC lh50 uLine"><?=get_p_name($pat)?></div>
			<div class="fx fx-js-sb">
				<div class="rvbu">
					<div class="rvbu_1" onclick="d_vis_Play(<?=$id?>,2,<?=$mood?>,'<?=_set_7h5mip7t6n?>')"></div>
					<div class="f1 fs18 clr6 TC"><?=$text?></div>
				</div>
				<? if($fast!=2){?>
                    <div class="rvbu">
                        <div class="rvbu_2"  onclick="d_vis_Play(<?=$id?>,3,<?=$mood?>,'<?=_set_7h5mip7t6n?>')"></div>
                        <div class="f1 fs18 clr5 TC"><?=k_skpd?></div>  
                    </div>
				<? }?>
			</div>
		</div>
		<div class="form_fot fr">
			<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>                
		</div>
		</div><? 
		}elseif($status==2){			
			echo loc($f_path.$prvPages[$mood].'.'.$vis);
		}
	}
}?>