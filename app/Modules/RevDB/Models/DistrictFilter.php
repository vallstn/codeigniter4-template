<?php

/**
 * Model Filter.
 */

namespace Dashboard\RevDB\Models;

use Bonfire\Core\Traits\Filterable;
use CodeIgniter\I18n\Time;

use Dashboard\RevDB\Models\DistrictModel;

class DistrictFilter extends DistrictModel
{
    use Filterable;

    /**
     * The filters that can be applied to
     * @var array
     */
    protected $filters = [
	
		/**
        'role' => [
            'title'   => 'User Role',
            'options' => 'getRoleFilters',
        ],
        'active' => [
            'title'   => 'Active?',
            'options' => [0 => 'Inactive', 1 => 'Active'],
        ],
        'last_active' => [
            'title'   => 'Last Active',
            'options' => [
                1   => '1 day',
                2   => '2 days',
                3   => '3 days',
                7   => '1 week',
                14  => '2 weeks',
                30  => '1 month',
                90  => '3 months',
                180 => '6 months',
                365 => '1 year',
                366 => '> 1 year',
            ],
        ],
		*/
    ];

    /**
     * Provides filtering functionality.
     *
     * @param array $params
     *
     * @return UserFilter
     */
    public function filter(?array $params = null)
    {
        $this->select('tbl_tn_district.*');

		/**
        if (isset($params['role']) && count($params['role'])) {
            $this->join('auth_groups_users agu', 'agu.user_id = tbl_tn_district.id')
                ->whereIn('agu.group', $params['role']);
        }
		*/
		
        return $this;
    }

    /**
     * Returns a list of all roles in the system.
     */
    public function getRoleFilters(): array
    {
        helper('setting');
        $groups = setting('AuthGroups.groups');

        $use = [];

        foreach ($groups as $alias => $info) {
            $use[$alias] = $info['title'];
        }

        asort($use);

        return $use;
    }
}
