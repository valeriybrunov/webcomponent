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

    describe(`Проверяем метод calculatingLimit():`, function() {

        beforeEach(() => {
            progress = new Progress();
        });

        afterEach(() => {
            progress = null;
        });

        it(`Имитируем поочерёдность загрузки файлов.`, function() {
            progress.limit = 0;
            let prevProgressBarValue = 50;
            let head = document.getElementsByTagName('head')[0];
            let scripts = 2;
            let imgs = 5;
            progress.totalLoad = scripts + imgs;
            for (var i = 0; i < scripts; i++) {
                let script = document.createElement('script');
                script.src = '#';
                script.type = 'text/javascript';
                script.setAttribute('loadfile', '0');
                head.append(script);
            }
            for (var i = 0; i < imgs; i++) {
                let img = document.createElement('img');
                img.src = '#';
                img.setAttribute('loadfile', '0');
                progress.append(img);
            }
            for (var i = 0; i < imgs; i++) {
                let image = progress.querySelector('img[loadfile="0"]');
                if (image) {
                    image.setAttribute('loadfile', '1');
                    progress.calculatingLimit();
                    assert.equal(progress.limit > prevProgressBarValue, true, `Неправильный подсчёт тегов img!`);
                    prevProgressBarValue = progress.limit;
                }
            }
            for (var i = 0; i < scripts; i++) {
                let src = head.querySelector('script[loadfile="0"]');
                if (src) {
                    src.setAttribute('loadfile', '1');
                    progress.calculatingLimit();
                    assert.equal(progress.limit > prevProgressBarValue, true, `Неправильный подсчёт тегов script!`);
                    prevProgressBarValue = progress.limit;
                }
            }
        });
    });

    describe(`Проверяем метод slow():`, function() {

        beforeEach(() => {
            progress = new Progress();
        });

        afterEach(() => {
            progress = null;
        });

        it(`Прогоняем метод slow().`, function() {
            let html = '<div class="progress__bar"></div>';
            progress.insertAdjacentHTML('beforeend', `<div class="progress__bar"></div>`);
            progress.dom.tagProgressBar = progress.querySelector('.progress__bar');
            progress.reset();
            sinon.stub(progress, 'reset').callsFake(function myReset() {
                assert.equal(progress.currentValue == 100, true, `Нет достижения 100%!`);
            });
            sinon.stub(progress, 'calculatingLimit').callsFake(function myCalLimit() {
                return;
            });
            let clock = sinon.useFakeTimers({toFake:["setTimeout"]});
            sinon.stub(clock, 'setTimeout').callsFake(function myTime() {
                progress.slow();
            });
            progress.slow();
        });
    });

    describe(`Проверяем метод fast():`, function() {
    
        beforeEach(() => {
            progress = new Progress();
        });
    
        afterEach(() => {
            progress = null;
        });

        it(`Прогоняем метод fast().`, function() {
            let html = '<div class="progress__bar"></div>';
            progress.insertAdjacentHTML('beforeend', `<div class="progress__bar"></div>`);
            progress.dom.tagProgressBar = progress.querySelector('.progress__bar');
            progress.reset();
            sinon.stub(progress, 'reset').callsFake(function myReset() {
                assert.equal(progress.currentValue == 100, true, `Нет достижения 100%!`);
            });
            let clock = sinon.useFakeTimers({toFake:["setTimeout"]});
            sinon.stub(clock, 'setTimeout').callsFake(function myTime() {
                progress.fast();
            });
            
        });
    });
});

/**
 * Запуск тестов.
 */
mocha.run();
