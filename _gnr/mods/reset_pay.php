<? include("../../__sys/mods/protected.php");?>
<?=header_sec($def_title,'');
$s_date=date('Y',getMaxMin('min','gnr_x_acc_payments','date'));
$e=getMaxMin('max','gnr_x_acc_p','date');
$e_date=date('Y',$e);
$last_id=getMaxMin('max','gnr_x_acc_p','id');
backupPayment();
?>
<script>
	function resPay(t){
		data=0;
		err=0;
		ok=0;
		ye=$('#y'+t).val();
		if(ye==0){
			nav(3,k_year_choose);
		}else{
			if(t==1){
				$('[pay_per]').each(function(){
					v=parseInt($(this).val());
					if(!v){v=0;}
					ok=1;
					if(v>100){
						nav(3,k_val_not_exceed+' <ff>100</ff>');
						err=1
					}else{						
						data+=','+v;
					}
				})
			}
			if(t==2){
				ok=1;
				data=$('#p2').val();
			}
			if(ok==0){
				nav(3,k_enter_one_val_atleast);
			}else{
				loader_msg(1,k_loading);
				$.post(f_path+"X/gnr_reset_pay.php",{t:t,y:ye,d:data},function(data){
					d=GAD(data);
					$('#out').html(d);
					loader_msg(0,'',0);
				})
			}
		}
	}
</script>
<div class="centerSideInHeaderFull "></div>
<div class="centerSideInFull of ">
	<div class="fl r_bord pd10 ofx so" fix="w:350|hp:0">
		<div class="f1 fs18 clr1 lh40"><?=k_edit_prices?></div>
		<div class="f1  clr5 lh40"><?=k_fill_desired_paym_percent?></div>
		
		<table width="300" border="0" cellspacing="0" cellpadding="6" class="grad_s holdH" type="static" >
		<tr>
			<td txt><?=k_thyear?></td>
			<td>
				<select id="y1">
				<option value="0"><?=k_choose_year?></option>
				<? for($i=$s_date;$i<=$e_date;$i++){
					echo '<option value="'.$i.'">'.$i.'</option>';
				}?>
				</select>
			</td>
		</tr><?
		foreach($clinicTypes as $k=> $val){
			if($val){
				echo '<tr>
				<td txt>'.$val.'</td>
				<td><input type="number" pay_per="'.$k.'" ></td>
				</tr>';
			}		
		}?>
		</table>
		<div class="fl ic40 icc2 ic40_save ic40Txt" onclick="resPay(1)"><?=k_edit_prices?></div>
	</div>
	<div class="fl r_bord pd10 ofx so" fix="w:350|hp:0">
		<div class="f1 fs18 clr1 lh40 "><?=k_data_recov?></div>
		<table width="300" border="0" cellspacing="0" cellpadding="6" class="grad_s holdH" type="static">
		<tr>
			<td txt><?=k_thyear?></td>
			<td>
				<select id="y2">
				<option value="0"><?=k_choose_year?></option>
				<? for($i=$s_date;$i<=$e_date;$i++){
					echo '<option value="'.$i.'">'.$i.'</option>';
				}?>
				</select>
			</td>
		</tr>
		<tr>
			<td txt><?=k_deprts?></td>
			<td>
				<select id="p2">
				<option value="0"><?=k_all_deps?></option>
				<? foreach($clinicTypes as $k=> $val){
					if($val){
						echo '<option value="'.$k.'">'.$val.'</option>';
					}
				}?>
				</select>
			</td>
		</tr>
		</table>
		<div class="fl ic40 icc4 ic40_save ic40Txt"  onclick="resPay(2)"><?=k_data_recov?></div>
		
	</div>
	<div class="fl pd10 ofx so" fix="wp:700|hp:0">
		<div class="cb mg10f w100 f1 fs16 clr5 lh40" id="out">
		<div class="f1 fs16 clr1"><?=k_lst_syc_dn?>: <ff dir="ltr"><?=date('Y-m-d',$e)?></ff></div>
		</div>
	</div>
</div>
<script>//sezPage='';$(document).ready(function(e){f(1);});</script>