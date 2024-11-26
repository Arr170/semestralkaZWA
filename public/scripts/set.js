export class Card{
    constructor(){
        this.owner_id = null
        this.id = null
        this.question = null
        this.question_image = null
        this.answer = null
        this.answer_image = null
    }

   
    postCard(){
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