<template lang="html">
  <div class="">
      <h1>{{ pesan }}</h1>
  </div>
</template>
<script>
import Vue from 'vue'
import Vuex from 'vuex'
import {
	mapState,
	mapMutations,
	mapGetters,
	mapActions
} from 'vuex'
import { Dashboard } from '../../../scripts/store/Dashboard'

Vue.use(Vuex)

export default {
	name: 'Dashboard',
	store: Dashboard,
	components: {
		
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
	data() {
		return {
			cookie: this.$store.state.shared.cookieName
		}
	},
	methods: {
		...mapMutations([

		]),
		...mapActions([
			
		]),
		hello() {
			this.$store.dispatch('hello')
		}
	},
	computed: {
		...mapState([
			'pesan'
		]),
	}
}
</script>