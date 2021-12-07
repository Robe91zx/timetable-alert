<template>
<app-layout title="Escuelas">
  <template #header>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Escuelas</h2>
  </template>

  <div class="py-12">
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="flex mb-4">
      <div class="w-3/5 h-12">
        <form method="get" @submit.prevent="submit">
          <input v-model="form.name" :disabled="form.processing" name="name" placeholder="Busqueda de Escuelas" type="text" class="w-3/4 my-2 px-3 py-1 border rounded-lg text-xs text-gray-700 focus:outline-none"/> 
        </form>    
      </div> 
      <div class="w-2/5 h-12 ">   
        <select v-model="selectedModal.value" class="float-right my-2 px-3 py-1 border rounded-lg text-xs text-gray-700 focus:outline-none" >
          <option class="py-1" value="" disabled>Seleccione una Funcionalidad</option>
          <option class="py-1" v-for="(option, index) in options" :key="index" v-bind:value="index">{{option}}</option>
        </select>
        <button class="my-2 px-3 py-1 float-right" @click="exportExcel()"> <jet-export/> </button>
        <button class="my-2 px-3 py-1 float-right" @click="openExcelRegister()"> <jet-import/> </button>  
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
          <tr v-for="college in colleges" :key="college.id"> 
            <td class="px-6 py-4 text-center"><jet-label>{{college.code}}</jet-label></td>
            <td class="px-6 py-4 text-center"><jet-label>Escuela de {{college.name}}</jet-label></td>
            <td class="px-6 py-4 text-center"><jet-label>{{college.email}}</jet-label></td>
            <td class="px-6 py-4 text-center"><jet-label>{{college.phone}}</jet-label></td>

            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
              <jet-button @click="this.modalShow=true;selectedCollege=college"> <jet-show/> </jet-button>
              <jet-button @click="this.modalUpdate=true;selectedCollege=college"> <jet-edit/> </jet-button>
              <jet-modify-button @click="this.modalDelete=true;selectedCollege=college"> <jet-delete/> </jet-modify-button>
            </td>
          </tr>
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
      <h2 class="text-xl font-bold py-4" v-if="selectedCollege"><strong> Escuela de {{selectedCollege.name}}</strong></h2>
      <p class="text-sm text-gray-500 px-8"> ¿Estas seguro de querer ir a ver sus Carreras?</p>   
    </template>
    <template v-slot:footer>
      <jet-modify-button @click="this.modalShow=false">Cerrar</jet-modify-button>
      <jet-danger-button @click="showCarreersOf()">Ir a Carreras</jet-danger-button>    
    </template>
  </jet-dialog-modal>

  <jet-dialog-modal :show="modalDelete">
    <template v-slot:content>
      <modal-delete-icon/>       
      <h2 class="text-xl font-bold py-4" v-if="selectedCollege"><strong> Escuela de {{selectedCollege.name}}</strong></h2>
      <p class="text-sm text-gray-500 px-8">¿Estas seguro de querer eliminar este elemento?</p>    
    </template>
    <template v-slot:footer>
      <jet-modify-button @click="this.modalDelete=false">Cerrar</jet-modify-button>
      <jet-danger-button @click="deleteCollege()">Dehabilitar</jet-danger-button>    
    </template>
  </jet-dialog-modal>

  <jet-dialog-modal :show="modalUpdate">
    <template v-slot:content>
      <modal-edit-icon/>
      <h2 class="text-xl font-bold py-4" v-if="selectedCollege"><strong> Escuela de {{selectedCollege.name}}</strong></h2>
      <p class="text-sm text-gray-500 px-8">¿Estas seguro de querer Actualizar este elemento?</p>    
    </template>
    <template v-slot:footer>
      <jet-modify-button @click="this.modalUpdate=false">Cerrar</jet-modify-button>
      <jet-danger-button @click="updateCollege()"> Modificar</jet-danger-button>    
    </template>
  </jet-dialog-modal>

  <register-college :show="modalRegisterCollege"></register-college>
  <excel-register :show="modalExcelRegister"></excel-register>

  <excel-college-has-carreer :show="modalExcelRelationCCarreer"></excel-college-has-carreer>
  <college-has-carreer :show="modalRelationCCarreer"></college-has-carreer>

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

import RegisterCollege from '@/Pages/Colleges/Modals/RegisterModal.vue';
import ExcelRegister from '@/Pages/Colleges/Modals/ExcelModal.vue';

import CollegeHasCarreer from '@/Pages/Colleges/Carreers/Modals/RelationsModal.vue';
import ExcelCollegeHasCarreer from '@/Pages/Colleges/Carreers/Modals/ExcelModalRelation.vue';


export default {
  props:{ colleges: Array, columns: Array, options: Object},
   
  data(){  
    return{ modalShow: false, modalDelete: false, modalUpdate: false, modalRegisterCollege: false, modalExcelRegister: false,
            modalRelationCCarreer: false, modalExcelRelationCCarreer:false,
            selectedCollege: Object,
        
      selectedModal:{ value: ''}, 
      form: useForm({ name: null}),
    }
  },

  components:{
    AppLayout, JetDialogModal, JetLabel, JetTitleLabel, JetButton, JetModifyButton, JetDangerButton,
    JetShow, JetEdit, JetDelete, JetImport, JetExport, ModalShowIcon, ModalEditIcon, ModalDeleteIcon,
    RegisterCollege, ExcelRegister, 
    CollegeHasCarreer, ExcelCollegeHasCarreer    
  },

  watch: {
    'selectedModal.value'(val) {
      if(val == 1){ this.openRegisterCollege()}
      else if(val == 2){ this.openCollegeHasCarreer()}
      else if(val == 3){ this.openExcelCollegeHasCarreers()}
      }
    },

  methods:{
    submit: function(){this.form.get(route("colleges.index"))},
    exportExcel: function(){Inertia.get(route('colleges.export'))} ,
    deleteCollege: function(){Inertia.delete(route("colleges.destroy", {college: this.selectedCollege}));this.closeModalDelete()},
    updateCollege: function(){Inertia.get(route("colleges.edit", {college: this.selectedCollege} ));this.closeModalUpdate()},
    showCarreersOf: function(){ Inertia.get(route('colleges.show', { college: this.selectedCollege} ))},

    openRegisterCollege(){this.modalRegisterCollege = true}, closeRegisterCollege(){this.modalRegisterCollege = false},
    openExcelRegister(){this.modalExcelRegister = true}, closeExcelRegister(){this.modalExcelRegister = false},
    openExcelCollegeHasCarreers(){this.modalExcelRelationCCarreer = true}, closeExcelCollegeHasCarreers(){this.modalExcelRelationCCarreer = false},
    openCollegeHasCarreer(){this.modalRelationCCarreer= true}, closeModalRelationsCarreer(){this.modalRelationCCarreer= false}, 

    
  }
};
</script>