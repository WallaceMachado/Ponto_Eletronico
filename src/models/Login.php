<?php


loadModel('User');
class Login extends Model {

   

    // VERIFICAR SE ESTÁ LOGADO
    public function checkLogin() {
       
        $user = User::getOne(['email' => $this->email]);
        

            // VERIFICA SE A SENHA É CORRETA password_verificy é interno do php
            if(password_verify($this->password, $user->password)) {
                return $user;
            }
        
        throw new Exception();
    }
}