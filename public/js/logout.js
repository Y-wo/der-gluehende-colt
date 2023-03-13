import {removeJwtFromLocalStorage} from "./jwtService.js";
import {checkJwtStatus} from "./jwtService.js";
import {checkAuthorization} from "./base.js";
import {localPath} from "./configuration.js";




await removeJwtFromLocalStorage()

const loginPath = localPath + "login"
let jwtResponse = await checkJwtStatus()
let isUserAuthentified = await jwtResponse.text()

if(window.location.pathname !== "/der-gluehende-colt/der-gluehende-colt/public/login"){
    if(isUserAuthentified === "false"){
        console.log(isUserAuthentified)
        console.log("weeeeeeeeeeeeeg")
        window.location.href = loginPath;
    }
}


