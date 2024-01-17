<? include("ajax_header.php");
if(isset($_POST['status'],$_POST['id'])){
	$status=pp($_POST['status'],'s');
	$id=pp($_POST['id']);
	if($status=='view'){?>
		<div class="win_body">
		<div class="form_header so lh40 clr1 f1 fs18">#Title#</div>
		<div class="form_body so">
			<form id="indexDelForm" name="indexDelForm" method="post" action="<?=$f_path?>X/index_delete.php" bv="ok-!-err" cb="index_delete_result('[1],[2]');"  >
				<table class="fTable" cellpadding="0" cellspacing="0" border="0"><?
					$cData=getColumesData('mxk640owj',1,0,' 1=1 '); 
					echo co_getFormInput(0,$cData['tzgu0h2fwv'],'',0);
					echo co_getFormInput(0,$cData['8f6h47qqc'],'',0);?>
				</table>
				<input type="hidden" name="id" value="<?=$id?>" />
				<input type="hidden" name="status" value="process" />
			</form>
		</div>
		<div class="form_fot fr">
			<div class="bu bu_t2 fr" onclick="win('close','#m_info4');"><?=k_close?></div>    
			<div style="margin-right:-1px;" class="bu bu_t3 fl" onclick="sub('indexDelForm');win('close','#m_info4');"><?=k_delete?></div>    
		</div>
		</div><?
	}elseif($status=='process'){
		if(isset($_POST['cof_tzgu0h2fwv'],$_POST['cof_8f6h47qqc'])){
			$algo=pp($_POST['cof_tzgu0h2fwv'],'s');
			$lock=pp($_POST['cof_8f6h47qqc'],'s');
			$err=0;
			$ok=index_delete($id,$err,$algo,$lock);
			if($ok && !$err){
				if(!mysql_q("delete from _indexes where id=$id")){
					$ok=0;
				}
			}
			if($err){
				$ok='err*'.$err;
		    }
			
			echo $ok;
		}
		
	}
}?>