import {removeJwtFromLocalStorage} from "./jwtService.js";
import {checkJwtStatus} from "./jwtService.js";
import {checkAccess} from "./base.js";
import {localPath, loginPath} from "./configuration.js";


await removeJwtFromLocalStorage();
let jwtResponse = await checkJwtStatus()
let isUserAuthentified = await jwtResponse.text()



if(!await checkAccess()){
    window.location.href = loginPath;
}






