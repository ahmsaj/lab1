<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id'],'s');
	$dir= $folderBack.'.backup/'.$id.'/';
	$info = $dir.'_info_res.php';
	$tables = $dir.'_tables_res.php';
	if(file_exists($info) && file_exists($tables)){
		include($folderBack.'.backup/'.$id.'/_info_res.php');
		include($folderBack.'.backup/'.$id.'/_tables_res.php');
		$info=json_decode($BU_info,true);
		$tables=json_decode($BU_tables,true);		
		?>
		<div class="fxg h100" fxg="gtc:300px 1fr">
			<div class="h100 pd10f cbg444 r_bord ofx so">
				<div class="f1 lh30 fs14">الاسم: <?=$info['name']?></div>
				<div class="f1 lh30 fs14">الكود: <?=$info['id']?></div>
				<div class="f1 lh30 fs14">عدد السجلات: <?=number_format($info['rows'])?></div>
				<div class="f1 lh30 fs14">الحجم: <?=getFileSize($info['size'],2)?></div>				
				<div id="saveBU_info">
					<?
				$per=$info['finshed_row']*100/$info['rows'];
					echo '<div class="cbgw pd10f br5 mg10v">
						<div class="f1 fs16 TC lh40">'.number_format($per,3).'%</div>
						<div class="snc_prog "><div style="width:'.number_format($per,3).'%"></div></div>
						<div class="f1 fs12 TC lh20">'.number_format($info['rows']).'/'.number_format($info['finshed_row']).'</div>
					</div>';
					// echo '<div class="ic40 ic40_save icc33 ic40Txt mg10t" saveBackup>اكمال النسخة الاحتياطية</div>';
					?>
				</div>
			</div>
			<div class="h100 ofx so pd10">
			<div><?
				foreach($tables as $table){?>					
					<div class="lh20 f1 "><?=$table['table']?> - <?=number_format($table['rows'])?></div>
					<div class="bord fx mg5v lh20">							
						<? foreach ($table['oprations'] as $k => $val){
							$clr='cbg4';
							if($val['status']){$clr='cbg6';}
							echo '<div class="'.$clr.' r_bord w100 lh20" style="height: 8px;" id="s_'.$val['no'].'" n="'.$val['no'].'"></div>';
						}?>
					</div><?
				}?>				
			</div>
		</div><?
	}
}?>
