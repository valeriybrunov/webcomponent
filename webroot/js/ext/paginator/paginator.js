/**
 * Расширяемый веб-компонент "Paginator". Открытая схема.
 */

import Paste from '../paste/paste.js';

/**
 * Класс Paginator.
 */
export default class Paginator extends Paste {

    /**
     * Конструктор.
     */
    constructor() {
        super();
        this.classList.add('paginator');
    }

    /**
     * Атрибут "eventnextPag".
     * 
     * @param string val
     * @return void
     */
    set eventnextpag(val) {
        this.setAttribute('eventnextpag', val);
    }
    get eventnextpag() {
        if (this.hasAttribute('eventnextpag')) {
            return this.getAttribute('eventnextpag');
        }
        else return Paginator.DEFAULT_EVENTNEXTPAG;
    }
    static get DEFAULT_EVENTNEXTPAG() {
        return 'click';
    }

    /**
     * Браузер вызывает этот метод при добавлении элемента в документ.
     * (может вызываться много раз, если элемент многократно добавляется/удаляется).
     */
    connectedCallback() {
        if (this.eventnextpag == 'click') {
            this.url = '#';
            let pasteClick = this.querySelector('.paste__click');
            pasteClick.addEventListener('click', (e) => this.transferUrl());
        }
        else if (this.eventnextpag == 'visibility') this.transferUrl('#');
        super.connectedCallback();
    }

    /**
     * Переносит значение скрытого поля в атрибут url.
     *
     * @param string simbol Символ, который будет установлен перед адресом в атрибуте url.
     * @return void
     */
    transferUrl(simbol = '') {
        this.mode = 'trubber';
        let input = this.querySelector('input[name="page"]');
        this.url = simbol + input.value;
    }

    /**
     * После вставки данных от AJAX-запроса переносит значение скрытого поля в атрибут url.
     *
     * @return void
     */
    success() {
        if (this.eventnextpag == 'visibility') this.transferUrl('#');
    }
}
