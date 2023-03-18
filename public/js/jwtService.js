import {apiPath} from "./configuration.js";

export async function getJwtReponse(){
    return fetch(apiPath + "get-jwt",
        {
            method: "POST",
            headers: {
            },
            body:
                JSON.stringify({
                })
        }
    )
        .then(async function (response) {
            console.log(response)
            return  response;
        })
}

export function setJwt(jwt){
    localStorage.setItem('jwt', jwt)
}

export function getJwt(){
    return localStorage.getItem('jwt')
}

async function removeJwt(){
    localStorage.removeItem('jwt');
}
