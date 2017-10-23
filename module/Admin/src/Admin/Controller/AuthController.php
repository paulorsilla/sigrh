<?php
namespace Admin\Controller;
 
use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Admin\Form\Login;
 
/**
* Controlador que gerencia os posts
*
* @category Admin
* @package Controller
* @author Elton Minetto<eminetto@coderockr.com>
*/
class AuthController extends ActionController
	{
	/**
	* Mostra o formulário de login
	* @return void
	*/
	public function indexAction()
	{
		$form = new Login();
		return new ViewModel(array(
			'form' => $form
		));
	}
	
	/**
	* Faz o login do usuário
	* @return void
	*/
	public function loginAction()
	{
		$request = $this->getRequest();
		if (!$request->isPost()) {
			throw new \exception('Acesso inválido');
		}
	
		$data = $request->getPost();
		$service = $this->getService('Admin\Service\Auth');
                $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		$auth = $service->authenticate(
                                    array('nome' => $data['nome'], 'senha' => $data['senha']), $em
                                               );
		return $this->redirect()->toUrl('/');
	}
	
	/**
	* Faz o logout do usuário
	* @return void
	*/
	public function logoutAction()
	{
		$service = $this->getService('Admin\Service\Auth');
		$auth = $service->logout();
		return $this->redirect()->toUrl('/');
	}
}