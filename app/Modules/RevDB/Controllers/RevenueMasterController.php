<?php

/**
 * Revenue Maters
 */

namespace Dashboard\RevDB\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\Exceptions\DataException;
use ReflectionException;

use Bonfire\Core\AdminController;

use Dashboard\RevDB\Models\DistrictFilter;
use Dashboard\RevDB\Models\DistrictModel;
use Dashboard\RevDB\Entities\District;

class RevenueMasterController extends BaseController
{        
    protected $theme      = 'Admin';
    protected $viewPrefix = 'Dashboard\RevDB\Views\\';
	
	/**
     * Display the District List.
     *
     * @return string
     */
    public function listd()
    {
        if (! auth()->user()->can('users.list')) {
            return redirect()->to(ADMIN_AREA)->with('error', lang('Bonfire.notAuthorized'));
        }
		
        /** @var districtFilter $districtModel */
        $districtModel = model(DistrictFilter::class);

        $districtModel->filter($this->request->getPost('filters'));

        $view = $this->request->getMethod() === 'post'
            ? $this->viewPrefix . '_table'
            : $this->viewPrefix . 'list';

        return $this->render($view, [
            'headers' => [
                'slno'              => 'Sl. No.',
                'DistrictName'       => 'Name',
                'DistrictNameTamil'    => 'Name-Tamil',
                'district_sname'      => 'Short Name',
                'agricode' => 'Agri. Dept. Code',
            ],
            'showSelectAll' => true,
            'districts'     => $districtModel->paginate(setting('Site.perPage')),
            'pager'         => $districtModel->pager,
        ]);
    }
    
}
