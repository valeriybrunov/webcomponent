/**
 * Импортируем основные файлы веб-компонента для тестирования.
 */
import Paginator from './paginator.js';

/**
 * Определяем Paginator, как пользовательский элемент.
 */
customElements.define("wc-paginator", Paginator);

/**
 * Настраиваем библиотеки для тестирования.
 */
mocha.setup( 'bdd' );
var assert = chai.assert;
var expect = chai.expect;

var paginator;

/**
 * Тесты.
 */
describe("Тест расширяемого вэб-компонента Paginator.", function() {

    describe(`Проверяем метод transferUrl():`, function() {

    	beforeEach(() => {
    		paginator = new Paginator();
    	});

        afterEach(() => {
        	paginator = null;
        });

        it(`Перенос адреса из скрытого поля в атрибут 'url'.`, function() {
        	let stringTest = "/my/test/3?page=7";
        	paginator.insertAdjacentHTML('beforeend', `
        		<div class="paste__replace">
        			<input type="hidden" name="page" value="${stringTest}">
        		</div>
        	`);
        	paginator.transferUrl();
        	assert.equal(stringTest == paginator.url, true, `Значение 'url' и скрытого поля не совпадают!`);
        });

        it(`Перенос адреса из скрытого поля в атрибут 'url' с подстановкой хеша.`, function() {
        	let stringTest = "/my/test/3?page=7";
        	paginator.insertAdjacentHTML('beforeend', `
        		<div class="paste__replace">
        			<input type="hidden" name="page" value="${stringTest}">
        		</div>
        	`);
        	paginator.transferUrl('#');
        	assert.equal('#' + stringTest == paginator.url, true, `Значение 'url' и скрытого поля не совпадают!`);
        });

    });

    describe(`Проверяем метод clearElements():`, function() {

    	beforeEach(() => {
    		paginator = new Paginator();
    	});

        afterEach(() => {
        	paginator = null;
        });

        it(`Скрытое поле присутствует.`, function() {
        	paginator.insertAdjacentHTML('beforeend', `
        		<div class="paste__replace">
        			<input type="hidden" name="page" value="">
        		</div>
        		<div class="paste__click paginator__click button">
    				<div class="text">Смотреть ещё...</div>
				</div>
				<div class="paste__trubber">мой труббер</div>
        	`);
        	paginator.clearElements();
        	let input = paginator.querySelector('input[name="page"]');
        	let replace = paginator.querySelector('.paste__replace');
            let click = paginator.querySelector('.paste__click');
            let trubber = paginator.querySelector('.paste__trubber');
            assert.equal(input != null, true, `Скрытое поле отсутствует!`);
        	assert.equal(replace != null, true, `Элемент с классом replace отсутствует!`);
        	assert.equal(click != null, true, `Элемент с классом click отсутствует!`);
        	assert.equal(trubber != null, true, `Элемент с классом trubber отсутствует!`);
        });

        it(`Скрытое поле отсутствует.`, function() {
        	paginator.insertAdjacentHTML('beforeend', `
        		<div class="paste__replace"></div>
        		<div class="paste__click paginator__click button">
    				<div class="text">Смотреть ещё...</div>
				</div>
				<div class="paste__trubber">мой труббер</div>
        	`);
        	paginator.clearElements();
        	let input = paginator.querySelector('input[name="page"]');
        	let replace = paginator.querySelector('.paste__replace');
            let click = paginator.querySelector('.paste__click');
            let trubber = paginator.querySelector('.paste__trubber');
            assert.equal(input == null, true, `Скрытое поле присутствует!`);
        	assert.equal(replace == null, true, `Элемент с классом replace присутствует!`);
        	assert.equal(click == null, true, `Элемент с классом click присутствует!`);
        	assert.equal(trubber == null, true, `Элемент с классом trubber присутствует!`);
        });
    });
});

/**
 * Запуск тестов.
 */
mocha.run();