'use strict'
document.addEventListener("DOMContentLoaded", function(){

    console.log("test aus login.script")

    let jwtPath = "http://127.0.0.1/der-gluehende-colt/der-gluehende-colt/public/test"

    function getJwt(){
        fetch(jwtPath,
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
                console.log(await response.text())
            })
    }


    getJwt()
})