import Vue from 'vue'
import ssloader from './template/content/loader.vue'
import AppRouter from './scripts/router.js'
//import sidebar from './template/elements/sidebar.vue'
import appheader from './template/elements/app-header.vue'
import appfooter from './template/elements/app-footer.vue'


new Vue({
  el: '#loader',
  render: h => h(ssloader)
})

// new Vue({
//     el: '#aside',
//     render: h => h(sidebar)
// })

new Vue({
    el: '#app-header',
    render: h => h(appheader)
})

new Vue({
    el: '#app-footer',
    render: h => h(appfooter)
})
