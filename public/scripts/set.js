export class Card{
    constructor(){
        this.owner_id = null
        this.id = null
        this.question = null
        this.question_image = null
        this.answer = null
        this.answer_image = null
    }
    set_question(question_text){
        this.question = question_text
    }
    set_q_image(img){
        this.question_image = img
    }
    set_answer(ans){
        this.answer = ans
    }
    set_a_img(img){
        this.answer_image = img
    }
    post_card(){
        // logic: send card to backend
        // then set is of created card in db
    }

}

export class CardsSet{
    constructor(){
        this.id = null
        this.owner_id = null
        this.public = null
        this.cards = []
        this.name = null
    }
    set_name(name){
        this.name = name
    }
    append_card(card){
        this.cards.push(card.id)
    }
    delete_card(card){
        this.cards.remove(card.id)
    }
    change_type(){
        // logic: switch public value in database
    }
}