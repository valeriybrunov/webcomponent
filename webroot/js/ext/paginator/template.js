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
            .paginator_click .paginator__click {
                display: none;
            }
        </style>`;
    },
}