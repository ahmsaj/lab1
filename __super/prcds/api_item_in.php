<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
$m_id=pp($_POST['id']);
$apiTypesArr=array('','Text','Date','Act','Photo','Parent','list','Custom','Sub Data');
$_SESSION['apim']=$m_id;?>
<div class="win_body">
<div class="winButts"><div class="wB_x fr" onclick="win('close','#full_win1');loadModule()"></div></div><?	
	$title=get_val('api_module','module',$m_id);
	?>
    <div class="form_header lh40">
    	<div class="fl f1 lh40 fs18 f1 clr1 ws"><?=get_key($title)?></div>
  		<div title="<?=k_add?>" class=" fr List_add_butt" onclick="apiInputItem(<?=$m_id?>,0)"></div>		
    </div>
	<div class="form_body so">
		<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s g_ord holdH" type="static" t_ord="api_modules_items_in" c_ord="ord" >
		<thead>
		<tr>
			<th width="20" class="reSoHoldH" tilte="<?=k_rank_possib?>"></th>
			<th>#</th>
			<th><?=k_input?></th>
			<th><?=k_font_field?></th>
			<th><?=k_type?></th>			
			<th><?=k_sub_value?></th>
			<th width="30"><?=k_search?></th>
			<th width="30"><?=k_required?></th>			
			<th width="30"><?=k_active?></th>
			<th width="100"></th>
		</tr>
		</thead>
		<tbody>
		<?
		$sql="select * from `api_modules_items_in` where mod_id='$m_id' order by ord ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			while($r=mysql_f($res)){
				$id=$r['id'];
				$type=$r['type'];
				$colum=$r['colum'];
				$in_name=$r['in_name'];
				$name=$r['name_'.$lg];
				$sub_type=$r['sub_type'];
				$ord=$r['ord'];
				$search=$r['search'];
				$requerd=$r['requerd'];
				$act=$r['act'];
				
				$ch1=$ch2=$ch3='off';
				if($search){$ch1='on';}
				if($requerd){$ch2='on';}
				if($act){$ch3='on';}
				?>		
				
				<tr row_id="<?=$id?>" row_ord="<?=$ord?>">
					<td width="20" class="reSoHold"><div></div></td>
					<td width="40"><ff><?=$id?></ff></td>					
					<td><ff><?=$in_name?></ff></td>					
					<td><ff><?=$colum?></ff></td>
					<td><ff><?=$apiTypesArr[$type]?></ff></td>
					<td><?=get_subType_a($type,$sub_type)?></td>
					<td><div class="form_checkBox fl"><div ch="<?=$ch1?>"></div></div></td>
					<td><div class="form_checkBox fl"><div ch="<?=$ch2?>"></div></div></td>
					<td><div class="form_checkBox fl"><div ch="<?=$ch3?>"></div></div></td>
					<td><div class="ic40 icc1 ic40_edit fl " onclick="apiInputItem(<?=$m_id?>,<?=$id?>)"></div>
					<div class="ic40 icc2 ic40_del fl" onclick="co_del_rec_cb('udvs23g96t',<?=$id?>,'apiInputsWin(<?=$m_id?>)')"></div></td>					
				</tr><?
			}
		}?>
		</tbody>
		</table>
	</div>
	<div class="form_fot fr">	    
    	<div class="bu bu_t2 fr" onclick="win('close','#full_win1');loadModule()"><?=k_close?></div>
	</div>
</div><?
}?>