document.addEventListener("DOMContentLoaded", function(){


    let testInput = document.querySelector('.testInput')
    let testButton = document.querySelector('.testButton');
    let testOutput = document.querySelector('.testOutput')


    testButton.addEventListener('click', function() {
        let content = (testInput.value === '') ? 'Kein Input vorhanden' : testInput.value;
        testOutput.innerHTML = content;
    })


})