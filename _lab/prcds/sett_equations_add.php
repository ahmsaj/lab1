<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['l'] , $_POST['no'])){
	$id=pp($_POST['id']);
	$l=pp($_POST['l']);
	$no=pp($_POST['no']);
	$t=pp($_POST['t']);
	if($no){list($values,$item)=get_val('lab_m_services_equations','equations,item',$no);}
	$winType='';
	$r_name=get_val('lab_m_services','name_'.$lg,$id);
	if($l==1){$r_name=k_select_link_type;}
	if($l==2){
		$winType=' type="full" ';
		if($t==11){
			$sn=pp($_POST['sn']);
			$sn_name=get_val('lab_m_services_items','name_'.$lg,$sn);
			$r_name=k_equ_assign_item.' ( '.$sn_name.' )';
		}
		if($t==1){$r_name=k_sel_itm_val;}
		if($t==2){$r_name=k_sel_itm_percent;}
		if($t==3){$r_name=k_sel_itm_layout;}
	}
	?>
	<div class="win_body">
    <div class="form_header">
	<div class="fl lh40 fs18 f1 clr1 ws"><?=$r_name?></div>
	<? if($t==3 && $l==2){
		$ch="";
		if($item==1){$ch=" selected ";}
		echo '<div class="f1 fs14 cb lh60">'.k_choose_chart_type.' :
		<select id="ch_type" t fix="w:150">
			<option value="0">'.k_bar_chart.'</option>
			<option value="1" '.$ch.'>'.k_curved.'</option>
		</select>&nbsp;
		</div>';
	}?>
    <? if($t==11 && $l==2){?>
    <div id="nqn" class="nqn cb"><?=getQGraphic($values)?></div>
    <DIV class="q_tool">
    	<div o class="fr" txt="+" no="1">+</div>
        <div o class="fr" txt="x" no="2">x</div>
        <div o class="fr" txt="-" no="3">-</div>
        <div o class="fr" txt="÷" no="4">÷</div>
		<div a class="fr" txt=")" no="5">)</div>
		<div a class="fr" txt="(" no="6">(</div>
		<div a class="fr" txt="√" no="7">√</div>
        <div c class="fl">C</div>
        <div v class="fl" no="100" txt="">100</div>
        <div v class="fl" no="50" txt="">50</div>
        <div v class="fl" no="25" txt="">25</div>
        <div n class="fl" >
        	<div class="fl" nn></div>
        	<div class="fl"><input type="number" id="qnoO" /></div>
        </div>        
    </DIV>
    <? }?>
    </div>
	<div class="form_body so" <?=$winType?>>
	<?
	if($l==1){		
		echo '<div class="c_cont">';
		foreach($aQtypes as $t){
			echo '<div class="ATIc fl" onclick="anaQType='.$t[0].'; anaEqu_set(2,'.$id.','.$no.',\''.$t[1].'\')">
			<div i style="background-image:url(../im/'.$t[2].'.png)"></div>
			<div t class="f1">'.$t[1].'</div>
			</div>';
		}
		echo '</div>';
	}
	if($l==2){
		if($t==2 || $t==3){
			if($no){
				$values=get_val('lab_m_services_equations','equations',$no);
				$selectedItem=explode(',',$values);
			}else{
				$selectedItem=array();
			}
			
			if($t==2){
				$sql="select * from lab_m_services_items where serv='$id' and type=2 order by ord ";
			}
			if($t==3){
				$sql="select * from lab_m_services_items where serv='$id' and type=2 and report_type IN(1,2,4,7) order by ord ";
			}
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				$tap1='';
				$tap2='';
				while($r=mysql_f($res)){
					$ana_id=$r['id'];
					$name=$r['name_'.$lg];
					$unit=$r['unit'];
					$a_id=$r['id'];
					$ok=1;
					if($t==2){$unit_c=get_val('lab_m_services_units','code',$unit);if($unit_c!='%')$ok=0;}
					if($ok){
						if(!in_array($a_id,$selectedItem)){
							$tap1.='<div no="'.$a_id.'" d="s">'.$name.'</div>'; 
							$tap2.='<div no="'.$a_id.'" d="h">'.$name.'</div>';
						}else{
							$tap1.='<div no="'.$a_id.'" d="h">'.$name.'</div>'; 
							$tap2.='<div no="'.$a_id.'" d="s">'.$name.'</div>';
						}
					}
				}			
				echo '<div class="aq_list fl so" l>
					<div class="lh40 f1 fs18 clr1 TC uLine">'.k_itms_list.'</div>'.$tap1.'</div>
					<div class="aq_list  so" t><div class="lh40 f1 fs18 clr1 TC uLine">'.k_selc_itms.'</div>'.$tap2.'
				</div>';
				echo script('setQList()');
			}else{
				echo '<div class="f1 fs14 clr5">'.k_no_tems_available.'</div>';
			}
		}
		if($t==1){						
			$sql="select * from lab_m_services_items where serv='$id' and type=2 and report_type IN(1,2,4,7) and id NOT IN 
			(select item from  lab_m_services_equations where ana_no='$id' and type =1 ) order by ord ASC";			
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				$tap1='';
				$tap2='';
				while($r=mysql_f($res)){
					$ana_id=$r['id'];
					$name=$r['name_'.$lg];
					$unit=$r['unit'];
					$a_id=$r['id'];
					$tap1.='<div no="'.$a_id.'" d="s">('.$ana_id.') '.$name.'</div>';
				}			
				echo '<div class="aq_list fl so" t style="width:100%">'.$tap1.'</div>';
				
				echo script('setQList2('.$id.','.$no.')');
			}else{
				echo '<div class="f1 fs14 clr5">'.k_no_tems_available.'</div>';
			}
		}
		if($t==11){						
			$sql="select * from lab_m_services_items where id!='$sn' and serv='$id' and type=2 and report_type IN(1,2,4,7) order by ord ";			
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				$tap1='';
				$tap2='';
				while($r=mysql_f($res)){
					$name=$r['name_'.$lg];
					$unit=$r['unit'];
					$a_id=$r['id'];
					$tap1.='<div no="'.$a_id.'" txt="'.$name.'" c_ord class="fl">
						<div n class="fl ws">'.$a_id.'</div>
						<div t class="fl ws">'.$name.'</div>
					</div>';
				}			
				echo '<section  w="220" m=6" c_ord id="q_list3" class="q_list3 fl">'.$tap1.'</section>';
				
				echo script('setQList3()');
			}else{
				echo '<div class="f1 fs14 clr5">'.k_no_tems_available.'</div>';
			}
		}
	}?>
	</div>
	<div class="form_fot fr">
    	<? if($t==2 || $t==3){$action='saveQu('.$id.','.$no.');';}?>
        <? if($t==11){$action='saveQu1('.$id.','.$no.');';}
		if($l==2){?>        
        <div class="bu bu_t3 fl" onclick="<?=$action?>"><?=k_save?></div>
        <? }?>
        <div class="bu bu_t2 fr" onclick="win('close','#m_info2');"><?=k_close?></div>               
	</div>
	</div><?
}?>