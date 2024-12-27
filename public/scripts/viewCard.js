import { Card, CardsSet } from "./set.js"

const cardImg = document.getElementById("card-img")
const cardText = document.getElementById("card-text")
const showBtn = document.getElementById("show-btn")
const nextBtn = document.getElementById("next-btn")
const prevBtn = document.getElementById("prev-btn")

const html = new XMLHttpRequest()
let BASE_URL = ""
const url = window.location.href
if(url.includes("~kupriars")){
    BASE_URL = "/~kupriars"
}


let activeSet = null
let activeCard = null
let page = 0
let side = null

export function loadSet() {
    const url = window.location.href
    const parts = url.split("/")
    const urlLen = parts.length
    const viewerPos = parts.indexOf("viewer")
    const setId = parts[viewerPos + 1]

    console.log("loading set", setId)

    if (setId) {
        console.log("set id:", setId)
        html.onload = () => {
            try {
                const jsonData = JSON.parse(html.response)
                parseResponse(jsonData)
                //setName.value = jsonData.name
            } catch (error) {
                console.error("Failed to parse JSON:", error)
            }

        }

        html.onerror = () => {
        }

        html.open("GET", BASE_URL+"/setCreator/get/" + setId)



        html.send()
        
    }
}

function showAnswer(){
    cardText.innerHTML = activeCard.answer ? activeCard.answer.replace(/\n/g, '<br>') : ""
    cardImg.src = activeCard.answer_image_url ? activeCard.answer_image_url : BASE_URL+"/public/static/answer.png"

}

function showQuestion(){
    cardText.innerHTML = activeCard.question ? activeCard.question.replace(/\n/g, '<br>') : ""
    cardImg.src = activeCard.question_image_url ? activeCard.question_image_url : BASE_URL+"/public/static/question.png"

}

function handleShowBtn(){
    if(side === "q"){
        side = "a"
        showAnswer()

    }
    else if(side === "a"){
        side = "q"
        showQuestion()
    }
}

function showNext(){
    if(page < activeSet.cards.length-1){
        page += 1
        activeCard = activeSet.cards[page]
        showQuestion()
    }

}

function showPrev(){
    if(page > 0){
        page -= 1
        activeCard = activeSet.cards[page]
        showQuestion()
    }
}


function parseResponse(response) {
    let set = new CardsSet()
    set.id = response.id
    set.author_id = response.author_id
    set.is_private = response.is_private
    set.name = response.name
    response.cards.forEach(c => {
        console.log("adding card" + c.id)
        let card = new Card()
        card.id = c.id
        card.set_id = c.set_id
        card.question = c.question
        card.question_image_url = c.question_image_url
        card.answer = c.answer
        card.answer_image_url = c.answer_image_url
        set.cards.push(card)
    })
    activeSet = set
    activeCard = set.cards[0]
    page = 0
    side = "q"
    showQuestion()
}

document.addEventListener("DOMContentLoaded", ()=>{
    loadSet()
})

prevBtn.addEventListener("click", ()=>showPrev())
nextBtn.addEventListener("click", ()=>showNext())
showBtn.addEventListener("click", ()=>handleShowBtn())
