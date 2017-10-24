<?php
use Core\Test\ControllerTestCase;
use Admin\Controller\IndexController;
use Admin\Model\User;
use Zend\Http\Request;
use Zend\Stdlib\Parameters;
use Zend\View\Renderer\PhpRenderer;
 
 
/**
* @group Controller
*/
class UserControllerTest extends ControllerTestCase
{
	/**
	* Namespace completa do Controller
	* @var string
	*/
	protected $controllerFQDN = 'Admin\Controller\UserController';
	
	/**
	* Nome da rota. Geralmente o nome do módulo
	* @var string
	*/
	protected $controllerRoute = 'admin';
	
	/**
	* Testa a página inicial, que deve mostrar os posts
	*/
	public function testUserIndexAction()
	{
		// Cria users para testar
		$userA = $this->addUser();
		$userB = $this->addUser();
		
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
		
		$this->assertArrayHasKey('users', $variables);
		
		// Faz a comparação dos dados
		$controllerData = $variables["users"];
		$this->assertEquals($userA->name, $controllerData[0]->name);
		$this->assertEquals($userB->name, $controllerData[1]->name);
	}
	
	/**
	* Testa a tela de inclusão de um novo registro
	* @return void
	*/
	public function testUserSaveActionNewRequest()
	{
	
		// Dispara a ação
		$this->routeMatch->setParam('action', 'save');
		$result = $this->controller->dispatch($this->request, $this->response);
		// Verifica a resposta
		$response = $this->controller->getResponse();
		$this->assertEquals(200, $response->getStatusCode());
		// Testa se recebeu um ViewModel
		$this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
		
		//verifica se existe um form
		$variables = $result->getVariables();
		$this->assertInstanceOf('Zend\Form\Form', $variables['form']);
		$form = $variables['form'];
		//testa os ítens do formulário
		$id = $form->get('id');
		$this->assertEquals('id', $id->getName());
		$this->assertEquals('hidden', $id->getAttribute('type'));
	}
	
	/**
	* Testa a tela de alteração de um user
	*/
	public function testUserSaveActionUpdateFormRequest()
	{
		$userA = $this->addUser();
		
		// Dispara a ação
		$this->routeMatch->setParam('action', 'save');
		$this->routeMatch->setParam('id', $userA->id);
		$result = $this->controller->dispatch($this->request, $this->response);
		
		// Verifica a resposta
		$response = $this->controller->getResponse();
		$this->assertEquals(200, $response->getStatusCode());
		
		// Testa se recebeu um ViewModel
		$this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
		
		$variables = $result->getVariables();
		
		//verifica se existe um form
		$variables = $result->getVariables();
		$this->assertInstanceOf('Zend\Form\Form', $variables['form']);
		$form = $variables['form'];
		
		//testa os ítens do formulário
		$id = $form->get('id');
		$name = $form->get('name');
		$this->assertEquals('id', $id->getName());
		$this->assertEquals($userA->id, $id->getValue());
		$this->assertEquals($userA->name, $name->getValue());
	}
	
	/**
	* Testa a inclusão de um novo user
	*/
	public function testUserSaveActionPostRequest()
	{
		// Dispara a ação
		$this->routeMatch->setParam('action', 'save');
		$this->request->setMethod('post');
		$this->request->getPost()->set('name', 'Bill Gates');
		$this->request->getPost()->set('password', md5('apple'));
		$this->request->getPost()->set('username', 'bill');
		$this->request->getPost()->set('valid', 1);
		$this->request->getPost()->set('role', 'admin');
		$result = $this->controller->dispatch($this->request, $this->response);
		// Verifica a resposta
		$response = $this->controller->getResponse();
		//a página redireciona, então o status = 302
		$this->assertEquals(302, $response->getStatusCode());
		$headers = $response->getHeaders();
		$this->assertEquals('Location: /admin/user', $headers->get('Location'));
		
	}
	
	public function testUserUpdateAction()
	{
		$user = $this->addUser();
		// Dispara a ação
		$this->routeMatch->setParam('action', 'save');
		$this->request->setMethod('post');
		$this->request->getPost()->set('id', $user->id);
		$this->request->getPost()->set('name', 'Alan Turing');
		$this->request->getPost()->set('password', md5('apple'));
		$this->request->getPost()->set('username', 'bill');
		$this->request->getPost()->set('valid', 1);
		$this->request->getPost()->set('role', 'admin');
		$result = $this->controller->dispatch($this->request, $this->response);
		
		$response = $this->controller->getResponse();
		//a página redireciona, então o status = 302
		$this->assertEquals(302, $response->getStatusCode());
		$headers = $response->getHeaders();
		$this->assertEquals('Location: /admin/user', $headers->get('Location'));
	}
	
	/**
	* Tenta salvar com dados inválidos
	*
	*/
	public function testUserSaveActionInvalidPostRequest()
	{
		// Dispara a ação
		$this->routeMatch->setParam('action', 'save');
		$this->request->setMethod('post');
		$this->request->getPost()->set('username', '');
		$result = $this->controller->dispatch($this->request, $this->response);
		
		//verifica se existe um form
		$variables = $result->getVariables();
		$this->assertInstanceOf('Zend\Form\Form', $variables['form']);
		$form = $variables['form'];
		
		//testa os errors do formulário
		$username = $form->get('username');
		$usernameErrors = $username->getMessages();
		$this->assertEquals("Value is required and can't be empty", $usernameErrors['isEmpty']);
	}
	
	/**
	* Testa a exclusão sem passar o id do user
	* @expectedException exception
	* @expectedExceptionMessage Código obrigatório
	*/
	public function testUserInvalidDeleteAction()
	{
		// Dispara a ação
		$this->routeMatch->setParam('action', 'delete');
		
		$result = $this->controller->dispatch($this->request, $this->response);
		// Verifica a resposta
		$response = $this->controller->getResponse();
		
	}
	
	/**
	* Testa a exclusão do user
	*/
	public function testUserDeleteAction()
	{
		$user = $this->addUser();
		// Dispara a ação
		$this->routeMatch->setParam('action', 'delete');
		$this->routeMatch->setParam('id', $user->id);
		
		$result = $this->controller->dispatch($this->request, $this->response);
		// Verifica a resposta
		$response = $this->controller->getResponse();
		//a página redireciona, então o status = 302
		$this->assertEquals(302, $response->getStatusCode());
		$headers = $response->getHeaders();
		$this->assertEquals('Location: /admin/user', $headers->get('Location'));
	}
	
	/**
	* Adiciona um user para os testes
	*/
	private function addUser()
	{
		$user = new User();
		$user->username = 'steve';
		$user->password = md5('apple');
		$user->name = 'Steve <b>Jobs</b>';
		$user->valid = 1;
		$user->role = 'admin';
		
		$em = $this->serviceManager->get('Doctrine\ORM\EntityManager');
		$em->persist($user);
		$em->flush();
		
		return $user;
	}
	
}