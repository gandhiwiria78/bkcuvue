
export default {
    
    index: function(p){
        return axios.get('/api/files/index',{params:p});
    },
    store : function (formData) {
        return axios.post('/api/files/store', formData);
    },
    destroy: function(id){
        return axios.delete('/api/files/'+id );
    },
    destroyDraft: function(id){
        return axios.delete('/api/files/draft/'+id );
    },
    

    
}