<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['opr'])){
	$id=pp($_POST['id']);
	$opr=pp($_POST['opr']);
	$p_name=get_p_name($id);
	if($p_name){
		if($opr==1){?>	
			<div class="win_body">
			<div class="winButts"><div class="wB_x fr" onclick="win('close','#full_win2');"></div></div>
			<div class="form_header so lh40 clr1 f1 fs18"><?=$p_name?>
			<div class="fr ic40 icc4 ic40_adddoc" fix="h:50|w:50" addDoce title="إضافة مستند"></div> 
			<div class="fr ic40 icc4 ic40_addimage" fix="h:50|w:50" addImage title="إضافة صورة" ></div>	
			</div>
			<div class="form_body of" type="pd0">
                <div class="fxg h100" fxg="gtc:350px 1fr|gtr: 1fr">
                    <div class="h100 r_bord ofx so pd10" pdSer>
                        <div class="f1 fs14 clr1 lh40"><?=k_type?></div>
                        <div class="lh50">
                            <select t name="type">
                            <option value=""><?=k_all_types?></option>
                            <option value="1"><?=k_photos?></option>
                            <option value="2"><?=k_documents?></option>
                            </select>
                        </div>

                        <div class="f1 fs14 clr1 lh40"><?=k_doc_cat?></div>
                        <div class="lh50">
                            <?=make_Combo_box('gnr_x_patients_docs_cats','name_'.$lg,'id','where act =1 ','cat',0,'','t',k_all_cats)?>
                        </div>

                        <div class="f1 fs14 clr1 lh40"><?=k_doc_name?></div>
                        <div class="lh50"><input type="text" name="title"></div>

                        <div class="f1 fs14 clr1 lh40"><?=k_doc_details?></div>
                        <div class="lh50"><input type="text" name="des"></div>

                        <div class="f1 fs14 clr1 lh40"><?=k_doc_date?> </div>
                        <div class="lh50"><input type="text" class="Date" name="date"></div>
                    </div>
                    <div class="h100 ofx so pd10" id="pd_data"></div>
                </div>  
            </div>
            <div class="form_fot fr">
                <div class="bu bu_t2 fr" onclick="win('close','#full_win2');"><?=k_close?></div>
            </div>
            <?
		}else{
			$q='';
			if(isset($_POST['ser'])){
				$ser=$_POST['ser'];
				foreach($ser as $k=>$s){
					$s=pp($s,'s');
					if($k=='type'){$q.=" and type='$s' ";}
					if($k=='cat'){$q.=" and cat='$s' ";}
					if($k=='title'){$q.=" and title like '%$s%' ";}
					if($k=='des'){$q.=" and des like '%$s%' ";}
					if($k=='date'){$s=convDate2Strep($s);$q.=" and doc_date = '$s' ";}
				}
			}
			$sql="select * from gnr_x_patients_docs where patient='$id' $q order by doc_date DESC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			$blcTitle=k_docs_num;
			if($q){$blcTitle=k_search_results;}
			echo '<div class="f1 fs16 clr1 lh50 uline">'.$blcTitle.'<ff> ( '.$rows.' ) </ff></div>';
			if($rows){			
				while($r=mysql_f($res)){
					$d_id=$r['id'];
					$doc=$r['doc'];
					$type=$r['type'];				
					$cat=$r['cat'];
					$user=$r['user'];
					$date=$r['date'];
					$doc_date=$r['doc_date'];
					$date=$r['date'];
					$careator=$r['careator'];
					$title=$r['title'];
					$des=$r['des'];				
					if($type==1){$docView=imgViewer($doc,120,120);}
					if($type==2){$docView=viewFile($doc,0,1,80,100);}				
					$catTxt =get_val_arr('gnr_x_patients_docs_cats','name_'.$lg,$cat,'c');
					$userTxt=get_val_arr('_users','name_'.$lg,$user,'u');?>

					<div class="fl w100 bord " style="border-top:4px #ccc solid">
						<div class="fl r_bord pd5f " style="min-height: 120px" fix="w:100|hp:0"><?=$docView?></div>
						<div class="fl pd10" fix="wp:101">
							<div dir="ltr" class="fr ff fs18 B clr5 lh40">
							<?=date('Y-m-d',$doc_date)?></div>
							<div class="fl f1 clr55 lh40 fs16"><?=$catTxt?></div>
							<? if($careator){?><div class="cb f1 clr1111 lh30 fs14"><?=k_doc_creator?> : <?=$careator?></div><?}
							if($title){?><div class="cb w100 f1 fs16 lh30 TL"><?=$title?></div><? }
							if($des){?><div class="cb f1 lh30 TL"><?=nl2br($des)?></div><? }?>
						</div>
					</div>

					<div class="fl w100 lh30 bord cbg444">
						<? if($user==$thisUser){?>
							<div class="fr ic30 icc1 ic30_edit" title="<?=k_edit?>" onclick="addPatDoc(<?=$d_id?>,<?=$type?>)"></div>
							<!-- <div class="fr ic30 icc2 ic30_del" title="<?=k_delete?>" onclick="delPatDoc(<?=$d_id?>)"></div> -->
						<? }?>
						<div class="fl lh30 pd10 f2 fs14"><?=k_doc_entry?> : <?=$userTxt?> - <?=k_input_time?> : <ff dir="ltr" class="fs14">
							<?=date('Y-m-d h:i',$date)?></ff> 
						</div>
					</div>					
					<div class="cb lh20">&nbsp;</div><?
				}
			}else{
				if(!$q){
					echo '<div class="f1 clr1 fs16 lh40">'.k_no_doc_to_pat.'</div>';
				}
			}
		}
	}
}?>
