<?php
/**
 *
 */
?>

<?php
    $this->Paginator->setTemplates([
        'nextActive' => '<input type="hidden" name="page" value="{{url}}">',
		'nextDisabled' => '',
    ]);
?>
<div class="paste__replace">
	<?= $this->Paginator->next() ?>
</div>
