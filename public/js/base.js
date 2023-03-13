import {checkJwtStatus} from "./jwtService.js";
import {apiPath, localPath, remotePath } from "./configuration.js";

console.log("halloo from base")

export async function checkAuthorization(){
    const loginPath = localPath + "login"
    let jwtResponse = await checkJwtStatus()
    let isUserAuthentified = await jwtResponse.text()

    if(window.location.pathname !== "/der-gluehende-colt/der-gluehende-colt/public/login"){
        if(!isUserAuthentified){
            window.location.href = loginPath;
        }
    }
}

const loginPath = localPath + "login"
let jwtResponse = await checkJwtStatus()
let isUserAuthentified = await jwtResponse.text()

if(window.location.pathname !== "/der-gluehende-colt/der-gluehende-colt/public/login"){
    if(!isUserAuthentified){
        window.location.href = loginPath;
    }
}
