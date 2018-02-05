<?php
 
use Core\Test\ControllerTestCase;
use Admin\Controller\AuthController;
use Admin\Model\User;
use Zend\Http\Request;
use Zend\Stdlib\Parameters;
use Zend\View\Renderer\PhpRenderer;
 
 
/**
* @group Controller
*/
class AuthControllerTest extends ControllerTestCase
{
	/**
	* Namespace completa do Controller
	* @var string
	*/
	protected $controllerFQDN = 'Admin\Controller\AuthController';
	
	/**
	* Nome da rota. Geralmente o nome do módulo
	* @var string
	*/
	protected $controllerRoute = 'admin';
	
	public function test404()
	{
		$this->routeMatch->setParam('action', 'action_nao_existente');
		$result = $this->controller->dispatch($this->request);
		$response = $this->controller->getResponse();
		$this->assertEquals(404, $response->getStatusCode());
	}
	
	public function testIndexActionLoginForm()
	{
		// Invoca a rota index
		$this->routeMatch->setParam('action', 'index');
		$result = $this->controller->dispatch($this->request, $this->response);
		
		// Verifica o response
		$response = $this->controller->getResponse();
		$this->assertEquals(200, $response->getStatusCode());
		
		// Testa se um ViewModel foi retornado
		$this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
		
		// Testa os dados da view
		$variables = $result->getVariables();
		
		$this->assertArrayHasKey('form', $variables);
		
		// Faz a comparação dos dados
		$this->assertInstanceOf('Zend\Form\Form', $variables['form']);
		$form = $variables['form'];
		//testa os ítens do formulário
		$username = $form->get('username');
		$this->assertEquals('username', $username->getName());
		$this->assertEquals('text', $username->getAttribute('type'));
		
		$password = $form->get('password');
		$this->assertEquals('password', $password->getName());
		$this->assertEquals('password', $password->getAttribute('type'));
	}
	
	/**
	* @expectedException exception
	* @expectedExceptionMessage Acesso inválido
	*/
	public function testLoginInvalidMethod()
	{
		$user = $this->addUser();
		
		// Invoca a rota index
		$this->routeMatch->setParam('action', 'login');
		$result = $this->controller->dispatch($this->request, $this->response);
		
	}
	public function testLogin()
	{
		$user = $this->addUser();
		
		// Invoca a rota index
		$this->request->setMethod('post');
		$this->request->getPost()->set('username', $user->username);
		$this->request->getPost()->set('password', 'apple');
		
		$this->routeMatch->setParam('action', 'login');
		$result = $this->controller->dispatch($this->request, $this->response);
		
		// Verifica o response
		$response = $this->controller->getResponse();
		//deve ter redirecionado
		$this->assertEquals(302, $response->getStatusCode());
		$headers = $response->getHeaders();
		$this->assertEquals('Location: /', $headers->get('Location'));
	}
	
	public function testLogout()
	{
		$user = $this->addUser();
		
		$this->routeMatch->setParam('action', 'logout');

		$result = $this->controller->dispatch($this->request, $this->response);
		
		// Verifica o response
		$response = $this->controller->getResponse();
		//deve ter redirecionado
		$this->assertEquals(302, $response->getStatusCode());
		$headers = $response->getHeaders();
		$this->assertEquals('Location: /', $headers->get('Location'));
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
