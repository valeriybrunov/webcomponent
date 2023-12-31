## Webcomponent плагин для CakePHP.

### Что может этот плагин?

Плагин позволяет использовать в виде (view) веб-компоненты, создавать каркас веб-компонентов из командной строки, а также производить тестирование веб-компонентов.

[Установка](#install)

[Настройка](#settings)

[Основные команды в терминале](#terminal)

[Как использовать?](#used)

[Тестирование js-файла веб-компонента](#testing)

[Дополнительные библиотеки и расширяемые веб-компоненты.](#extend)

[Расширяемый веб-компонент Paste.](./PASTE.md)

[Расширяемый веб-компонент Paginator.](./PAGINATOR.md)

### <a id="install">Установка.</a>

Вы можете установить этот плагин в свое приложение CakePHP с помощью [composer](https://getcomposer.org).

Рекомендуемый способ установки пакетов composer - это:

```
composer require valeriy-brunov/webcomponent
composer dumpautoload
bin/cake plugin load Webcomponent
```

Для удаления плагина используйте команду:

```
composer remove valeriy-brunov/webcomponent --update-with-dependencies
```

### <a id="settings">Настройки.</a>

После установки плагина необходимо подключить помошник плагина. Для этого необходимо добавить строку:

```php
// ./src/Controller/AppController.php
public function initialize(): void
{
    // Добавить строку:
    $this->viewBuilder()->addHelper('Webcomponent.Webcomp');
}
```

В основной шаблон, расположенный в `./templates/layout/default.php`, между тегами `<head>` добавить строку:

```html
<style>.init {display: none;}</style>
```

### <a id="terminal">Основные команды в терминале.</a>

Создать файлы для нового веб-компонента:

```
$ bin/cake webcomp <name>
```

где *name* - имя веб-компонента. Должно состоять из одного слова. Регистр первой буквы не имеет значения.

Для создания веб-компонента с закрытой (теневой) схемой необходимо применить параметр "-close" (сокращённо "-c"):

```
$ bin/cake webcomp <name> -c
```

Для создания файлов веб-компонента внутри плагина необходимо создать сам плагин командой:

```
$ bin/cake bake plugin <name>
```

Далее создаём файлы веб-компонента внутри только что созданного плагина с закрытой (теневой) схемой:

```
$ bin/cake webcomp <name> -p -c
```

Для создания файлов веб-компонента с открытой схемой:

```
$ bin/cake webcomp <name> -p
```

### <a id="used">Как использовать?</a>

Чтобы вставить веб-компонент в вид (view):

```php
<?= $this->Webcomp->имяВебКомпонента() ?>
```

По умолчанию внутреннее содержимое веб-компонента загружается из одноимённого (совпадает с названием веб-компонента) элемента, расположенного в директории `../element/webcomp/`. Есть ряд настроек, которые помогут загрузить внутреннее содержимое веб-компонента из ячейки или оставить содержимое пустым. Для этого используют зарезервированное слово `view`:

```php
<?php echo 
	$this->Webcomp->имяВебКомпонента([
		// Значение по умолчанию: загружает содержимое из одноименного элемента.
		'view' => 'element',
		// Загружает содержимое из одноименной ячейки.
		'view' => 'cell',
		// Оставить внутреннее содержимое пустым.
		'view' => 'clear',
	]);
?>
```

Имя веб-компонента можно указать в виде верблюжей записи, при этом имя элемента или ячейки, которые будут загружать внутреннее содержимое, должно состоять из букв в нижнем регистре.

Передача данных и опций в элемент или ячейку осуществляется через ключевые слова `data` и `options`. Передача осуществляется точно так же, как если бы Вы вызвали элемент или ячейку напрямую:

```php
echo $this->element('myelement', $data, $options);
echo $this->cell('mycell', $data, $options);
```

Например, Вы хотите передать в элемент `myUser` веб-компонента имя в переменной `name`:

```php
<?php echo
	$this->Webcomp->myUser([
		'data' => [// Ключевое слово `date`.
			'name' => 'Valera',// Переданное значение.
		],
		'options' => [// Ключевое слово `options`.
			'cashe' => true,
		],
	]);
?>
```

Любые значения массива, переданные веб-компоненту в виде `ключ=>значение` преобразуются в `имяАтрибута=значение`, т.е. к веб-компоненту будут добавлены атрибуты. Ключом массива атрибутов не могут выступать ключевые слова такие как `view`, `data`, `options`. Например, следующий массив, переданный в веб-компонент, превратится в атрибуты веб-компонента:

```php
<?php echo
	$this->Webcomp->myUser([
		'display' => 'no',
		'open' => 'false',
	]);
?>
```

Выведет в веб-браузер:

```html
<wc-myuser display="no" open="false"></wc-myuser>
```

Для вызова веб-компонента из плагина, необходимо указать имя плагина перед именем веб-компонента, при этом имя плагина отделяется подчёркиванием от имени веб-компонента и должно начинаться с символа в верхнем регистре:

```php
<?= $this->Webcomp->Paste_myComp() ?>
```

Вызвать веб-компонент из плагина `Paste`, внутреннее содержимое веб-компонента загрузить из элемента `myComp` этого плагина.

### <a id="testing">Тестирование js-файла веб-компонента.</a>

Тесты должны содержаться в файле `test.js`. Для запуска теста необходимо в адресной строке браузера набрать адрес:

```text
Для теста js-файла плагина:
localhost/webcompplugin/имяПлагинаВебКомпонента
```

```text
Для теста js-файла:
localhost/webcomp/имяВебКомпонента
```

### <a id="extend">Дополнительные библиотеки и расширяемые веб-компоненты.</a>

Библиотеки и расширяемые веб-компоненты помогут добавить дополнительную функциональность в веб-компонент. Библиотеки содержат набор методов, которые можно использовать в своём веб-компоненте и содержат внутри себя безымянный класс. Напротив, расширяемые веб-компоненты - это готовые веб-компоненты содержащие сеттеры и геттеры от которых необходимо наследоваться, чтобы добавить их функциональность в свой веб-компонент.

### <a id="paste">Тестирование расширяемых веб-компонентов и библиотек.</a>

```text
Для теста раширяемого веб-компонента js-файла:
localhost/webcomponent/имяВебКомпонента
```