export function deleteSet(id){
    if(confirm("Are you shure you want to permamently delete set with id " + id +"?")){
        console.log("deleting...")
        const html = new XMLHttpRequest()
        html.onload = () => {
            location.reload()
        }
        html.onerror = () => {

        }
        html.open("DELETE", "/setCreator/delete/"+id)
        html.send()
    }
}

export function deleteUser(id){
    if(confirm("Are you shure you want to permamently delete set with id " + id +"?")){
        console.log("deleting...")
        const html = new XMLHttpRequest()
        html.onload = () => {
            location.reload()
        }
        html.onerror = () => {

        }
        html.open("DELETE", "/user/delete/"+id)
        html.send()
    }
}

window.deleteUser = deleteUser;
window.deleteSet = deleteSet;