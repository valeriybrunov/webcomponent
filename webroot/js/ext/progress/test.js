/**
 * Импортируем основные файлы веб-компонента для тестирования.
 */
import Progress from './progress.js';

/**
 * Определяем Paginator, как пользовательский элемент.
 */
customElements.define("wc-progress", Progress);

/**
 * Настраиваем библиотеки для тестирования.
 */
mocha.setup( 'bdd' );
var assert = chai.assert;
var expect = chai.expect;

var progress;

/**
 * Тесты.
 */
describe("Тест расширяемого вэб-компонента Progress.", function() {

    describe(`Проверяем метод before():`, function() {

    	beforeEach(() => {
    		progress = new Progress();
    	});

        afterEach(() => {
        	progress = null;
        });

        it(`Вставка атрибутов 'loadfile' и 'onload' в тег '<script>'.`, function() {
            let html = `
                <script type="text/javascript" src="/ffff/fffff"></script>
                <div>errereyery</div>
                <div>wywgrgergetg</div>
            `;
            progress.before(html);
            assert.equal(progress.totalLoad == 1, true, `Добавление атрибутов не произошло!`);
        });

        it(`Вставка атрибутов 'loadfile' и 'onload' в тег '<img>'.`, function() {
            let html = `
                <div>errereyery</div>
                <img src="/ffff/ffff/fffff">
                <div>wywgrgergetg</div>
            `;
            progress.before(html);
            assert.equal(progress.totalLoad == 1, true, `Добавление атрибутов не произошло!`);
        });

        it(`Вставка атрибутов 'loadfile' и 'onload' в теги '<img>' и '<script>'.`, function() {
            let html = `
                <script type="text/javascript" src="/ffff/fffff"></script>
                <div>errereyery</div>
                <img src="/ffff/ffff/fffff">
                <div>wywgrgergetg</div>
            `;
            progress.before(html);
            assert.equal(progress.totalLoad == 2, true, `Добавление атрибутов не произошло!`);
        });

        it(`Вставка атрибутов 'loadfile' и 'onload' в теги '<img>' и '<script>' в произвольном кол-ве.`, function() {
            let html = '';
            let rnd1 = Math.floor(Math.random()*(10 - 3) + 3);
            for (var i = 0; i < rnd1; i++) {
                html = html + `<script type="text/javascript" src="/ffff/fffff"></script>`;
            }
            let rnd2 = Math.floor(Math.random()*(10 - 3) + 3);
            for (var i = 0; i < rnd2; i++) {
                html = html + `<div>wywgrgergetg</div><img src="/ffff/ffff/fffff"><div>wywgrgergetg</div>`;
            }
            progress.before(html);
            assert.equal(progress.totalLoad == rnd1 + rnd2, true, `Добавление атрибутов не произошло!`);
        });
    });
});

/**
 * Запуск тестов.
 */
mocha.run();