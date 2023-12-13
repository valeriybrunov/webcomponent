/**
 * Шаблон для расширяемого компонента "paginator".
 */
export default {

    render( props ) {
        return `${this.css( props )}`;
    },

    /**
     * Перемещает стили в компонент.
     */
    css( p ) { return `
        <style>
            .progress__wrap {
                height: 5px;
            }
            .progress__bar {
                height: 100%;
                width: 0%;
                background-color: green;
            }
        </style>`;
    },

    /**
     * Кеширование элементов компонента не входящих в теневую модель.
     */
    mapDom( scope ) {
        return {
            tagProgressBar: scope.querySelector('.progress__bar'),
            head: document.getElementsByTagName('head')[0],
        }
    },
}