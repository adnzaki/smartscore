var siswa = new Vue({
    el: '#dataSiswa',
    data: {
        daftarSiswa: '',
        showDaftarSiswa: false,
        // data for pagination
        pageLinks: [], limit: 10, offset: 0,
        prev: 0, next: 0, first: 0,
        last: 0, setStart: 0
    },
    methods: {
        getSiswa: function(limit, start) {
            var obj = siswa;
            offset = start * limit;
            this.prev = start - 1;
            $.ajax({
                url: baseUrl + 'SiswaController/fetchSiswa/' + limit + '/' + offset,
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
            this.pageLinks = [];
            let countLink = num / this.limit;
            countLink = Math.ceil(countLink);
            for(let i = 0; i < countLink; i++) {
                this.pageLinks.push(i + 1);
            }
            this.last = countLink;
            return this.pageLinks;
        }
    },
})
