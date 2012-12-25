## MantenhaMe - Componente para CakePHP 2.x

### O problema

Depois que o usuário realiza o login, é comum depois de um certo tempo a sessão expirar por inatividade,
fazendo com que o usuário realize o login novamente. Isso é muito incomodo para o usuário.

### O Objetivo

Bastando o usuário marcar uma checkbox no momento do login para informar ao sistema que
ele quer se manter conectado naquele computador.

### A Solução

Este componente serve para manter o usuário conectado pelo período que você definir.

## Instalação

No seu `AppController` adicione ou crie o seu método `beforeFilter` e coloque o seguinte:


      public function beforeFilter() {
                 
        $cookie = $this->Cookie->read('Usuario');		
        
        if ($cookie and $this->Auth->loggedIn() == false) {
        
        	$partes = explode(":", @stripslashes($cookie));
        	$this->loadModel('User');
        	$usuario = $this->User->find('first', array('conditions'=>array('User.username'=>$partes[0], 'User.password'=>$partes[1])));
        	$this->Auth->login($usuario['User']);
        	
        }
        
      }

Suponhamos que você tenha um `UserController`, e obviamente com os métodos para `Login` e `Logout`.
Vamos implementá-lo colocando:

    public function login() {
			
    if ($this->Auth->login())  { 
    
    	if ($this->data['User']['mantenha_me']) {
    	
    		$usuario = $this->User->findByUsername($this->data['User']['username']);	
    		$hash = $usuario['User']['username'].':'.$usuario['User']['password'];
    		$this->Cookie->write('Usuario', $hash, false, '+2 weeks');
    		
    	}
    	else { $this->Cookie->delete('Usuario'); }
            
        }
    }
      
Feito isso, o componente guarda as informações do usuário para realizar a validação logo mais.
Para configurar o período que o sistema manterá o usuário logado, você pode mudar o valor acima, que por padrão é: `+2 weeks`.

Adicione ao `Logout` do seu `UserController`:

    public function logout() {  		  
    
       $this->Cookie->delete('Usuario');
       $this->Auth->logout();
                
    } 

## Meus contatos

* Facebook: www.facebook.com/EduardoSpek
* Twitter: www.twitter.com/EduardoSpek

