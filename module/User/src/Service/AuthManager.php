<?php

namespace User\Service;

//use User\Entity\User;
use SigRH\Entity\Colaborador;

/**
 * The AuthManager service is responsible for user's login/logout and simple access
 * filtering.
 * The access filtering feature checks whether the current visitor
 * is allowed to see the given page or not.
 */
class AuthManager {
	/**
	 * Authentication service.
	 * 
	 * @var \Zend\Authentication\AuthenticationService
	 */
	private $authService;
	
	/**
	 * Session manager.
	 * 
	 * @var Zend\Session\SessionManager
	 */
	private $sessionManager;
	
	/**
	 * Contents of the 'access_filter' config key.
	 * 
	 * @var array
	 */
	private $config;
	
	/**
	 * Doctrine entity manager.
	 * @var Doctrine\ORM\EntityManager
	 */
	private $entityManager;
	
	/**
	 * Constructs the service.
	 */
	public function __construct($authService, $sessionManager, $config, $entityManager = null) {
		$this->authService = $authService;
		$this->sessionManager = $sessionManager;
		$this->config = $config;
		$this->entityManager = $entityManager;
	}
	
	/**
	 * Performs a login attempt.
	 * If $rememberMe argument is true, it forces the session
	 * to last for one month (otherwise the session expires on one hour).
	 */
	public function login($login, $password) {


                // Check if user has already logged in. If so, do not allow to log in
		// twice.
		if ($this->authService->getIdentity () != null) {
			throw new \Exception ( 'Already logged in' );
                }
            
                //Verifica se o usuário está cadastrado no sistema
		$user = $this->entityManager->getRepository(Colaborador::class)->findOneByLoginLocal($login);
                
		$result = new \Zend\Authentication\Result(0, null);
                
                if ($user != null) {
		
			// Authenticate with login/password.
			$authAdapter = $this->authService->getAdapter ();
			$authAdapter->setIdentity ( $login  );
                        //array('login'=>$login,'papel'=>$user->getPapel(),'nome'=>$user->getNome()/*,'matricula'=>$user->getMatricula()*/)
			$authAdapter->setCredential ( $password );
			$result = $this->authService->authenticate ();
                        if (  $result  ){
                            $this->authService->getStorage()->write(
                                    array( 'login'=>$login,
                                           'papel'=>$user->getPapel(),
                                           'nome'=>$user->getNome()
                                           /*,'matricula'=>$user->getMatricula()*/)
                                    );
                        }
			
		}
		
		return $result;
	}
	
	/**
	 * Performs user logout.
	 */
	public function logout() {
		// Allow to log out only when user is logged in.
 		if ($this->authService->getIdentity () == null) {
// 			throw new \Exception ( 'The user is not logged in' );
			return false;
 		}
		
		// Remove identity from session.
		$this->authService->clearIdentity ();
	}
	
	/**
	 * This is a simple access control filter.
	 * It is able to restrict unauthorized
	 * users to visit certain pages.
	 *
	 * This method uses the 'access_filter' key in the config file and determines
	 * whenther the current visitor is allowed to access the given controller action
	 * or not. It returns true if allowed; otherwise false.
	 */
	public function filterAccess($controllerName, $actionName) {
                $papel_usuario = "convidado";
                if ( $this->authService->hasIdentity() ) {
                    $user = $this->authService->getIdentity() ;
                    $papel_usuario = $user['papel'];
                    //papel
                }
            //echo("filterAccess : $controllerName, $actionName (modo: ".$this->config ['options'] ['mode'] .") ");
		// Determine mode - 'restrictive' (default) or 'permissive'. In restrictive
		// mode all controller actions must be explicitly listed under the 'access_filter'
		// config key, and access is denied to any not listed action for unauthorized users.
		// In permissive mode, if an action is not listed under the 'access_filter' key,
		// access to it is permitted to anyone (even for not logged in users.
		// Restrictive mode is more secure and recommended to use.
		$mode = isset ( $this->config ['options'] ['mode'] ) ? $this->config ['options'] ['mode'] : 'restrictive';
		if ($mode != 'restrictive' && $mode != 'permissive')
			throw new \Exception ( 'Invalid access filter mode (expected either restrictive or permissive mode' );

		
		if (isset ( $this->config ['controllers'] [$controllerName] )) {
                        
			$items = $this->config ['controllers'] [$controllerName];
			foreach ( $items as $item ) {
				$actionList = $item ['actions'];
				$allow = $item ['allow'];

                                
				if (is_array ( $actionList ) && in_array ( $actionName, $actionList ) || $actionList == '*') {
					if ($allow === '*'){
						return true; // Anyone is allowed to see the page.
                                        }else if ($allow === '@' && $this->authService->hasIdentity ()) {
						return true; // Only authenticated user is allowed to see the page.
					} else if ($allow == $papel_usuario ) {
						return true; // Only authenticated user is allowed to see the page.
					} else if ( is_array($allow) && in_array($papel_usuario,$allow) ) {
						return true; // Only authenticated user is allowed to see the page.
					} else {
						return false; // Access denied.
					}
				}
			}
		}
		
		// In restrictive mode, we forbid access for unauthorized users to any
		// action not listed under 'access_filter' key (for security reasons).
		if ($mode == 'restrictive' && ! $this->authService->hasIdentity ())
			return false;
			
			// Permit access to this page.
		return true;
	}
}