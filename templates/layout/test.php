<?php
/**
 * Основной шаблон для тестирования "js" кода.
 */
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        Тестирование JS файлов.
    </title>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>

    <?= $this->fetch('content') ?>
    <?= $this->fetch('testblock') ?>

    <!-- Элемент с id="mocha" будет содержать результаты тестов. -->
    <div id="mocha"></div>

</body>
</html>