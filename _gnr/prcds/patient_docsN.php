<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['opr'])){
	$id=pp($_POST['id']);
	$opr=pp($_POST['opr']);
	$p_name=get_p_name($id);
	if($p_name){
		if($opr==1){?>
            <div class="fxg h100 w100" fxg="gtc:1fr 3fr">
                <div class="cbg444 r_bord pd10">
                    <div class="f1 fs16 lh30 pd10v pd10 uLine"><?=$p_name?></div>
                    <div class="" pdSer>
                        <div class="f1 lh30"><?=k_type?>:</div>
                        <div class="lh50">
                            <select t name="type">
                            <option value=""><?=k_all_types?></option>
                            <option value="1"><?=k_photos?></option>
                            <option value="2"><?=k_documents?></option>
                            </select>
                        </div>
                        
                        <div class="f1 lh30"><?=k_doc_cat?>:</div>
                        <div class="lh50">
                            <?=make_Combo_box('gnr_x_patients_docs_cats','name_'.$lg,'id','where act =1 ','cat',0,'','t',k_all_cats)?>
                        </div>

                        <div class="f1 lh30"><?=k_doc_name?>:</div>
                        <div class="lh50"><input type="text" name="title"></div>

                        <div class="f1 lh30"><?=k_doc_details?>:</div>
                        <div class="lh50"><input type="text" name="des"></div>

                        <div class="f1 lh30"><?=k_doc_date?>:</div>
                        <div class="lh50"><input type="text" class="Date" name="date"></div>
                    </div>
                </div>
                <div class="of pd10 fxg cbg4" fxg="gtr:50px 1fr">
                    <div class="w100 fl lh50 b_bord">
                        <div class="fl f1 fs14 pd10"  >عدد المستندات ( <ff14 id="docTotal">0</ff14> )</div>
                        <div class="fr ic30 icc4 ic30_add ic30Txt mg10v" addDoce>إضافة مستند</div> 
                        <div class="fr ic30 icc22 ic30_add ic30Txt mg10f" addImage>إضافة صورة</div> 
                    </div>
                    <div class="of mg10v pd10v">
                        <div class="fl w100 h100 ofx so pd10" id="pd_data"></div>
                    </div>
                </div>
            </div><?
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
			echo $rows.'^';
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
					if($type==1){$docView=viewPhotosImg($doc,1,1,60,80,$title,$d_id);}
					if($type==2){$docView=viewFile($doc,0,1,65,80);}				
					$catTxt =get_val_arr('gnr_x_patients_docs_cats','name_'.$lg,$cat,'c');
					$userTxt=get_val_arr('_users','name_'.$lg,$user,'u');?>
                    
                    <div class="fl w100 uLine fxg bord cbgw" fxg="gtc:80px 1fr">
                        <div class="fl r_bord pd5f cbg444 "><?=$docView?></div>
                        <div>
                            <div class="pd10f">
                                <div dir="ltr" class="fr ff fs14 B clr5 lh30">
                                <?=date('Y-m-d',$doc_date)?></div>
                                <div class="fl f1 clr55 lh30 fs14"><?=$catTxt?></div>
                                <? if($careator){?><div class="cb f1 clr1111 lh30"><?=k_doc_creator?> : <?=$careator?></div><?}
                                if($title){?><div class="cb w100 f1  lh30 TL"><?=$title?></div><? }
                                if($des){?><div class="cb f1 lh30 TL"><?=nl2br($des)?></div><? }?>
                            </div>
                            <div class=" fl w100 t_bord lh40 pd10">
                                <div class="fl lh40 f1 ">
                                    <?=k_doc_entry?> : <?=$userTxt?> - <?=k_input_time?> : <ff dir="ltr" class="fs14">
                                    <?=date('Y-m-d h:i',$date)?></ff> 
                                </div>
                                <? if($user==$thisUser){?>
                                    <div class="fr i30 i30_edit mg5v" title="<?=k_edit?>" onclick="addPatDoc(<?=$d_id?>,<?=$type?>)"></div>
                                    <!-- <div class="fr i30 i30_del mg5v" title="<?=k_delete?>" onclick="delPatDoc(<?=$d_id?>)"></div> -->
                                <? }?>
                            </div>
                        </div>                        
                    </div>
					<?
				}
			}else{
				if(!$q){
					echo '<div class="f1 clr1 fs16 lh40">'.k_no_doc_to_pat.'</div>';
				}
			}
		}
	}
}?>
