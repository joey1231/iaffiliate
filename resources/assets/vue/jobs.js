import Vue from 'vue';

import VueResource from 'vue-resource';

// components
import pagination from './components/paginations';

//install http client for vue
Vue.use(VueResource);

Vue.component('vue-pagination', pagination);
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