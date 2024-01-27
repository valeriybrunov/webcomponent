<?php
declare(strict_types=1);

namespace Webcomponent\Command\Bake\Mycommands;

use Webcomponent\Command\Bake\Mycommands\ControlСommands;

/**
 * Класс содержит методы команд.
 *
 * Каждый метод должен начинаться с "wc", далее с большой буквы идёт имя базовой опции.
 */
class MyCommands extends ControlCommands
{
    /**
     * Текст зависимости.
     */
    public $depenText = '';

    /**
     * Создать файлы веб-компонента.
     *
     * @param string    $name   Имя веб-компонента.
     * @param bool      $close  Применить закрытую схему для true.
     * @param bool      $plugin Создать файлы веб-компонента в плагине для true.
     * @param ConsoleIo $io
     * @param bool      $depen  Указывает, что веб-компонент является зависимостью для true.
     * @return void
     */
    public function wc( $name, $close, $plugin, $io, $depen = false ): void
    {
        $this->depenText = '-->Веб-компонент ';// ...уже установлен(а) в приложение.

        $this->createFiles( $name,
            [// Названия шаблонов для создания файлов.
                ['basic', 'template', 'test'], 'element',
            ],
            [// Названия создаваемых файлов.
                [$name.'.js', 'template.js', 'test.js'], $name.'.php',
            ],
            [// Директории, где будут созданы файлы.
                'webroot' . DS . 'js' . DS . 'webcomp' . DS . $name . DS,
                'templates' . DS . 'element' . DS . 'webcomp' . DS,
            ],
            $io,
            $plugin,
        );

        if ( isset($this->$name) ) return;

        if ( $depen ) {// Текст, который выведется в терминал, если этот метод является зависимостью.
            
        }
        else {// Текст, который выведется в терминал, если это основной метод, а остальные - зависимости.
            $this->depenBasicMethod( $name, 'Созданы файлы веб-компонента', $io );
        }
    }

    /**
     * Создать файлы библиотеки.
     *
     * @param string    $name   Имя веб-компонента.
     * @param bool      $close  Применить закрытую схему для true.
     * @param bool      $plugin Создать файлы веб-компонента в плагине для true.
     * @param ConsoleIo $io
     * @param bool      $depen  Указывает, что веб-компонент является зависимостью для true.
     * @return void
     */
    public function wcAddlib( $name, $close, $plugin, $io, $depen = false ): void
    {
        switch ($name) {
            case 'ajax':
                $this->depenText = '-->Библиотека ';// ...уже установлен(а) в приложение.
                
                $this->createFiles( $name,
                    [// Названия шаблонов для создания файлов.
                        ['libajax'],
                    ],
                    [// Названия создаваемых файлов.
                        ['ajax.js'],
                    ],
                    [// Директории, где будут созданы файлы.
                        'webroot' . DS . 'js' . DS . 'webcomp' . DS . 'lib' . DS,
                    ],
                    $io,
                    $plugin,
                );

                if ( isset($this->$name) ) return;

                if ( $depen ) {// Текст, который выведется в терминал, если этот метод является зависимостью.
                    $this->depenMethod( $name, 'Зависимость-->Созданы файлы библиотеки', $io );
                }
                else {// Текст, который выведется в терминал, если это основной метод, а остальные - зависимости.
                    $this->depenBasicMethod( $name, 'Созданы файлы библиотеки', $io );
                }
                break;

            default:

                $this->actionError( "Библиотеки с именем " . $name . " не существует!", $io );
        }
    }

    /**
     * Создать веб-компонент с наследованием от расширяемого веб-компонента.
     *
     * @param string    $name   Имя веб-компонента.
     * @param string    $name2  Имя веб-компонента, от которого осуществляется наследование.
     * @param bool      $close  Применить закрытую схему для true.
     * @param bool      $plugin Создать файлы веб-компонента в плагине для true.
     * @param ConsoleIo $io
     * @param bool      $depen  Указывает, что веб-компонент является зависимостью для true.
     * @return void
     */
    public function wcExtends( $name, $name2, $close, $plugin, $io, $depen = false ): void
    {
        switch ($name2) {

            case 'paste':
                $this->wcAddextends( 'paste', $close, $plugin, $io, true );// Устанавливаем зависимости.

                $this->depenText = '-->Веб-компонент ';// ...уже установлен(а) в приложение.

                $this->createFiles( $name,
                    [// Названия шаблонов для создания файлов.
                        ['basicextpaste', 'template', 'test'], 'element',
                    ],
                    [// Названия создаваемых файлов.
                        [$name.'.js', 'template.js', 'test.js'], $name.'.php',
                    ],
                    [// Директории, где будут созданы файлы.
                        'webroot' . DS . 'js' . DS . 'webcomp' . DS . $name . DS,
                        'templates' . DS . 'element' . DS . 'webcomp' . DS,
                    ],
                    $io,
                    $plugin,
                );

                if ( isset($this->$name) ) return;

                if ( $depen ) {// Текст, который выведется в терминал, если этот метод является зависимостью.
                    $this->depenMethod( $name, 'Зависимость-->Созданы файлы веб-компонента с наследованием от Pаste', $io );
                }
                else {// Текст, который выведется в терминал, если это основной метод, а остальные - зависимости.
                    $this->depenBasicMethod( $name, 'Созданы файлы веб-компонента с наследованием от Pаste - ', $io );
                }
                break;

            case 'paginator':
                $this->wcAddextends( 'paginator', $close, $plugin, $io, true );// Устанавливаем зависимости.

                $this->depenText = '-->Веб-компонент ';// ...уже установлен(а) в приложение.

                $this->createFiles( $name,
                    [// Названия шаблонов для создания файлов.
                        ['basicextpaginator', 'template', 'test'], 'element',
                    ],
                    [// Названия создаваемых файлов.
                        [$name.'.js', 'template.js', 'test.js'], $name.'.php',
                    ],
                    [// Директории, где будут созданы файлы.
                        'webroot' . DS . 'js' . DS . 'webcomp' . DS . $name . DS,
                        'templates' . DS . 'element' . DS . 'webcomp' . DS,
                    ],
                    $io,
                    $plugin,
                );

                if ( isset($this->$name) ) return;

                if ( $depen ) {// Текст, который выведется в терминал, если этот метод является зависимостью.
                    $this->depenMethod( $name, 'Зависимость-->Созданы файлы веб-компонента с наследованием от Pаginator', $io );
                }
                else {// Текст, который выведется в терминал, если это основной метод, а остальные - зависимости.
                    $this->depenBasicMethod( $name, 'Созданы файлы веб-компонента с наследованием от Paginator - ', $io );
                }
                break;

            case 'progress':
                $this->wcAddextends( 'progress', $close, $plugin, $io, true );// Устанавливаем зависимости.

                $this->depenText = '-->Веб-компонент ';// ...уже установлен(а) в приложение.

                $this->createFiles( $name,
                    [// Названия шаблонов для создания файлов.
                        ['basicextprogress', 'template', 'test'], 'element',
                    ],
                    [// Названия создаваемых файлов.
                        [$name.'.js', 'template.js', 'test.js'], $name.'.php',
                    ],
                    [// Директории, где будут созданы файлы.
                        'webroot' . DS . 'js' . DS . 'webcomp' . DS . $name . DS,
                        'templates' . DS . 'element' . DS . 'webcomp' . DS,
                    ],
                    $io,
                    $plugin,
                );

                if ( isset($this->$name) ) return;

                if ( $depen ) {// Текст, который выведется в терминал, если этот метод является зависимостью.
                    $this->depenMethod( $name, 'Зависимость-->Созданы файлы веб-компонента с наследованием от Progress', $io );
                }
                else {// Текст, который выведется в терминал, если это основной метод, а остальные - зависимости.
                    $this->depenBasicMethod( $name, 'Созданы файлы веб-компонента с наследованием от Progress - ', $io );
                }
                break;

            default:

                $this->actionError( "Унаследоваться от веб-компонента с именем " . $name2 . " не возможно. Такого расширяемого веб-компонента не существует!", $io );
        }
        
    }

    /**
     * Создать расширяемый веб-компонент.
     *
     * @param string    $name   Имя веб-компонента.
     * @param bool      $close  Применить закрытую схему для true.
     * @param bool      $plugin Создать файлы веб-компонента в плагине для true.
     * @param ConsoleIo $io
     * @param bool      $depen  Указывает, что веб-компонент является зависимостью для true.
     * @return void
     */
    public function wcAddextends( $name, $close, $plugin, $io, $depen = false ): void
    {
        switch ($name) {

            case 'paste':
                $this->wcAddlib( 'ajax', $close, $plugin, $io, true );// Устанавливаем зависимости.

                $this->depenText = '-->Расширяемый веб-компонент ';// ...уже установлен(а) в приложение.

                $this->createFiles( $name,
                    [// Названия шаблонов для создания файлов.
                        ['extpaste', 'extpastetemplate', 'extpastetest'],
                    ],
                    [// Названия создаваемых файлов.
                        ['paste.js', 'template.js', 'test.js'],
                    ],
                    [// Директории, где будут созданы файлы.
                        'webroot' . DS . 'js' . DS . 'webcomp' . DS . 'ext' . DS . 'paste' . DS,
                    ],
                    $io,
                    $plugin,
                );

                if ( isset($this->$name) ) return;

                if ( $depen ) {// Текст, который выведется в терминал, если этот метод является зависимостью.
                    $this->depenMethod( $name, 'Зависимость-->Созданы файлы расширяемого веб-компонента', $io );
                }
                else {// Текст, который выведется в терминал, если это основной метод, а остальные - зависимости.
                    $this->depenBasicMethod( $name, 'Созданы файлы расширяемого веб-компонента', $io );
                }
                break;

            case 'paginator':
                $this->wcAddextends( 'paste', $close, $plugin, $io, true );// Устанавливаем зависимости.

                $this->depenText = '-->Расширяемый веб-компонент ';// ...уже установлен(а) в приложение.

                $this->createFiles( $name,
                    [// Названия шаблонов для создания файлов.
                        ['extpaginator', 'extpaginatortemplate', 'extpaginatortest'],
                    ],
                    [// Названия создаваемых файлов.
                        ['paginator.js', 'template.js', 'test.js'],
                    ],
                    [// Директории, где будут созданы файлы.
                        'webroot' . DS . 'js' . DS . 'webcomp' . DS . 'ext' . DS . 'paginator' . DS,
                    ],
                    $io,
                    $plugin,
                );

                if ( isset($this->$name) ) return;

                if ( $depen ) {// Текст, который выведется в терминал, если этот метод является зависимостью.
                    $this->depenMethod( $name, 'Зависимость-->Созданы файлы расширяемого веб-компонента', $io );
                }
                else {// Текст, который выведется в терминал, если это основной метод, а остальные - зависимости.
                    $this->depenBasicMethod( $name, 'Созданы файлы расширяемого веб-компонента', $io );
                }
                break;

            case 'progress':
                $this->wcAddextends( 'paste', $close, $plugin, $io, true );// Устанавливаем зависимости.

                $this->depenText = '-->Расширяемый веб-компонент ';// ...уже установлен(а) в приложение.

                $this->createFiles( $name,
                    [// Названия шаблонов для создания файлов.
                        ['extprogress', 'extprogresstemplate', 'extprogresstest'],
                    ],
                    [// Названия создаваемых файлов.
                        ['progress.js', 'template.js', 'test.js'],
                    ],
                    [// Директории, где будут созданы файлы.
                        'webroot' . DS . 'js' . DS . 'webcomp' . DS . 'ext' . DS . 'progress' . DS,
                    ],
                    $io,
                    $plugin,
                );

                if ( isset($this->$name) ) return;

                if ( $depen ) {// Текст, который выведется в терминал, если этот метод является зависимостью.
                    $this->depenMethod( $name, 'Зависимость-->Созданы файлы расширяемого веб-компонента', $io );
                }
                else {// Текст, который выведется в терминал, если это основной метод, а остальные - зависимости.
                    $this->depenBasicMethod( $name, 'Созданы файлы расширяемого веб-компонента', $io );
                }
                break;

            default:

                $this->actionError( "Расширяемого веб-компонента с именем " . $name . " не существует!", $io );
        }
    }

    /**
     * Создать веб-компонент с ajax-пагинацией.
     *
     * @param string    $name   Имя веб-компонента.
     * @param bool      $close  Применить закрытую схему для true.
     * @param bool      $plugin Создать файлы веб-компонента в плагине для true.
     * @param ConsoleIo $io
     * @param bool      $depen  Указывает, что веб-компонент является зависимостью для true.
     * @return void
     */
    public function wcList( $name, $close, $plugin, $io, $depen = false ): void
    {
        $this->depenText = '-->Веб-компонент ';// ...уже установлен(а) в приложение.

        $this->createFiles( $name,
            [// Названия шаблонов для создания файлов.
                ['basic', 'template', 'test'], 'elementlist', 'elementajax'
            ],
            [// Названия создаваемых файлов.
                [$name.'.js', 'template.js', 'test.js'], $name.'.php', $name.'.php',
            ],
            [// Директории, где будут созданы файлы.
                'webroot' . DS . 'js' . DS . 'webcomp' . DS . $name . DS,
                'templates' . DS . 'element' . DS . 'webcomp' . DS,
                'templates' . DS . 'element' . DS . 'webcomp' . DS . 'ajax' . DS,
            ],
            $io,
            $plugin,
        );

        if ( isset($this->$name) ) return;

        if ( $depen ) {// Текст, который выведется в терминал, если этот метод является зависимостью.
            $this->depenMethod( $name, 'Зависимость-->Созданы файлы веб-компонента, содержащий пагинацию (листинг)', $io );
        }
        else {// Текст, который выведется в терминал, если это основной метод, а остальные - зависимости.
            $this->depenBasicMethod( $name, 'Создан веб-компонент, содержащий пагинацию (листинг)', $io );
            $io->out( '<greentext>Не забудьте в конце действия контроллёра вставить код:</greentext>' );
            $io->out( "<greentext>if (\$this->request->is('ajax')) return \$this->render('/element/webcomp/ajax/" . $name . "');</greentext>" );
        }
    }
}
