<?php
/**
 * Импортируем основные библиотеки для тестирования.
 */
?>
<?= $this->Html->css( 'Webcomponent.mocha.css', ['block' => true] ) ?>
<?= $this->Html->script( 'Webcomponent.testlibs' . DS . 'mocha.js', ['block' => 'testblock', 'type' => 'module'] ) ?>
<?= $this->Html->script( 'Webcomponent.testlibs' . DS . 'chai.js', ['block' => 'testblock', 'type' => 'module'] ) ?>
<?= $this->Html->script( 'Webcomponent.testlibs' . DS . 'sinon.js', ['block' => 'testblock', 'type' => 'module'] ) ?>

<?php
/**
 * Файл с тестами.
 */
?>
<?= $this->Html->script( 'webcomp' . DS . 'ext' . DS . $dir . DS . 'test.js', ['block' => 'testblock', 'type' => 'module'] ) ?>
<div id="test"></div>
