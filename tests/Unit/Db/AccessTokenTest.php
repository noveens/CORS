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

namespace OCA\OAuth2\Tests\Unit\Db;

use OCA\OAuth2\Db\AccessToken;
use PHPUnit_Framework_TestCase;

class AccessTokenTest extends PHPUnit_Framework_TestCase {

	/** @var AccessToken $accessToken */
	private $accessToken;

	public function setUp() {
		parent::setUp();

		$this->accessToken = new AccessToken();
	}

	public function testResetExpires() {
		$expected = time() + 3600;
		$this->accessToken->resetExpires();
		$this->assertEquals($expected, $this->accessToken->getExpires(), '', 1);
	}

	public function testHasExpired() {
		$this->assertTrue($this->accessToken->hasExpired());
		$this->accessToken->setExpires(10);
		$this->assertTrue($this->accessToken->hasExpired());
		$this->accessToken->resetExpires();
		$this->assertFalse($this->accessToken->hasExpired());
	}

}
