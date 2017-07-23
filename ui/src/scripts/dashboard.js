import Vue from 'vue'
import { shared } from './shared.js'
import { global } from './global.js'

export default {
    name: 'dashboard',
    mixins: [shared, global],
    data() {
        return {
            pesan: 'testtt',
            urlToken: '',
        }        
    },
    beforeRouteEnter(to, from, next) {
        next(vm => vm.hello())
    },
    beforeRouteUpdate(to, from, next) {
        this.hello()
        next()
    },
    beforeRouteLeave(to, from, next) {
        next()
    },
    methods: {
        hello() {
            let token = this.getCookie('ss_session')
            if(token === 'undefined') {
                window.location.href = `${this.apiUrl}authcontroller/logout/`
            } else {
                this.pesan = 'Selamat Datang'
            }            
        }
    }
}
