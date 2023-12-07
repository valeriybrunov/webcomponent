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
        this.init = 0;// Указывает на первоначальную загрузку.
    }

    /**
     * Браузер вызывает этот метод при добавлении элемента в документ.
     * (может вызываться много раз, если элемент многократно добавляется/удаляется).
     */
    //connectedCallback() {
        //super.connectedCallback();
    //}

    /**
     * Следим за изменениями этих атрибутов и отвечаем соответственно.
     *
     * @param string name Имя атрибута, в котором произошли изменения.
     * @param string oldVal Старое значение атрибута, т.е. до его изменения.
     * @param string newVal Новое значение атрибута.
     * @return void
     *
     * !!! При первой загрузке страницы, если атрибуты установлены в веб-компоненте, происходит
     *     срабатывание данной функции, при этом "oldVal=null", а "newVal" будет равно значению,
     *     установленному в веб-компоненте.
     */
    attributeChangedCallback(name, oldVal, newVal) {
        if ( oldVal ) {
            switch ( name ) {// При обновление значений.
                case 'url':// Для атрибута 'url'.
                    this.init = 1;// Указывает на изменения атрибута "url".
                    break;
            }
        }
        super.attributeChangedCallback(name, oldVal, newVal);
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
    query() {
        if (this.checkUrl() == 1 || this.checkUrl() == 3) return;
        let self = this;
        Ajax.connect({
            url: self.url,
            success: function(html) {
                if (self.init == 0) self.initDownload();
                if (self.init == 1) self.nextDownload();
            },
            error: function(status, statusText) {},
            errorConnect: function() {},
        });
    }

    /**
     * При первоначальной загрузке страницы.
     *
     * @return void
     */
    initDownload() {
        this.success(
            this.timer(
                this.resetTimerId(
                    this.checkMode(
                        this.replaceHTML(
                            this.moveTagsScript(html)
                        )
                    )
                )
            )
        );
    }

    /**
     *
     */
    nextDownload() {

    }
}
