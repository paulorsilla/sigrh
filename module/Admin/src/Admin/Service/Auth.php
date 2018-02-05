<?php
namespace Admin\Service;
 
use Core\Service\Service;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\Ldap as AuthAdapter;
//use Zend\Db\Sql\Select;
use Zend\Config\Factory as Factory;
//use Admin\Model\Usuario as Usuario;
//use Zend\Db\Sql\Sql;

/**
* Serviço responsável pela autenticação da aplicação
*
* @category Admin
* @package Service
* @author Elton Minetto<eminetto@coderockr.com>
*/
class Auth extends Service
{
	/**
	* Adapter usado para a autenticação
	* @var Zend\Db\Adapter\Adapter
	*/
	//private $dbAdapter;

	/**
	* Construtor da classe
	*
	* @return void
	*/
	public function __construct() 
	{
		/////////$this->dbAdapter = $dbAdapter;
	}

	/**
	* Faz a autenticação dos usuários
	*
	* @param array $params
	* @return array
	*/
	public function authenticate($params, $em)
	{
 		if (!isset($params['nome']) || !isset($params['senha'])) {
			throw new \exception("Parâmetros inválidos");
		}
		
		if(!is_file('./module/Admin/config/ldapconfig.php')) {
			throw new \exception("Falta arquivo de configuração ldap em: ./module/Admin/config/ldapconfig.php");
		}
		$config = new Factory();
		$options = $config->fromFile('./module/Admin/config/ldapconfig.php');
		$nome = $params['nome'];
		$senha = $params['senha'];
		
                $user = $em->getRepository('\Admin\Model\Usuario')->findOneBy(array('login' => $nome));                
                
                if ($user->valido != 1) {
                        return 'Usuário inválido ou não cadastrado';
			//Verifica se o usuário é válido ou se ele está cadastrado para utilizar o sistema
		//	throw new \exception("Usuário inválido ou não cadastrado");
		}
                if ($user->usaldap == 1) {
                    //Realiza a autenticação na base LDAP
                    $auth = new AuthenticationService();
                    $authAdapter = new AuthAdapter($options, $nome, $senha);
                    $result = $auth->authenticate($authAdapter);

                    if (!$result->isValid()) {
                            return 'Login ou senha inválidos';
    //			throw new \exception("Login ou senha inválidos");
                    }
                } else {
                    
                    $auth = new AuthenticationService();
                    $authAdapter = $this->getServiceManager()->get('doctrine.authenticationadapter.orm_default');
                    $authAdapter->setIdentityValue($nome);
                    $authAdapter->setCredentialValue(md5($senha));
                    $result = $auth->authenticate($authAdapter);
                    
                    /*if ( md5($senha) != $user->senha){
                        return 'Login ou senha inválidos (sem ldap)';
                    }*/
                    if (!$result->isValid()) {
                            return 'Login ou senha inválidos';
    //			throw new \exception("Login ou senha inválidos");
                    }
                }

		//salva o usuario na sessão
		$session = $this->getServiceManager()->get('Session');
		$session->offsetSet('user', $user);
		return true;
	}

	/**
	* Faz a autorização do usuário para acessar o recurso
	* @param string $moduleName Nome do módulo sendo acessado
	* @param string $controllerName Nome do controller
	* @param string $actionName Nome da ação
	* @return boolean
	*/
	public function authorize($moduleName, $controllerName, $actionName)
	{
		$auth = new AuthenticationService();
		$role = 'convidado';
		if ($auth->hasIdentity()) {
			$session = $this->getServiceManager()->get('Session');
			$user = $session->offsetGet('user');
			$role = $user->funcao;
                        //die('Role:'.$role);
		}
                if ( empty($role)) 
                    $role = 'convidado';
		$resource = $controllerName . '.' . $actionName;
		$acl = $this->getServiceManager()->get('Core\Acl\Builder')->build();
		if ($acl->isAllowed($role, $resource)) {
			return true;
		}
		return false;
	}
	
	/**
	* Faz o logout do sistema
	*
	* @return void
	*/
	public function logout() 
	{
		$auth = new AuthenticationService();
		$session = $this->getServiceManager()->get('Session');
		$session->offsetUnset('user');
		$auth->clearIdentity();
		return true;
	}
}