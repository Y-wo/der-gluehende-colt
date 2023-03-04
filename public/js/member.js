'use strict';
import {getData} from "./helperFunctions.js"

const remoteApiPath = "http://www.invincible-projects.de/api/";
const localApiPath = "http://127.0.0.1/der-gluehende-colt/der-gluehende-colt/public/api/";

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

// return string with department names
function getDepartmentNames(memberDepartmentEntities){
    let departmentNames = "";
    for(let entry of memberDepartmentEntities){
        departmentNames += entry.department.name + "<br>"
        console.log(entry)
    }
    return departmentNames;
}

function countMembersAttendance(attendances){
    let counter = 0
    for (let entry of attendances){
        counter++
    }
    return counter
}



document.addEventListener("DOMContentLoaded", async function(){

    /*
        todo hier:
        Anwesenheiten in diesem Jahr checken oder was war das andere?

        todo hier:
        checken, ob Person HEUTE anwesend ist und dafür einen Wert in der Checkbox setzen



     */

    const tableBodyMembers = $('.table-body-members');

    let members = await getMembers()


    // create table for each member
    members.forEach(member => {
        const departmentNames = getDepartmentNames(member.memberDepartmentEntities);
        const countedAttendances = countMembersAttendance(member.attendanceEntities)
        tableBodyMembers.append(
            "<tr>" +
                "<td>" + member.firstName + "</td>" +
                "<td>" + member.lastName + "</td>" +
                "<td>" + departmentNames + "</td>" +
                "<td><input type='checkbox'></td>" +
                "<td>" + countedAttendances + "</td>" +
            "</tr>"
        )
    console.log(member);
    }
    );


})