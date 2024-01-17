<? include("../../__sys/prcds/ajax_header.php");

if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	list($r_name,$equation)=get_val('cln_m_vital','name_'.$lg.',equation',$id);
	?>
	<div class="win_body">
    <div class="form_header">
	<div class="fl lh40 fs18 f1 clr1 ws"><?=$r_name?></div>    
    <div id="nqn" class="nqn cb"><?=getVQGraphic($equation)?></div>
    <DIV class="q_tool">
    	<div o class="fl" txt="+" no="1">+</div>
        <div o class="fl" txt="*" no="2">*</div>
        <div o class="fl" txt="-" no="3">-</div>
        <div o class="fl" txt="/" no="4">/</div>
        <div c class="fr">C</div>
        <div v class="fr" no="100" txt="">100</div>
        <div v class="fr" no="50" txt="">50</div>
        <div v class="fr" no="25" txt="">25</div>
        <div n class="fr" >
        	<div class="fr" nn></div>
        	<div class="fr"><input type="number" id="qnoO" /></div>
        </div>        
    </DIV>

    </div>
	<div class="form_body so" <?=$winType?>>
	<?
		$sql="select * from cln_m_vital where id!='$id' order by ord ";			
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
				
			echo script('setVital_links()');
		}else{
			echo '<div class="f1 fs14 clr5">'.k_no_tems_available.'</div>';
		}
		
	?>
	</div>
	<div class="form_fot fr">    		
        <div class="bu bu_t3 fl" onclick="saveQuV(<?=$id?>)"><?=k_save?></div>        
        <div class="bu bu_t2 fr" onclick="win('close','#m_info2');"><?=k_close?></div>               
	</div>
	</div><?
}?>