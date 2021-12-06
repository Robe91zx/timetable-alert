<template>
<app-layout title="Asignaturas">
  <template #header>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Asignaturas</h2>
  </template>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="flex mb-4">
        <div class="w-3/5 h-12">
          <form method="get" @submit.prevent="submit">
            <input v-model="form.name" :disabled="form.processing" name="name" placeholder="Busqueda" type="text" class="w-3/4 my-2 px-3 py-1 border rounded-lg text-xs text-gray-700 focus:outline-none"/> 
          </form>    
        </div>                                                                    
        <div class="w-2/5 h-12"> 
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
                  <template v-for="faculty in subjects" :key="faculty.id">
                    <tr v-for="subject in faculty.subjects" :key="subject.id">
                      <td class="px-6 py-4 text-center"><jet-label>{{subject.code}}</jet-label></td>
                      <td class="px-6 py-4 text-center"><jet-label>{{subject.name}}</jet-label>
                        <div class="text-sm text-gray-500">{{faculty.name}}</div>
                      </td>
                      <td class="px-6 py-4 text-center"><jet-label>PREREQUISITO</jet-label></td>
                      <td class="px-6 py-4 text-center"><jet-label>{{subject.hours}} Hrs</jet-label></td>
                      <td class="px-6 py-4 text-center"><jet-label v-if="subject.state ==1"> Activo</jet-label><jet-label v-else> No Activo</jet-label></td>
                      
                      <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <jet-button @click="openModalShow();selectedSubject=subject"> <jet-show/></jet-button>
                        <jet-button @click="openModalUpdate();selectedSubject=subject"> <jet-edit/></jet-button>
                        <jet-modify-button @click="openModalDelete();selectedSubject=subject"> <jet-delete/></jet-modify-button>
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
      <h2 class="text-xl font-bold py-4" v-if="selectedSubject"><strong> Asignatura {{selectedSubject.name}}</strong></h2>
      <p class="text-sm text-gray-500 px-8"> ¿Estas seguro de querer ir a ver sus departamentos?</p>   
    </template>
    <template v-slot:footer>
      <jet-modify-button @click="closeModalShow()">Cerrar</jet-modify-button>
      <jet-button @click="showCoursesOf()">Ir a Cursos</jet-button>    
    </template>
  </jet-dialog-modal>

  <jet-dialog-modal :show="modalUpdate">
    <template v-slot:content>
      <modal-edit-icon/>
      <h2 class="text-xl font-bold py-4" v-if="selectedSubject"><strong> Asignatura {{selectedSubject.name}}</strong></h2>
      <p class="text-sm text-gray-500 px-8">¿Estas seguro de querer Actualizar este elemento?</p>    
    </template>
    <template v-slot:footer class="p-3  mt-2 text-center space-x-4 md:block">
      <jet-modify-button @click="closeModalUpdate()">Cerrar</jet-modify-button>
      <jet-button @click="updateSubject()"> Modificar</jet-button>   
    </template>
  </jet-dialog-modal>

  <jet-dialog-modal :show="modalDelete">
    <template v-slot:content>
      <modal-delete-icon/>
      <h2 class="text-xl font-bold py-4" v-if="selectedSubject"><strong> Asignatura {{selectedSubject.name}}</strong></h2>
      <p class="text-sm text-gray-500 px-8">¿Estas seguro de querer eliminar este elemento?</p>    
    </template>
    <template v-slot:footer>
      <jet-modify-button @click="closeModalDelete()">Cerrar</jet-modify-button>
      <jet-danger-button @click="deleteSubject()">Dehabilitar</jet-danger-button>    
    </template>
  </jet-dialog-modal>

  <excel-modal :show="modalExcel"></excel-modal>
  <register-modal :show="modalCreate"></register-modal>
  
</app-layout>
</template>

<script>
import {Link} from '@inertiajs/inertia-vue3';
import {Inertia} from '@inertiajs/inertia';
import JetLabel from "@/Jetstream/Label";
import { useForm} from '@inertiajs/inertia-vue3';
import AppLayout from "@/Layouts/AppLayout";
import JetDialogModal from "@/Jetstream/DialogModal";
import JetTitleLabel from "@/Jetstream/TitleLabel";
import JetImport from '@/Jetstream/ImportLogo'
import JetButton from "@/Jetstream/Button";
import JetModifyButton from "@/Jetstream/ModifyButton";
import JetDangerButton from "@/Jetstream/ButtonDanger";
import ModalShowIcon from '@/Jetstream/modalShowIcon'
import ModalEditIcon from '@/Jetstream/modalEditIcon'
import ModalDeleteIcon from '@/Jetstream/modalDeleteIcon'
import JetExport from '@/Jetstream/ExportLogo'
import RegisterModal from "@/Pages/Subjects/Modals/RegisterModal";
import ExcelModal from "@/Pages/Subjects/Modals/ExcelModal";
import JetEdit from '@/Jetstream/EditLogo'
import JetShow from '@/Jetstream/ShowLogo'
import JetDelete from '@/Jetstream/DeleteLogo'

export default {
  props:{
    subjects: Array, columns: Object, options: Object
  },
  
  data(){
    return{
      modalShow: false, modalDelete: false, modalExcel: false,
      modalUpdate: false,modalCreate: false,
      selectedSubject: Object,
      
      form: useForm({ name: null}),
      selectedModal:{value: ''}, 

    }
  },

  watch: {
    'selectedModal.value'(val) {
    if(val == 1){ this.openModalCreate()} 
    },
  },
  
  components:{
JetEdit, JetShow, JetDelete,
    AppLayout, RegisterModal, ExcelModal, 
    JetDialogModal, JetTitleLabel, JetLabel,
    Link, JetExport, JetImport,
    JetButton,JetModifyButton,JetDangerButton,ModalEditIcon,ModalShowIcon,ModalDeleteIcon
  },

  methods:{
    openModalShow() {this.modalShow=true}, closeModalShow() {this.modalShow=false},
    openModalUpdate() {this.modalUpdate=true}, closeModalUpdate() {this.modalUpdate=false},
    openModalDelete() {this.modalDelete=true}, closeModalDelete() {this.modalDelete=false},
    openModalCreate() {this.modalCreate = true}, closeModalCreate() {this.modalCreate = false},
    openModalExcel() {this.modalExcel = true}, closeModalExcel() {this.modalExcel = false},

    submit: function(){  this.form.get(route("subjects.index"));},
    exportExcel: function(){Inertia.get(route('subjects.export'))},
    showCoursesOf: function(){},
    updateSubject: function(){ Inertia.get(route("subjects.edit", {subject: this.selectedSubject} )); this.closeModalUpdate() },
    deleteSubject: function(){ Inertia.delete(route("subjects.destroy", {subject: this.selectedSubject} )); this.closeModalDelete() },
  }
};
</script>