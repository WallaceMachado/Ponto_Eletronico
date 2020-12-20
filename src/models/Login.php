<?php


loadModel('User');
class Login extends Model {

   

    // VERIFICAR SE ESTÁ LOGADO
    public function checkLogin() {
       
        $user = User::getOne(['email' => $this->email]);
         if($user) {
            if($user->end_date) {// atributo que informa se o usuário ainda é funcionario da empresa ou foi desligado
                throw new AppException('Usuário está desligado da empresa.');
            }

            if(password_verify($this->password, $user->password)) {
                return $user;
            }
        }
        
            throw new AppException('Usuário e Senha inválidos.');
    }
}