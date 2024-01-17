<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$status=get_val('osc_x_visits','status',$id);
	$sql=" SELECT m.name_$lg , x.* FROM osc_m_add_service m , osc_x_add_service x where x.vis='$id' and x.add_srv=m.id ";	
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){	
		echo '<div>';
		while($r=mysql_f($res)){
			$r_id=$r['id'];			
			$srv_txt=$r['name_'.$lg];
			echo '<div class="fl lh40 uLine w100">';
			if($status==1){
				echo '<div class="fr ic40 icc2 ic40_del" onclick="osc_srv_del('.$r_id.')" title="'.k_delete.'"></div>';
			}
			echo '<div class="f1 fs16 lh30 clr1" >'.$srv_txt.'</div>			
			</div>';
			
		}
		echo '</div>';			
	}

}?>