## MantenhaMe - Componente para CakePHP 2.x

### O problema

Depois que o usuário realiza o login, é comum depois de um certo tempo a sessão expirar por inatividade,
fazendo com que o usuário realize o login novamente. Isso é muito incomodo para o usuário.

### O Objetivo

Bastando o usuário marcar uma checkbox no momento do login para informar ao sistema que
ele quer se manter conectado naquele computador.

### A Solução

Este componente serve para manter o usuário conectado pelo período que você definir.

## Requisitos

* Download do component: http://github.com/EduardoSpek/cakephp-remember-me-auto-login
* Adicione o arquivo `MantenhaMeComponent.php` na pasta `app/Controller/Component`

## Instalação

No seu `AppController` adicione ou crie o seu método `beforeFilter` e coloque o seguinte:


      public function beforeFilter() {
        
          $this->MantenhaMe->validar();
        
      }

Feito isso, o componente verificará se é para manter o usuário logado ou não.

Suponhamos que você tenha um `UserController`, e obviamente com os métodos para `Login` e `Logout`.
Vamos implementá-lo com os métodos do nosso componente `MantenhaMeComponent`, 
portanto, no seu `UserController` adicione:

    public function login() {
			
    if ($this->Auth->login())  { 
    
          $this->MantenhaMe->login('+ 2 weeks');
            
        }
    } 
      
Feito isso, o componente guarda as informações do usuário para realizar a validação logo mais.
Para configurar o período que o sistema manterá o usuário logado, você pode mudar o valor, que por padrão é: `+2 weeks`.

Adicione o método abaixo no método `Logout` do seu `UserController`:

    public function logout() {  		  
    
        $this->MantenhaMe->logout();
                
    } 

## Meus contatos

* Facebook: www.facebook.com/EduardoSpek
* Twitter: www.twitter.com/EduardoSpek

