<? include("../../__sys/mods/protected.php");?>
<?=header_sec($def_title);?>
<div class="centerSideInHeader">
	<div class="rep_header fl"><?
	$options='<option value="0">'.k_allusrs.'</option>';
	$sql="select * from _users order by name_$lg ASC ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$id=$r['id'];
			$name=$r['name_'.$lg];
			$options.='<option value="'.$id.'">'.$name.'</option>';       
		}
	}?>
	<select id="log_fil" class="reportList" onChange="log_h_ref_Do();"><?=$options?></select>
	</div>
</div>
<div class="centerSideIn so"></div>
<script>$(document).ready(function(e){log_h_ref();log_h_ref_Do();});</script>
