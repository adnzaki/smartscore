var module = new Vue({
    data: {
        activeModule: 'beranda',
        toOpen: ''
    },
    methods: {
        beranda() {
            if(this.activeModule !== 'beranda') {
                if (this.close() !== false) {
                    this.toOpen = 'beranda'
                    this.activeModule = 'beranda'
                    beranda.getDashboard()
                }
            }
        },
        siswa() {
            this.toOpen = 'siswa'
            this.close()
            this.activeModule = 'siswa'
            siswa.getSiswa(siswa.limit, 0, '')
        },
        rombel() {
            if(this.close() !== false) {
                this.toOpen = 'rombel'
                this.close()
                this.activeModule = 'rombel'
                rombel.getRombel()
            }
        },
        open(moduleName) {
            this.toOpen = moduleName
            switch (moduleName) {
                case 'beranda': this.beranda(); break
                case 'siswa': this.siswa(); break
                case 'rombel': this.rombel(); break
                default: 'Module name has not been initialized'
            }
        },
        close() {
            switch (this.activeModule) {
                case 'beranda':
                    beranda.showDashboard = false
                    break
                case 'siswa':
                    if(shared.formHasValue("#formTambahSiswa")) {
                        sidebar.modal.siswaIsFilled = true
                        return false
                    } else {
                        siswa.showDaftarSiswa = false
                        siswa.showFormAdd = false
                        siswa.showFormEdit = false
                    }
                    break
                case 'rombel':
                    rombel.showDaftarRombel = false
                    break
                default: 'Module has not been initialized'
            }
        }
    }
})
