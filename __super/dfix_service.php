<?=header_sec($def_title,'');?>
<script>
rr_act_clnc=0;
rr_act_srv=0;
rr_act_srv2=0;
function rr_selclnic(id){
	rr_act_clnc=id;
	$('#seves').html(loader_win);
	$('#srvR').html('');
	$('#srvR2').html('');
	$.post(f_path+"X/___rr_opr.php",{clnc:id,t:1}, function(data){
		d=GAD(data);		
		$('#seves').html(d);
		fixForm();
		fixPage();		
	})
}
function rr_selsrv(id){
	rr_act_srv=id;
	$('#srvR').html(loader_win);
	$('#srvR2').html('');
	$.post(f_path+"X/___rr_opr.php",{clnc:rr_act_clnc,srv:id,t:2}, function(data){
		d=GAD(data);		
		$('#srvR').html(d);
		fixForm();
		fixPage();		
	})
}
function rr_selsrv2(id){
	rr_act_srv2=id;
	$('#srvR2').html(loader_win);
	$.post(f_path+"X/___rr_opr.php",{clnc:rr_act_clnc,srv:rr_act_srv,srv2:id,t:3}, function(data){
		d=GAD(data);		
		$('#srvR2').html(d);
		fixForm();
		fixPage();		
	})
}
function rr_curr(){	
	$('#srvR2').html(loader_win);
	$.post(f_path+"X/___rr_opr.php",{clnc:rr_act_clnc,srv:rr_act_srv,srv2:rr_act_srv2,t:4}, function(data){
		d=GAD(data);		
		rr_selclnic(rr_act_clnc);
		fixForm();
		fixPage();		
	})
}
</script>
<div class="centerSideInHeader lh50"></div>
<div class="centerSideInFull ofx">
	<div class="fl r_bord " fix="w:300|hp:0">
		<div class="b_bord lh60 pd10"><?
			$sql="select * from gnr_m_clinics where linked!=0 and type=1";
			$res=mysql_q($sql);
			$options='';
			while($r=mysql_f($res)){
				$id=$r['id'];
				$name=$r['name_'.$lg];
				$options.='<option value="'.$id.'">'.$name.'</option>';
			}?>
			<select onChange="rr_selclnic(this.value,1)"><option value="0"><?=k_clin_choose?> </option><?=$options?></select>
		</div>
		<div class="ofx so w100 pd10" fix="hp:50" id="seves">
		</div>
	</div>
	<div class="fl r_bord" fix="w:300|hp:0" id="srvR"></div>
	<div class="fl pd10" fix="wp:600|hp:0" id="srvR2"></div>
</div>
<script>//sezPage='';$(document).ready(function(e){f(1);});</script>