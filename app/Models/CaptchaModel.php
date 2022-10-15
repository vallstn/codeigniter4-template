<?php

namespace App\Models;

use CodeIgniter\Database\Exceptions\DataException;
use CodeIgniter\Model;

/**
 * This Captcha model is ready for your customization.
 */
class CaptchaModel extends Model
{
    protected $DBGroup    = 'default';
    protected $table      = 'captcha';
    protected $primaryKey = 'captcha_id';

    protected $useAutoIncrement = true;

    protected $returnType = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['captcha_time', 'ip_address', 'word', 'imgName'];

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
