<?php
declare(strict_types=1);

namespace Webcomponent\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

/**
 * Webcomp helper
 */
class WebcompHelper extends Helper
{
    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = ['defaultView' => 'element'];
    
    /**
     * Имя веб-компонента.
     */
    protected $_name = false;

    /**
     * Имена подключаемых помошников.
     */
    public $helpers = ['Html'];

    /**
     * Настройка помошника.
     */
    public function initialize( array $config ): void
    {}

    /**
     * Сеттер установки имени веб-компонента.
     *
     * @param string|bool "Чистое" имя веб-компонента (не должно содержать имя плагина).
     */
    public function setName( $name ): void
    {
        $this->_name = $name;
    }

    /**
     * Метод "__call".
     *
     * Метод срабатывает при вызове не существующего метода.
     *
     * @param  string $name Имя веб-компонента из $this->Webcomp->имяВебКомпонента().
     * @param  array  $arr  Массив значений, переданных в веб-компонент.
     * @return string       Html-код веб-компонента.
     */
    public function __call($name, array $arr): string
    {
        return $this->Html->script( 'webcomp' . DS . $this->clearNameWebcomp($name) . DS . $this->clearNameWebcomp($name), ['block' => true, 'type' => 'module']) .
                '<' . ($arr[0]['tag'] ?? 'div') . '-' . $this->clearNameWebcomp( $name ) . $this->addAttr($arr) . '>' .
                $this->contentWebcomp(
                    $this->nameWebcomp($name),
                    $arr[0]['view'] ?? $this->getConfig('defaultView'),
                    $arr[0]['data'] ?? [],
                    $arr[0]['options'] ?? []
                ) . '</' . ($arr[0]['tag'] ?? 'div') . '-' . $this->clearNameWebcomp($name) . '>';
    }

    /**
     * Возвращает внутреннее содержимое веб-компонента.
     * 
     * @param  string $name    Имя веб-компонента.
     * @param  string $view    Вид: элемент, ячейка или пусто.
     * @param  array  $data    Данные для веб-компонента.
     * @param  array  $options Опции веб-компонента.
     * @return string          Html-код внутреннего содержимого веб-компонента.
     */
    public function contentWebcomp( $name, $view, $data, $options ): string
    {
        switch ( $view ) {
            case 'element':
                return $this->getView()->element( $this->urlLoad($name), $data, $options );
            case 'cell':
                return $this->getView()->cell( $this->urlLoad($name), $data, $options );
            case 'clear':
                return '';
        }
    }

    /**
     * Возвращает "правильное" имя веб-компонента для загрузки его из элемента, ячейки или плагина.
     *
     * @param  string $name Имя веб-компонента из $this->Webcomp->имяВебКомпонента().
     * @return string       Имя веб-компонента (все буквы в нижнем регистре без подчеркивания).
     */
    public function nameWebcomp( $name ): string
    {
        if ( mb_substr_count( $name, '_' ) == 1 ) {
            return ucfirst( strtolower( str_replace( '_', '.', $name ) ) );
        }

        return strtolower($name);
    }

    /**
     * Формирует url загрузки для элемента или ячейки.
     *
     * @param  string $name Имя веб-компонента.
     * @return string       Url загрузки элемента или ячейки.
     */
    public function urlLoad($name): string
    {
        if (mb_substr_count($name, '.')) {
            $url = str_replace('.', '.webcomp' . DS, $name);
        }
        else $url = 'webcomp' . DS . $name;

        return $url;
    }

    /**
     * Возвращает "очищенное" имя веб-компонента от имени плагина.
     *
     * @param  string $name Имя веб-компонента (может содержать имя плагина).
     * @return string       Имя веб-компонента, очищенное от имени плагина.
     */
    public function clearNameWebcomp( $name ): string
    {
        if ( $this->_name ) return $this->_name;

        if ( mb_substr_count($name, '_') == 1 ) {
            $str = explode('_', $name);
            $this->_name = $str[1];
        }
        else $this->_name = $name;

        return $this->_name;
    }

    /**
     * Превращает массив в строку "атрибут"="значение".
     *
     * @param  array $arr Массив "атрибут"=>"значение".
     * @return string     Строка "атрибут"="значение".
     */
    public function addAttr( $arr ): string
    {
        if ( isset($arr[0]['class']) ) {
            if ( is_array($arr[0]['class']) ) {
                array_push($arr[0]['class'], 'init ' . $this->_name);
            }
            elseif ( is_string($arr[0]['class']) ) {
                $arr[0]['class'] = 'init ' . $this->_name . ' ' . $arr[0]['class'];
            }
        }
        else $arr[0]['class'] = 'init ' . $this->_name;

        $skipVal = ['view', 'data', 'options'];// Значения не являющиеся атрибутами.

        $tagAttr = [];
        foreach ( $arr[0] as $key => $val ) {
            if ( !in_array($key, $skipVal) ) {
                $tagAttr[] = $key . '="' . $this->arrInString( $val ) . '"';
            }
        }

        return ' ' . implode(' ', $tagAttr);
    }

    /**
     * Значения массива преобразует в строку.
     * 
     * @param  array|string $arr Массив или строка значений.
     * @return string            Строка значений через пробел.
     */
    public function arrInString( $arr )
    {
        if ( is_array($arr) ) {
            return implode(' ', $arr);
        }
        if ( is_string($arr) ) {
            return $arr;
        }
    }
}
