<?php
/**
 * @author Noveen Sachdeva "noveen.sachdeva@research.iiit.ac.in"
 * @license AGPL-3.0
 *
 * This code is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License, version 3,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License, version 3,
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 */

return [
    'routes' => [
        # Routes for admin settings
        ['name' => 'settings#getDomains', 'url' => '/domains', 'verb' => 'GET'],
        ['name' => 'settings#addDomain', 'url' => '/domains', 'verb' => 'POST'],
        ['name' => 'settings#removeDomain', 'url' => '/domains/{id}/delete', 'verb' => 'POST']
    ]
];