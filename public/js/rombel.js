

var rombel = new Vue({
    el: '#dataRombel',
    data: {
        showDaftarRombel: false
    },
    methods: {
        getRombel() {
            setTimeout(() => {
                this.showDaftarRombel = true
            }, 400)
        }
    },
})
