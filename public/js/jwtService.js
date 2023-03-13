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

    if()

    let jwt = localStorage.getItem('jwt')
    console.log(jwt)
}

export async function removeJwtFromLocalStorage(){
    localStorage.removeItem('jwt');
}