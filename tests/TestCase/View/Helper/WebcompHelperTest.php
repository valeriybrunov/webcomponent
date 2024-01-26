<?php
declare(strict_types=1);

namespace Webcomponent\Test\TestCase\View\Helper;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use Webcomponent\View\Helper\WebcompHelper;

/**
 * Webcomponent\View\Helper\WebcompHelper Test Case
 *
 * Запуск теста из командной строки:
 *      $ vendor/bin/phpunit /opt/lampp/htdocs/mysite/plugins/Webcomponent/tests/TestCase/View/Helper/WebcompHelperTest.php
 */
class WebcompHelperTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Webcomponent\View\Helper\WebcompHelper
     */
    protected $Webcomp;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $view = new View();
        $this->Webcomp = new WebcompHelper($view);
    }

    /**
     * Тестируем метод "nameWebcomp".
     */
    public function testNameWebcomp(): void
    {
        $in =  ['Plugin_myComp', 'plugin_myComp', 'myWebComp'];
        $out = ['Plugin.mycomp', 'Plugin.mycomp', 'mywebcomp'];

        for ($i = 0; $i < count($in); $i++)
        {
            $result = $this->Webcomp->nameWebcomp($in[$i]);
            $this->assertStringContainsString($out[$i], $result);
        }
    }

    /**
     * Тестируем метод "urlLoad".
     */
    public function testUrlLoad(): void
    {
        $in  = ['Plugin.mycomp', 'mywebcomp'];
        $out = ['Plugin.webcomp'.DS.'mycomp', 'webcomp'.DS.'mywebcomp'];

        for ($i = 0; $i < count($in); $i++)
        {
            $result = $this->Webcomp->urlLoad($in[$i]);
            $this->assertStringContainsString($out[$i], $result);
        }
    }

    /**
     * Тестируем метод "clearNameWebcomp".
     */
    public function testClearNameWebcomp(): void
    {
        $in  = ['Plugin_myWebComp', 'myWebComponent'];
        $out = ['myWebComp',        'myWebComponent'];

        for ($i = 0; $i < count($in); $i++)
        {
            $this->Webcomp->setName(false);
            $result = $this->Webcomp->clearNameWebcomp($in[$i]);
            $this->assertStringContainsString($out[$i], $result);
        }
    }

    /**
     * Тестируем метод "addAttr".
     */
    public function testAddAttr(): void
    {
        $in[0][0]['view'] = 'element';
        $in[1][0]['data']['ddd'] = 'fff';
        $in[2][0]['options']['mySetting']['ddd'] = 444;
        $in[3][0]['data']['ddd'] = 'fff';
        $in[3][0]['options']['mySetting']['gtgt'] = 555;
        $in[4][0]['view'] = 'element';
        $in[4][0]['options']['mySetting']['ddd'] = 444;
        $in[5][0]['view'] = 'element';
        $in[5][0]['data']['ddd'] = 'fff';
        $in[5][0]['options']['mySetting']['ddd'] = 444;
        $in[6][0]['myAttr'] = 'myString';
        $in[7][0]['frrt'] = 'sed';
        $in[7][0]['gT'] = 'ddttt';
        $out = [
            ' class="init myWebComp"',
            ' class="init myWebComp"',
            ' class="init myWebComp"',
            ' class="init myWebComp"',
            ' class="init myWebComp"',
            ' class="init myWebComp"',
            ' myAttr="myString" class="init myWebComp"',
            ' frrt="sed" gT="ddttt" class="init myWebComp"',
        ];

        for ($i = 0; $i < count($in); $i++) {
            $this->Webcomp->setName('myWebComp');
            $result = $this->Webcomp->addAttr($in[$i]);
            $this->assertStringContainsString($out[$i], $result);
        }
    }

    /**
     * Тестируем метод "__call".
     */
    public function test__call(): void
    {
        $result = $this->Webcomp->__call('myWebComp', [
            0 => ['view' => 'clear']
        ]);
        $this->assertStringContainsString('<div-myWebComp class="init myWebComp"></div-myWebComp>', $result);

        $result = $this->Webcomp->__call('myWebComp', [
            0 => [
                'view' => 'clear',
                'fir' => 'dwq',
            ]
        ]);
        $this->assertStringContainsString('<div-myWebComp fir="dwq" class="init myWebComp"></div-myWebComp>', $result);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Webcomp);

        parent::tearDown();
    }
}
