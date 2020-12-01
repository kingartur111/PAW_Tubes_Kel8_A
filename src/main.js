import Vue from 'vue'
import App from './App.vue'
import vuetify from './plugin/vuetify'
import router from './router'
import axios from 'axios'
import Chartkick from 'vue-chartkick'
import Chart from 'chart.js'

Vue.use(Chartkick.use(Chart))

Vue.config.productionTip = false

Vue.prototype.$http = axios;
Vue.prototype.$api = 'http://127.0.0.1:8000/api';

new Vue({
  vuetify,
  router,
  render: h => h(App),
}).$mount('#app')