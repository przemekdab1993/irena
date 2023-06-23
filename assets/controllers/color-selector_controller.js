import {Controller} from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ['buttonPick', 'select'];
    static values = {
        defaultColorId: Number
    }
    selectedColorId = null;

    connect() {
        super.connect();

        console.log(this.defaultColorIdValue);

    }

    pickColor(event) {
        this.setPickColor(event.currentTarget.dataset.colorId);
    }

    setPickColor(colorId) {
        const buttonClicked = this.findSelectedButtonPicker(colorId);

        if (colorId === this.selectedColorId) {
            buttonClicked.classList.remove('selected-color-square');
            this.selectTarget.value = null;
            this.selectedColorId = null;

            return;
        }

        if (this.findSelectedButtonPicker(this.selectedColorId)) {
            this.findSelectedButtonPicker(this.selectedColorId).classList.remove('selected-color-square');
        }
        this.selectedColorId = colorId;

        buttonClicked.classList.add('selected-color-square');
        this.selectTarget.value = event.currentTarget.dataset.colorId;
    }

    findSelectedButtonPicker(colorId) {
        return this.buttonPickTargets.find((button) => {
            return button.dataset.colorId === colorId;
        });
    }
}