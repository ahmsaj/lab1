<? include("../../__sys/prcds/ajax_header.php");
?><div class="win_body"> 
    <div class="form_body ofx so">  
    
    	<div class="f1 blc_win_title bwt_icon7"><?=k_select_form_prescription?></div><?		
		$sql="select * from gnr_x_prescription_temp where doc='$thisUser'";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			echo '<div class="tamplist listStyle so">';
			while($r=mysql_f($res)){
				$id=$r['id'];
				$name=$r['name'];
				echo '<div t_id="'.$id.'">'.$name.'</div>';
			}
			echo '</div>';
		}else{
			echo '<div class="winOprNote f1">'.k_no_templates.'</div>';
		}?>        
    
    </div>
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="win('close','#m_info3');"><?=k_cancel?></div>
    </div>

</div>