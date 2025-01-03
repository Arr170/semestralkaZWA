import { Card, CardsSet } from "./set.js"

const params = new URL(window.location.href).searchParams
const setName = document.getElementById("set-name")
const cardText = document.getElementById("set-card-text")
const cardImg = document.getElementById("set-card-img")
const ctrlLeft = document.getElementById("go-back")
const ctrlRight = document.getElementById("go-forward")
const flipFront = document.getElementById("flip-front")
const flipBack = document.getElementById("flip-back")
const addBtn = document.getElementById("add-new")
const previewFront = document.getElementById("set-preview-question")
const previewBack = document.getElementById("set-preview-answer")
const previewFrontImg = document.getElementById("img-preview-front")
const previewBackImg = document.getElementById("img-preview-back")
const counterSpan = document.getElementById("counter")
const privateCheckBtn = document.getElementById("set-private")
const deleteCardBtn = document.getElementById("delete-card-btn")
const deleteSetBtn = document.getElementById("delete-set-btn")

const html = new XMLHttpRequest()
let BASE_URL = ""
const url = window.location.href
if (url.includes("~kupriars")) {
    BASE_URL = "/~kupriars"
}




let activeSet = null
let activeCard = null
let page = 0
let activeSide = "front"

const reader = new FileReader()

export function loadSet() {
    const url = window.location.href
    const parts = url.split("/")
    const urlLen = parts.length
    const indexPos = parts.indexOf("index")
    const setId = parts[indexPos + 1]




    html.onerror = () => {
        alert("Error while uploading set!")
    }

    if (setId) {
        html.onload = () => {
            try {
                const jsonData = JSON.parse(html.response)
                parseResponse(jsonData)
                setName.value = jsonData.name
            } catch (error) {
                console.error("Failed to parse JSON:", error)
            }

        }
        html.open("GET", BASE_URL + "/setCreator/get/" + setId)
        html.setRequestHeader("Content-Type", "application/json")
        html.send()
    }
    else {
        html.onload = () => {
            try {
                const jsonData = JSON.parse(html.response)
                setUrlId(jsonData.id)
                
            } catch (error) {
                alert("Failed to parse JSON:", error)
            }

        }
        html.open("GET", BASE_URL + "/setCreator/initSet")
        html.setRequestHeader("Content-Type", "application/json")
        html.send()
    }
}

function controllerManager() {
    const cardsInSet = activeSet.cards.length
    if (page == 0) {
        ctrlLeft.setAttribute("disabled", "true")
    }
    else {
        ctrlLeft.removeAttribute("disabled")
    }

    if (cardsInSet <= page) {
        ctrlRight.setAttribute("disabled", "true")
    }
    else {
        ctrlRight.removeAttribute("disabled")
    }

    if (activeSide === "front") {
        flipFront.setAttribute("disabled", true)
        flipBack.removeAttribute("disabled")
    }
    else {
        flipFront.removeAttribute("disabled")
        flipBack.setAttribute("disabled", true)
    }
    updateCounter(cardsInSet)

}


function addNewCard() {
    html.onload = () => {
        const jsonData = JSON.parse(html.response)
        activeCard = new Card()
        activeCard.id = jsonData.id

        page = activeSet.cards.length

        if (!activeSet.cards.includes(activeCard)) {
            activeSet.cards.push(activeCard)
        }

        loadCard("front")
        loadPreview()
    }

    html.onerror = () => {
        alert("Error in adding new cards!")
    }

    html.open("GET", BASE_URL + "/setCreator/newCard/" + activeSet.id)
    html.send()
}

function setUrlId(id) {
    const url = window.location.href
    const parts = url.split("/")
    const urlLen = parts.length
    const indexPos = parts.indexOf("index")
    const setId = parts[indexPos + 1]
    let newUrl = ""
    let i = 0
    for (i; i <= indexPos; i++) {
        newUrl = newUrl + parts[i] + "/"
    }
    newUrl = newUrl + id
    window.location.href = newUrl
}

function parseResponse(response) {
    let set = new CardsSet()
    set.id = response.id
    set.author_id = response.author_id
    set.is_private = response.private
    privateCheckBtn.checked = set.is_private == "true"? true : false;
    set.name = response.name
    response.cards.forEach(c => {
        let card = new Card()
        card.id = c.id
        card.set_id = c.set_id
        card.question = c.question
        card.question_image_url = c.question_img_url
        card.answer = c.answer
        card.answer_image_url = c.answer_img_url
        set.cards.push(card)
    })
    activeSet = set
    activeCard = set.cards[0]

    page = 0
    loadCard("front")
    loadPreview()
    controllerManager()
}

function loadCard(side) {
    if (side === "front") {
        activeSide = "front"
        cardText.value = activeCard.question
    }
    else {
        cardText.value = activeCard.answer
    }
    controllerManager()
}

function prevCard() {
    if (page > 0) {
        page -= 1
        activeCard = activeSet.cards[page]
        loadCard("front")
        loadPreview()
        controllerManager()
    }
}


function nextCard() {
    const cardsInSet = activeSet.cards.length
    if (page < cardsInSet - 1) {
        page += 1
        activeCard = activeSet.cards[page]
        loadCard("front")
        loadPreview()
        controllerManager()
    }
}

// updates gui and send new name to server
function updateSetName() {
    activeSet.name = setName.value
    html.onload = () => { }
    html.onerror = () => {
        alert("somethign went wrong. Update name error")
    }

    html.open("POST", BASE_URL + "/setCreator/updateSetName/" + activeSet.id)
    const data = JSON.stringify({
        id: activeSet.id,
        newName: activeSet.name
    })
    html.setRequestHeader("Content-Type", "application/json")
    html.send(data)

}

function updatePrivateSetting() {
    activeSet.is_private = privateCheckBtn.checked
    html.onload = () => { }
    html.onerror = () => {
        alert("Something went wring. Update private error")
    }

    html.open("POST", BASE_URL + "/setCreator/updateSetPrivate/" + activeSet.id)
    const data = JSON.stringify({
        id: activeSet.id,
        isPrivate: activeSet.is_private
    })
    html.setRequestHeader("Content-Type", "application/json")
    html.send(data)
}

export function loadPreviewImgFront() {
    const imgUrl = activeCard.question_image_url

    if (imgUrl) {
        previewFrontImg.src = BASE_URL + "/setCreator/serveImg/" + imgUrl
    }
    else {
        previewFrontImg.src = BASE_URL + "/public/static/question.png"
    }


}

export function loadPreviewImgBack() {
    const imgUrl = activeCard.answer_image_url

    if (imgUrl) {
        previewBackImg.src = BASE_URL + "/setCreator/serveImg/" + imgUrl
    }
    else {
        previewBackImg.src = BASE_URL + "/public/static/answer.png"
    }

}

export function loadPreview() {
    previewFront.textContent = activeCard.question ? activeCard.question : ""
    previewBack.textContent = activeCard.answer ? activeCard.answer : ""
    loadPreviewImgBack()
    loadPreviewImgFront()
    cardImg.value = ''


}

export function flipToFront() {
    loadCard("front")
    activeSide = "front"
    flipFront.setAttribute("disabled", true)
    flipBack.removeAttribute("disabled")
}

export function flipToBack() {
    loadCard("back")
    activeSide = "back"
    flipFront.removeAttribute("disabled")
    flipBack.setAttribute("disabled", true)
}

function updateCardText() {
    activeSet.is_private = privateCheckBtn.checked
    html.onload = () => {

    }
    html.onerror = () => {
        alert("Error while updating card name")
    }

    let data = null

    if (activeSide === "front") {
        activeCard.question = cardText.value
        previewFront.textContent = activeCard.question ? activeCard.question : ""
        data = JSON.stringify({
            id: activeCard.id,
            setId: activeSet.id,
            text: activeCard.question,
            side: "front"
        })
    }
    else {
        activeCard.answer = cardText.value
        previewBack.textContent = activeCard.answer ? activeCard.answer : ""
        data = JSON.stringify({
            id: activeCard.id,
            setId: activeSet.id,
            text: activeCard.answer,
            side: "back"
        })
    }

    html.open("POST", BASE_URL + "/setCreator/updateCardText/" + activeCard.id)

    html.setRequestHeader("Content-Type", "application/json")
    html.send(data)
}

function resizeImg(file) {
    return new Promise((resolve, reject) => {
        const img = new Image();
        const reader = new FileReader()

        reader.onload = function(event) {
            img.src = event.target.result
        };

        reader.onerror = function() {
            reject("Error reading file.")
        };

        reader.readAsDataURL(file)

        img.onload = function() {

            const max_h = 512
            const max_w = 512
            const ratio = img.height / img.width

            let new_h = img.height
            let new_w = img.width

            if (img.height != max_h) {
                new_h = max_h
                new_w = Math.round(max_h / ratio)
            }

            if (new_w != max_w) {
                new_w = max_w
                new_h = Math.round(ratio * new_w)
            }

            const canvas = document.createElement("canvas")
            const context = canvas.getContext("2d")

            canvas.width = new_w
            canvas.height = new_h

            context.drawImage(img, 0, 0, canvas.width, canvas.height)

            canvas.toBlob((blob) => {
                const resizedFile = new File([blob], file.name, { type: file.type })
                resolve(resizedFile)
            }, file.type)
        }
    })
}

function updateCardImg() {
    const formData = new FormData()

    const cardInfo = JSON.stringify({
        setId: activeSet.id,
        cardId: activeCard.id,
        cardSide: activeSide,
    });

    formData.append("cardInfo", cardInfo)

    const file = cardImg.files[0]

    resizeImg(file).then((resizedFile) => {
        formData.append("image", resizedFile)

        const html = new XMLHttpRequest()
        html.onload = () => {
            const jsonData = JSON.parse(html.response)
            console.log(jsonData)
            if (activeSide == "front") {
                activeCard.question_image_url = jsonData.question_img_url
                loadPreviewImgFront()
            } else {
                activeCard.answer_image_url = jsonData.answer_img_url
                loadPreviewImgBack()
            }
        };

        html.onerror = () => {
            alert("Error while updating image.")
        };

        html.open("POST", BASE_URL + "/setCreator/updateCardImg/" + activeCard.id)
        html.send(formData)

    }).catch((err) => {
        console.error("Error resizing image: ", err)
    })
}   


function updateCounter(cardsInSet) {
    counterSpan.textContent = (page + 1) + '/' + cardsInSet
}

function deleteCard(){
    if(confirm("Are you sure you want delete this card?")){
        if(activeSet.cards.length > 1){

        html.onload = () => {
            location.reload()
        }
        html.onerror = () => {
            alert("Something went wrong while deliting card.")
            location.reload()
        }
        html.open("DELETE", BASE_URL+"/setCreator/deleteCard/"+activeCard.id)
        html.send()
        }
        else{
            alert("Set can not be empty. You can delete the set.")
        }
    }
}

function deleteSet(){
    if(confirm("Are you sure you want delete this set?")){

        html.onload = () => {
            location.href = BASE_URL+"/user/"
        }
        html.onerror = () => {
            alert("Something went wrong while deliting set.")
            location.reload()
        }
        html.open("DELETE", BASE_URL+"/setCreator/delete/"+activeSet.id)
        html.send()

    }
}


setName.addEventListener("focusout", updateSetName)
cardText.addEventListener("focusout", updateCardText)
cardImg.addEventListener("change", updateCardImg)
flipFront.addEventListener("click", flipToFront)
flipBack.addEventListener("click", flipToBack)
ctrlLeft.addEventListener("click", prevCard)
ctrlRight.addEventListener("click", nextCard)
addBtn.addEventListener("click", addNewCard)
privateCheckBtn.addEventListener("change", updatePrivateSetting)
deleteCardBtn.addEventListener("click", deleteCard)
deleteSetBtn.addEventListener("click", deleteSet)
addEventListener("DOMContentLoaded", () => {
    loadSet()
})


