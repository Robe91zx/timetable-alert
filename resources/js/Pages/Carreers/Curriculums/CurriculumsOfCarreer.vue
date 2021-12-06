<template>
<app-layout title="Carreras">
  <template #header> 
    <div v-for="carreer in CurriculumsOf" v-bind:key="carreer.id">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight"> Carrera {{carreer.name}}</h2>
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
        <template v-for="carreer in CurriculumsOf" v-bind:key="carreer.id">   
          <tr v-for="curriculum in carreer.curriculums" :key="curriculum.id"> 
            <td class="px-6 py-4 text-center"><jet-label>{{curriculum.code}}</jet-label></td>
            <td class="px-6 py-4 text-center"><jet-label>Malla {{curriculum.name}}</jet-label></td>
            <td class="px-6 py-4 text-center"><jet-label>{{curriculum.duration}} Semestres</jet-label></td>
            <td class="px-6 py-4 text-center"><jet-label v-if="curriculum.state == 1"> Activo</jet-label><jet-label v-else> No Activo</jet-label></td>

            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
              <jet-button @click="openInfoCurriculum();selectedCurriculum=curriculum"> <jet-show/> </jet-button>
              <jet-button @click="openModalUpdate();selectedCurriculum=curriculum"> <jet-edit/> </jet-button>
              <jet-modify-button @click="openModalDelete();selectedCurriculum=curriculum"> <jet-delete/> </jet-modify-button>
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

  <jet-dialog-modal :show="modalInfoCurriculum">
    <template v-slot:content>
      <modal-show-icon/>
      <h2 class="text-xl font-bold py-4" v-if="selectedCurriculum"><strong> Malla {{selectedCurriculum.name}}</strong></h2>
      <p class="text-sm text-gray-500 px-8">¿Estas seguro de querer redirigir a la interfase de Curriculum?</p>    
    </template>
    <template v-slot:footer class="p-3  mt-2 text-center space-x-4 md:block">
      <jet-modify-button @click="closeInfoCurriculum()">Cerrar</jet-modify-button>
      <jet-button @click="showSubjectsOf()">Ir a Asignaturas</jet-button>    
      <jet-button @click="InfoDepartment()">Ir a Website</jet-button>    
    </template>
  </jet-dialog-modal>

<jet-dialog-modal :show="modalUpdate">
    <template v-slot:content>
      <modal-edit-icon/>
      <h2 class="text-xl font-bold py-4" v-if="selectedCurriculum"><strong> Malla de {{selectedCurriculum.name}}</strong></h2>
      <p class="text-sm text-gray-500 px-8">¿Estas seguro de querer Actualizar este elemento?</p>    
    </template>
    <template v-slot:footer class="p-3  mt-2 text-center space-x-4 md:block">
      <jet-modify-button @click="closeModalUpdate()">Cerrar</jet-modify-button>
      <jet-danger-button @click="updateCurriculum()"> Modificar</jet-danger-button>    
    </template>
  </jet-dialog-modal>

  <jet-dialog-modal :show="modalDelete">
    <template v-slot:content>
      <modal-delete-icon/>       
      <h2 class="text-xl font-bold py-4" v-if="selectedCurriculum"><strong>  Malla {{selectedCurriculum.name}}</strong></h2>
      <p class="text-sm text-gray-500 px-8">¿Estas seguro de querer quitar {{selectedCurriculum.name}} de la Carrera {{CurriculumsOf.name}}?</p>    
    </template>
    <template v-slot:footer class="p-3  mt-2 text-center space-x-4 md:block">
      <jet-modify-button @click="closeModalDelete()">Cerrar</jet-modify-button>
      <jet-danger-button @click="deleteCurriculum()">Borrar</jet-danger-button>    
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

  props:{ CurriculumsOf:Array, columns:Array, selectedDepartment: Object, errors: Object,
    },

  data(){
    return{ 
      modalUpdate: false, modalDelete: false, modalInfoCurriculum: false,        
    }    
},

  methods:{
    openInfoCurriculum(){this.modalInfoCurriculum =true}, closeInfoCurriculum(){this.modalInfoCurriculum =false},
    openModalUpdate(){this.modalUpdate =true}, closeModalUpdate(){this.modalUpdate =false},
    openModalDelete(){this.modalDelete =true}, closeModalDelete(){this.modalDelete =false},

    showSubjectsOf: function(){ Inertia.get(route("curriculums.show", { curriculum: this.selectedCurriculum} )); this.closeInfoCurriculum(); },
    updateDepartment: function(){ Inertia.get(route('curriculums.edit', { curriculum: this.selectedCurriculum})) },
    deleteCurriculumOf: function(){ Inertia.delete(route('curriculums.remove', { curriculum: this.selectedDepartment})) },
    
    
    InfoDepartment: function(){
    //Corregir para que cargue, segun la facultad o departamento que solicitan. Esto es solo testing
    let url='https://{{DepartmentsOf.website}}'
    this.modalInfoDepartment = false;
    window.open(url);
    },
  
}
}
</script>