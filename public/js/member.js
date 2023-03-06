'use strict';
import {getData} from "./helperFunctions.js"

const remoteApiPath = "http://www.invincible-projects.de/api/";
const localApiPath = "http://127.0.0.1/der-gluehende-colt/der-gluehende-colt/public/api/";

// gets all members from server
function getMembers(){
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
        console.log(entry)
    }
    return departmentNames;
}

// returns members attendance in the last year
// info: Date is turned into miliSecond to count (getTime())
function countMembersAttendanceLastYear(attendances){
    let counter = 0
    const oneYearAgoMs = new Date(new Date().setFullYear(new Date().getFullYear() - 1)).getTime();
    const todayMs = new Date().getTime();

    for (let entry of attendances){
        const entryDate = new Date(entry.date);
        const entryDateMs = entryDate.getTime();
        if(entryDateMs <= todayMs && entryDateMs >= oneYearAgoMs) counter++
    }
    return counter;
}

// checks, if member is authorized to buy a weapon
function checkWeaponAuthorization(attendancesLastYear){
    return attendancesLastYear >= 12;
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


document.addEventListener("DOMContentLoaded", async function(){

    /*
        todo hier:
        checken mit der Funktion isMemberHereToday, ob Person HEUTE anwesend ist und dafür einen Wert in der Checkbox setzen
     */

    const tableBodyMembers = $('.table-body-members');
    let members = await getMembers()


    // creates table for each member
    members.forEach(member => {
        const departmentNames = getDepartmentNames(member.memberDepartmentEntities);
        const countedAttendances = countMembersAttendanceLastYear(member.attendanceEntities)
        const weaponAuthorization = checkWeaponAuthorization(countedAttendances) ? 'ja' : 'nein'
        const isMemberTodayHere = isMemberHereToday(member.attendanceEntities)

        console.log(isMemberTodayHere)

        //appends table-row at tableBodyMembers
        tableBodyMembers.append(
            `<tr>
                <td> ${member.firstName} </td>
                <td> ${member.lastName} </td>
                <td> ${departmentNames} </td>
                <td><input type='checkbox' class='checkbox-today-${member.id}'></td>
                <td> ${weaponAuthorization} </td>
            </tr>`
        )

        let checkboxToday = $(`.checkbox-today-${member.id}`);



        checkboxToday.click(function(){
            console.log("klick! " + member.id)
        })


    console.log(member);
    }
    );


})