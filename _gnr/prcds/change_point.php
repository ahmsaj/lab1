<? include("../../__sys/prcds/ajax_header.php");
if(_set_tauv8g02){
	if(isset($_POST['p'])){
		$p_id=pp($_POST['p']);
		if(!$p_id){?>
			<div class="win_body">			
			<div class="form_body so"><?
				$sql="select * from gnr_m_resp_points ";
				$res=mysql_q($sql);
				while($r=mysql_f($res)){
					echo '<div class="bu bu_t1" onclick="changPoint('.$r['id'].')">'.$r['name_'.$lg].'</div>';
				}
				?>
			</div>
			<div class="form_fot fr">							
				<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>     
			</div>
			</div><?
		}else{
			list($id,$clinics,$name)=get_val('gnr_m_resp_points','id,clinics,name_'.$lg,$p_id);
			//if(!$clinics){$clinics=0;}
			$_SESSION['po_id']=$id;
			$_SESSION['po_clns']=$clinics;				
		}
	}	
	
}?>