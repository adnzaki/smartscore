import Vue from 'vue'
import { shared } from './shared.js'

export default {
    name: 'dashboard',
    mixins: [shared],
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
            this.pesan = 'Selamat Datang'
        }
    }
}
