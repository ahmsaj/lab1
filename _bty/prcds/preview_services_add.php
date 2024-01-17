<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$vis_status=get_val('bty_x_visits','status',$id);
	$p_id=get_val('bty_x_visits','patient',$id);	
	$c=$userSubType;
    $c=getMClinic($c);?>
	<div class="win_body">
	<div class="form_header" type="full">
		<div class="fr serTotal ff fs18 B" id="serTotal">0</div>
        <div class="f1 fs18 lh40"><?=get_p_name($p_id)?></div>         
        </div>
        <div class="form_body so"><?
		$alreadyServ=array();
		if($vis_status==1){								
			$sql="select service , status , id from bty_x_visits_services where visit_id='$id' ";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				$i=0;
				while($r=mysql_f($res)){
					$alreadyServ[$i]['id']=$r['id'];
					$alreadyServ[$i]['service']=$r['service'];
					$alreadyServ[$i]['status']=$r['status'];
					$i++;
				}
			}
			$sql="select * from bty_m_services where cat IN(select id from bty_m_services_cat where  clinic='$c') and act=1 order by ord ASC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				?>
				<form name="n_visit" id="n_visit" action="<?=$f_path?>X/bty_preview_services_save.php" method="post"  cb="bty_rev_ref(0,<?=$id?>);" bv="id">
                <input type="hidden" name="id" value="<?=$id?>"/>
                <table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s holdH">
				<tr><th width="30">#</th><th><?=k_service?></th><th width="80"><?=k_price?></th><?				
				while($r=mysql_f($res)){
					$s_id=$r['id'];
					$name=$r['name_'.$lg];
					$hos_part=$r['hos_part'];
					$doc_part=$r['doc_part'];
					$rev=$r['rev'];					
					$cat=$r['cat'];
					$price=$hos_part+$doc_part;
					$bg='';
					$ch='';
					foreach($alreadyServ as $data){
						if($s_id==$data['service']){
							if($data['status']!=3 ){$bg='#eeeeee';}
						}												
					}
					echo '<tr bgcolor="'.$bg.'"><td>';
					if($bg==''){echo '<input type="checkbox" name="ser_'.$s_id.'" par="ceckServ" value="'.$price.'" '.$ch.' />';}
					echo '</td>
					<td class="f1">'.get_val('bty_m_services_cat','name_'.$lg,$cat).' ( '.$name.' )</td>
					<td><ff id="p3_'.$s_id.'">'.number_format($price).'<ff></td>					
					</tr>';
				}?>
				</table></form><?
			}	
		}
	?></div>
        <div class="form_fot fr">
    	<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
        <? if($vis_status==1){?>
        <div class="bu bu_t3 fl" onclick="sub('n_visit');"><?=k_save?></div><? }?>
		</div>
        </div><?
	}
?>