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
});

/**
 * Запуск тестов.
 */
mocha.run();