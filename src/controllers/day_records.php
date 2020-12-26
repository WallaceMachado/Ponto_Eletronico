<?php
// carrega os registros de ponto do dia

session_start();
requireValidSession();// valida se tem um usuário valido na sessão se não tiver ele direciona para a tela de login

loadTemplateView('day_records');// redireciona para a view