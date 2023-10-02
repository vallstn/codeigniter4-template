<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use App\Controllers\BaseController;

class DownloadController extends BaseController
{
   
    public function __construct()
    {
		helper(['auth', 'text']);
		$this->session = service('session');

		$this->db = \Config\Database::connect();
    }

    /**
     * Return Resource Images
     */    

    public function resource($imageName)
    {

        $image = ROOTPATH.'/themes/Portal/image/'.$imageName;
        if(file_exists($image))
        {
            if(($image = file_get_contents(ROOTPATH.'/themes/Portal/image/'.$imageName)) === FALSE)
                show_404();

            // choose the right mime type
            $mimeType = 'image/jpg';

            $this->response
                ->setStatusCode(200)
                ->setContentType($mimeType)
                ->setBody($image)
                ->send();
        }

    }
	
	/**
     * Return Resource CSS
     */    

    public function resourcecss($cssName)
    {

        $css = ROOTPATH.'/themes/Portal/plugins/css/'.$cssName;
        if(file_exists($css))
        {
            if(($css = file_get_contents(ROOTPATH.'/themes/Portal/plugins/css/'.$cssName)) === FALSE)
                show_404();

            // choose the right mime type
            $mimeType = 'text/css';

            $this->response
                ->setStatusCode(200)
                ->setContentType($mimeType)
                ->setBody($css)
                ->send();

        }

    }
	
	/**
     * Return Resource JS
     */    

    public function resourcesvg($svgName)
    {

        $css = ROOTPATH.'/themes/Portal/image/'.$svgName;
        if(file_exists($js))
        {
            if(($css = file_get_contents(ROOTPATH.'/themes/Portal/image/'.$svgName)) === FALSE)
                show_404();

            // choose the right mime type
            $mimeType = 'image/svg+xml';

            $this->response
                ->setStatusCode(200)
                ->setContentType($mimeType)
                ->setBody($svg)
                ->send();

        }

    }
	
	
}