<? include("../__sys/mods/protected.php");?>
</div>
<footer id="mwFooter"></footer>
</div>
<? include("../__main/footer.php");?>
<div class="co_filter"><?=modFilter($mod_data['c'],$sendingParsToForm).filterCustom($customFiltter,$customPageFiltter);?></div>
<div class="filter"><? if($i_tree_f){?><div class="left_Item"></div><? }?><?=$filter;?></div>
<? for($d=0;$d<10;$d++){
    //echo '<div id="opr_form'.$d.'"></div>';
}?>
<? for($d=1;$d<6;$d++){echo '<div id="full_win'.$d.'" class="full_win"></div>';}?>
<style id="st"></style>
<div class="hide" id="bcScript"></div>
</body>
</html>