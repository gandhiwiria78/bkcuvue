//membuat vuex module 
import suratAPI from '../../api/surat'; 

export const surat = {
    namespaced:true,
    //state
    state: {
        data:{}, //data 1 object
        dataS:[], // data array , banyak objek,
        count:{}, // 
        dataStat:'',
        dataStatS:'',
        countStat:'',
        update:[],
        updateStat: '',
        filesSurat:{},
        filesSuratStat:'',
        data2:{},
        dataS2:[],
        dataStats2:'',
        update2:[],
        updateStats2:'',
        nomorGenerete:{},
        rules: [], //laravel rules
        options:[], // laravel option
        columnData:[
            {
                title: "No.",
                name: "No."
            },
            {
                title: "Nomor Surat",
                name: "no_surat",
                tipe: "numeric",
                sort: true,
                hide: false,
                disable: false,
                isChart: false,
                filter: true,
                filterDefault: true
            },
            {
                title: "Nama Pengirim",
                name: "pengelola.name",
                tipe: 'string',
                sort: false,
                hide: false,
                disable: false,
                filter: true,
            },
            {
                title: 'Kode Surat',
                name: 'kode',
                tipe: 'string',
                sort: false,
                hide: false,
                disable: false,
                filter: true,                                   
            },
            {
                title: 'Perihal',
                name: 'perihal',
                tipe: 'string',
                sort: false,
                hide: false,
                disable: false,
                filter: true,
            },
            {
                title: 'Tujuan',
                name: 'tujuan',
                tipe: 'string',
                sort: false,
                hide: false,
                disable: false,
                filter: true,
            },
            {
                title: 'Tgl. / Waktu Buat',
                name: 'created_at',
                tipe: 'datetime',
                sort: false,
                hide: false,
                disable: false,
                filter: true,                                   
            },
            {
                title: 'Tgl. / Waktu Ubah',
                name: 'updated_at',
                tipe: 'datetime',
                sort: false,
                hide: false,
                disable: false,
                filter: true,
            },
        ],
        columnData2:[
            {
                title: "No.",
                name: "No."
            },
            {
                title: "Kode Surat",
                name: "kode",
                tipe: "string",
                sort: true,
                hide: false,
                disable: false,
                isChart: false,
                filter: true,
                filterDefault: true
            },
            {
                title: 'Perihal',
                name: 'perihal',
                tipe: 'string',
                sort: false,
                hide: false,
                disable: false,
                filter: true,
            },
            {
                title: 'Tujuan',
                name: 'tujuan',
                tipe: 'string',
                sort: false,
                hide: false,
                disable: false,
                filter: true,
            },
            {
                title: 'Tgl. / Waktu Buat',
                name: 'created_at',
                tipe: 'datetime',
                sort: false,
                hide: false,
                disable: false,
                filter: true,                                   
            },
            {
                title: 'Tgl. / Waktu Ubah',
                name: 'updated_at',
                tipe: 'datetime',
                sort: false,
                hide: false,
                disable: false,
                filter: true,
            },
        ]
    },

    //getter 
    getters:{
        data: state => state.data,
        dataS: state => state.dataS,
        dataStat: state => state.dataStat,
        dataStatS: state => state.dataStatS,
        update: state => state.update,
        updateStat: state => state.updateStat,
        rules: state => state.rules,
        options: state => state.options,
        columnData: state => state.columnData,
        nomorGenerete: state => state.nomorGenerete,
        filesSurat: state => state.filesSurat,
        filesSuratStat : state =>state.filesSuratStat,
        data2: state => state.data2,
        dataS2: state =>state.dataS2,
        dataStats2: state =>state.dataStats2,
        update2: state => state.update2,
        updateStat2: state => state.updateStat2,
        columnData2: state =>state.columnData2,
    },

    //actions
    actions:{
        //commit Adalah ...? , commit dan  mutasi 
        index({commit},p ){
            commit('setDataStatS', 'loading');
            suratAPI.index(p).then(function(response){
                commit('setDataS', response.data.model);
                commit('setDataStatS','success');
                commit('setData',response.data.model);
            }).catch(error=>{
                commit('setDataS',error.response);
                commit('setDataStatS','fail');
                //console.log('Error',error.response)
            });
        },
    
        indexSuratKeluar({commit},p ){
            commit('setDataStatS', 'loading');
            suratAPI.indexSuratKeluar(p).then(function(response){
                commit('setDataS', response.data.model);
                commit('setDataStatS','success');     
            }).catch(error=>{
                commit('setDataS',error.response);
                commit('setDataStatS','fail');
                //console.log('Error',error.response)
            });
        },

        indexSuratMasuk({commit},p){
            commit('setDataStats2', 'loading');
            suratAPI.indexSuratMasuk(p).then(function(response){
                commit('setDataS2', response.data.model);
                commit('setDataStats2','success');
                
                //console.log('response',response.data.model);
            }).catch(error=>{
                commit('setDataS2',error.response);
                commit('setDataStats2','fail');
                // console.log('Error',error.response);
            });
        },
        
        indexTranceSuratKeluar({commit},p ){
            commit('setDataStats2', 'loading');
            suratAPI.indexTranceSuratKeluar(p).then(function(response){
                commit('setDataS2', response.data.model);
                commit('setDataStats2','success');
                //console.log('response',response.data.model);
            }).catch(error=>{
                commit('setDataS2',error.response);
                commit('setDataStats2','fail');
                // console.log('Error',error.response);
            });
        },

        indexTranceSuratMasuk({commit},p){
            commit('setDataStatS', 'loading');
            suratAPI.indexTranceSuratMasuk(p).then(function(response){
                commit('setDataS', response.data.model);
                commit('setDataStatS','success');     
            }).catch(error=>{
                commit('setDataS',error.response);
                commit('setDataStatS','fail');
                //console.log('Error',error.response)
            });
        },

        


        store( {commit, state, dispatch}, form ){
            commit('setUpdateStat', 'loading');
            suratAPI.store( form )
              .then( function( response ){
                if(response.data.saved){
                  commit('setUpdate', response.data);
                  commit('setUpdateStat', 'success');
                }else{
                  commit('setUpdateStat', 'fail');
                }
              })
              .catch(error => {
                commit('setUpdate', error.response);   
                commit('setUpdateStat', 'fail');
              });
        },

        storeSuratMasuk( {commit, state, dispatch}, form ){
            commit('setUpdateStat', 'loading');
            suratAPI.storeSuratMasuk( form )
              .then( function( response ){
                if(response.data.saved){
                  commit('setUpdate', response.data);
                  commit('setUpdateStat', 'success');
                }else{
                  commit('setUpdateStat', 'fail');
                }
              })
              .catch(error => {
                commit('setUpdate', error.response);   
                commit('setUpdateStat', 'fail');
              });
        },

        create({commit}){
            //
            commit('setDataStatS','loading'); 
            suratAPI.create().then(function(response){
                commit('setDataS',response.data.model);
                commit('setDataStatS','loading'); 
            }).cacth(error=>{
                commit('setDataS',error.response);
                commit('setDataStat','fail');
            });
        },

        edit( {commit}, id ){
            commit('setDataStat', 'loading');
            suratAPI.edit( id )
              .then( function( response ){
                commit('setData', response.data.form);
                commit('setRules', response.data.rules);
                commit('setOptions', response.data.options)
                commit('setDataStat', 'success');
              })
              .catch(error => {
                commit('setData', error.response);
                commit('setRules', []);
                commit('setOptions', [])
                commit('setDataStat', 'fail');
              });
        },
        
        editSuratMasuk( {commit}, id ){
            commit('setDataStat', 'loading');
            suratAPI.editSuratMasuk( id )
              .then( function( response ){
                commit('setData', response.data.form);
                commit('setRules', response.data.rules);
                commit('setOptions', response.data.options)
                commit('setDataStat', 'success');
              })
              .catch(error => {
                commit('setData', error.response);
                commit('setRules', []);
                commit('setOptions', [])
                commit('setDataStat', 'fail');
              });
        },
        
        // update data
        update( {commit, state, dispatch}, [id, form] ){
            commit('setUpdateStat', 'loading');
    
            suratAPI.update( id, form )
            .then( function( response ){
                if(response.data.saved){
                    commit('setUpdate', response.data);
                    commit('setUpdateStat', 'success');
                }else{
                    commit('setUpdateStat', 'fail');
                }
            })
            .catch(error => {
                commit('setUpdate', error.response);   
                commit('setUpdateStat', 'fail');
            });
        },

        updateSuratMasuk( {commit, state, dispatch}, [id, form] ){
            commit('setUpdateStat', 'loading');
            console.log('testssmass',form);
            suratAPI.updateSuratMasuk( id, form )
            .then( function( response ){
                if(response.data.saved){
                    commit('setUpdate', response.data);
                    commit('setUpdateStat', 'success');
                }else{
                    commit('setUpdateStat', 'fail');
                }
            })
            .catch(error => {
                commit('setUpdate', error.response);   
                commit('setUpdateStat', 'fail');
            });
        },

        getSurat({commit}, id ){
            commit('setDataStatS', 'loading');
            suratAPI.getSurat(id).then(function(response){
                commit('setDataS', response.data.model);
                commit('setDataStatS','success');
            }).catch(error=>{
                commit('setDataS',error.response);
                commit('setDataStatS','fail');
                //console.log('Error',error.response)
            });
        },

        getSuratMasuk({ commit }, id){
            commit('setDataStats2','loading');
            //console.log('test masuk ngak ya',id);
            suratAPI.getSuratMasuk(id).then( function(response){
                commit('setDataS2', response.data.model);
                commit('setDataStats2','success');
                // console.log('response',response.data.model);
            }).catch( error =>{
                commit('setDataS2',error.response);
                commit('setDataStats2','fail');
                // console.log('Error',error.response);
            });
        },

        getNomorSurat({commit}){
            commit('setDataStatS', 'loading');
            suratAPI.getNomorSurat().then(function(response){
                commit('setNomorGenerete', response);
                commit('setDataStatS','success');     
            }).cacth( error=>{
                commit('setDataS',error.response);
                commit('setDataStatS','fail');
                //console.log('Error',error.response)
            });
        },

        getFilesSurat({ commit,state, dispatch },[id,form]){
            commit('setFilesStat', 'loading');
            suratAPI.getFilesSurat( id, form ).then(function(response){
                //console.log(response);
                commit('setFiles', response.data.model);
                commit('setFilesStat','success');
            }).catch(error=>{
                commit('setFiles', error.response);
                commit('setFilesStat','fail');
            });
        },
        destroyPivot( {commit, state, dispatch}, id ){
            commit('setUpdateStat', 'loading');
            suratAPI.destroyPivot( id )
            .then( function( response ){
                if(response.data.deleted){
                commit('setUpdate', response.data);
                commit('setUpdateStat', 'success');
                }else{
                commit('setUpdateStat', 'fail');
                }
            })
            .catch(error => {
                commit('setUpdate', error.response);         
                commit('setUpdateStat', 'fail');
            });
        },
        destroySuratMasuk({commit}, id){
            commit('setUpdateStat2', 'loading');
            suratAPI.destroySuratMasuk( id )
            .then( function( response ){
                if(response.data.deleted){
                    commit('setUpdate2', response.data);
                    commit('setUpdateStat2', 'success');
                }else{
                    commit('setUpdateStat2', 'fail');
                }
            })
            .catch(error => {
                commit('setUpdate2', error.response);         
                commit('setUpdateStat2', 'fail');
            });
        },
        destroySuratKeluar({commit}, id){
            commit('setUpdateStat', 'loading');
            suratAPI.destroySuratKeluar( id )
            .then( function( response ){
                if(response.data.saved){
                    commit('setUpdate', response.data);
                    commit('setUpdateStat', 'success');
                }else{
                    commit('setUpdateStat', 'fail');
                }
            })
            .catch(error => {
                commit('setUpdate', error.response);   
                commit('setUpdateStat', 'fail');
            });
        },
        softDestroySuratKeluar({commit}, id){
            commit('setUpdateStat', 'loading');
            suratAPI.softDestroySuratKeluar( id )
            .then( function( response ){
                if(response.data.saved){
                    commit('setUpdate', response.data);
                    commit('setUpdateStat', 'success');
                }else{
                    commit('setUpdateStat', 'fail');
                }
            })
            .catch(error => {
                commit('setUpdate', error.response);   
                commit('setUpdateStat', 'fail');
            });
        },
        softDestroySuratMasuk({commit}, id){
            commit('setUpdateStat2', 'loading');
            suratAPI.softDestroySuratMasuk( id )
            .then( function( response ){
                if(response.data.deleted){
                    commit('setUpdate2', response.data);
                    commit('setUpdateStat2', 'success');
                }else{
                    commit('setUpdateStat2', 'fail');
                }
            })
            .catch(error => {
                commit('setUpdate2', error.response);         
                commit('setUpdateStat2', 'fail');
            });
        },
        restoreSuratMasuk({commit},id){
            commit('setUpdateStat2', 'loading');
            suratAPI.restoreSuratMasuk( id )
            .then( function( response ){
                if(response.data.deleted){
                    commit('setUpdate', response.data);
                    commit('setUpdateStat', 'success');
                }else{
                    commit('setUpdateStat', 'fail');
                }
            })
            .catch(error => {
                commit('setUpdate', error.response);         
                commit('setUpdateStat', 'fail');
            });
        },
        restoreSuratKeluar({commit},id){
            commit('setUpdateStat', 'loading');
            suratAPI.restoreSuratKeluar( id )
            .then( function( response ){
                if(response.data.saved){
                    commit('setUpdate', response.data);
                    commit('setUpdateStat', 'success');
                }else{
                    commit('setUpdateStat', 'fail');
                }
            })
            .catch(error => {
                commit('setUpdate', error.response);   
                commit('setUpdateStat', 'fail');
            });
        },
        addColumnData( {commit}, data){
            commit('setColumnData', data);
        },
        
        resetDataStat( {commit} ){
            commit('setDataStat', '');
        },

        resetUpdateStat( {commit} ){
            commit('setUpdateStat', '');
        },
        resetUpdateStat2( {commit} ){
            commit('setUpdateStat2', '');
        }

    },

    //mutations
    mutations:{
        setData ( state, data ){
            state.data = data;
        },
        setDataS ( state, data ){
            state.dataS = data;
        },
        setDataStat( state, status ){
            state.dataStat = status;
        },
        setDataStatS( state, status ){
            state.dataStatS = status;
        },
        setUpdate ( state, data ){
            state.update = data;
        },
        setUpdateStat( state,status ){
            state.updateStat = status;
        },
        setRules( state, rules ){
            state.rules = rules;
        },
        setOptions( state, options ){
            state.options = options;
        },
        setNomorGenerete(state, nomorGenerete){
            state.nomorGenerete =  nomorGenerete;
        },
        setColumnData(state, data){
            state.columnData = data;
        },
        setColumnData2(state, data){
            state.columnData2 = data;
        },
        setFiles(state, data){
            state.filesSurat = data;
        },
        setFilesStat(state,status){
            state.filesSuratStat = status;
        },
        setDataS2(state, data){
            state.dataS2 = data;
        },
        setDataStats2(state,data){
            state.dataStats2 = data;
        },
        setUpdate2 ( state, data ){
            state.update2 = data;
        },
        setUpdateStat2( state,status ){
            state.updateStat2 = status;
        },
        
    }
};