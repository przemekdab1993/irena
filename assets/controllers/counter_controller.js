import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    connect() {
        super.connect();

        this.element.innerHTML = 'You have clicked me 0 times :(';
    }
}