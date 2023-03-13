'use strict'
import {apiPath} from "./configuration.js";
import {getJwtReponse} from "./jwtService.js";



document.addEventListener("DOMContentLoaded", async function(){
    const submitButton = $('.submitButton')

    const passwordInput = $('.password')
    const memberIdInput = $('.memberId')



    submitButton.click(async function() {
        let password = passwordInput.val()
        let memberId = memberIdInput.val()

        let getJwtResponse = await getJwtReponse(memberId, password)

        console.log(getJwtResponse.status)

        // store jwt in localStorage if status is ok
        if(getJwtResponse.status === 200){
            let jwt = await getJwtResponse.text()
            console.log(jwt)
            localStorage.setItem('jwt', jwt)

        //     how to get storage by key:
        //     console.log(localStorage.getItem('jwt'))

        }
    })
})