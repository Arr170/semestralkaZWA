import { Card, CardsSet } from "./set.js"

const cardImg = document.getElementById("card-img")
const cardText = document.getElementById("card-text")
const showBtn = document.getElementById("show-btn")
const nextBtn = document.getElementById("next-btn")
const prevBtn = document.getElementById("prev-btn")
const modalImg = document.getElementById("card-img-modal")
const imgModal = document.getElementById("img-modal")
const imgCol = document.getElementById("left-col")
const cardSign = document.getElementById("card-sign")

const html = new XMLHttpRequest()
let BASE_URL = ""
const url = window.location.href
if (url.includes("~kupriars")) {
    BASE_URL = "/~kupriars"
}


let activeSet = null
let activeCard = null
let page = 0
let side = null

function loadSet() {
    const url = window.location.href
    const parts = url.split("/")
    const urlLen = parts.length
    const viewerPos = parts.indexOf("viewer")
    const setId = parts[viewerPos + 1]


    if (setId) {
        html.onload = () => {
            try {
                const jsonData = JSON.parse(html.response)
                parseResponse(jsonData)
                //setName.value = jsonData.name
            } catch (error) {
                alert("Failed to parse JSON:", error)
            }

        }

        html.onerror = () => {
        }

        html.open("GET", BASE_URL + "/setCreator/get/" + setId)



        html.send()

    }
}

function controllerManager() {
    if (page == activeSet.cards.length - 1) {
        nextBtn.setAttribute("disabled", "true")
    } else {
        nextBtn.removeAttribute("disabled")
    }


    if (page == 0) {
        prevBtn.setAttribute("disabled", "true")
    } else {
        prevBtn.removeAttribute("disabled")
    }
}

function showAnswer() {
    if (activeCard.answer) {
        cardText.textContent = activeCard.answer
        cardText.style.display = "flex"
    }
    else {
        cardText.style.display = "none"
    }

    if (activeCard.answer_image_url) {
        cardImg.src = BASE_URL + "/setCreator/serveImg/" + activeCard.answer_image_url
        imgCol.style.display = "flex"
    }
    else {
        imgCol.style.display = "none"
    }
    cardSign.innerHTML = "Answer:"

}

function showQuestion() {
    if (activeCard.question) {
        cardText.textContent = activeCard.question
        cardText.style.display = "flex"
    }
    else {
        cardText.style.display = "none"
    }

    if (activeCard.question_image_url) {
        cardImg.src = BASE_URL + "/setCreator/serveImg/" + activeCard.question_image_url
        imgCol.style.display = "flex"
    }
    else {
        imgCol.style.display = "none"
    }
    cardSign.innerHTML = "Question:"
}

function handleShowBtn() {
    if (side === "q") {
        side = "a"
        showAnswer()

    }
    else if (side === "a") {
        side = "q"
        showQuestion()
    }
}

function showNext() {
    if (page < activeSet.cards.length - 1) {
        page += 1
        activeCard = activeSet.cards[page]
        showQuestion()
    }
    controllerManager()

}

function showPrev() {
    if (page > 0) {
        page -= 1
        activeCard = activeSet.cards[page]
        showQuestion()
    }
    controllerManager()
}


function parseResponse(response) {
    let set = new CardsSet()
    set.id = response.id
    set.author_id = response.author_id
    set.is_private = response.is_private
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
    side = "q"
    showQuestion()
}

function showImgBig() {
    modalImg.src = cardImg.src
    imgModal.style.display = "block"
}

document.addEventListener("DOMContentLoaded", () => {
    loadSet()
})

window.addEventListener("click", (event) => {
    if (event.target == imgModal || event.target == modalImg) {
        imgModal.style.display = "none"
    }
})

prevBtn.addEventListener("click", () => showPrev())
nextBtn.addEventListener("click", () => showNext())
showBtn.addEventListener("click", () => handleShowBtn())
cardImg.addEventListener("click", () => showImgBig())
