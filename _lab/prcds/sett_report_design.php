<? include("../../__sys/prcds/ajax_header.php");?>
<div class="moveBox"></div>
<div class="win_body"><?
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	list($r_name,$report_de,$type)=get_val('lab_m_services','short_name,report_de,type',$id);
	if($type==2 || $type==3){
		mysql_q("UPDATE lab_m_services SET report_de='' where id='$id' ");
		echo script("win('close','#full_win1');nav(5,'".k_Can_not_set_design_test_."')");
		exit;
	};
		
	$rd_Selceted_t1=get_sel_rd($report_de,1);
	$rd_Selceted_t2=get_sel_rd($report_de,2);
	$der=drow_edit_rd($report_de);	
	?>
    <div class="form_header lh40">
		<div class="fl ff lh40 fs18 B f1 clr1 ws"><?=$r_name?></div>
        <div class="rd_icons fr lh40 fs18 f1 clr1 ws">
			<div class="fr rd_r1"></div>
            <div class="fr rd_r2"></div>
            
        </div>
    </div>
	<div class="form_body so" type="static">
    	<div class="fl rd_b1 so"><?
		$taps='';
        $sql="select * from lab_m_services_items where serv='$id'  order by ord ASC";			
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$tap1='';
			$tap2='';
			while($r=mysql_f($res)){
				$name=$r['name_'.$lg];
				$unit=$r['unit'];
				$a_id=$r['id'];
				$type=$r['type'];
				$icon='i';
				$t='';if($type==1){$t='t="ok"';$icon='';}
				$cls='';
				if(in_array($a_id,$rd_Selceted_t1)){$cls=' hide ';}
				$taps.='<div no="'.$a_id.'" txt="'.$name.'" '.$t.' c_ord class="fl '.$cls.' " del="1">
					<div '.$icon.' class="fl ws"></div>
					<div t class="fl ws">'.$name.'</div>
				</div>';
			}				
		}
		$sql="select * from lab_m_services_equations where ana_no='$id' and type> 1  order by ord ASC ";			
		$res=mysql_q($sql);
		$rows2=mysql_n($res);
		if($rows2>0){
			while($r=mysql_f($res)){
				$a_id=$r['id'];
				$item=$r['item'];
				$q=$r['equations'];
				$type=$r['type'];
				$q_txt=getaQNames($type,$q);				
				$icon='s'.$type;
				$t='t="s'.$type.'"';
				$cls='';
				if(in_array($a_id,$rd_Selceted_t2)){$cls=' hide ';}
				$taps.='<div no="'.$a_id.'" txt="'.$q_txt.'" '.$t.' c_ord class="fl '.$cls.' " del="'.$type.'">
					<div '.$icon.' class="fl ws"></div>
					<div t class="fl ws">'.limitString($q_txt,35).'</div>
				</div>';
			}				
		}
		if($rows+ $rows2==0){
			echo '<div class="f1 fs14 clr5">'.k_no_tems_available.'</div>';
		}else{
			echo '<section  w="220" m=6" c_ord id="q_list3" class="q_list3 fl">'.$taps.'</section>';
			echo script('setQList3()');
		}
		?>
        </div>
        <div class="fl rd_b2 so"><?=$der?></div>        
	</div>
	<div class="form_fot fr">
	    <div class="bu bu_t3 fl" onclick="save_rd(<?=$id?>);"><?=k_save?></div>
		<div class="bu bu_t2 fr" onclick="win('close','#full_win1');"><?=k_close?></div>
	</div>
	<?
}?>
</div>