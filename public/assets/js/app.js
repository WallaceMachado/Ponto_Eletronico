// codigo em java script, não precisa de ;
//hard load na pagina para carregar o JS ctrl + shift + r
(function () {
    const menuToggle = document.querySelector('.menu-toggle')
    menuToggle.onclick = function (e) {
        const body = document.querySelector('body')
        body.classList.toggle('hide-sidebar')
    }
})()

function ativarRelogio() {
    const relogioAtivo = document.querySelector('[ative-relogio]')
    if(!relogioAtivo) return // retorna nullo

    function addUmSegundo(hours, minutes, seconds) {
        const d = new Date()
        d.setHours(parseInt(hours))
        d.setMinutes(parseInt(minutes))
        d.setSeconds(parseInt(seconds) + 1)
    
        const h = `${d.getHours()}`.padStart(2, 0)//padstart formata para numero de cartere que a variavel terá + o numero que será usado para completar caso não tenha 2
        const m = `${d.getMinutes()}`.padStart(2, 0)
        const s = `${d.getSeconds()}`.padStart(2, 0)
    
        return `${h}:${m}:${s}`
    }

    setInterval(function() {
        // '07:27:19' => ['07', '27', '19']
        const parts = relogioAtivo.innerHTML.split(':')//transforma uma straing em array conform acima
        relogioAtivo.innerHTML = addUmSegundo(...parts)
    }, 1000)
}

ativarRelogio()// chama a função a cima