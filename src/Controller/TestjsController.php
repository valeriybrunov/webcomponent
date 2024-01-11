<?php
declare(strict_types=1);

namespace Webcomponent\Controller;

use Webcomponent\Controller\AppController;

/**
 * Testjs Controller
 *
 * @method \Webcomponent\Model\Entity\Testj[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TestjsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index( $dir )
    {
        $this->viewBuilder()->setLayout('Webcomponent.test');
        $this->set( 'dir', $dir );
    }
}
