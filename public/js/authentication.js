export function setJwt(jwt){
    sessionStorage.setItem("jwt", jwt);
}

export function isCorrectJwt(){
    let jwt = sessionStorage.getItem('jwt');
    return jwt === 'hundekind'
}
