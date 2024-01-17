<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	list($vis_status,$p_id)=get_val('bty_x_laser_visits','status,patient',$id);
	$c=$userSubType;?>
	<div class="win_body">
		<div class="form_header" type="full">		
        	<div class="f1 fs18 lh40"><?=get_p_name($p_id)?></div>
        </div>
        <div class="form_body so"><?
			$alreadyServ=array();
			if($vis_status==1){
				$alreadyServVals=0;
				$cat=1;
				$alreadyServ=get_vals('bty_x_laser_visits_services','service',"visit_id='$id' ");
				
				$q='';
				if($alreadyServ){
					$q=" and id NOT IN($alreadyServ)";
					$cat=get_val_con('bty_m_services','cat',"id in($alreadyServ)");	
				}
				$sql="select * from bty_m_services where cat ='$cat' and act=1 $q order by ord ASC";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows>0){?>
					<form name="n_visit" id="n_visit" action="<?=$f_path?>X/bty_lsr_preview_services_save.php" method="post"  cb="loadLaserServ();" bv="">
					<input type="hidden" name="id" value="<?=$id?>"/>
					<table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s holdH">
					<tr><th width="30">#</th><th><?=k_service?></th><?				
					while($r=mysql_f($res)){
						$s_id=$r['id'];
						$name=$r['name_'.$lg];
						$cat=$r['cat'];
						$bg='';
						$ch='';
						foreach($alreadyServ as $data){
							if($s_id==$data['service']){
								if($data['status']!=3 ){$bg='#eeeeee';}
							}											
						}
						echo '<tr bgcolor="'.$bg.'">
						<td><input type="checkbox" name="ser_'.$s_id.'" value="'.$price.'" '.$ch.' /></td>
						<td class="f1"><ff>'.get_val('bty_m_services_cat','name_'.$lg,$cat).'</ff> ( '.$name.' )</td>
						</tr>';
					}?>
					</table></form><?
				}	
			}?>
		</div>
        <div class="form_fot fr">
			<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
			<? if($vis_status==1){?><div class="bu bu_t3 fl" onclick="sub('n_visit');"><?=k_save?></div><? }?>
		</div>
	</div><?
}?>