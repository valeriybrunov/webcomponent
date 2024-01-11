/**
 * Расширяемый веб-компонент "Progress".
 */

import Template from './template.js';
import Paste from '../paste/paste.js';

/**
 * Класс Progress.
 */
export default class Progress extends Paste {

    /**
     * Конструктор.
     */
    constructor() {
        super();
        this.classList.add('progress');
        this.insertAdjacentHTML('afterbegin', Template.render());
        this.dom = Template.mapDom(this);
    }

    /**
     * Сброс к первоначальным установкам.
     *
     * @return void
     */
    reset() {
        this.checkMode();
        this.totalLoad = 0;// Общее количество файлов, загрузку которых необходимо отследить.
        this.currentValue = 0;// Текущее значение прогресс-бара для отображения.
        this.valueSlow = 0;// Значение "медленного" прогресс-бара.
        this.valueFast = 0;// Значение "быстрого" прогресс-бара.
        this.limit = 0;// Динамически изменяемое значение в %, к которому должны стремиться
                       // достигнуть методы смещения прогресс-бара: fast() и slow().
        this.dom.tagProgressBar.setAttribute('style', `width:0%`);
    }

    /**
     * Удлиняет прогресс-бар на 1 пиксель.
     *
     * @return void
     */
    moveProgressBar() {
        this.currentValue = Math.max(this.valueSlow, this.valueFast);
        this.dom.tagProgressBar.setAttribute('style', `width:${this.currentValue}%`);
        if (this.currentValue == 100) this.reset();
    }

    /**
     * "Медленно" удлиняет прогресс-бар на 1 пиксель.
     *
     * Время, заложенное для удлинения "медленного" прогресс-бара, должно быть сопоставимо
     * с максимальным временем отдачи сервером страницы, по окончанию которого показывается
     * ошибка 404 (страница недоступна).
     *
     * @return void
     */
    slow() {
        if (this.valueSlow < 100) this.valueSlow++;
        this.moveProgressBar();
        if (this.valueSlow == 100) {
            // Указать, что страница не загрузилась!!!
            return;
        }
        if (this.currentValue >= 50) this.calculatingLimit();
        if (this.valueSlow < 100 && this.currentValue < 100) setTimeout(this.slow, 30);
    }

    /**
     * "Быстро" удлиняет прогресс-бар на 1 пиксель.
     *
     * @return void
     */
    fast() {
        if (this.valueFast < 100) {
            if (this.valueFast < this.limit) this.valueFast++;
        }
        this.moveProgressBar();
        if (this.valueFast < 100 && this.currentValue < 100) setTimeout(this.fast, 5);
    }

    /**
     * Расчитывет значение this.limit - процент загрузки страницы.
     *
     * @return void
     */
    calculatingLimit() {
        let notLoadJs = this.dom.head.querySelectorAll('script[loadfile=\"0\"]');
        let notLoadImg = this.querySelectorAll('img[loadfile=\"0\"]');
        let notLoad = notLoadJs.length + notLoadImg.length;
        let countLoad = this.totalLoad - notLoad;
        if (countLoad == this.totalLoad) this.limit = 100;
        else {
            this.limit = Math.floor((50/this.totalLoad)*countLoad + 50);
        }
    }

    /**
     * Вставляет необходимые атрибуты в теги '<img>' и '<script>'.
     *
     * @param string html Html-код, полученный от AJAX-запроса.
     * @return string Строка с добавленными атрибутами.
     */
    before(html) {
        const replaceScript = '<script loadfile="0" onload="this.setAttribute(\'loadfile\', \'1\')"';
        const replaceImg = '<img loadfile="0" onload="this.setAttribute(\'loadfile\', \'1\')"';
        html = html.replaceAll('<script', replaceScript);
        html = html.replaceAll('<img', replaceImg);
        this.totalLoad = html.split(replaceScript).length + html.split(replaceImg).length - 2;
        return html;
    }

    /**
     * AJAX-запрос.
     *
     * @return void
     */
    query() {
        if (this.checkUrl() == 1 || this.checkUrl() == 3) return;
        let self = this;
        Ajax.connect({
            url: self.url,
            beforeSend: function() {
                self.slow();
            },
            success: function(html) {
                this.limit = 50;
                self.fast();
                self.replaceHTML(
                    self.moveTagsScript(
                        self.before(html)
                    )
                )
            },
            error: function(status, statusText) {},
            errorConnect: function() {},
        });
    }
}
