<?php
/*
  ****************************************************
	****** MantenhaMeComponent para CakePHP 2.x ********
	** Desenvolvido por Eduardo Barros Freire (Spek) ***
	** Facebook: www.facebook.com/EduardoSpek **********
	** Twitter: @EduardoSpek ***************************
	****************************************************	
*/
class MantenhaMeComponent extends Component {

	public $components = array('Auth', 'Cookie');
	
	public function validar() {
		
		//Lemos o cookie com os dados de acesso do usuário
		$cookie = $this->Cookie->read('Usuario');		
		
		/* 
			Verificamos se existe dados armazenados no cookie e se não há nenhuma sessão aberta
			Incorporamos o model User, pesquisamos pelo usuário com seus dados e realizamos o login
		*/
		if ($cookie and $this->Auth->loggedIn() == false) {
			
			$partes = explode(":", stripslashes($cookie));
			$this->loadModel('User');
			$usuario = $this->User->find('first', array('conditions'=>array('User.username'=>$partes[0], 'User.password'=>$partes[1])));
			$this->Auth->login($usuario['User']);				
				
		}
			
	}
	
	public function login($periodo) {
		
		//Se a checkbox foi marcada pelo usuário, registramos os dados no cookie
		if ($this->data['User']['mantenha_me']) {
					
			$usuario = $this->User->findByUsername($this->data['User']['username']);	
			$hash = $usuario['User']['username'].':'.$usuario['User']['password'];
			$this->Cookie->write('Usuario', $hash, false, $periodo);
						
		} 
		//Caso contrário, apagamos o cookie caso exista
		else { $this->Cookie->delete('Usuario'); }
			
	}
	
	public function logout() {
		
		//Apagamos o cookie caso exista e efetuamos o logout no AuthComponent, fechando assim, a sessão do usuário.
		$this->Cookie->delete('Usuario');
		$this->Auth->logout();
		
	}


}
