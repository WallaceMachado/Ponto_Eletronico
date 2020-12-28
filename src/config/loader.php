<?php
// carregar classes

function loadModel($modelName) {
    require_once(MODEL_PATH . "/{$modelName}.php");
}

function loadView($viewName, $params = array()) {

    if(count($params) > 0) {
        foreach($params as $key => $value) {
            if(strlen($key) > 0) {// verifica o tamanho da strinh se é maior do que zero
                ${$key} = $value;
            }
        }
    }

    require_once(VIEW_PATH . "/{$viewName}.php");
}

// carrega os templates de tela
function loadTemplateView($viewName, $params = array()) {

    if(count($params) > 0) {
        foreach($params as $key => $value) {
            if(strlen($key) > 0) {
                ${$key} = $value;
            }
        }
    }

    $user = $_SESSION['user'];
    $workingHours = WorkingHours::loadFromUserAndDate($user->id, date('Y-m-d'));
    $horasTrabalhadas = $workingHours->obterIntervalosTrabalhados()->format('%H:%I:%S');// format transforma para string
    $HoraDeSaida = $workingHours->obterHoraDeSaida()->format('H:i:s');// format transforma para string
    

       
    require_once(TEMPLATE_PATH . "/header.php"); // template da view cabeçalho de pagina
    require_once(TEMPLATE_PATH . "/left.php");// menu lateral
    require_once(VIEW_PATH . "/{$viewName}.php");
    require_once(TEMPLATE_PATH . "/footer.php");// rodapé de pagina
    
   
}

function renderTitle($title, $subtitle, $icon = null) {
    require_once(TEMPLATE_PATH . "/title.php");
}

