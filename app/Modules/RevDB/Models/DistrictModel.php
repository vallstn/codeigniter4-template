<?php

namespace Dashboard\RevDB\Models;

use CodeIgniter\Database\Exceptions\DataException;
use CodeIgniter\Model;

use Dashboard\RevDB\Entities\District;

/**
 * This District model is ready for your customization.
 */
class DistrictModel extends Model
{
    protected $DBGroup    = 'tamilnadu';
    protected $table      = 'tbl_tn_district';
    protected $primaryKey = 'DistrictCode';

    protected $useAutoIncrement = false;

    protected $returnType     = District::class;
    protected $useSoftDeletes = true;

    protected $allowedFields = ['DistrictName', 'DistrictNameTamil', 'district_sname', 'agricode'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
	
	/**
     * Performs additional setup when finding objects
     * for the recycler. This might pull in additional
     * fields.
     */
    public function setupRecycler()
    {
        $dbPrefix = $this->db->getPrefix();

			return $this->select("{$dbPrefix}tbl_tn_district.* as districtpurge
		
        ");
    }    
    
}
