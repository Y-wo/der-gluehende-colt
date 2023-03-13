'use strict';
import {
    apiPath,
    countDepartments,
    attendencesPerYearForGunAuhorization, loginPath
} from "./configuration.js";
import {checkAccess} from "./base.js";

document.addEventListener("DOMContentLoaded", async function(){
    if(!await checkAccess()){
        window.location.href = loginPath;
    }
})