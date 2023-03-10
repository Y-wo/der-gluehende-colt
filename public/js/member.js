'use strict';

// CONFIGURATION VARIABLES
const countDepartments = 3
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

// determines departments where member is in attendance today
function getDepartmentsWhereMemberIsInAttendanceToday(attendanceEntities){
    const now = new Date();
    const midnightMs = now.setHours(0,0,0,0);
    const departments = []

    // limits attendances to 3 (see variable "countDepartments") because of performance (there are only a few departments)
    const lastAttendances = attendanceEntities.slice(-countDepartments)

    for(let attendance of lastAttendances){
        let attendanceDate = new Date(attendance.date)
        if(attendanceDate > midnightMs) {
            departments.push(attendance.department.id)
        }
    }
    return departments;
}


// sets new attendance for member with departmentId
function setAttendance(memberId, departmentId){
    return fetch(localApiPath + `handle-attendance/${memberId}/${departmentId}`,
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
        todo
        Datums Funktionen evtl vereinfachen (keine Ms nöltig?)
     */


    const tableBodyMembers = $('.table-body-members');
    const testP = $('.test-p');
    const testBtn = $('.test-btn')
    let members = await getMembers();


    console.log(members);

    // creates table for each member and use information from the fetched "members"
    members.forEach(member => {

        const departmentNames = getDepartmentNames(member.memberDepartmentEntities);
        const countedAttendances = countMembersGunAttendanceLastYear(member.attendanceEntities)
        const weaponAuthorization = checkWeaponAuthorization(countedAttendances) ? 'ja' : 'nein'
        // const isMemberTodayHere = isMemberHereToday(member.attendanceEntities)
        const departmentsWhereMemberIsInAttendanceToday = getDepartmentsWhereMemberIsInAttendanceToday(member.attendanceEntities)

        // html table elements
        const tableRowMember = $(`<tr class='tr-${member.id}'></tr>`)
        const tableDataFirstName = $(`<td> ${member.firstName} </td>`)
        const tableDataLastName = $(`<td> ${member.lastName} </td>`)
        const tableDataDepartments = $(`<td> ${departmentNames} </td>`)
        const tableDataWeaponAuthorized = $(`<td> ${weaponAuthorization} </td>`)
        const tableDataForCheckboxes = $(`<td></td>`)

        tableBodyMembers.append(tableRowMember)
        tableRowMember.append(tableDataFirstName, tableDataLastName, tableDataDepartments, tableDataForCheckboxes)

        // creates checkbox for each department
        // adds function to set/unset attendance
        // appends checkbox to tableDataForCheckboxes
        for(let entry of member.memberDepartmentEntities){
            let departmentId = entry.department.id
            let departmentName = entry.department.name

            let checkboxDepartment = $(`<input type="checkbox" data-department="${departmentId}" data-member="${member.id}">${departmentName}</input>`)

            // set checkbox checked, if member is in attendance today
            if(departmentsWhereMemberIsInAttendanceToday.includes(departmentId)) checkboxDepartment.prop("checked", true)

            tableDataForCheckboxes.append(checkboxDepartment)

            // add click-EventListener for setting/unsetting the attendance today
            checkboxDepartment.click(async function(event){
                let targetsDepartment = event.target.dataset['department'];
                let targetsMember = event.target.dataset['member'];
                let response = await setAttendance(targetsMember, targetsDepartment);

                console.log("Status: " + response.status);
                console.log(await response.text());


            })
        }

        tableRowMember.append(tableDataWeaponAuthorized)
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