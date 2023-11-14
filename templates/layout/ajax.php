<?php
/**
 * Для AJAX-загрузки веб-компонентов.
 *
 * Использовать в контроллёре:
 *      $this->viewBuilder()->setLayout('Webcomponent.ajax');
 */
?>
<?= $this->fetch('script') ?>
<?= $this->fetch('content') ?>