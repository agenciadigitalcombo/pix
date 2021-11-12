import Vue from './vendor/vue.js'

const App = new Vue({
    el: '#app',
    data: {
        loading: false,
        amount: '0,00',
        seller_id: null,
        config: false,
        step: 1,
        error: null,
        codigo_qr: null
    },
    methods: {
        to_cents: amount => amount.replace(/\D/gi, ''),
        save_seller() {
            localStorage.setItem('seller_id', this.seller_id)
            this.close_config()
        },
        async pix() {
            let seller_id = this.seller_id
            let amount = this.to_cents(this.amount)
            if(!seller_id) {
                this.error = "Configure um ID de vendedor"
                return false
            }
            if( amount < 500 ) {
                this.error = "Somente valor acima de R$5,00"
                return false
            }
            if( amount > 99900 ) {
                this.error = "Somente valor até  R$999,00"
                return false
            }
            let full_url = `https://pix.combopay.com.br/api/?behalf=${seller_id}&amount=${amount}`
            this.loading = true
            let request = await fetch(full_url)
            let parse_json = await request.json()
            this.loading = false
            this.error = null
            if( !parse_json.next ) {
                this.error = parse_json.message
                return null
            }
            this.step = 2
            this.codigo_qr = parse_json.qr_code
            this.qr( parse_json.qr_code )            
        },
        qr(code) {
            new QRCode(this.$refs.print_qr, {
                text: code,
                width: 230,
                height: 230,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.L
            });
        },
        close_config() {
            this.config = false
        },
        open_config() {
            this.config = true
        },
        copiar() {
            this.$refs.code_qr.select(); document.execCommand('copy');
        },
        masc_money() {
            let valor = this.amount.replace(/\D/gi, '')
            valor = (valor / 100).toLocaleString('pt-br', { minimumFractionDigits: 2 })
            this.amount = valor
        },
        go_back() {
            this.step = 1
            this.amount = "0,00"
            this.codigo_qr = null
            this.error = null
            this.$refs.print_qr.innerHTML = ''
        }
    },
    mounted() {
        this.seller_id = localStorage.getItem('seller_id')
    }
})


