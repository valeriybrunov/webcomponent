<?php
declare(strict_types=1);

namespace Webcomponent\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Core\Plugin;

/**
 * Webcomp command.
 */
class WebcompCommand extends Command
{
	public static function getDescription(): string
    {
        return 'Создавайте веб-компоненты при помощи команд в консоли.';
    }

	protected function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser->addArgument('name', [
            'help' => 'Имя веб-компонента.',
        ]);

        // Опция "-plugin".
        $parser->addOption('plugin', [
            'help' => 'Создает в плагине файлы веб-компонента.',
            'short' => 'p',
            'boolean' => true,
        ]);

        // Опция "-close".
        $parser->addOption('close', [
            'help' => 'Создает файлы веб-компонента для закрытой схемы.',
            'short' => 'c',
            'boolean' => true,
        ]);

        return $parser;
    }

    /**
     * Запускает команду на исполнение.
     */
    public function execute(Arguments $args, ConsoleIo $io): int
    {
        $name = strtolower($args->getArgument('name'));

        if (empty($name)) {
        	$io->error('Не задано имя веб-компонента!');
        	$this->abort();
        }

        if (!preg_match( '/^[a-zA-Z][a-zA-Z0-9]*$/', $name) ) {
        	$io->error('В название веб-компонента указаны недопустимые символы!');
        	$this->abort();
        }

        if ($args->getOption('close')) {// Для закрытой схемы.
        	$this->createFiles($name,
				[// Названия шаблонов для создания файлов.
					['basicclose', 'template', 'test'], 'element',
				],
				[// Названия создаваемых файлов.
					[$name.'.js', 'template.js', 'test.js'], $name.'.php',
				],
				[// Директории, где будут созданы файлы.
					'webroot' . DS . 'js' . DS . 'webcomp' . DS . $name . DS,
					'templates' . DS . 'element' . DS . 'webcomp' . DS,
				],
				$args->getOption('plugin')
			);
        }
        else {
        	$this->createFiles($name,
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
				$args->getOption('plugin')
			);
        }

		$io->setStyle('greentext', ['text' => 'green']);
        $io->setStyle('boldik', ['text' => 'green', 'bold' => true]);

        $io->hr();
        $io->out("<greentext>Создан веб-компонент </greentext><boldik>" . ucfirst($name) . "</boldik>");
        $io->hr();

        return static::CODE_SUCCESS;
    }

    /**
     * Создаёт новые файлы из шаблонов.
     *
     * @param string $name Имя веб-компонента, файлы которого необходимо создать.
     * @param array $nameTemplateFile Многомерный массив имён шаблонов.
     * @param array $nameCreateFile   Многомерный массив с перечнем имён файлов, включая расширения
     *                                файлов, которые необходимо создать.
     * @param array $dir Одномерный массив, содержащий директории, в которых нужно создать файлы
     *                   с именами из массива $nameCreateFile.
     * @param bool $plugin Создать веб-компонент в плагине или в базовом месте.
     * @return void
     */
    public function createFiles( $name, $nameTemplateFile, $nameCreateFile, $dir, $plugin = false ): void
    {
    	$newFile = new \Webcomponent\Command\Bake\NewfileCommand();

    	foreach ($dir as $key => $value) {

    		if ($plugin) $path = '..' . DS . 'plugins' . DS . ucfirst($name) . DS;
    		else $path = '..' . DS;

    		$newFile->pathFragment = $path . $value;

    		if (is_array($nameTemplateFile[$key])) {
    			foreach ($nameTemplateFile[$key] as $key2 => $value2) {
    				$newFile->nameTemplateReader = $value2;
    				$newFile->templateName = 'Webcomponent.' . $value2 . 'Template';
    				$newFile->fileNameSave = $nameCreateFile[$key][$key2];
    				$this->executeCommand($newFile, [$name]);
    			}
    		}
    		if (is_string($nameTemplateFile[$key])) {
    			$newFile->nameTemplateReader = $nameTemplateFile[$key];
    			$newFile->templateName = 'Webcomponent.' . $nameTemplateFile[$key] . 'Template';
    			$newFile->fileNameSave = $nameCreateFile[$key];
    			$this->executeCommand($newFile, [$name]);
    		}
    	}
    }
}