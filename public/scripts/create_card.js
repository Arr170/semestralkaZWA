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


let activeSet = null
let activeCard = null
let page = 0
let activeSide = "front"

export function controllerManager() {
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

    if(activeSide === "front"){
        flipFront.setAttribute("disabled", true)
        flipBack.removeAttribute("disabled")
    }
    else{
        flipFront.removeAttribute("disabled")
        flipBack.setAttribute("disabled", true)
    }

}

export function loadSet() {
    const setId = params.get('set_id')
    console.log("loading set", setId)

    if (setId) {
        console.log("set id:", setId)
        //load set
    }
    else {
        console.log("no set id in params")
        setName.textContent = "Set name"
        //load set builder
        activeSet = new CardsSet()
        activeCard = new Card()
        page = 0
        controllerManager()
    }
}


export function loadCard(side) {
    if (side === "front") {
        activeSide = "front"
        cardText.value = activeCard.question
        //add loading of img
    }
    else{
        cardText.value = activeCard.answer
    }
    controllerManager()
}



export function preventCardDelete(){
    if(activeSet.cards.includes(activeCard)){
        console.log("card is already saved")
    }
    else{
        activeSet.cards.push(activeCard)
    }
}

export function addNewCard(){
    preventCardDelete()
    activeCard = new Card()
    page = activeSet.cards.length
    console.log("now page is ", page)
    loadCard("front")
}


export function prevCard() {
    preventCardDelete()
    // add: + flip to front side
    if (page <= 0) { return null }
    page -= 1
    activeCard = activeSet.cards[page]
    loadCard("front")
    controllerManager()
}


export function nextCard() {
    preventCardDelete()
    // add: + flip to front side
    const cardsInSet = activeSet.cards.length
    if (page >= cardsInSet) { return null }
    page += 1
    activeCard = activeSet.cards[page]
    loadCard("front")
    controllerManager()
}



//maybe excesive, think about how to add animation
export function flipToFront() {
    loadCard("front")
    activeSide = "front"
    flipFront.setAttribute("disabled", true)
    flipBack.removeAttribute("disabled")
}

export function flipToBack(){
    loadCard("back")
    activeSide = "back"
    flipFront.removeAttribute("disabled")
    flipBack.setAttribute("disabled", true)
}

function updateSetName(){
    activeSet.set_name(setName.value)
    console.log("new set name: ", activeSet.name)
    console.log(activeSet)
}

function updateCardText(){
    
    if(activeSide === "front"){
        activeCard.question = cardText.value.replace(/\n/g, '<br>')
        previewFront.innerHTML = activeCard.question
    }
    else{
        activeCard.answer = cardText.value.replace(/\n/g, '<br>')
        previewBack.innerHTML = activeCard.question
    }
    console.log("text value in card updated", activeCard)

}

setName.addEventListener("focusout", updateSetName)
cardText.addEventListener("focusout", updateCardText)
flipFront.addEventListener("click", flipToFront)
flipBack.addEventListener("click", flipToBack)
ctrlLeft.addEventListener("click", prevCard)
ctrlRight.addEventListener("click", nextCard)
addBtn.addEventListener("click", addNewCard)



addEventListener("DOMContentLoaded", () => {
    console.log("content loaded")
    loadSet()
})