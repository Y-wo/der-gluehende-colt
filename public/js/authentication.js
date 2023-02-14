export function testFunction(){
    console.log("test von dortidort")
}

export function setJwt(jwt){
    sessionStorage.setItem("jwt", jwt);
}

export function isCorrectJwt(){
    let jwt = sessionStorage.getItem('jwt');
    return jwt === 'hundekind'
}

export function processAuthentication(){

    console.log("processAuthentication() aufgerufen")

    if(isCorrectJwt()) {
        console.log("ZUGANG GEWÄHRT")
    }else{
        console.log("ZUGANG VERWEIGERT")
        $('#exampleModal').modal('show')
    }

}