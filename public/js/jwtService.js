import {apiPath} from "./configuration.js";

export async function getJwtReponse(memberId, password){
    return fetch(apiPath + "get-jwt",
        {
            method: "POST",
            headers: {
            },
            body:
                JSON.stringify({
                    password: password,
                    memberId: memberId
                })
        }
    )
        .then(async function (response) {
            return  response;
        })
}

export function checkJwtStatus(){
    let jwt = localStorage.getItem('jwt')
    console.log(jwt)

    return fetch(apiPath + "check-jwt",
        {
            method: "POST",
            headers: {
            },
            body:
                JSON.stringify({
                    jwt: jwt,
                })
        }
    )
        .then(async function (response) {
            return  response;
        })
}

export async function removeJwtFromLocalStorage(){
    localStorage.removeItem('jwt');
}