<?php

/**
 * Tamil Nadu Revenue / Panchayat Details Administration.
 */

namespace Dashboard\RevDB;

use Bonfire\Core\BaseModule;
use Bonfire\Menus\MenuItem;

class Module extends BaseModule
{
    /**
     * Setup our admin area needs.
     */
    public function initAdmin()
    {
        // Add to the Content menu
        $sidebar = service('menus');

        $sidebar->menu('sidebar')
        ->createCollection('RevenueMaster', 'Revenue Master')
        ->setFontAwesomeIcon('fas fa-database')
        ->setCollapsible();

        $item    = new MenuItem([
            'title'           => 'District',
            'namedRoute'      => 'revenueMaster/district',
            'fontAwesomeIcon' => 'fas fa-table',
            'permission'      => 'users.view',
        ]);
        $sidebar->menu('sidebar')->collection('RevenueMaster')->addItem($item);

        // Add Users Settings
        $item = new MenuItem([
            'title'           => 'Taluk',
            'namedRoute'      => 'taluk-data',
            'fontAwesomeIcon' => 'fas-table',
            'permission'      => 'users.settings',
        ]);
        $sidebar->menu('sidebar')->collection('RevenueMaster')->addItem($item);
    }
}
