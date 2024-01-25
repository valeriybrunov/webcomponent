<?php
declare(strict_types=1);

namespace Webcomponent\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Core\Plugin;

use Webcomponent\Command\Bake\Mycommands\MyCommands;

/**
 * Webcomp command.
 */
class WebcompCommand extends Command
{
    /**
     * Описание.
     */
    public static function getDescription(): string
    {
        return 'Создавайте заполняемые шаблоны веб-компонентов при помощи команд в консоли.';
    }

    /**
     * Парсер.
     */
    protected function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        /***************************************************************
         *                      Аргументы.
         ***************************************************************/

        $parser->addArgument('name', [
            'help' => 'Имя веб-компонента.',
        ]);

        $parser->addArgument('name2', [
            'help' => 'Имя второго веб-компонента.',
        ]);

        /***************************************************************
         *                      Опции.
         ***************************************************************/

        // Опция "--plugin".
        $parser->addOption('plugin', [
            'help' => 'Создает в плагине файлы веб-компонента. Может указываться совместно с другими опциями.',
            'short' => 'p',
            'boolean' => true,
        ]);

        // Опция "--close".
        $parser->addOption('close', [
            'help' => 'Создает файлы веб-компонента для закрытой схемы. Может указываться совместно с другими опциями.',
            'short' => 'c',
            'boolean' => true,
        ]);

        // Опция "--list".
        $parser->addOption('list', [
            'help' => 'Создает веб-компонент с файлами для пагинации.',
            'short' => 'l',
            'boolean' => true,
        ]);

        // Опция "--extends".
        $parser->addOption('extends', [
            'help' => 'Создает веб-компонент "name" с наследованием от "name2". Если веб-компонент(ы) не установлен, устанавливает его (их).',
            'short' => 'e',
            'boolean' => true,
        ]);

        // Опция "--addlib".
        $parser->addOption('addlib', [
            'help' => 'Создает веб-компонент "name" с подключенной библиотекой "name2". Если библиотек "name2" не установлена, установит её. Если веб-компонент "name" существует в приложении, добавит к нему строку подключения библиотеки "name2".',
            'short' => 'a',
            'boolean' => true,
        ]);

        // Опция "--addextends".
        $parser->addOption('addextends', [
            'help' => 'Создает расширяемый веб-компонент "name".',
            'short' => 'x',
            'boolean' => true,
        ]);

        return $parser;
    }

    /**
     * Запускает команду на исполнение.
     */
    public function execute( Arguments $args, ConsoleIo $io ): int
    {
        /**
         * Работаем с аргументами.
         */

        // name
        if ( empty( $args->getArgument('name') ) ) {
            $io->error( 'Не задано имя веб-компонента!' );
            $this->abort();
        }

        $name = strtolower( $args->getArgument('name') );

        if ( !preg_match( '/^[a-zA-Z][a-zA-Z0-9]*$/', $name ) ) {
            $io->error( 'В название веб-компонента указаны недопустимые символы!' );
            $this->abort();
        }

        // name2
        if ( $args->getArgument( 'name2' ) !== null ) {
            $name2 = strtolower( $args->getArgument( 'name2' ) );
            if (!preg_match( '/^[a-zA-Z][a-zA-Z0-9]*$/', $name2 ) and isset( $name2 )) {
                $io->error('В название указаны недопустимые символы!');
                $this->abort();
            }
        }

        /**
         * Обрабатываем команды.
         *
         * Все опции должны быть перечислены в функции in_array. Сначала перечисляются базовые
         * опции, которые определяют, что конкретно что должна сделать команда, какой использовать
         * шаблон для создания веб-компонента. Затем идут вспомогательные опции, которые могут
         * не указываться, но уточняют команду, набранную в терминале. Например, опция `--plugin`
         * укажет, что веб-компонент необходимо создавать в плагине.
         */
        $basicOption = '';
        $additionalOption = [];
        foreach ( $args->getOptions() as $key => $val ) {
            if ( in_array( $key, ['list', 'extends', 'addlib', 'addextends'] ) and $val ) {
                $basicOption = $key;
            }
            elseif ( in_array( $key, ['plugin', 'close'] ) and $val ) {
                $additionalOption[] = $key;
            }
        }

        /**
         * Генерируем команду.
         */
        $myCom = new MyCommands();
        $nameMethod = 'wc' . ucfirst( $basicOption );
        if ( $args->getArgument( 'name2' ) !== null ) {
            $myCom->$nameMethod(
                $name,
                $name2,
                in_array( 'close', $additionalOption ),
                in_array( 'plugin', $additionalOption ),
                $io,
            );
        }
        else {
            $myCom->$nameMethod(
                $name,
                in_array( 'close', $additionalOption ),
                in_array( 'plugin', $additionalOption ),
                $io,
            );
        }

        return static::CODE_SUCCESS;
    }
}
