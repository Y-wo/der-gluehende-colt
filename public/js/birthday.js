'use strict';
import {
    apiPath, loginPath
} from "./configuration.js"
import {checkAccess} from "./base.js";

function getMembersWhoseBirtdayIsComing(){
    return fetch(apiPath + "birthdays",
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
            return JSON.parse(await response.text())
        })
}


document.addEventListener("DOMContentLoaded", async function(){
    // if(!await checkAccess()){
    //     window.location.href = loginPath;
    // }

    const birthdaysTable = $('.birthdays-table')
    const birtdayDiv = $('.birthday-div')

    const members = await getMembersWhoseBirtdayIsComing()

    //creates a table entry for each member whose birthday is coming in the next month
    if(members.length > 0){
        for(let member of members){
            let birthday = new Date(member.birthday)
            let day = birthday.getDate()
            let month = birthday.getMonth() + 1
            // add 0 to a month if it is smaller than 10 because it looks better
            let manipulatedMonth = (month < 10) ? `0${month}` : month
            let year = birthday.getFullYear()
            console.log(birthday)


            const tableRowMember = $(`<tr class='tr-${member.id}'></tr>`)
            const tableDataid = $(`<td> ${member.id} </td>`)
            const tableDataFirstName = $(`<td> ${member.firstName} </td>`)
            const tableDataLastName = $(`<td> ${member.lastName} </td>`)
            const tableDataBirthday = $(`<td> ${day}.${manipulatedMonth}.${year} </td>`)

            tableRowMember.append(
                tableDataid,
                tableDataFirstName,
                tableDataLastName,
                tableDataBirthday
            );

            birthdaysTable.append(tableRowMember);


            // checks if members birthday is today and visualizes it
            let today = new Date();
            if(day === today.getDate() && month === (today.getMonth() + 1)){
                tableRowMember.addClass('bg-info')
            }
        }
    }else{
        birthdaysTable.addClass('d-none')
        birtdayDiv.append('<p>Es stehen keine Geburtstag im nächsten Monat an</p>')
    }

})