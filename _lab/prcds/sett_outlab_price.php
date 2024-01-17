<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	if(getTotalCO('lab_m_external_Labs'," id='$id' ")>0){
	?>
	<div class="win_body">
    <div class="form_header">
	<div class="fl lh40 fs18 f1 clr1 ws"><?=get_val('lab_m_external_Labs','name_'.$lg,$id)?></div>
    <div class="fr lh40">
    </div>
    </div>
	<div class="form_body so">
	<?
	$values=array();
	$sql="select ana,price from lab_m_external_Labs_price where lab='$id' ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$ana=$r['ana'];
			$price=$r['price'];
			$values[$ana]=$price;
		}
	}
	
    $sql="select * from lab_m_services order by outlab DESC , short_name ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		?>
        <div  style="margin-top:-10px;">
        <form name="lab_pr" id="lab_pr" action="<?=$f_path?>X/lab_sett_outlab_price_save.php" method="post" cb="loadModule()">
	    <input type="hidden" name="id" value="<?=$id?>"/>
		<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static">
        <tr>
            <th><?=k_analysis?></th>
            <th><?=k_code?></th>
            <th><?=k_price?></th>
        	<th><?=k_lab_pricing?></th>
        </tr>
        <?
        while($r=mysql_f($res)){
			$a_id=$r['id'];
			$short_name=$r['short_name'];
			$code=$r['code'];
			$unit=$r['unit'];
			$outlab=$r['outlab'];
			$bg='';
			if($outlab){$bg='#eeeeee';}
			echo '<tr bgcolor="'.$bg.'">
			<td class="ff fs16 B">'.$short_name.'</td>
			<td class="ff fs16 B">'.$code.'</td>
			<td><ff>'.number_format(_set_x6kmh3k9mh*$unit).'</ff></td>
			<td><input name="a_'.$a_id.'" value="'.$values[$a_id].'" type="number"/></td>
			</tr>';
		}?>
        </table>
        </form>
        </div><?
	}else{
		echo '<div class="f1 fs14 clr5">'.k_no_ad_tests.'</div>';
	}
	?>
	</div>
	<div class="form_fot fr">
	    <div class="bu bu_t3 fl" onclick="sub('lab_pr');"><?=k_save?></div>
		<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>                
	</div>
	</div><?
	}
}?>