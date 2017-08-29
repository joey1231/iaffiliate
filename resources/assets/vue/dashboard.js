import Vue from 'vue';

import VueResource from 'vue-resource';

//install http client for vue
Vue.use(VueResource);

Vue.http.headers.common['X-CSRF-TOKEN'] = window.Laravel.csrfToken;
new Vue({
  el: '#employeer',
  data:{

  },
  method:{

  },
  mounted(){

  }
});