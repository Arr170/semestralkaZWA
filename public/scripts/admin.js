let BASE_URL = ""
const url = window.location.href
if (url.includes("~kupriars")) {
    BASE_URL = "/~kupriars"
}

export function deleteSet(id) {
    if (confirm("Are you sure you want to permamently delete set with id " + id + "?")) {
        const html = new XMLHttpRequest()
        html.onload = () => {
            location.reload()
        }
        html.onerror = () => {
            alert("Error while deleting!")
        }
        html.open("DELETE", BASE_URL + "/setCreator/delete/" + id)
        html.send()
    }
}

export function deleteUser(id) {
    if (confirm("Are you sure you want to permamently delete user with id " + id + "?")) {
        const html = new XMLHttpRequest()
        html.onload = () => {
            location.reload()
        }
        html.onerror = () => {
            alert("Error while deleting!")
        }
        html.open("DELETE", BASE_URL + "/user/delete/" + id)
        html.send()
    }
}

window.deleteUser = deleteUser;
window.deleteSet = deleteSet;