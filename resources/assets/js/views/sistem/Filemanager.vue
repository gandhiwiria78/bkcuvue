<template>
  <div>
    <!-- Page header -->
    <page-header :title="title" :titleDesc="titleDesc" :titleIcon="titleIcon"></page-header>

    <!-- page container -->
    <div class="page-content pt-0">
      <div class="content-wrapper">
        <div class="content">

           <div class="row">
                <div class="col-lg-12">
                    <div class="card" style="height:500px">
                    <file-manager v-bind:settings="settings"></file-manager>
                    </div>
                </div>
           </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
  import pageHeader from "../../components/pageHeader.vue";
  import { getLocalUser } from "../../helpers/auth";

  export default {
    components: {
      pageHeader,
    },
    mounted(){
      
    },
    data() {
      return {
        title: 'File Manager',
        titleDesc: 'File Manager',
        titleIcon: 'icon-list',
        // settings object structure
        settings: {
            //axios headers
            headers: {
             'X-Requested-With': 'XMLHttpRequest',
             Authorization: `Bearer `+getLocalUser().token,
            },
            //baseUrl: 'https://bkcuvue.test/admins/filemanager/tree?disk=CUKB',// overwrite base url Axios
            windowsConfig: 1, // overwrite config
            
        },
      }
    },
    created(){
      window.scrollTo(0, 0);
    },
    
  }
</script>