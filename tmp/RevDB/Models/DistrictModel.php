<?php

namespace Dashboard\RevDB\Models;

use CodeIgniter\Database\Exceptions\DataException;
use CodeIgniter\Model;

use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\Shield\Exceptions\InvalidArgumentException;
use CodeIgniter\Shield\Exceptions\ValidationException;

/**
 * This User model is ready for your customization.
 * It extends Shield's UserModel, providing many auth
 * features built right in.
 */
class DistrictModel extends Model
{
    protected $DBGroup    = 'tamilnadu';
    protected $table      = 'tbl_tn_district';
    protected $primaryKey = 'DistrictCode';

    protected $useAutoIncrement = false;

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['DistrictName', 'DistrictNameTamil', 'district_sname', 'agricode'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    
    
}
