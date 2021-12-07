<template>
<app-layout title="Carreras">
  <template #header> 
    <div v-for="faculty in CarreersOf" v-bind:key="faculty.id">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Facultad de {{faculty.name}}</h2>
    </div>  
  </template>   

  <div class="py-12">
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> 
  <div class="flex flex-col mt-8">
  <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
  <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
  <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
    <table class="min-w-full divide-y divide-gray-200">
      <thead>
        <th scope="col" v-for="column in columns" :key="column.name"><jet-title-label>{{column}}</jet-title-label></th>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">     
        <template v-for="faculty in CarreersOf" v-bind:key="faculty.id">   
          <tr v-for="carreer in faculty.carreers" :key="carreer.id"> 
            <td class="px-6 py-4 text-center"><jet-label>{{carreer.code}}</jet-label></td>
            <td class="px-6 py-4 text-center"><jet-label>{{carreer.name}}</jet-label></td>
            <td class="px-6 py-4 text-center"><jet-label>{{carreer.email}}</jet-label></td>
            <td class="px-6 py-4 text-center"><jet-label>{{carreer.phone}}</jet-label></td>

            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
              <jet-button @click="openInfoCarreer();selectedCarreer=carreer"> <jet-show/> </jet-button>
              <jet-button @click="openModalUpdate();selectedCarreer=carreer"> <jet-edit/> </jet-button>
              <jet-modify-button @click="openModalDelete();selectedCarreer=carreer"> <jet-delete/> </jet-modify-button>
            </td>
          </tr>
        </template>  
      </tbody>
    </table>
  </div>
  </div>
  </div>
  </div>
  </div>
  </div>     

  <jet-dialog-modal :show="modalInfoCarreer">
    <template v-slot:content>
      <modal-show-icon/>
      <h2 class="text-xl font-bold py-4" v-if="selectedCarreer"><strong> Carrera: {{selectedCarreer.name}}</strong></h2>
      <p class="text-sm text-gray-500 px-8">¿Estas seguro de querer redirigir a la interfase de {{selectedCarreer.name}}?</p>    
    </template>
    <template v-slot:footer class="p-3  mt-2 text-center space-x-4 md:block">
      <jet-modify-button @click="closeInfoCarreer()">Cerrar</jet-modify-button>
      <jet-button @click="showCurriculumsOf()">Ir a Carrera</jet-button>    
      <jet-button @click="InfoCarreer()">Ir a Website</jet-button>    
    </template>
  </jet-dialog-modal>

  <jet-dialog-modal :show="modalUpdate">
    <template v-slot:content>
      <modal-edit-icon/>
      <h2 class="text-xl font-bold py-4" v-if="selectedCarreer"><strong> Carrera: {{selectedCarreer.name}}</strong></h2>
      <p class="text-sm text-gray-500 px-8">¿Estas seguro de querer Actualizar este elemento?</p>    
    </template>
    <template v-slot:footer class="p-3  mt-2 text-center space-x-4 md:block">
      <jet-modify-button @click="closeModalUpdate()">Cerrar</jet-modify-button>
      <jet-danger-button @click="updateCarreer()"> Modificar</jet-danger-button>    
    </template>
  </jet-dialog-modal>

  <jet-dialog-modal :show="modalDelete">
    <template v-slot:content>
      <modal-delete-icon/>       
      <h2 class="text-xl font-bold py-4" v-if="selectedCarreer"><strong> Carrera: {{selectedCarreer.name}}</strong></h2>
      <p class="text-sm text-gray-500 px-8">¿Estas seguro de querer quitar {{selectedCarreer.name}} de la Facultad?</p>    
    </template>
    <template v-slot:footer class="p-3  mt-2 text-center space-x-4 md:block">
      <jet-modify-button @click="closeModalDelete()">Cerrar</jet-modify-button>
      <jet-danger-button @click="deleteCarreerOf()">Borrar</jet-danger-button>    
    </template>
  </jet-dialog-modal> 

</app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout"
import {Inertia} from '@inertiajs/inertia';
import JetInputError from "@/Jetstream/InputError"
import JetLabel from "@/Jetstream/Label"
import JetTitleLabel from "@/Jetstream/TitleLabel"
import JetButton from "@/Jetstream/Button"
import JetModifyButton from "@/Jetstream/ModifyButton"
import JetDangerButton from "@/Jetstream/DangerButton"
import JetDialogModal from "@/Jetstream/DialogModal";
import JetEdit from '@/Jetstream/EditLogo'
import JetShow from '@/Jetstream/ShowLogo'
import JetDelete from '@/Jetstream/DeleteLogo'
import ModalShowIcon from '@/Jetstream/modalShowIcon'
import ModalEditIcon from '@/Jetstream/modalEditIcon'
import ModalDeleteIcon from '@/Jetstream/modalDeleteIcon'

export default {
  components:{
    AppLayout, JetDialogModal, JetInputError, 
    JetTitleLabel, JetLabel, JetButton, JetModifyButton, JetDangerButton,
    JetEdit, JetShow, JetDelete, ModalShowIcon, ModalEditIcon, ModalDeleteIcon
  },

  props:{ CarreersOf:Array, columns:Array, selectedCarreer: Object },

  data(){
    return{ modalUpdate: false, modalDelete: false, modalInfoCarreer: false }    
  },

  methods:{
    updateCarreer: function(){Inertia.get(route('carreers.edit', { carreer: this.selectedCarreer} )); },
    showCurriculumsOf: function(){ Inertia.get(route("carreers.showCurriculums", {carreer: this.selectedCarreer} )); this.closeInfoCarreer(); },
    
    ///////////////////////NOT WORKING//////////////////
    InfoCarreer: function(){
      //Corregir para que cargue, segun la facultad o departamento que solicitan. Esto es solo testing
      let url='https://{{carreersOf.website}}'
      this.modalInfoCarreer = false;
      window.open(url);
    },
    deleteCarreerOf: function(){
      let facultiesandcarreer = this.selectedCarreer.pivot
      console.log(facultiesandcarreer)
      Inertia.delete(route('facultiesandcarreers.destroy', { facultiesandcarreer: this.selectedcarreer.pivot} ))  
    },

    ///////////////////////////////////////////////////
    openInfoCarreer(){this.modalInfoCarreer =true}, closeInfoCarreer(){this.modalInfoCarreer =false},
    openModalUpdate(){this.modalUpdate =true}, closeModalUpdate(){this.modalUpdate =false},
    openModalDelete(){this.modalDelete =true}, closeModalDelete(){this.modalDelete =false},
  }
}
</script>