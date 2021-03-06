<?php
/**
 * UnassignRoleFromUserSignal class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */

namespace eZ\Publish\Core\SignalSlot\Signal\RoleService;

use eZ\Publish\Core\SignalSlot\Signal;

/**
 * UnassignRoleFromUserSignal class
 * @package eZ\Publish\Core\SignalSlot\Signal\RoleService
 */
class UnassignRoleFromUserSignal extends Signal
{
    /**
     * RoleId
     *
     * @var mixed
     */
    public $roleId;

    /**
     * UserId
     *
     * @var mixed
     */
    public $userId;
}
