export class Card{
    constructor(){
        this.set_id = null
        this.id = null
        this.question = null
        this.question_image = null
        this.question_image_url = null
        this.answer = null
        this.answer_image = null
        this.answer_image_url = null
    }



}

export class CardsSet{
    constructor(){
        this.id = null
        this.author_id = null
        this.is_private = null
        this.cards = []
        this.name = null
    }
}