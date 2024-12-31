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
const submitBtn = document.getElementById("submit-btn")
const counterSpan = document.getElementById("counter")
const privateCheckBtn = document.getElementById("set-private")

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
        console.log("some kind of error while uploading set")
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
                console.error("Failed to parse JSON:", error)
            }

        }
        html.open("GET", BASE_URL + "/setCreator/initSet")
        html.setRequestHeader("Content-Type", "application/json")
        html.send()
    }
}

function controllerManager() {
    const cardsInSet = activeSet.cards.length
    console.log(activeSet.cards)
    console.log("there are ", cardsInSet, "cards in this set")
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
    //preventCardDelete()
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
        console.log("error in adding new cards")
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
        console.log("adding card" + c.id)
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
    console.log("in parsing", activeSet)

    page = 0
    loadCard("front")
    loadPreview()
    controllerManager()
}

function loadCard(side) {
    if (side === "front") {
        activeSide = "front"
        cardText.value = activeCard.question
        //add loading of img
    }
    else {
        cardText.value = activeCard.answer
    }
    controllerManager()
}

function prevCard() {
    //preventCardDelete()
    // add: + flip to front side
    if (page > 0) {
        page -= 1
        activeCard = activeSet.cards[page]
        loadCard("front")
        loadPreview()
        controllerManager()
    }
}


function nextCard() {
    //preventCardDelete()
    // add: + flip to front side
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
        console.log("update name error")
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
        console.log("update name error")
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
    const img = activeCard.question_image
    const imgUrl = activeCard.question_image_url
    //console.log("img url front", imgUrl)

    if (imgUrl) {
        previewFrontImg.src = BASE_URL + "/setCreator/serveImg/" + imgUrl
        return
    }

    if (img) {
        reader.addEventListener(
            "load",
            (activeCard) => {
                // convert image file to base64 string
                //console.log("front img loaded")
                activeCard.question_image_url = reader.result
                previewFrontImg.src = reader.result
                //console.log(reader.result)
            },
            { once: true }
        )
        reader.readAsDataURL(img)
    }
    else {
        previewFrontImg.src = BASE_URL + "/public/static/question.png"
    }


}

export function loadPreviewImgBack() {
    const img = activeCard.answer_image
    const imgUrl = activeCard.answer_image_url
    console.log("img url back", imgUrl)

    if (imgUrl) {
        previewBackImg.src = BASE_URL + "/setCreator/serveImg/" + imgUrl
        return
    }

    if (img) {
        reader.addEventListener(
            "load",
            () => {
                console.log("back img loaded")
                // convert image file to base64 string
                activeCard.answer_image_url = reader.result
                previewBackImg.src = reader.result
                console.log(reader.result)
            },
            { once: true }
        )
        reader.readAsDataURL(img)
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
        console.log("update name error")
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

function updateCardImg() {
    const formData = new FormData()

    const cardInfo = JSON.stringify({
        setId: activeSet.id,
        cardId: activeCard.id,
        cardSide: activeSide,
    })

    formData.append("cardInfo", cardInfo)

    formData.append("image", cardImg.files[0])

    const updatingCard = activeCard

    html.onload = (updatingCard, activeSide) => {
        const jsonData = JSON.parse(html.response)
        if (activeSide === "front") {
            updatingCard.question_image_url = jsonData.question_img_url
            //loadPreviewImgFront()
        }
        else {
            updatingCard.answer_image_url = jsonData.answer_img_url
            //loadPreviewImgBack()
        }
    }
    html.onerror = () => {
        console.log("update name error")
    }

    html.open("POST", BASE_URL + "/setCreator/updateCardImg/" + activeCard.id)
    html.send(formData)

    if (activeSide === "front") {
        activeCard.question_image = cardImg.files[0]
        loadPreviewImgFront()
    }
    else {
        activeCard.answer_image = cardImg.files[0]
        loadPreviewImgBack()
    }
}

function updateCounter(cardsInSet) {
    counterSpan.textContent = (page + 1) + '/' + cardsInSet
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
//submitBtn.addEventListener("click", uploadSet);

addEventListener("DOMContentLoaded", () => {
    console.log("content loaded")
    loadSet()
})


