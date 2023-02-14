'use strict';
import {
    testFunction,
    processAuthentication,
    setJwt
} from "./authentication.js"

document.addEventListener("DOMContentLoaded", function(){

    setJwt('sdfgsdfg');
    processAuthentication();

    testFunction();



    let testInput = $('.testInput')
    let testButton = $('.testButton');
    let testOutput = $('.testOutput')




    testButton.on("click",function(){
        // console.log("jquery test")
        // let content = (testInput.value === '') ? 'Kein Input vorhanden' : testInput.value;
        // testOutput.html("test ausgabe")

        $('#exampleModal').modal('toggle')

    })


})