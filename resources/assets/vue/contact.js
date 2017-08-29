import Vue from 'vue';

import VueResource from 'vue-resource';

//install http client for vue
Vue.use(VueResource);

Vue.http.headers.common['X-CSRF-TOKEN'] = window.Laravel.csrfToken;
new Vue({
  el: '#employeer',
  props: ['id'],
  data:{
  		contact:{},
  		submitting:false,

  },

  methods:{
		save(){
				this.submitting = true;
				 this.$http.post('/user/contact',this.contact).then(function(response, status, header){  
             
                   toastr.success('Create Contact!', response.data.message, {
                    closeButton: true,
                    progressBar: false,
                  });
                     this.submitting=false;
                     this.contact={};
                       $("#primaryModal .close").click()
                  
                    table.ajax.reload();
              }).catch(function(response,status,header){
              		var data = Object.keys(response.data).map(function(key,value){
              				return [response.data[key][value]];
              		});
                  toastr.warning(data.toString(),'Errors Found', {
                    closeButton: true,
                    progressBar: true,
                  });
               this.submitting=false;
            }); 
  		},
  		cancel(){
  			this.contact={};
  		},	
  		fetching(){
  			this.submitting = true;
  			this.$http.get('/user/contact/'+this.id).then(function(response, status, header){  
  					 this.contact = response.data.contact;
                     this.submitting=false;
                   
              }).catch(function(response,status,header){
              		var data = Object.keys(response.data).map(function(key,value){
              				return [response.data[key][value]];
              		});
                  toastr.warning(data.toString(),'Errors Found', {
                    closeButton: true,
                    progressBar: true,
                  });
               this.submitting=false;
            }); 
  		},
  		update(){
  			this.submitting = true;
				 this.$http.put('/user/contact/'+this.id,this.contact).then(function(response, status, header){  
             
                   toastr.success('Update Contact!', response.data.message, {
                    closeButton: true,
                    progressBar: false,
                  });
                     this.submitting=false;
                    
              }).catch(function(response,status,header){
              		var data = Object.keys(response.data).map(function(key,value){
              				return [response.data[key][value]];
              		});
                  toastr.warning(data.toString(),'Errors Found', {
                    closeButton: true,
                    progressBar: true,
                  });
               this.submitting=false;
            }); 
  		},
      destroy(){
        console.log($(this).attr('id'));
      }
  },
  mounted(){
  	if (typeof(this.id) != "undefined" && this.id != null){
  			this.fetching();
  	}
  }
});