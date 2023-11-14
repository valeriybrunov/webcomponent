/**
 * Расширяемый веб-компонент "Paginator". Открытая схема.
 */

import Template from './template.js';
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
        this.insertAdjacentHTML('afterbegin', Template.render());
    }

    /**
     * Атрибут "nextPag".
     * 
     * @param string val
     * @return void
     */
    set nextpag(val) {
        this.setAttribute('nextpag', val);
    }
    get nextpag() {
        if (this.hasAttribute('nextpag')) {
            return this.getAttribute('nextpag');
        }
        else return Paginator.DEFAULT_NEXTPAG;
    }
    static get DEFAULT_NEXTPAG() {
        return 'button';
    }

    /**
     * Браузер вызывает этот метод при добавлении элемента в документ.
     * (может вызываться много раз, если элемент многократно добавляется/удаляется).
     */
    connectedCallback() {
        super.connectedCallback();
    }
}
