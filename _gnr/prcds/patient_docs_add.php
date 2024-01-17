<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['pat'],$_POST['id'])){
	$pat=pp($_POST['pat']);
	$id=pp($_POST['id']);
	$t=pp($_POST['t']);	
	$part=pp($_POST['part']);
	$subPart=pp($_POST['subPart']);	
	$doc_date=date('Y-m-d');
	//$careator=get_val('_users','name_'.$lg,$thisUser);
	if($pat && $t){
		if($id){
			$r=getRec('gnr_x_patients_docs',$id);
			$doc=$r['doc'];
			$t=$r['type'];
			$patient=$r['patient'];
			$cat=$r['cat'];
			$user=$r['user'];			
			$doc_date=date('Y-m-d',$r['doc_date']);
			$careator=$r['careator'];
			$title=$r['title'];
			$des=$r['des'];
			if($patient!=$pat && $user==$thisUser){exit;}
		}
		if($t==1){
			$txTtitle=k_img_add;
			$subTitle=k_photo;
			//$docInput=imageUpN('doc',$doc,1,'',1).'<span>'.k_atleast_img_add.'</span>';
            $docInput=imageUpN(0,'doc','tp_photo',$doc,1,0).'<span>'.k_atleast_img_add.'</span>';
		}
		if($t==2){
			$txTtitle=k_doc_add;
			$subTitle=k_dcmnt;
			$docInput=upFile('doc',$doc,1,'',1).'<span> '.k_accptd_docs.' ( PDF , DOC , EXl )</span>';
		}        
        $bc='patDocs('.$pat.',2)';
        if($PER_ID=='fy50elewgz'){$bc='patDocsN('.$pat.',2)';}
		?>
		<form name="patDoc" id="patDoc" method="post" action="<?=$f_path?>X/gnr_patient_docs_save.php" cb="<?=$bc?>" bv="">
		<input type="hidden" name="pat" value="<?=$pat?>"/>
		<input type="hidden" name="id" value="<?=$id?>"/>
		<input type="hidden" name="t" value="<?=$t?>"/>			
		<div class="win_body">
		<div class="form_header so lh40 clr1 f1 fs18"><?=get_p_name($pat).' ( '.$txTtitle.' )'?></div>
		<div class="form_body so">
			<table class="fTable" cellpadding="0" cellspacing="0" border="0">
				<tr><td n><?=k_cat?> :  <span>*</span></td>
				<td><?=make_Combo_box('gnr_x_patients_docs_cats','name_'.$lg,'id','where act =1 ','cat',1,$cat,'t',k_all_cats )?></td></tr>
				<tr><td n><?=$subTitle?> : <span>*</span></td>
				<td><?=$docInput?></td></tr>
				<tr><td n><?=k_doc_date?> : <span>*</span> </td>
				<td><input type="text" name="doc_date" required  class="Date" value="<?=$doc_date?>"></td></tr>
				<tr><td n><?=k_doc_creator?>: </td>
				<td><input type="text" name="careator" value="<?=$careator?>"></td></tr>
				<tr><td n><?=k_doc_title?> : </td>
				<td><input type="text" name="title" value="<?=$title?>"></td></tr>
				<tr><td n><?=k_details?> : </td>
				<td><textarea t name="des" class="w100"><?=$des?></textarea></td></tr>
			</table>
		</div>
		<div class="form_fot fr">
			<div class="bu bu_t2 fr" onclick="win('close','#m_info4');"><?=k_close?></div>
			<div class="bu bu_t3 fl" onclick="sub('patDoc');"><?=k_save?></div>
		</div>
		</div>
		</form><?
	}
}?>