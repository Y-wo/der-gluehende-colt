import {apiPath, loginPath} from "../js/configuration.js";
import {checkJwtStatus} from "../js/jwtService.js";
import {checkAccess} from "../js/base.js";

document.addEventListener("DOMContentLoaded", async function(){
    // if(!await checkAccess()){
    //     window.location.href = loginPath;
    // }
})