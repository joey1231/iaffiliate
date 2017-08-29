import Vue from 'vue';

import VueResource from 'vue-resource';

//install http client for vue
Vue.use(VueResource);

Vue.http.headers.common['X-CSRF-TOKEN'] = window.Laravel.csrfToken;
new Vue({
  el: '#employeer',
  props: ['id'],
  data:{
  		lander:{},
  		submitting:false,
      urls:[],
      url:''
  },

  methods:{
		save(){
				this.submitting = true;
				 this.$http.post('/lander/list',this.lander).then(function(response, status, header){  
             
                   toastr.success('Create Lander!', response.data.message, {
                    closeButton: true,
                    progressBar: false,
                  });
                     this.submitting=false;
                     this.lander={};
                     $("#primaryModal .close").click()
                  
                    table.ajax.reload();
              }).catch(function(response,status,header){
                console.log(response);
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
  			this.lander={};
  		},	
  		fetching(){
  			this.submitting = true;
  			this.$http.get('/lander/list/'+this.id).then(function(response, status, header){  
  					 this.lander = response.data.data;
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
				 this.$http.put('/lander/list/'+this.id,this.lander).then(function(response, status, header){  
             
                   toastr.success('Update Lander!', response.data.message, {
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
      },
      addLander(){
        if(this.url.trim() !=''){
          var urls_split = this.url.split(",");

          this.urls.push(this.url);
          this.url='';
        }
      },
      remove(index){
        if (index > -1) {
            this.urls.splice(index, 1);
        }
      },
     addLanderPost(){
        this.urls = this.url.split("\n");
        this.submitting = true;
         this.$http.post('/lander/list/add-bulk/'+this.id,{'urls':this.urls}).then(function(response, status, header){  
             
                   toastr.success('Bulk url Created!', response.data.message, {
                    closeButton: true,
                    progressBar: false,
                  });
                     this.submitting=false;
                     this.urls=[];
                    
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
     }
  },
  mounted(){

  	if (typeof(this.id) != "undefined" && this.id != null){
  			this.fetching();
  	}else{
   
    }
  }
});