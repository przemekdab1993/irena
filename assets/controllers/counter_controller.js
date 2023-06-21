import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ['count'];

    count = 0;

    connect() {
    }

    increment() {
        this.count++;
        this.countTarget.innerHTML = this.count;
    }
}