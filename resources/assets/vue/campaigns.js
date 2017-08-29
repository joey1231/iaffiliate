import Vue from 'vue';

import VueResource from 'vue-resource';

//install http client for vue
Vue.use(VueResource);

Vue.http.headers.common['X-CSRF-TOKEN'] = window.Laravel.csrfToken;
new Vue({
  el: '#employeer',
  props: ['id'],
  data:{
  		campaign:{blacklist_cost:1,greylist_cost:1,whitelist_cost:3},
      reports:[],
  		submitting:false,

  },

  methods:{
		save(){
				this.submitting = true;
				 this.$http.post('/campaign',this.campaign).then(function(response, status, header){  
             
                   toastr.success('Create campaign!', response.data.message, {
                    closeButton: true,
                    progressBar: false,
                  });
                     this.submitting=false;
                     this.campaign={blacklist_cost:1,greylist_cost:1,whitelist_cost:3};
                     this.reports=response.data.data
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
  			this.campaign={};
  		},	
  		fetching(){
  			this.submitting = true;
  			this.$http.get('/campaign/'+this.id).then(function(response, status, header){  
  					 this.campaign = response.data.data;
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
				 this.$http.put('/campaign/'+this.id,this.campaign).then(function(response, status, header){  
             
                   toastr.success('Update campaign!', response.data.message, {
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
      showStatus(status){
          var label ='';
          if(status == 1){
            label='BlackList';
          }
          if(status==2){
             label='GreyList';
          }
          if(status==3){
             label='WhiteList';
          }
          return label;
      },
      showBanStatus(status){
            var label ='';
          if(status == 0){
            label='Not Ban';
          }
          if(status==2){
             label='Banned';
          }
           return label;
      },
      showBanResponse(status){
          return "<pre style='background:#fff;border:1px solid #000;max-width:300px'> <code>" + status + "</code></pre>";
      },
      banStatus(report){

         this.$http.post('/campaign/pause/'+id).then(function(response, status, header){  
                report = response.data.report;
              }).catch(function(response,status,header){  
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