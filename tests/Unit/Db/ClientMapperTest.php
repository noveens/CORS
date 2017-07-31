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

use OCA\OAuth2\AppInfo\Application;
use OCA\OAuth2\Db\AccessToken;
use OCA\OAuth2\Db\AccessTokenMapper;
use OCA\OAuth2\Db\AuthorizationCode;
use OCA\OAuth2\Db\AuthorizationCodeMapper;
use OCA\OAuth2\Db\Client;
use OCA\OAuth2\Db\ClientMapper;
use PHPUnit_Framework_TestCase;

class ClientMapperTest extends PHPUnit_Framework_TestCase {

	/** @var ClientMapper $clientMapper */
	private $clientMapper;

	/** @var string $identifier */
	private $identifier = 'NXCy3M3a6FM9pecVyUZuGF62AJVJaCfmkYz7us4yr4QZqVzMIkVZUf1v2IzvsFZa';

	/** @var string $secret */
	private $secret = '9yUZuGF6pecVaCfmIzvsFZakYNXCyr4QZqVzMIky3M3a6FMz7us4VZUf2AJVJ1v2';

	/** @var string $redirectUri */
	private $redirectUri = 'https://owncloud.org';

	/** @var string $name */
	private $name = 'ownCloud';

	/** @var boolean $allowSubdomains */
	private $allowSubdomains = true;

	/** @var Client $client1 */
	private $client1;

	/** @var int $id */
	private $id;

	/** @var Client $client2 */
	private $client2;

	/** @var string $userId */
	private $userId = 'john';

	/** @var AuthorizationCodeMapper $authorizationCodeMapper */
	private $authorizationCodeMapper;

	/** @var AuthorizationCode $authorizationCode */
	private $authorizationCode;

	/** @var AccessTokenMapper $accessTokenMapper */
	private $accessTokenMapper;

	/** @var AccessToken $accessToken */
	private $accessToken;

	public function setUp() {
		parent::setUp();

		$app = new Application();
		$container = $app->getContainer();

		$this->clientMapper = $container->query('OCA\OAuth2\Db\ClientMapper');
		$this->clientMapper->deleteAll();

		$client = new Client();
		$client->setIdentifier($this->identifier);
		$client->setSecret($this->secret);
		$client->setRedirectUri($this->redirectUri);
		$client->setName($this->name);
		$client->setAllowSubdomains($this->allowSubdomains);

		$this->client1 = $this->clientMapper->insert($client);
		$this->id = $this->client1->getId();

		$client = new Client();
		$client->setIdentifier('uGF62As4yr4QZqVz3a6FM9peJVJaCfmkYz7ucVyUZZUf1v2IzvsFZaMIkVNXCy3M');
		$client->setSecret('z7us4VZUf2fmIzvsFZakYNXCyrky3M39yUZuGF6pecVaCa6FMAJVJ1v24QZqVzMI');
		$client->setRedirectUri('https://www.google.de');
		$client->setName('Google');
		$this->client2 = $this->clientMapper->insert($client);

		$this->authorizationCodeMapper = $container->query('OCA\OAuth2\Db\AuthorizationCodeMapper');
		$this->authorizationCodeMapper->deleteAll();
		$this->accessTokenMapper = $container->query('OCA\OAuth2\Db\AccessTokenMapper');
		$this->accessTokenMapper->deleteAll();

		$authorizationCode = new AuthorizationCode();
		$authorizationCode->setCode('akYNVaCz7us4VZUf2f24QZqXCyrky3M39yUZuGF6pecVzMImIzvsFZa6FMAJVJ1v');
		$authorizationCode->setClientId($this->id);
		$authorizationCode->setUserId($this->userId);
		$authorizationCode->resetExpires();
		$this->authorizationCode = $this->authorizationCodeMapper->insert($authorizationCode);

		$accessToken = new AccessToken();
		$accessToken->setToken('qXF6pecVzMf2f24QZIzvImakYNVaCz7ussFZa6FMAJVJ1vCyrky3M39yUZuG4VZU');
		$accessToken->setClientId($this->id);
		$accessToken->setUserId($this->userId);
		$accessToken->resetExpires();
		$this->accessToken = $this->accessTokenMapper->insert($accessToken);
	}

	public function tearDown() {
		parent::tearDown();

		$this->clientMapper->delete($this->client1);
		$this->clientMapper->delete($this->client2);
		$this->authorizationCodeMapper->delete($this->authorizationCode);
		$this->accessTokenMapper->delete($this->accessToken);
	}

	public function testFind() {
		/** @var Client $client */
		$client = $this->clientMapper->find($this->id);

		$this->assertEquals($this->id, $client->getId());
		$this->assertEquals($this->identifier, $client->getIdentifier());
		$this->assertEquals($this->secret, $client->getSecret());
		$this->assertEquals($this->redirectUri, $client->getRedirectUri());
		$this->assertEquals($this->name, $client->getName());
		$this->assertEquals($this->allowSubdomains, $client->getAllowSubdomains());
	}

	/**
	 * @expectedException \OCP\AppFramework\Db\DoesNotExistException
	 */
	public function testFindDoesNotExistException() {
		$this->clientMapper->find(-1);
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testFindInvalidArgumentException1() {
		$this->clientMapper->find(null);
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testFindInvalidArgumentException2() {
		$this->clientMapper->find('qwertz');
	}

	public function testFindByIdentifier() {
		/** @var Client $client */
		$client = $this->clientMapper->findByIdentifier($this->identifier);

		$this->assertEquals($this->id, $client->getId());
		$this->assertEquals($this->identifier, $client->getIdentifier());
		$this->assertEquals($this->secret, $client->getSecret());
		$this->assertEquals($this->redirectUri, $client->getRedirectUri());
		$this->assertEquals($this->name, $client->getName());
		$this->assertEquals($this->allowSubdomains, $client->getAllowSubdomains());
	}

	/**
	 * @expectedException \OCP\AppFramework\Db\DoesNotExistException
	 */
	public function testFindByIdentifierDoesNotExistException() {
		$this->clientMapper->findByIdentifier('qwertz');
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testFindByIdentifierInvalidArgumentException1() {
		$this->clientMapper->findByIdentifier(null);
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testFindByIdentifierInvalidArgumentException2() {
		$this->clientMapper->findByIdentifier(12);
	}

	public function testFindAll() {
		$clients = $this->clientMapper->findAll();

		$this->assertEquals(2, count($clients));
	}

	public function testFindByUser() {
		$clients = $this->clientMapper->findByUser($this->userId);

		$this->assertEquals(1, count($clients));

		/** @var Client $client */
		$client = $clients[0];
		$this->assertEquals($this->id, $client->getId());
		$this->assertEquals($this->identifier, $client->getIdentifier());
		$this->assertEquals($this->secret, $client->getSecret());
		$this->assertEquals($this->redirectUri, $client->getRedirectUri());
		$this->assertEquals($this->name, $client->getName());
		$this->assertEquals($this->allowSubdomains, $client->getAllowSubdomains());

		$clients = $this->clientMapper->findByUser('qwertz');
		$this->assertEmpty($clients);
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testFindByUserInvalidArgumentException1() {
		$this->clientMapper->findByUser(null);
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testFindByUserInvalidArgumentException2() {
		$this->clientMapper->findByUser(12);
	}

	public function testDeleteAll() {
		$this->assertEquals(2, count($this->clientMapper->findAll()));
		$this->clientMapper->deleteAll();
		$this->assertEquals(0, count($this->clientMapper->findAll()));
	}

}
