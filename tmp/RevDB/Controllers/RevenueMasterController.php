<?php

/**
 * Revenue Maters
 */

namespace Dashboard\RevDB\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\Exceptions\DataException;
use ReflectionException;
use Dashboard\RevDB\Models\DistrictModel;


include(APPPATH . 'Libraries/GroceryCrudEnterprise/autoload.php');
use GroceryCrud\Core\GroceryCrud;

class RevenueMasterController extends BaseController
{        
    protected $theme      = 'Admin';
    protected $viewPrefix = 'Dashboard\RevDB\Views\\';

    /**
     * Display the uses currently in the system.
     *
     * @return string
     */
    public function district()
    {
        if (! auth()->user()->can('users.list')) {
            return redirect()->to(ADMIN_AREA)->with('error', lang('Bonfire.notAuthorized'));
        }
		
		$crud = $this->_getGroceryCrudEnterprise();

        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());

        $crud->setTable('tbl_tn_district');
        $crud->setSubject('Customer', 'Customers');

        $output = $crud->render();
		
		//print_r($output); die;

        return $this->_crud_output($output);
    }
	
	private function _crud_output($output = null) {
		
        if (isset($output->isJSONResponse) && $output->isJSONResponse) {
			header('Content-Type: application/json; charset=utf-8');
			echo $output->output;
			exit;
        }
		
		return $this->render($this->viewPrefix . 'index', [
            'js_files' => $output->js_files,
			'css_files' => $output->css_files,
			'data' => $output->output,
        ]);
    }

    private function _getDbData() {
        $db = (new \Config\Database())->tamilnadu;
        return [
            'adapter' => [
                'driver' => 'Pdo_Mysql',
                'host'     => $db['hostname'],
                'database' => $db['database'],
                'username' => $db['username'],
                'password' => $db['password'],
                'charset' => 'utf8'
            ]
        ];
    }
    private function _getGroceryCrudEnterprise($bootstrap = true, $jquery = true) {
        $db = $this->_getDbData();
        $config = (new \Config\GroceryCrudEnterprise())->getDefaultConfig();

        $groceryCrud = new GroceryCrud($config, $db);
        return $groceryCrud;
    }
}
