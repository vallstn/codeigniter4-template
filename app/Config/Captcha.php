<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Captcha extends BaseConfig
{
    /**
     * --------------------------------------------------------------------
     * Codeigniter 3 Like Captcha
     * --------------------------------------------------------------------
     * 
	*/
    public array $defaults = array(
		'word'			=> '',
		'img_path'		=> WRITEPATH.'/captcha/',
		'img_url'		=> '/captcha/',
		'img_width'		=> '100',
		'img_height'	=> '40',
		'font_path'		=> '',
		'expiration'	=> 600,
		'word_length'	=> 6,
		'font_size'		=> 12,
		'img_id'		=> '',
		'pool'			=> '0123456789',
		'colors'		=> array(
			'background'=> array(255,255,255),
			'border'	=> array(153,102,102),
			'text'		=> array(0,0,0),
			'grid'		=> array(22, 235, 235)
		)
	);
	
	
	
    
}
