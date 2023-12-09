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
        this.insertAdjacentHTML( 'afterbegin', Template.render() );
        this.cashe = this.casheValue();
    }

    /**
     * Кеширование значений или объектов.
     */
    casheValue() {
        return {
            head: document.getElementsByTagName('head')[0],
        }
    }

    /**
     * Сброс к первоначальным установкам.
     *
     * @return void
     */
    reset() {
        this.currentValue = 0;// Текущее значение прогресс-бара для отображения.
        this.valueSlow = 0;// Значение "медленного" прогресс-бара.
        this.valueFast = 0;// Значение "быстрого" прогресс-бара.
        this.limit = 0;
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
        this.moveProgress();
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
        this.moveProgress();
        if (this.valueFast < 100 && this.currentValue < 100) setTimeout(this.fast, 5);
    }

    /**
     * AJAX-запрос.
     *
     * @return void
     */
    before(html) {
        const replaceScript = '<script loadfile="0" onload="this.setAttribute(\'loadfile\', \'1\')"';
        const replaceImg = '<img loadfile="0" onload="this.setAttribute(\'loadfile\', \'1\')"';
        html = html.replaceAll('<script', replaceScript);
        html = html.replaceAll('<img', replaceImg);
        this.totalLoad = html.split(replaceScript).length + html.split(replaceImg).length - 2;
        return html;
    }
}
