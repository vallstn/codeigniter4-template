<?php

/**
 * This file is part of Bonfire.
 *
 * (c) Lonnie Ezell <lonnieje@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Dashboard\RevDB\Helpers;

use Bonfire\Search\Interfaces\SearchProviderInterface;
use Dashboard\RevDB\Models\DistrictModel;

class SearchProviderDistrict extends DistrictModel implements SearchProviderInterface
{
    /**
     * Performs a primary search for just this resource.
     */
    public function search(string $term, int $limit = 10, ?array $post = null): array
    {
        // @phpstan-ignore-next-line
        return $this
            ->select('tbl_tn_district.*')
            // ->join('auth_identities', 'auth_identities.user_id = users.id', 'inner')
            ->like('DistrictName', $term, 'right', true, true)
            ->orlike('DistrictNameTamil', $term, 'right', true, true)
            ->orLike('district_sname', $term, 'right', true, true)
            ->orLike('agricode', $term, 'both', true, true)
            ->orderBy('DistrictName', 'asc')
            ->findAll($limit);
    }

    /**
     * Returns the name of the resource.
     */
    public function resourceName(): string
    {
        return 'districts';
    }

    /**
     * Returns a URL to the admin area URL main list
     * for this resource.
     */
    public function resourceUrl(): string
    {
        return 'revenueMaster/districts';
    }

    /**
     * Returns the name of the view to use when
     * displaying the list of results for this
     * resource type.
     */
    public function resultView(): string
    {
        return 'Search/districts';
    }
}
