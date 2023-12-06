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

        
    });
});

/**
 * Запуск тестов.
 */
mocha.run();