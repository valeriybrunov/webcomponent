/**
 * Шаблон для расширяемого компонента "paste".
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
            .paste__trubber,
            .paste__replace {
                display: none;
            }
            .paste_trubber .paste__trubber {
                display: block;
            }
            .paste_trubber .paste__replace {
                display: none;
            }
            .paste_replace .paste__trubber {
                display: none;
            }
            .paste_replace .paste__replace {
                display: block;
            }
        </style>`;
    },
}
