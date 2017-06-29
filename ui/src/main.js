import Vue from 'vue'
import App from './App.vue'
import Ajax from './Ajax.vue'

new Vue({
  el: '#app',
  render: h => h(App)
})

new Vue({
    el: '#test',
    render: h => h(Ajax)
})
