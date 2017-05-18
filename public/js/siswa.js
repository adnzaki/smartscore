var siswa = new Vue({
    el: '#dataSiswa',
    data: {
        daftarSiswa: '',
        showDaftarSiswa: false,
        showFormAdd: false,
        // data for pagination
        pageLinks: [], limit: 10, offset: 0,
        prev: 0, next: 0, first: 0,
        last: 0, setStart: 0
    },
    methods: {
        getSiswa: function(limit, start) {
            this.showFormAdd = false;
            var obj = siswa;
            offset = start * limit;
            this.prev = start - 1;
            $.ajax({
                url: baseUrl + 'admin/SiswaController/fetchSiswa/' + limit + '/' + offset,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    obj.daftarSiswa = data['dataSiswa'];
                    obj.showDaftarSiswa = true;
                    obj.pagination(data['totalRows']);
                    start === (obj.last -= 1) ? obj.next = start : obj.next = start + 1;
                }
            })
        },
        pagination: function(num) {
            // reset links
            this.pageLinks = [];

            // hitung jumlah halaman yang dibutuhkan untuk link pagination
            let countLink = num / this.limit;
            countLink = Math.ceil(countLink);

            // generate link pagination....
            for(let i = 0; i < countLink; i++) {
                this.pageLinks.push(i + 1);
            }
            this.last = countLink;
            return this.pageLinks;
        },
        showForm: function() {
            this.showDaftarSiswa = false;
            setTimeout(function() {
                siswa.showFormAdd = true;
                setTimeout(function() {
                    $("#datetimepicker1").datetimepicker({
                        format: 'DD/MM/YYYY',
                        icons: {
                          time: 'fa fa-clock-o',
                          date: 'fa fa-calendar',
                          up: 'fa fa-chevron-up',
                          down: 'fa fa-chevron-down',
                          previous: 'fa fa-chevron-left',
                          next: 'fa fa-chevron-right',
                          today: 'fa fa-screenshot',
                          clear: 'fa fa-trash',
                          close: 'fa fa-remove'
                        }
                    });
                }, 100)
            }, 400);
        },
        closeForm: function() {
            this.showFormAdd = false;
            setTimeout(function() {
                siswa.showDaftarSiswa = true;
            }, 400);
        },
    },
})
