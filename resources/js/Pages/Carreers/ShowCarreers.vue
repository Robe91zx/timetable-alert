<template>
<app-layout title="Carreras">
  <template #header>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Carreras</h2>
  </template>

  <div class="py-12">
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
  <div class="flex mb-4">
    <div class="w-3/5 h-12">
      <form method="get" @submit.prevent="submit">
        <input v-model="form.name" :disabled="form.processing" name="carreer" placeholder="Busqueda de Carreras" type="text" class="w-3/4 my-2 px-3 py-1 border rounded-lg text-xs text-gray-700 focus:outline-none" /> 
      </form>    
    </div>
    <div class="w-2/5 h-12 ">   
      <select v-model="selectedModal.value" class="float-right my-2 px-3 py-1 border rounded-lg text-xs text-gray-700 focus:outline-none" >
        <option class="py-1" value="" disabled>Seleccione una Funcionalidad</option>
        <option class="py-1" v-for="(option, index) in options" :key="index" v-bind:value="index" >{{option}}</option>
      </select> 
      <button class="my-2 px-3 py-1 float-right" @click="exportExcel()" > <jet-export/> </button>
      <button class="my-2 px-3 py-1 float-right" @click="openModalExcel()"> <jet-import/> </button> 
    </div>
  </div>   

  <div class="flex flex-col mt-8">
  <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
  <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
  <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">              
    <table class="min-w-full divide-y divide-gray-200">
      <thead>
        <tr><th scope="col" v-for="column in columns" :key="column.name"><jet-title-label>{{column}}</jet-title-label></th></tr>
      </thead>                
      <tbody class="bg-white divide-y divide-gray-200">                      
        <template v-for="faculty in carreers" :key="faculty.id">
          <tr v-for="carreer in faculty.carreers" :key="carreer.id"> 
            <td class="px-6 py-4 text-center"><jet-label>{{faculty.name}}</jet-label></td>
            <td class="px-6 py-4 text-center"><jet-label>{{carreer.name}}</jet-label></td>
            <td class="px-6 py-4 text-center"><jet-label>{{carreer.email}}</jet-label></td>
            <td class="px-6 py-4 text-center"><jet-label>{{carreer.phone}}</jet-label></td>

            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
              <jet-button @click="openModalShow();selectedCarreer=carreer"> <jet-show/></jet-button>
              <jet-button @click="openModalUpdate();selectedCarreer=carreer"> <jet-edit/></jet-button>
              <jet-modify-button @click="openModalDelete();selectedCarreer=carreer"> <jet-delete/></jet-modify-button>
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
      
   <jet-dialog-modal :show="modalShow">
      <template v-slot:content>
        <modal-show-icon/>
        <h2 class="text-xl font-bold py-4" v-if="selectedCarreer"><strong> Carrerra: {{selectedCarreer.name}}</strong></h2>
        <p class="text-sm text-gray-500 px-8"> ¿Estas seguro de querer ir a ver sus Datos?</p>   
      </template>
      <template v-slot:footer>
        <jet-modify-button @click="closeModalShow()">Cerrar</jet-modify-button>
        <jet-danger-button @click="showSubjectsOf()">Ir a Asignaturas</jet-danger-button>    
        <jet-danger-button @click="showCurriculumsOf()">Ir a Curriculums</jet-danger-button>    
      </template>
    </jet-dialog-modal>

    <jet-dialog-modal :show="modalUpdate">
      <template v-slot:content>
        <modal-edit-icon/>
        <h2 class="text-xl font-bold py-4" v-if="selectedCarreer"><strong> Carrera: {{selectedCarreer.name}}</strong></h2>
        <p class="text-sm text-gray-500 px-8">¿Estas seguro de querer Actualizar este elemento?</p>      
      </template>
      <template v-slot:footer>
        <jet-modify-button @click="closeModalUpdate()">Cerrar</jet-modify-button>
        <jet-danger-button @click="updateCarreer()"> Modificar</jet-danger-button>   
      </template>
    </jet-dialog-modal>

    <jet-dialog-modal :show="modalDelete">
      <template v-slot:content>
        <modal-delete-icon/>
        <h2 class="text-xl font-bold py-4" v-if="selectedCarreer"><strong> Carrera: {{selectedCarreer.name}}</strong></h2>
        <p class="text-sm text-gray-500 px-8">¿Estas seguro de querer eliminar este elemento?</p>    
      </template>
      <template v-slot:footer>
        <jet-modify-button @click="closeModalDelete()">Cerrar</jet-modify-button>
        <jet-danger-button @click="deleteCarreer()">Dehabilitar</jet-danger-button>    
      </template>
    </jet-dialog-modal>

    <!--Modal Components-->
    <excel-modal :show="modalExcel"></excel-modal>
    <register-modal :show="modalCreate"></register-modal>
    <relations-modal-curriculum :show="modalRelation"></relations-modal-curriculum>

</app-layout>
</template>

<script>
import {Inertia} from '@inertiajs/inertia';
import { useForm} from '@inertiajs/inertia-vue3';
import AppLayout from "@/Layouts/AppLayout";
import JetDialogModal from "@/Jetstream/DialogModal";
import JetLabel from "@/Jetstream/Label";
import JetTitleLabel from "@/Jetstream/TitleLabel";
import JetButton from "@/Jetstream/Button";
import JetModifyButton from "@/Jetstream/ModifyButton";
import JetDangerButton from "@/Jetstream/ButtonDanger";
import JetShow from '@/Jetstream/ShowLogo'
import JetEdit from '@/Jetstream/EditLogo'
import JetDelete from '@/Jetstream/DeleteLogo'
import JetImport from '@/Jetstream/ImportLogo'
import JetExport from '@/Jetstream/ExportLogo'
import ModalShowIcon from '@/Jetstream/modalShowIcon'
import ModalEditIcon from '@/Jetstream/modalEditIcon'
import ModalDeleteIcon from '@/Jetstream/modalDeleteIcon'

import RegisterModal from "@/Pages/Carreers/Modals/RegisterModal";
import ExcelModal from "@/Pages/Carreers/Modals/ExcelModal";
import RelationsModalCurriculum from "@/Pages/Carreers/Modals/RelationsModal";

export default {
  props:{ carreers: Array, columns: Array, options: Object},

  data(){  
    return{
      modalShow: false, modalUpdate: false, modalDelete: false,  modalCreate: false, modalExcel: false,  
      modalRelation: false ,
      selectedCarreer: Object,
       
      selectedModal:{value: ''}, 
      form: useForm({name: null}),
    }
  },
    
  components:{
    AppLayout, JetDialogModal, JetLabel, JetTitleLabel, JetButton, JetModifyButton, JetDangerButton,
    JetShow, JetEdit, JetDelete, JetImport, JetExport, ModalShowIcon, ModalEditIcon, ModalDeleteIcon, 
    RegisterModal , ExcelModal,
    RelationsModalCurriculum,
        
  },

  watch: {
    'selectedModal.value'(val) {
       if(val == 1){ this.openModalCreate()}
      else if(val == 2){ this.openModalRelationsCurriculum()}

    }
  },

  methods:{
    openModalShow() {this.modalShow=true}, closeModalShow() {this.modalShow=false},
    openModalUpdate() {this.modalUpdate=true}, closeModalUpdate() {this.modalUpdate=false},
    openModalDelete() {this.modalDelete=true}, closeModalDelete() {this.modalDelete=false},
    openModalCreate() {this.modalCreate = true}, closeModalCreate() {this.modalCreate = false}, 
    openModalRelationsCurriculum() {this.modalRelationCurriculum = true}, closeModalRelationsCurriculum() {this.modalRelationCurriculum = false},
    openModalExcel() {this.modalExcel = true}, closeModalExcel() {this.modalExcel = false},
     
    submit: function(){ this.form.get(route("carreers.index"));},
    exportExcel: function(){Inertia.get(route('carreers.export'))} ,
    deleteCarreer: function(){Inertia.delete(route("carreers.destroy", { carreer: this.selectedCarreer} )); this.closeModalDelete()},
    updateCarreer: function(){Inertia.get(route("carreers.edit", { carreer: this.selectedCarreer} )); this.closeModalUpdate()},
      
    showCarreer: function(){ window.open(this.selectedCarreer.website)},
    showCurriculumsOf: function(){Inertia.get(route('carreers.showCurriculums', { carreer: this.selectedCarreer})); this.closeModalShow()},
    showSubjectsOf: function(){},
     
    },
};
</script>