<? include("../../__sys/prcds/ajax_header.php");
?><div class="win_body"><?
if(isset($_POST['id'])){	
	$id=pp($_POST['id']);
	list($view,$p_id,$c_id)=get_val('xry_x_pro_radiography','view,p_id,c_id',$id);?>
    <div class="form_body so">
    <div class="f1 fs18 clr1 lh40"><?=k_sel_exp_typ?></div>
    <form name="x_out" id="x_out" action="<?=$f_path?>X/cln_preview_radiology_out_save.php" method="post"  cb="" bv="">
	<input type="hidden" name="id" id="id" value="<?=$id?>"/>
    <input type="hidden" name="p" id="id" value="<?=$p_id?>"/>
    <input type="hidden" name="c" id="id" value="<?=$c_id?>"/>
    <div class="radioBlc so fl" name="type" req="1" par="swt" >
    <input type="radio" name="type" checked value="1" par="swt"/><label><?=k_print?></label>
    <input type="radio" name="type" value="2" par="swt"/><label><?=k_crt_adserv?></label>
    </div>
    <table width="100%" border="0" class="grad_s " type="static" cellspacing="0" cellpadding="4" over="0">
	<tr>
    <th width="40">#</th>            	
    <th><?=k_service?></th>
    <th><?=k_corr_serv_cntr?></th>
    </tr><?
	
	//$status_txt=array(k_report_not_enterd,k_report_enterd);
	//$status_color=array($clr5,$clr6);
	//$status_color2=array('#ffffff',$clr4);
	$sql="select * from xry_x_pro_radiography_items where xph_id='$id' ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$s_id=$r['id'];
			$mad_id=$r['mad_id'];
			$photo=$r['photo'];
			$note=$r['note'];
			$status=$r['status'];
			$s_link=get_val('xry_m_pro_radiography_details','s_link',$mad_id);
			$serv_txt=k_srv_ntav_hos;
			$serv_color=$clr5;
			$mood=1;
			$ch='checked';
			$price='';
			if($s_link){
				$sql2="select hos_part,doc_part , name_$lg from cln_m_services where id='$s_link' limit 1 ";
				$res2=mysql_q($sql2);
				$rows2=mysql_n($res2);
				if($rows2){
					$r2=mysql_f($res2);
					$hos_part=$r2['hos_part'];
					$doc_part=$r2['doc_part'];
					$serv_txt=$r2['name_'.$lg];				
					$serv_color=$clr6;
					$price='<br><ff>'.number_format($hos_part+$doc_part).'</ff>';
					$mood=2;
					$ch='';
				}
			}?>
			<tr mood="<?=$mood?>">
            	<td><input type="checkbox" par="lxo" name="srv_<?=$s_id?>" <?=$ch?>/></td>
				<td class="fs12 f1"><?=get_val('xry_m_pro_radiography_details','name_'.$lg,$mad_id)?></td>
                <td class="fs12 f1" style="color:<?=$serv_color?>"><?=$serv_txt.$price?></td>
			</tr><?
		}
	}?>
    </table>
    </form>
    </div>
    <div class="form_fot fr">
        <div class="bu bu_t3 fl" onclick="exportXOut();" ><?=k_export?></div>
        <div class="bu bu_t2 fr" onclick="win('close','#m_info3');" ><?=k_close?></div>        
    </div><?	
}?>
</div>