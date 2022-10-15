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

    protected $column_order = [null, 'DistrictName', 'DistrictNameTamil', 'district_sname', 'agricode', null];
    protected $column_search = ['DistrictName', 'DistrictNameTamil'];
    protected $order = ['DistrictName' => 'asc'];
    protected $request;
    protected $data;

    function __construct(RequestInterface $request, $arguments = null)
    {
        parent::__construct();
        $this->request = $request;
    }

    private function _get_datatables_query()
    {
        // Defines a table and joins to another table
        // return $this->where('user_id', $user->id)->orderBy($this->primaryKey)->findAll();
        $this->data = $this->select('DistrictName, DistrictNameTamil, district_sname, agricode')->findAll();

        $i = 0;
        // If there is a search request
        if ($this->request->getVar('search')['value']) {
            foreach ($this->column_search as $column) {
                if ($i == 0) {
                    $this->data->groupStart();
                    $this->data->like($column, $this->request->getVar('search')['value']);
                } else {
                    $this->data->orLike($column, $this->request->getVar('search')['value']);
                }
                // If the query has searched all columns
                if (count($this->column_search) - 1 == $i) {
                    $this->data->groupEnd();
                }
                $i++;
            }
        }

        // If there is a sorting request
        if ($this->request->getVar('order')) {
            // If sorted in the 5th table
            if ($this->column_order[$this->request->getVar('order')['0']['column']] != null) {
                $this->data->orderBy($this->column_order[$this->request->getVar('order')['0']['column']], $this->request->getVar('order')['0']['dir']);
            }
        }

        // If there is no sorting request, it will be sorted according to Default Sort
        else if (isset($this->order)) {
            $order = $this->order;
            $this->data->orderBy(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        // Limiting so that not all data is directly loaded
        if ($this->request->getVar('length') != -1) {
            $this->data->limit($this->request->getVar('length'), $this->request->getVar('start'));
        }
        // Returns data as an array
        return $this->data->get()->getResultArray();
    }

    function count_filtered()
    {
        // Number of data found when there is a filter
        $this->_get_datatables_query();
        return $this->data->countAllResults();
    }

    public function count_all()
    {
        // Counting all available data
        $tbl_storage = $this->table($this->table);
        return $tbl_storage->countAllResults();
    }
    
}
