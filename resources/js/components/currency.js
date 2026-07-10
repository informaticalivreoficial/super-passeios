export default function currencyInput(initialValue = null, model = null) {
    return {
        display: '',

        init() {
            if (initialValue) {
                this.display = this.toDisplay(parseFloat(initialValue));
            }
        },

        toDisplay(num) {
            if (isNaN(num)) return '';

            return Number(num).toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            });
        },

        onInput(event) {
            let raw = event.target.value.replace(/\D/g, '');

            if (!raw) {
                this.display = '';

                if (model) {
                    this.$wire.set(model, null);
                }

                return;
            }

            let value = parseInt(raw, 10) / 100;

            this.display = this.toDisplay(value);

            if (model) {
                this.$wire.set(model, value.toFixed(2));
            }
        }
    }
}