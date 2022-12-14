<?php

/**
 * This file is part of Bonfire.
 *
 * (c) Lonnie Ezell <lonnieje@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Dashboard\RevDB\Libraries;

/**
 * Provides view cells for District
 */
class ViewCells
{
    protected $viewPrefix = 'Dashboard\RevDB\Views\\';

    /**
     * Displays the form fields for user meta fields.
     */
    public function metaFormFields()
    {
        return view($this->viewPrefix . 'meta/list', [
            'fieldGroups' => setting('Revenue.metaFields'),
        ]);
    }
}
