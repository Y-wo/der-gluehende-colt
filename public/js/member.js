'use strict';
import {getData} from "./helperFunctions.js"

const remoteApiPath = "http://www.invincible-projects.de/api/";
const localApiPath = "http://127.0.0.1/der-gluehende-colt/der-gluehende-colt/public/api/";

// gets all members from server
async function getMembers(){
    return fetch(localApiPath + "member",
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

// returns string with department names
function getDepartmentNames(memberDepartmentEntities){
    let departmentNames = "";
    for(let entry of memberDepartmentEntities){
        departmentNames += entry.department.name + "<br>"
    }
    return departmentNames;
}

// returns members attendance in the last year in the gut department
// info: Date is turned into miliSecond to count (getTime())
function countMembersGunAttendanceLastYear(attendances){
    let counter = 0
    const oneYearAgoMs = new Date(new Date().setFullYear(new Date().getFullYear() - 1)).getTime();
    const todayMs = new Date().getTime();

    for (let entry of attendances){
        // only count if attendance relates to department "gun"
        if(entry.department.name === "Schusswaffen"){
            const entryDate = new Date(entry.date);
            const entryDateMs = entryDate.getTime();
            if(entryDateMs <= todayMs && entryDateMs >= oneYearAgoMs) counter++
        }
    }
    return counter;
}

// checks, if member is authorized to buy a weapon
function checkWeaponAuthorization(gunAttendancesLastYear){
    return gunAttendancesLastYear >= 12;
}

// returns true if the last stored attendance entry of member in miliseconds is bigger than midnightsMiliSeconds
// and nowMiliSeconds
function isMemberHereToday(attendanceEntities){
    const now = new Date();
    const nowMs = now.getTime();
    const midnightMs = now.setHours(0,0,0,0);
    const lastAttendanceEntity = attendanceEntities.slice(-1)[0];
    const lastAttendanceEntityDate = lastAttendanceEntity.date;
    const lastAttendanceDate = new Date(lastAttendanceEntityDate)
    const lastAttendanceMs = lastAttendanceDate.getTime();

    return lastAttendanceMs >= midnightMs && lastAttendanceMs <= nowMs;
}

// set new attendance for member with departmentId
function setAttendance(memberId, departmentId){
    return fetch(localApiPath + `set-attendance/${memberId}/${departmentId}`,
        {
            method: "POST",
            headers: {
            },
            body:
                JSON.stringify({
                })
        }
    )
}


document.addEventListener("DOMContentLoaded", async function(){

    /*
        event Listener für die Checkbox einführen. Soll so klappen wie hier:
        public/js/member.js:136

        todo hier:
        checken mit der Funktion isMemberHereToday, ob Person HEUTE anwesend ist und dafür einen Wert in der Checkbox setzen

        todo
        Datums Funktionen evtl vereinfachen (keine Ms nöltig?)
     */

    const tableBodyMembers = $('.table-body-members');
    const testP = $('.test-p');
    const testBtn = $('.test-btn')
    let members = await getMembers();


    // creates table for each member
    members.forEach(member => {
        const departmentNames = getDepartmentNames(member.memberDepartmentEntities);
        const countedAttendances = countMembersGunAttendanceLastYear(member.attendanceEntities)
        const weaponAuthorization = checkWeaponAuthorization(countedAttendances) ? 'ja' : 'nein'
        const isMemberTodayHere = isMemberHereToday(member.attendanceEntities)

        const tableRowMember = $(`<tr class='tr-${member.id}'></tr>`)
        tableBodyMembers.append(tableRowMember)
        const tableDataDepartment = $(`<td></td>`)
        tableRowMember.append(tableDataDepartment)


        // create checkbox for each department and add function to set/unset attendance
        for(let entry of member.memberDepartmentEntities){
            let departmentId = entry.department.id
            let departmentName = entry.department.name

            let checkboxDepartment = $(`<input type="checkbox" data-department="${departmentId}" data-member="${member.id}">${departmentName}</input>`)

            tableDataDepartment.append(checkboxDepartment)

            checkboxDepartment.click(async function(event){

                let targetsDepartment = event.target.dataset['department']
                let targetsMember = event.target.dataset['member']
                let response = await setAttendance(targetsMember, targetsDepartment)

                console.log(await response.text())


                //if setting of attendance was successful
                // if (response.status === 201){
                //     console.log("yippie!")
                // }else{
                //
                // }

            })

        }

        console.log(member)


        tableRowMember.append("<td data-title='test' class='bla'>bla</td>")
        $('.bla').click(function(e) {
            console.log(e.target.dataset['title'])
            console.log("hello")
        });




        //appends table-row at tableBodyMembers
//         tableBodyMembers.append(
//             `<tr>
//                 <td> ${member.firstName} </td>
//                 <td> ${member.lastName} </td>
//                 <td> ${departmentNames} </td>
// <!--                <td><input type='checkbox' class='checkbox-today-${member.id}'></td>-->
//                 <td> ${checkboxes} </td>
//                 <td> ${weaponAuthorization} </td>
//             </tr>`
//         )

        // let checkboxToday = $(`.checkbox-today-${member.id}`);
        //
        //
        //
        //
        // checkboxToday.click(function(){
        //     console.log("klick! " + member.id)
        // })


    // console.log(member);
    }
    );


//    --------------------------- test






    //KLAPPT
    // testBtn.click(async function(){
    //     let testText = await getMembers();
    //     let testEntry = testText[0].street
    //     testP.append(testEntry)
    // })




})