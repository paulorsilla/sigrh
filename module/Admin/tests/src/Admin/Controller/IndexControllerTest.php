<?php
 
use Core\Test\ControllerTestCase;
use Admin\Controller\IndexController;
use Application\Model\Post;
use Zend\Http\Request;
use Zend\Stdlib\Parameters;
use Zend\View\Renderer\PhpRenderer;
 
 
/**
* @group Controller
*/
class IndexControllerTest extends ControllerTestCase
{
	/**
	* Namespace completa do Controller
	* @var string
	*/
	protected $controllerFQDN = 'Admin\Controller\IndexController';
	
	/**
	* Nome da rota. Geralmente o nome do módulo
	* @var string
	*/
	protected $controllerRoute = 'admin';
	
	/**
	* Testa o acesso a uma action que não existe
	*/
	public function test404()
	{
		$this->routeMatch->setParam('action', 'action_nao_existente');
		$result = $this->controller->dispatch($this->request);
		$response = $this->controller->getResponse();
		$this->assertEquals(404, $response->getStatusCode());
	}
	
	/**
	* Testa a tela de inclusão de um novo registro
	* @return void
	*/
	public function testSaveActionNewRequest()
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
	* Testa a alteração de um post
	*/
	public function testSaveActionUpdateFormRequest()
	{
		$postA = $this->addPost();
		
		// Dispara a ação
		$this->routeMatch->setParam('action', 'save');
		$this->routeMatch->setParam('id', $postA->id);
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
		$title = $form->get('title');
		$this->assertEquals('id', $id->getName());
		$this->assertEquals($postA->id, $id->getValue());
		$this->assertEquals($postA->title, $title->getValue());
	}
	
	/**
	* Testa a inclusão de um novo post
	*/
	public function testSaveActionPostRequest()
	{
		// Dispara a ação
		$this->routeMatch->setParam('action', 'save');
		$this->request->setMethod('post');
		$this->request->getPost()->set('title', 'Apple compra a Coderockr');
		$this->request->getPost()->set(
		'description', 'A Apple compra a <b>Coderockr</b><br> '
		);
		$result = $this->controller->dispatch($this->request, $this->response);
		// Verifica a resposta
		$response = $this->controller->getResponse();
		//a página redireciona, então o status = 302
		$this->assertEquals(302, $response->getStatusCode());
		
		//verifica se salvou
		$posts = $this->getTable('Application\Model\Post')->fetchAll()->toArray();
		$this->assertEquals(1, count($posts));
		$this->assertEquals('Apple compra a Coderockr', $posts[0]['title']);
		$this->assertNotNull($posts[0]['post_date']);
	}
	
	/**
	* Tenta salvar com dados inválidos
	*
	*/
	public function testSaveActionInvalidPostRequest()
	{
		// Dispara a ação
		$this->routeMatch->setParam('action', 'save');
		$this->request->setMethod('post');
		$this->request->getPost()->set('title', '');
		$result = $this->controller->dispatch($this->request, $this->response);
		
		//verifica se existe um form
		$variables = $result->getVariables();
		$this->assertInstanceOf('Zend\Form\Form', $variables['form']);
		$form = $variables['form'];
		
		//testa os errors do formulário
		$title = $form->get('title');
		$titleErrors = $title->getMessages();
		$this->assertEquals("Value is required and can't be empty", $titleErrors['isEmpty']);
		
		$description = $form->get('description');
		$descriptionErrors = $description->getMessages();
		$this->assertEquals("Value is required and can't be empty", $descriptionErrors['isEmpty']);
	}
	
	/**
	* Testa a exclusão sem passar o id do post
	* @expectedException exception
	* @expectedExceptionMessage Código obrigatório
	*/
	public function testInvalidDeleteAction()
	{
		$post = $this->addPost();
		// Dispara a ação
		$this->routeMatch->setParam('action', 'delete');
		
		$result = $this->controller->dispatch($this->request, $this->response);
		// Verifica a resposta
		$response = $this->controller->getResponse();
		
	}
	
	/**
	* Testa a exclusão do post
	*/
	public function testDeleteAction()
	{
		$post = $this->addPost();
		// Dispara a ação
		$this->routeMatch->setParam('action', 'delete');
		$this->routeMatch->setParam('id', $post->id);
		
		$result = $this->controller->dispatch($this->request, $this->response);
		// Verifica a resposta
		$response = $this->controller->getResponse();
		//a página redireciona, então o status = 302
		$this->assertEquals(302, $response->getStatusCode());
		
		//verifica se excluiu
		$posts = $this->getTable('Application\Model\Post')->fetchAll()->toArray();
		$this->assertEquals(0, count($posts));
	}
	
	/**
	* Adiciona um post para os testes
	*/
	private function addPost()
	{
	        date_default_timezone_set("America/Sao_Paulo");
		$post = new Post();
		$post->title = 'Apple compra a Coderockr';
		$post->description = 'A Apple compra a <b>Coderockr</b><br> ';
		$post->post_date = date('Y-m-d H:i:s');
		
		$saved = $this->getTable('Application\Model\Post')->save($post);
		
		return $saved;
	}
}