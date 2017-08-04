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

namespace OCA\CORS\Panels;

use OCP\IURLGenerator;
use OCP\IUserSession;
use OCP\Settings\ISettings;
use OCP\Template;
use OCP\IConfig;

class PersonalPanel implements ISettings {

	/**
	 * @var IUserSession
	 */
	protected $userSession;

	/**
	 * @var IURLGenerator
	 */
	protected $urlGenerator;

	/** @var IConfig */
	private $config;

	public function __construct(
		IUserSession $userSession,
		IURLGenerator $urlGenerator,
		IConfig $config) {

		$this->config = $config;
		$this->userSession = $userSession;
		$this->urlGenerator = $urlGenerator;
	}

	public function getSectionID() {
		return 'security';
	}

	/**
	 * @return Template
	 */
	public function getPanel() {
		$userId = $this->userSession->getUser()->getUID();
		$domainsSet = $this->config->getUserValue($userId, 'cors', 'domains');
		if ($domainsSet == '') {
			// 0 passes the is_empty() check
			$domains = 0;
		} else {
			$domains = explode(",", $domainsSet);
		}
		$t = new Template('cors', 'settings-personal');
		$t->assign('user_id', $userId);
		$t->assign('domains', $domains);
		$t->assign('urlGenerator', $this->urlGenerator);
		return $t;
	}


	public function getPriority() {
		return 20;
	}

}
