<template>
   <ckeditor type="classic" 
    v-model="content"
    :upload-adapter="UploadAdapter"
    
    ></ckeditor>
</template>
<script>
import { url_config } from '../helpers/url.js';
import { getLocalUser } from "../helpers/auth";
    export default {
        mounted(){
		  // console.log('Test qweqwewq ' & CKeditor)
		   $(document).ready(function() {
			//    $(".ck-content").on( 'keydown',evt=> {
			// 		console.log( 'Pressed key: '+ evt.keyCode );
			// 		if( evt.keyCode == 8){
			// 			console.log('Hapus');
			// 		}
			// 	});
				 $(document).on("keydown", '.ck-content', function(event) { 
					  const key = event.keyCode; // const {key} = event; ES6+
					  console.log(key)
						if (key === "Backspace" || key === 8) {
							return false;
						}
				  });
				$(".image img").click(function() {
					console.log('clikc')
				});
		  });
        },
        data(){
            return{
                content:'',
                UploadAdapter : function (loader) {
					
				},
            }
        },
       
    }
</script>