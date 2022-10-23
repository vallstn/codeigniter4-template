<?php

/**
 * Public Users Dashboard
 */

namespace Dashboard\Portal\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\Exceptions\DataException;
use ReflectionException;

class PublicController extends BaseController
{
    public function __construct()
    {

        helper(['auth', 'text']);

        $this->session = service('session');
        $this->db = \Config\Database::connect();

        if (! auth()->user()) {
            return redirect()->to(ADMIN_AREA);
        }
    }
	
	protected $theme      = 'Public';
    protected $viewPrefix = 'Dashboard\Portal\Views\\';

	/**
     * Display the District List.
     *
     * @return string
     */
    public function index()
    {
		return $this->render($this->viewPrefix.'welcome_message_new', [
            'headers' => [
                'slno'              => 'Sl. No.',
            ],
        ]);
        return view('welcome_message_new');
    }

}
