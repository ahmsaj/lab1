<? include("../../__sys/prcds/ajax_header.php");
if (isset($_POST['state'], $_POST['id'])) {
	$state = $_POST['state'];
	$id = pp($_POST['id']); ?>
	<div class="win_body">
		<div class="form_header so lh40 clr1 f1 fs18">
			<? if ($state == 'down') { ?>
				<input type="text" placeholder="<?= k_search ?>" class="ser_icons" style="margin-bottom:10px;" id="list_ser_option">
			<? } else if ($state == 'up') { ?>
				<div class="fl ic40 ic40_add_new"></div>
				<div class="fl lh40 clrb f1 fs18"><?= k_new_temp ?></div>
			<? } ?>
		</div>
		<div class="form_body so">
			<? if ($state == 'down') { ?>
				<input type="hidden" name="process" value="<?= $id ?>" />
				<? $sql = 'select id,name from exc_templates';
				$res = mysql_q($sql);
				$rows = mysql_n($res);
				while ($r = mysql_f($res)) {
					$id = $r['id'];
					$name = $r['name']; ?>
					<div name="<?= $name ?>" template="<?= $id ?>" class="listOptbutt"><?= $name ?></div>

				<? }
			} else if ($state == 'up') { ?>
				<div class="f1 fs16 clr5 pd10"><?= k_save_setts_as_template ?></div>
				<div class="f1 fl clr1 fs14 lh40 pd10" fix="w:110"><?= k_template_name ?>:</div>
				<input name="template_name" class="fl" type="text" fix="wp:120" />
			<? } ?>
		</div>
		<div class="form_fot fr">
			<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?= k_close ?></div>
			<div class="bu bu_t1 fl" onclick="templateSave(<?= $id ?>)"><?= k_save ?></div>

		</div>
	</div>
<? } ?>