

var beranda = new Vue({
    el: '#beranda',
    data: {
        showDashboard: true
    },
    methods: {
        getDashboard() {
            setTimeout(() => {
                this.showDashboard = true
            }, 400)
        }
    }
})
