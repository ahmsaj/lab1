<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['type'])){
	$id=pp($_POST['type']);
    $clr='cbg555';
    if($id){$clr='cbg666';}?>
    <div class="h100 fxg " fxg="gtc:240px 5fr">
        <div class="fl r_bord pd10 ofx so cbg4" reqFilter>
            <?=patForm()?>
            <div class="lh30 f1 clr1111 fs12">نوع النتائج : </div>
            <div>
                <select ser_p="all">
                    <option value="1">الطلابات الغير معالجة</option>
                    <option value="2">كل الطلبات</option>
                </select>
            </div>
        </div>        
	    <div class="ofx so pd10 h100" id="reqsListView"></div>
    </div><?
}?>