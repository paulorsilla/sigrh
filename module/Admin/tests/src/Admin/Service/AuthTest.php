<?php
namespace Admin\Service;
 
use DateTime;
use Core\Test\ServiceTestCase;
use Admin\Model\User;
use Core\Model\EntityException;
use Zend\Authentication\AuthenticationService;
 
/**
* Testes do serviço Auth
* @category Admin
* @package Service
* @author Elton Minetto<eminetto@coderockr.com>
*/
 
/**
* @group Service
*/
class AuthTest extends ServiceTestCase
{
 
	/**
	* Authenticação sem parâmetros
	* @expectedException \exception
	* @return void
	*/
	public function testAuthenticateWithoutParams()
	{
		$authService = $this->serviceManager->get('Admin\Service\Auth');
		$authService->authenticate();
	}
	
	/**
	* Authenticação sem parâmetros
	* @expectedException exception
	* @expectedExceptionMessage Parâmetros inválidos
	* @return void
	*/
	public function testAuthenticateEmptyParams()
	{
		$authService = $this->serviceManager->get('Admin\Service\Auth');
		$authService->authenticate(array());
	}
	
	/**
	* Teste da autenticação inválida
	* @expectedException exception
	* @expectedExceptionMessage Login ou senha inválidos
	* @return void
	*/
	public function testAuthenticateInvalidParameters()
	{
		$authService = $this->serviceManager->get('Admin\Service\Auth');
		$authService->authenticate(array('username' => 'invalid', 'password' => 'invalid'));
	}
	
	/**
	* Teste da autenticação Inválida
	* @expectedException exception
	* @expectedExceptionMessage Login ou senha inválidos
	* @return void
	*/
	public function testAuthenticateInvalidPassword()
	{
		$authService = $this->serviceManager->get('Admin\Service\Auth');
		$user = $this->addUser();
		
		$authService->authenticate(array('username' => $user->username, 'password' => 'invalida'));
	}
	
	/**
	* Teste da autenticação Válida
	* @return void
	*/
	public function testAuthenticateValidParams()
	{
		$authService = $this->serviceManager->get('Admin\Service\Auth');
		$user = $this->addUser();
		$result = $authService->authenticate(
		array('username' => $user->username, 'password' => 'apple')
		);
		$this->assertTrue($result);
		
		//testar a se a authenticação foi criada
		$auth = new AuthenticationService();
		$this->assertEquals($auth->getIdentity(), $user->username);
		
		//verica se o usuário foi salvo na sessão
		$session = $this->serviceManager->get('Session');
		$savedUser = $session->offsetGet('user');
		$this->assertEquals($user->id, $savedUser->id);
		
	}
	
	/**
	* Limpa a autenticação depois de cada teste
	* @return void
	*/
	public function tearDown()
	{
		parent::tearDown();
		$auth = new AuthenticationService();
		$auth->clearIdentity();
	}
	
	/**
	* Teste do logout
	* @return void
	*/
	public function testLogout()
	{
		$authService = $this->serviceManager->get('Admin\Service\Auth');
		$user = $this->addUser();
		$result = $authService->authenticate(
		array('username' => $user->username, 'password' => 'apple')
		);
		$this->assertTrue($result);
		
		$result = $authService->logout();
		$this->assertTrue($result);
		//verifica se removeu a identidade da autenticação
		$auth = new AuthenticationService();
		$this->assertNull($auth->getIdentity());
		
		//verifica se o usuário foi removido da sessão
		$session = $this->serviceManager->get('Session');
		$savedUser = $session->offsetGet('user');
		$this->assertNull($savedUser);
	}
	
	/**
	* Teste de autorização
	* @return void
	*/
	public function testAuthorize()
	{
		$authService = $this->getService('Admin\Service\Auth');
		
		$result = $authService->authorize();
		$this->assertFalse($result);
		
		$user = $this->addUser();
		
		$result = $authService->authenticate(
			array('username' => $user->username, 'password' => 'apple')
		);
		$this->assertTrue($result);
		
		$result = $authService->authorize();
		$this->assertTrue($result);
	}
	
	private function addUser()
	{
		$user = new User();
		$user->username = 'steve';
		$user->password = md5('apple');
		$user->name = 'Steve <b>Jobs</b>';
		$user->valid = 1;
		$user->role = 'admin';
		
		$saved = $this->getTable('Admin\Model\User')->save($user);
		return $saved;
	}
 
}