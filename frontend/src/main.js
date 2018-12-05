import Vue from 'vue'
import App from './App.vue'
import VueHighcharts from 'vue-highcharts'
import axios from 'axios'
import VueAnalytics from 'vue-analytics'
const moment = require('moment')
require('moment/locale/sr')

axios.defaults.baseURL = process.env.VUE_APP_BACKEND_BASE_URL

Vue.config.productionTip = false

Vue.use(require('vue-moment'), {
  moment
})

Vue.use(VueAnalytics, {
  id: 'UA-25952845-10'
})

Vue.use(VueHighcharts)

new Vue({
  render: h => h(App)
}).$mount('#app')
