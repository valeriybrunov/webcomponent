<?php
declare(strict_types=1);

namespace Webcomponent\Command\Bake;

use Bake\Command\SimpleBakeCommand;
use Cake\Core\Plugin;

/**
 * Генерирует новый файл из шаблона.
 *
 * Здесь преднамеренно оставлены значения у свойств, чтобы было понимание того, как формируются
 * шаблоны и пути к ним.
 */
class NewfileCommand extends SimpleBakeCommand
{
    /**
     * Директория для сохранения нового файла.
     *
     * @var string
     */
    public $pathFragment = '../templates/element/FooPath/';

    /**
     * Получить имя сгенерированного объекта.
     *
     * @var string
     */
    public $nameTemplateReader = 'newfile';

    /**
     * Имя файла шаблона из которого будет сгенерирован новый файл.
     *
     * @var string
     */
    public $templateName = 'Webcomponent.newfileTemplate';

    /**
     * Имя файла, который будет сохранён.
     *
     * @var string
     */
    public $fileNameSave = 'FooOut.php';

    /**
     * Возвращает имя файла шаблона.
     *
     * @return string
     */
    public function name(): string
    {
        return $this->nameTemplateReader;
    }

    /**
     * Возвращает имя файла шаблона.
     *
     * @return string
     */
    public function template(): string
    {
        return $this->templateName;
    }

    /**
     * Возвращает имя файла сгенерированного объекта без начального пути.
     *
     * @return string
     */
    public function fileName(string $name): string
    {
        return $this->fileNameSave;
    }
}