'use strict'
import {apiPath, localPath} from "./configuration.js";
import {checkJwtStatus, getJwtReponse} from "./jwtService.js";

document.addEventListener("DOMContentLoaded", async function(){

    // console.log("login.js aufgerufen")
    //
    // const submitButton = $('.submitButton')
    //
    // const passwordInput = $('.password')
    // const memberIdInput = $('.memberId')
    //
    // const indexPath = localPath
    //
    // submitButton.click(async function() {
    //     console.log("Button geklickt")
    //     let password = passwordInput.val()
    //     let memberId = memberIdInput.val()
    //
    //     let getJwtResponse = await getJwtReponse(memberId, password)
    //
    //     console.log(getJwtResponse.status)
    //
    //     // store jwt in localStorage if status is ok
    //     if(getJwtResponse.status === 200){
    //         let jwt = await getJwtResponse.text()
    //         localStorage.setItem('jwt', jwt)
    //     }
    //
    //
    //     let jwtResponse = await checkJwtStatus()
    //     let isUserAuthentified = await jwtResponse.text()
    //     if(isUserAuthentified === "true"){
    //         window.location.href = indexPath;
    //     }
    // })
})