'use strict';
import {
    path,
    apiPath,
    countDepartments,
    attendencesPerYearForGunAuhorization,
} from "./configuration.js";

// gets all members from server
async function getMembers(){
    return fetch(apiPath + "member",
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

// get member from server
function getMember(id){
    return fetch(apiPath + `member/${id}`,
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

// returns members attendance in the last year in the gun department
// info: Date is turned into miliSecond for counting (getTime())
function countMembersGunAttendanceLastYear(attendances){
    let counter = 0
    const oneYearAgoMs = new Date(new Date().setFullYear(new Date().getFullYear() - 1)).getTime();
    const todayEnd = new Date();
    todayEnd.setUTCHours(23,59,59,999);
    const todayEndMs = todayEnd.getTime()

    for (let entry of attendances){
        if(entry.department.name === "Schusswaffen"){
            const entryDate = new Date(entry.date);
            const entryDateMs = entryDate.getTime();
            if(entryDateMs <= todayEndMs && entryDateMs >= oneYearAgoMs) {
                counter++
            }
        }
    }
    return counter;
}

// checks, if member is authorized to buy a weapon
function checkWeaponAuthorization(gunAttendancesLastYear){
    return gunAttendancesLastYear >= attendencesPerYearForGunAuhorization;
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
    return fetch(apiPath + `handle-attendance/${memberId}/${departmentId}`,
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
    const tableBodyMembers = $('.table-body-members');
    let members = await getMembers();

    // creates table for each member and append it to the already existing table "tableBodyMembers"
    // therefor use information from the fetched "members"
    members.forEach(member => {
        const departmentNames = getDepartmentNames(member.memberDepartmentEntities);
        let countedAttendances = countMembersGunAttendanceLastYear(member.attendanceEntities)
        let isWeaponAuthorized = checkWeaponAuthorization(countedAttendances)
        let weaponAutorizationWord = isWeaponAuthorized ? 'ja' : 'nein'
        let weaponAuthorizationColor = isWeaponAuthorized ? 'bg-success' : 'bg-danger'
        // const isMemberTodayHere = isMemberHereToday(member.attendanceEntities)
        const departmentsWhereMemberIsInAttendanceToday = getDepartmentsWhereMemberIsInAttendanceToday(member.attendanceEntities)

        // html table elements
        const tableRowMember = $(`<tr class='tr-${member.id}'></tr>`)
        const tableDataId = $(`<td><a href="${path}member/${member.id}"> ${member.id} </a></td>`)
        const tableDataFirstName = $(`<td> ${member.firstName} </td>`)
        const tableDataLastName = $(`<td> ${member.lastName} </td>`)
        const tableDataDepartments = $(`<td> ${departmentNames} </td>`)
        let tableDataWeaponAuthorized = $(`<td class="weapon-autorization-${member.id} ${weaponAuthorizationColor} rounded"> ${weaponAutorizationWord} </td>`)
        const tableDataForCheckboxes = $(`<td></td>`)

        tableBodyMembers.append(tableRowMember)
        tableRowMember.append(tableDataId, tableDataFirstName, tableDataLastName, tableDataDepartments, tableDataForCheckboxes)

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

                // update gunAuthorization information
                // - get member new from server
                // - check again if member is authorized (and change visualization)
                let updatedMember = await getMember(member.id)
                let updatedCountedAttendances = countMembersGunAttendanceLastYear(updatedMember[0].attendanceEntities)

                let updatedIsWeaponAuthorized = checkWeaponAuthorization(updatedCountedAttendances);

                let updatedWeaponAuthorizationWord = updatedIsWeaponAuthorized ?  'ja' : 'nein';
                let updatedWeaponAuthorizationColor = updatedIsWeaponAuthorized ? 'bg-success' : 'bg-danger'

                tableDataWeaponAuthorized.html(updatedWeaponAuthorizationWord)

                if(updatedWeaponAuthorizationColor === "bg-danger" && tableDataWeaponAuthorized.hasClass('bg-success')){
                    tableDataWeaponAuthorized.removeClass("bg-success")
                    tableDataWeaponAuthorized.addClass('bg-danger')
                }else if(updatedWeaponAuthorizationColor === "bg-success" && tableDataWeaponAuthorized.hasClass('bg-danger')){
                    tableDataWeaponAuthorized.removeClass("bg-danger")
                    tableDataWeaponAuthorized.addClass('bg-success')
                }
            })
        }

        tableRowMember.append(tableDataWeaponAuthorized)
    }
    );
})