<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['tot'],$_POST['reject'])){
	$tot=pp($_POST['tot']);
	$reject=pp($_POST['reject']);
	$count_rows=pp($_POST['count_rows']);
?>
	<div class="win_body">
	<div class="form_body so of" style="height:80px;">
		<center>
			
		
			<div>
				<div class="f1 fs12 clr1 lh30"><?=k_file_recs?>: <ff count_rows><?=$count_rows?></ff> </div>		
				<div class="f1 fs12 clr1 lh30"><?=k_import_recs?>: <ff tot><?=$tot?></ff> </div>		
				<div class="f1 fs12 clr5 lh30"><?=k_declined_recs?>: <ff reject><?=$reject?></ff></div>	
			</div>

		</center>
		
	</div>
    <div class="form_fot fr">&nbsp;</div>
    </div><?
}?>

