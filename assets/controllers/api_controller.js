import { Controller } from '@hotwired/stimulus';

import axios from "axios";

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="api" attribute will cause
 * this controller to be executed. The name "api" comes from the filename:
 * api_controller.js -> "api"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {
    static targets = ['countryItem', 'countUsers', 'addAction', 'removeAction'];

    connect() {
        this.load();
    }

    load() {
        axios.get('http://127.0.0.1:8000/api/countries?order%5Bname%5D=asc')
            .then( (response) => {
                const countries = response.data;

                axios({
                    method: 'POST',
                    url: 'http://127.0.0.1:8000/country-list',

                    data: {
                        list: [...countries]
                    },
                })
                    .then(response => {
                        this.element.innerHTML = response.data;
                    });
            });
    };

    setEvent(event) {
        event.preventDefault();

        const button = event.currentTarget;
        const currentCountry = button.parentElement.parentElement;
        const countryId = button.dataset.countryId;
        const action = button.dataset.act;
        const countUsers = currentCountry.getElementsByClassName('js-count-user-visited')[0];
        const secondButton = action === 'add' ? currentCountry.getElementsByClassName('js-remove-visited')[0] : currentCountry.getElementsByClassName('js-add-visited')[0];

        axios.get(`/set-country-visited/${countryId}/${action}`)
            .then(response => {
                if (response.data.action === 'add') {
                    countUsers.innerHTML = +countUsers.textContent + 1;
                    button.classList.add('d-none');
                    secondButton.classList.remove('d-none');

                } else {
                    countUsers.innerHTML = +countUsers.textContent - 1;
                    button.classList.add('d-none');
                    secondButton.classList.remove('d-none');
                }
            });
    }
}
