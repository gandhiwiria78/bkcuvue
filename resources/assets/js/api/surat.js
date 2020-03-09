// menambahkan axios 

// untuk mengetahui axios ngambil model dan controller dari routes 

export default {
    index:function (p){
        return axios.get('/api/surat', { params: p }); 
    },
    indexSuratKeluar :function(p){
        return axios.get('/api/surat/keluar/index', { params: p });
    },
    indexSuratMasuk : function(p) {
        return axios.get('/api/surat/masuk/index', { params:p });
    },
    indexTranceSuratKeluar :function(p){
        return axios.get('/api/surat/keluar/trance', { params: p });
    },
    indexTranceSuratMasuk : function(p) {
        return axios.get('/api/surat/masuk/trance', { params:p });
    },
    getSurat:function (id){
        return axios.get('/api/surat/'+id); 
    },
    getSuratMasuk:function (id){
        return axios.get('/api/surat/masuk/edit/'+id); 
    },
    create :function(){
        return axios.get('/api/surat/create');
    },
    store: function(forms){
        return axios.post('/api/surat/store',forms)
    },
    storeSuratMasuk: function(forms){
        return axios.post('/api/surat/masuk/store',forms)
    },
    edit: function( id ){
        return axios.post('/api/surat/edit/'+id);
    },
    editSuratMasuk: function(id){
        return axios.get('/api/surat/masuk/edit/'+id);
    },
    update: function (id,form){
        const config = {
            headers: { 'content-type': 'multipart/form-data' }
        }
        return axios.post('/api/surat/update/'+id, form);
    },
    updateSuratMasuk: function (id, form){
        return axios.post('/api/surat/masuk/update/'+id, form);
    },
    getFilesSurat: function(id,form){
        return axios.post('/api/surat/getFiles/'+ id, form);
    },
    getNomorSurat: function (){
        return axios.get('/api/surat/getNomorSurat');
    },
    delete: function (id){
        return axios.post('/api/surat/delete/'+id);
    },
    destroyPivot: function (idFiles){
        return axios.delete('/api/surat/pivot/'+idFiles);
    },
    destroySuratMasuk:function (id){
        return axios.delete('/api/surat/masuk/destroy/'+id);
    },
    destroySuratKeluar:function(id){
        return axios.delete('/api/surat/keluar/destroy/'+id);
    },
    softDestroySuratMasuk: function(id){
        return axios.delete('/api/surat/masuk/softdestroy/'+id);
    },
    softDestroySuratKeluar: function(id){
        return axios.delete('/api/surat/keluar/softdestroy/'+id)
    },
    restoreSuratMasuk:function (id){
        return axios.post('/api/surat/masuk/restore/'+id);
    },
    restoreSuratKeluar: function (id){
        return axios.post('/api/surat/keluar/restore/'+id);
    }
}