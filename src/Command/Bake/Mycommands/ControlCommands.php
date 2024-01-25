<?php
declare(strict_types=1);

namespace Webcomponent\Command\Bake\Mycommands;

use Webcomponent\Command\Bake\NewfileCommand;

/**
 * Методы для создания файлов из команд в терминале.
 */
class ControlCommands
{
    /**
     * Проверяет наличие файлов в директории.
     *
     * Предотвращает повторную установку веб-компонентов  библиотек.
     *
     * @param string    $name     Имя веб-компонента.
     * @param string    $basePath Путь до проверяемого файла.
     * @param ConsoleIo $io
     * @return bool
     */
    private function mySelf( $name, $basePath, $io ): bool
    {
        if ( isset($this->$name) ) return true;

        if ( file_exists( ROOT . DS . $basePath ) ) {
            $io->setStyle( 'greentext', ['text' => 'green'] );
            $io->setStyle( 'boldik', ['text' => 'green', 'bold' => true] );
            $io->out( '<greentext>' . $this->depenText . $name . ' уже установлен(а) в приложение.</greentext>' );
            $this->$name = true;
            return true;
        }

        return false;
    }

    /**
     * Создаёт новые файлы из шаблонов.
     *
     * @param string    $name             Имя веб-компонента, файлы которого необходимо создать.
     * @param array     $nameTemplateFile Многомерный массив имён шаблонов.
     * @param array     $nameCreateFile   Многомерный массив с перечнем имён файлов, включая расширения
     *                                    файлов, которые необходимо создать.
     * @param array     $dir              Одномерный массив, содержащий директории, в которых нужно создать файлы
     *                                    с именами из массива $nameCreateFile.
     * @param ConsoleIo $io
     * @param bool      $plugin           Создать веб-компонент в плагине или в базовом месте.
     * @return void
     */
    public function createFiles( $name, $nameTemplateFile, $nameCreateFile, $dir, $io, $plugin ): void
    {
        $newFile = new NewfileCommand();

        foreach ($dir as $key => $value) {

            if ( $plugin ) $path = '..' . DS . 'plugins' . DS . ucfirst($name) . DS;
            else $path = '..' . DS;

            $newFile->pathFragment = $path . $value;

            if ( is_array( $nameTemplateFile[$key] ) ) {
                foreach ( $nameTemplateFile[$key] as $key2 => $value2 ) {
                    $newFile->nameTemplateReader = $value2;
                    $newFile->templateName = 'Webcomponent.' . $value2 . 'Template';
                    $newFile->fileNameSave = $nameCreateFile[$key][$key2];
                    if ( !$this->mySelf( $name, $value . $newFile->fileNameSave, $io ) ) {
                        $newFile->executeCommand( $newFile, [$name] );
                    }
                }
            }

            if ( is_string( $nameTemplateFile[$key] ) ) {
                $newFile->nameTemplateReader = $nameTemplateFile[$key];
                $newFile->templateName = 'Webcomponent.' . $nameTemplateFile[$key] . 'Template';
                $newFile->fileNameSave = $nameCreateFile[$key];
                if ( !$this->mySelf( $name, $value . $newFile->fileNameSave, $io ) ) {
                    $newFile->executeCommand( $newFile, [$name] );
                }
            }
        }
    }

    /**
     * Выводит в терминал сообщение, если зависимость удовлетворена.
     *
     * @param string    $name Имя веб-компонента.
     * @param string    $text Текст, который будет выделен зелёным цветом.
     * @param ConsoleIo $io
     * @return void
     */
    public function depenMethod( $name, $text, $io ): void
    {
        $io->setStyle( 'greentext', ['text' => 'green'] );
        $io->setStyle( 'boldik', ['text' => 'green', 'bold' => true] );
        $io->out( "<greentext>" . $text . " </greentext><boldik>" . ucfirst($name) . "</boldik>" );
    }

    /**
     * Выводит в терминал сообщение, если файлы успешно созданы.
     *
     * @param string    $name Имя веб-компонента.
     * @param string    $text Текст, который будет выделен зелёным цветом.
     * @param ConsoleIo $io
     * @return void
     */
    public function depenBasicMethod( $name, $text, $io ): void
    {
        $io->setStyle( 'greentext', ['text' => 'green'] );
        $io->setStyle( 'boldik', ['text' => 'green', 'bold' => true] );
        $io->hr();
        $io->out( "<greentext>" . $text . " </greentext><boldik>" . ucfirst($name) . "</boldik>" );
        $io->hr();
    }

    /**
     * Выводит в терминал сообщение, если такого расширяемого веб-компонента или библиотеки не существует.
     *
     * @param string    $text Текст, который будет выделен зелёным цветом.
     * @param ConsoleIo $io
     * @return void
     */
    public function actionError( $text, $io ): void
    {
        $io->setStyle( 'redtext', ['text' => 'red'] );
        $io->out( "<redtext>" . $text . "</redtext>" );
    }
}
