<? $x_mod=array('Modules','Users','Basic-information','Settings-S','Langs-Keys','_lang_keys_sys','Basic-information-S','');?>
<div class="centerSideFullIn of h100 fxg" fxg="gtc:1fr 1fr 2fr|gtr:40px 1fr">
    <div class="r_bord b_bord cbg4"><input class="TC f1" serMod type="text" placeholder="بحث بالموديول"/></div>
    <div class="r_bord b_bord cbg444 f1 fs14 lh40 TC">الحقول</div>
    <div class="fxg" fxg="gtc:4fr 120px">
        <div><input type="text" class="cbg444" id="fixSer" placeholder="بحث بالبيانات"/></div>
        <div class="fs14 f1 lh40 icc2 TC clrw" fixButt><?=k_repair?></div>
    </div>
    <div class="r_bord cbg4 pd10 ofx so" actButt="act" modList><?        
	$sql="select * from _modules order by ord ASC ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$id=$r['id'];
			$code=$r['code'];
			$module=$r['module'];
			$title=get_key($r['title_'.$lg]);
			if(!in_array($module,$x_mod)){
				echo '<div class="f1 lh40 cbgw bord pd10 mg10v Over2" mc="'.$code.'" Ctxt="'.$title.'">'.$title.' ( '.$module.' )</div>';
			}
		}
	}?>
    </div>
    <div class="r_bord pd10 ofx so cbg444" modFil id="cols"></div>
    <div class="r_bord pd10 ofx so" id="fix_data"></div>
</div>