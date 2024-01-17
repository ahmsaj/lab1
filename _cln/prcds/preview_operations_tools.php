<? include("../../__sys/prcds/ajax_header.php");
?><div class="win_body"><?
$t=pp($_POST['t'],'s');
$selTools=explode('|',$t);
$ids=array();
$quns=array();
for($i=0;$i<count($selTools);$i++){
	$vals=explode(':',$selTools[$i]);
	$ids[$i]=$vals[0];
	$quns[$i]=$vals[1];
}
?>
<div class="form_body so" type="full">
	<div class="win_inside_con">
		<div class="f1 blc_win_title  bwt_icon8" ><?=k_tools_list?>
			<div class="blc_win_title_icons fr"  id="bwtto">
				<div class="fr addToList" onclick="new_tool()" title="<?=k_add?>"></div>
			</div> 
		</div>
		<div class="toolList so">
		<?
		$sql="select * from cln_m_pro_operations_tools where doc='$thisUser' order by name_$lg ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			while($r=mysql_f($res)){
				$id=$r['id'];
				$name=$r['name_'.$lg];
				$ss='x';
				if(in_array($id,$ids)){
					$ss='y';
				}
				$q=1;	
				foreach($ids as $key=>$v){if($v==$id){$q=$quns[$key];}}					
				echo '
				<div class="toolrow" s="'.$ss.'" tNum="'.$id.'" n="'.$name.'">'.$name.' 
					<div class="fr"><input type="text" value="'.$q.'" placeholder="'.k_quantity.'" ></div></div>';
			}
		}?>
		</div>
	</div>
	</div>
<div class="form_fot fr">
	<div class="bu bu_t2 fr" onclick="win('close','#m_info3');" ><?=k_close?></div> 
	<div class="bu bu_t1 fr" id="seveWinOpr" onclick="save_selTool()"><?=k_save?></div>
</div>        
</div>
<?
$sendingParsToForm=getStaticPars('Doctor-Opration-Tools');
echo'<script>sendingParsToForm="'.$sendingParsToForm.'"</script>';
?>