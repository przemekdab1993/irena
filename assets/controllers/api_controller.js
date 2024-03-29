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
    static values = { method: String }

    connect() {
        this.load();
    }

    load() {
        axios.get('/api/countries?order%5Bname%5D=asc')
            .then( (response) => {
                const countries = response.data;

                axios({
                    method: 'POST',
                    url: '/country-list',

                    data: {
                        list: [...countries]
                    },
                })
                    .then(response => {
                        this.element.innerHTML = response.data;
                    });
            });

        };



}
