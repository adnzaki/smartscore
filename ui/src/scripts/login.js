new Vue({
    el: '#app',
    data: {
        msg: '',
        title: 'Silakan login dengan menggunakan akun Smartscore anda',
        apiUrl: 'http://localhost:71/smartscore/api/',
        username: '', password: ''  ,
        tahunAjaran: []
    },
    mounted: function() {
        var self = this
        $.ajax({
            url: `${this.apiUrl}authcontroller/getTahunAjaran`,
            type: 'get',
            dataType: 'json',
            success: function(data) {
                self.tahunAjaran = data
            }
        })
    },
    methods: {
        login: function() {
            var data = $("#formLogin").serialize()
            var self = this
            if(this.username === '' || this.password === '') {
                this.msg = 'Silakan masukkan username dan password anda'
            } else {
                $.ajax({
                    url: `${this.apiUrl}authcontroller/validate/`,
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                    success: function(data) {                 
                        if(data.code === 1) {
                            var tgl = new Date(),
                            skrg = tgl.getTime(),
                            expMs = skrg + 3600000,
                            exp = new Date(expMs)
                            document.cookie = `ss_session=${data.cookie};expires=${exp};path=/;`
                            self.msg = ''
                            self.title = data.msg
                            window.location.href = 'http://localhost:8080/smartscore.html#/dashboard'
                        } else {
                            self.msg = data.msg
                        }                   
                    },
                    error: function() {
                        self.msg = 'Gagal terkoneksi dengan server'
                    }
                })
            }            
        },
    }
})