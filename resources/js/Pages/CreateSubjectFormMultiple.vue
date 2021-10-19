<template>
    <app-layout>
        <template #header>
            <h2>Crear Asignatura</h2>
        </template>    
<!--{{subjects}}-->

 

    </app-layout>
</template>

<script>

import AppLayout from "@/Layouts/AppLayout"



export default {
    components:{
        AppLayout,
    },
    props:{
        modalMasive,
    },
    data(){
        return{ 
             subjects:[],
             form :{file: null}     
        }
    },

    methods:{
        loadMultiple(){
        axios.get('subjects.json')
        .then(response => {
            this.subjects = response.data;
        })
        .catch(error =>{
            console.log(error)
        })   
        },
        
         
    }
}
</script>


    