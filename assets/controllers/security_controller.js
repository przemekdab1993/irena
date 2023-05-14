import { Controller } from '@hotwired/stimulus';

import axios from "axios";

export default class extends Controller {
    //static values = { method: String }

    login(event) {
        event.preventDefault();
        this.element.innerHTML = 'dupa'

        console.log('dupek');

        axios({
            method: 'POST',
            url: 'http://127.0.0.1:8000/login',
            headers: {

            },
            data: {
                username: 'ddd',
                password: 'fsdfdf'
            },
        })
        .then(response => {
            this.element.innerHTML = response.data
        });

    }
}
