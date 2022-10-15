<?php

namespace Dashboard\RevDB\Entities;

use CodeIgniter\Entity\Entity;

class District extends Entity
{
	protected $attributes = [
        'DistrictCode'      => null,
        'DistrictName'      => null,
        'DistrictNameTamil' => null,
		'district_sname'   	=> null,
		'agricode'   		=> null,
        'created_at' => null,
        'updated_at' => null,
		'deleted_at' => null,
    ];

    protected $datamap = [
        // property_name => db_column_name
        'dcode' => 'DistrictCode',
		'ename' => 'DistrictName',
		'tname' => 'DistrictNameTamil',
		'sname' => 'district_sname',
    ];
	
	protected $dates = ['created_at', 'updated_at', 'deleted_at'];
	
	protected $casts = [
        'read_array'        => 'array',
        'read_json' 		=> 'json',
        'read_json_array'  	=> 'json-array',
		'read_csv' 			=> 'csv',
    ];
	
	/**
     * @return string
     */
    public function adminLink(?string $postfix = null)
    {
        $url = "/revenueMaster/districts/{$this->id}";

        if (! empty($postfix)) {
            $url .= "/{$postfix}";
        }

        return trim(site_url($url));
    }


}
