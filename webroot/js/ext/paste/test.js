/**
 * Импортируем основные файлы веб-компонента для тестирования.
 */
import Paste from './paste.js';

/**
 * Определяем Paste, как пользовательский элемент.
 */
customElements.define("wc-paste", Paste);

/**
 * Настраиваем библиотеки для тестирования.
 */
mocha.setup( 'bdd' );
var assert = chai.assert;
var expect = chai.expect;

var paste;

/**
 * Тесты.
 */
describe("Тест расширяемого вэб-компонента Paste.", function() {

    describe(`Проверяем метод checkMode():`, function() {

    	beforeEach(() => {
    		paste = new Paste();
    	});

        afterEach(() => {
        	paste = null;
        });

        it(`Первичная загрузка веб-компонента. Установка класса 'paste_replace'.`, function() {
        	paste.checkMode();
        	assert.equal(paste.classList.contains('paste_replace'), true, `Класс 'paste_replace' не установлен!`);
        });

        it(`Устанавливаем режим 'mode'='trubber'. Установка класса 'paste_trubber'.`, function() {
        	paste.mode = 'trubber';
        	paste.checkMode();
        	assert.equal(paste.classList.contains('paste_trubber'), true, `Класс 'paste_trubber' не установлен!`);
        });

        it(`Многократные вызовы метода checkMode(). Установка класса 'paste_replace'.`, function() {
        	paste.mode = 'html';
        	for (let i = 0; i < 5; i++) {
        		paste.checkMode();
        	}
        	assert.equal(paste.classList.contains('paste_replace'), true, `Класс 'paste_replace' не установлен!`);
        });

        it(`Чередование режимов checkMode() 'trubber' и 'html' с окончанием на 'html'.`, function() {
        	for (let i = 0; i < 5; i++) {
        		paste.mode = 'trubber';
	        	paste.checkMode();
	        	paste.mode = 'html';
	        	paste.checkMode();
        	}
        	assert.equal(paste.classList.contains('paste_replace'), true, `Класс 'paste_replace' не установлен!`);
        });

        it(`Чередование режимов checkMode() 'trubber' и 'html' с окончанием на 'trubber'.`, function() {
        	for (let i = 0; i < 5; i++) {
        		paste.mode = 'html';
	        	paste.checkMode();
	        	paste.mode = 'trubber';
	        	paste.checkMode();
        	}
        	assert.equal(paste.classList.contains('paste_trubber'), true, `Класс 'paste_replace' не установлен!`);
        });
    });

    describe(`Проверяем метод replaceHTML():`, function() {

    	beforeEach(() => {
    		paste = new Paste();
    	});

        afterEach(() => {
        	paste = null;
        });

        it(`Для 'miltiple'=false проверяем вставку нового блока.`, function() {
        	paste.insertAdjacentHTML('beforeend', '<div class="paste__replace">Replace</div>');
        	paste.replaceHTML('<div class="paste__replace">test</div>');
        	let newBlock = paste.querySelector('.paste__replace');
        	assert.equal(newBlock.innerText == 'test', true, `Новый блок не вставлен!`);
        });

        it(`Для 'miltiple'=true проверяем вставку новых блоков.`, function() {
        	paste.multiple = 'true';
        	paste.insertAdjacentHTML('beforeend', `
        		<div class="paste__replace1">Replace1</div>
        		Какой-то текст...
        		<div class="paste__replace2">Replace2</div>
        		Какой-то текст...
        		<div class="paste__replace3">Replace3</div>
        	`);
        	paste.replaceHTML(`
        		<div class="paste__replace1">Test1</div>
        		<separator>
        		<div class="paste__replace2">Test2</div>
        		<separator>
        		<div class="paste__replace3">Test3</div>
        	`);
        	for (var i = 1; i <= 3; i++) {
        		let block = paste.querySelector('.paste__replace' + i);
        		assert.equal(block.innerText == ('Test' + i), true, `Новый блок не вставлен!`);
        	}
        });
    });

    describe(`Проверяем метод moveTagsScript():`, function() {

        beforeEach(() => {
            paste = new Paste();
        });

        afterEach(() => {
            paste = null;
        });

        it(`В AJAX-запросе не содержатся теги '<script>'.`, function() {
            let html = '<div>Какой-то текст...</div>';
            let returnHtml = paste.moveTagsScript(html);
            assert.equal(html == returnHtml, true, `Метод вернул не верный html-код!`);
        });

        it(`Html-код содержит единственный тег '<script>'.`, function() {
            let html = '<script src="/mycomp/mycomp.js" type="module" id="testmycomp"></script>';
            html+= '<div>Какой-то текст...</div>';
            let resultHtml = paste.moveTagsScript(html);
            assert.equal(document.querySelector('#testmycomp') != null, true, `Тег "<script>" не добавлен!`);
            assert.equal(resultHtml == '<div>Какой-то текст...</div>', true, `Метод вернул не верный html-код!`);
            testmycomp.remove();
        });

        it(`Html-код содержит несколько тегов '<script>'.`, function() {
            let html = '';
            for (var i = 0; i < 3; i++) {
                html+= '<script src="/mycomp/mycomp' + i + '.js" type="module" id="testmycomp' + i + '"></script>';
            }
            html+= '<div>Какой-то текст...</div>';
            let resultHtml = paste.moveTagsScript(html);
            for (var i = 0; i < 3; i++) {
                let ts = document.querySelector('#testmycomp' + i);
                assert.equal(ts != null, true, `Тег "<script>" не добавлен!`);
                ts.remove();
            }
            assert.equal(resultHtml == '<div>Какой-то текст...</div>', true, `Метод вернул не верный html-код!`);
        });

        it(`Html-код содержит несколько тегов '<script>', но веб-компоненты уже присутствуют на странице.`, function() {
            class MyWebComponent1 extends HTMLElement {}
            class MyWebComponent2 extends HTMLElement {}
            class MyWebComponent3 extends HTMLElement {}
            for (var i = 0; i < 3; i++) {
                let myWebComp = document.createElement('wc-mycomp' + i);
                myWebComp.id = 'firstmywebcomp' + i;
                document.body.prepend(myWebComp);
                if (i==0) customElements.define('wc-mycomp' + i, MyWebComponent1);
                if (i==1) customElements.define('wc-mycomp' + i, MyWebComponent2);
                if (i==2) customElements.define('wc-mycomp' + i, MyWebComponent3);
                
            }
            let html = '';
            for (var i = 0; i < 3; i++) {
                html+= '<script src="/mycomp/mycomp' + i + '.js" type="module" id="testmycomp' + i + '"></script>';
            }
            html+= '<div>Какой-то текст...</div>';
            let resultHtml = paste.moveTagsScript(html);
            for (var i = 0; i < 3; i++) {
                let ts = document.querySelector('#testmycomp' + i);
                assert.equal(ts == null, true, `Тег "<script>" не должен быть добавлен!`);
                let tsWebComp = document.querySelector('#firstmywebcomp' + i);
                tsWebComp.remove();
            }
        });
    });

    describe(`Проверяем метод checkUrl():`, function() {

        beforeEach(() => {
            paste = new Paste();
        });

        afterEach(() => {
            paste = null;
        });

        it(`Установим в 'url' символ '#'.`, function() {
            assert.equal(paste.checkUrl() == 3, true, `Метод вернул не верный код!`);
        });

        it(`Установим в 'url' символ хеша и адрес.`, function() {
            paste.url = '#/myadress/myblock/';
            assert.equal(paste.checkUrl() == 1, true, `Метод вернул не верный код!`);
        });

        it(`Установим в 'url' случайный адрес.`, function() {
            paste.url = '/myadress/myblock/';
            assert.equal(paste.checkUrl() == 2, true, `Метод вернул не верный код!`);
        });
    });
});

/**
 * Запуск тестов.
 */
mocha.run();