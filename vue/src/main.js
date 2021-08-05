import Vue from 'vue'
import App from './App.vue'
import router from './router'
import login from './assets/js/login'

console.log(login.logado());
Vue.config.productionTip = false
new Vue({
  router,
  render: h => h(App)
}).$mount('#app');
