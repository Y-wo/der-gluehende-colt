document.addEventListener("DOMContentLoaded", function(){


    function getLoginStatus(){
        console.log('v---------------------------v')
        console.log("getLoginStatus() aufgerufen")

        sessionStorage.setItem("jwt", "hundekind");

        console.log('^---------------------------^')

        let jwt = sessionStorage.jwt

    }


    getLoginStatus()


    let testInput = document.querySelector('.testInput')
    let testButton = document.querySelector('.testButton');
    let testOutput = document.querySelector('.testOutput')


    testButton.addEventListener('click', function() {
        let content = (testInput.value === '') ? 'Kein Input vorhanden' : testInput.value;
        testOutput.innerHTML = content;
    })


})