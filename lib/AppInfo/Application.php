<?php
/**
 * @author Project Seminar "sciebo@Learnweb" of the University of Muenster
 * @copyright Copyright (c) 2017, University of Muenster
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

namespace OCA\CORS\AppInfo;

use OCP\AppFramework\App;

class Application extends App {

	/**
	 * Application constructor.
	 *
	 * @param array $urlParams Variables extracted from the routes.
	 */
	public function __construct(array $urlParams = array()) {
		parent::__construct('cors', $urlParams);

		$container = $this->getContainer();

		// Logger
		$container->registerService('Logger', function ($c) {
			return $c->query('ServerContainer')->getLogger();
		});

		// User Manager
		$container->registerService('UserManager', function($c) {
			return $c->query('ServerContainer')->getUserManager();
		});

	}

}
