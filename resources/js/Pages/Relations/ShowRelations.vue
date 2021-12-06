<template>
<app-layout title="Facultades">
  <template #header>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Facultades</h2>
  </template>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="flex mb-4">
        <div class="w-3/5 h-12">
          <form method="get" @submit.prevent="submit">
            <input v-model="form.name" :disabled="form.processing" name="name" placeholder="Busqueda de Facultades" type="text" class="w-3/4 my-2 px-3 py-1 border rounded-lg text-xs text-gray-700 focus:outline-none" /> 
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
                  <tr><th scope="col" v-for="column in columns1" :key="column.name"><jet-title-label>{{column}}</jet-title-label></th></tr>
                </thead>
                  
                <tbody class="bg-white divide-y divide-gray-200">                      
                  <template v-for="faculty in AllOf" :key="faculty.id">
                    <template v-if="faculty.departments">
                      <tr v-for="department in faculty.departments" :key="department.id"> 
                        <td class="px-6 py-4 text-center"><jet-label>{{faculty.name}}</jet-label></td>
                        <td class="px-6 py-4 text-center"><jet-label>Depto. de {{department.name}}</jet-label></td>
                        <td class="px-6 py-4 text-center"><jet-label>{{department.email}}</jet-label></td>
                        <td class="px-6 py-4 text-center"><jet-label>{{department.phone}}</jet-label></td>

                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                          <jet-button @click="openModalShow();selectedDeptarment=deptarment"> <jet-show/></jet-button>
                          <jet-button @click="openModalUpdate();selectedDeptarment=deptarment"> <jet-edit/></jet-button>
                          <jet-modify-button @click="openModalDelete();selectedDeptarment=deptarment"> <jet-delete/></jet-modify-button>
                        </td>
                      </tr>
                    </template>
                    <template v-if="faculty.colleges">
                      <tr v-for="college in faculty.colleges" :key="college.id"> 
                        <td class="px-6 py-4 text-center"><jet-label>{{faculty.name}}</jet-label></td>
                        <td class="px-6 py-4 text-center"><jet-label>EScuela de {{college.name}}</jet-label></td>
                        <td class="px-6 py-4 text-center"><jet-label>{{college.email}}</jet-label></td>
                        <td class="px-6 py-4 text-center"><jet-label>{{college.phone}}</jet-label></td>

                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                          <jet-button @click="openModalShow();selectedCollege=college"> <jet-show/></jet-button>
                          <jet-button @click="openModalUpdate();selectedCollege=college"> <jet-edit/></jet-button>
                          <jet-modify-button @click="openModalDelete();selectedCollege=college"> <jet-delete/></jet-modify-button>
                        </td>
                      </tr>
                    </template>  
                  </template>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="flex flex-col mt-8">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">              
              <table class="min-w-full divide-y divide-gray-200">
                <thead>
                  <tr><th scope="col" v-for="column in columns2" :key="column.name"><jet-title-label>{{column}}</jet-title-label></th></tr>
                </thead>
                  
                <tbody class="bg-white divide-y divide-gray-200">                      
                  <template v-for="faculty in AllOf" :key="faculty.id">
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
      <h2 class="text-xl font-bold py-4" v-if="selectedFaculty"><strong> Facultad de {{selectedFaculty.name}}</strong></h2>
      <p class="text-sm text-gray-500 px-8"> ¿Estas seguro de querer ir a ver sus departamentos?</p>   
    </template>
    <template v-slot:footer>
      <jet-modify-button @click="closeModalShow()">Cerrar</jet-modify-button>
      <jet-button @click="showDepartmentsOf()">Ir a Deptos</jet-button>    
    </template>
  </jet-dialog-modal>

  <jet-dialog-modal :show="modalUpdate">
    <template v-slot:content>
      <modal-edit-icon/>
      <h2 class="text-xl font-bold py-4" v-if="selectedFaculty"><strong> Facultad de {{selectedFaculty.name}}</strong></h2>
      <p class="text-sm text-gray-500 px-8">¿Estas seguro de querer Actualizar este elemento?</p>    
    </template>
    <template v-slot:footer class="p-3  mt-2 text-center space-x-4 md:block">
      <jet-modify-button @click="closeModalUpdate()">Cerrar</jet-modify-button>
      <jet-button @click="updateFaculty()"> Modificar</jet-button>   
    </template>
  </jet-dialog-modal>

  <jet-dialog-modal :show="modalDelete">
    <template v-slot:content>
      <modal-delete-icon/>
      <h2 class="text-xl font-bold py-4" v-if="selectedFaculty"><strong> Facultad de {{selectedFaculty.name}}</strong></h2>
      <p class="text-sm text-gray-500 px-8">¿Estas seguro de querer eliminar este elemento?</p>    
    </template>
    <template v-slot:footer>
      <jet-modify-button @click="closeModalDelete()">Cerrar</jet-modify-button>
      <jet-danger-button @click="deleteFaculty()">Dehabilitar</jet-danger-button>    
    </template>
  </jet-dialog-modal>

  <!--Modals Component-->
    <excel-modal :show="modalExcel"></excel-modal>
    <register-modal :show="modalCreate"></register-modal>
    <edit-modal :show="modalEdit"></edit-modal>
    <relations-modal-department :show="modalRelationDepartment"></relations-modal-department>
    <excel-relations-modal-department :show="modalExcelRelationDepartment"></excel-relations-modal-department>
    <relations-modal-college :show="modalRelationCollege"></relations-modal-college>
    <excel-relations-modal-college :show="modalExcelRelationCollege"></excel-relations-modal-college>
    <relations-modal-carreer :show="modalRelationCarreer"></relations-modal-carreer>
    <excel-relations-modal-carreer :show="modalExcelRelationCarreer"></excel-relations-modal-carreer>
  
</app-layout>
</template>

<script>
import {Inertia} from '@inertiajs/inertia';
import { useForm} from '@inertiajs/inertia-vue3';
import AppLayout from "@/Layouts/AppLayout";
import JetDialogModal from "@/Jetstream/DialogModal";
import JetLabel from "@/Jetstream/Label";
import JetButton from "@/Jetstream/Button";
import JetModifyButton from "@/Jetstream/ModifyButton";
import JetDangerButton from "@/Jetstream/ButtonDanger";
import JetTitleLabel from "@/Jetstream/TitleLabel";
import RegisterModal from "@/Pages/Faculties/Modals/RegisterModal";
import EditModal from "@/Pages/Faculties/Modals/testing-EditModal";
import ExcelModal from "@/Pages/Faculties/Modals/ExcelModal";
import RelationsModalDepartment from "@/Pages/Faculties/Departments/Modals/RelationsModal";
import ExcelRelationsModalDepartment from "@/Pages/Faculties/Departments/Modals/ExcelModalRelation";
import RelationsModalCollege from "@/Pages/Faculties/Colleges/Modals/RelationsModal";
import ExcelRelationsModalCollege from "@/Pages/Faculties/Colleges/Modals/ExcelModalRelation";
import RelationsModalCarreer from "@/Pages/Faculties/Carreers/Modals/RelationsModal";
import ExcelRelationsModalCarreer from "@/Pages/Faculties/Carreers/Modals/ExcelModalRelation";
import JetEdit from '@/Jetstream/EditLogo'
import JetShow from '@/Jetstream/ShowLogo'
import JetDelete from '@/Jetstream/DeleteLogo'
import ModalShowIcon from '@/Jetstream/modalShowIcon'
import ModalEditIcon from '@/Jetstream/modalEditIcon'
import ModalDeleteIcon from '@/Jetstream/modalDeleteIcon'
import JetImport from '@/Jetstream/ImportLogo'
import JetExport from '@/Jetstream/ExportLogo'


export default {
  props:{
    AllOf: Array, columns1: Array, columns2: Array, options: Object
  },

  data(){  
    return{
      modalShow: false, modalDelete: false, modalUpdate: false, modalExcel: false, modalCreate: false, modalEdit: false, 
      modalRelationDepartment: false, modalExcelRelationDepartment: false , modalRelationCollege: false, modalExcelRelationCollege: false ,modalRelationCarreer: false, modalExcelRelationCarreer: false,
      selectedFaculty: Object,
        
      selectedModal:{value: ''}, 
      form: useForm({name: null}),
    }
  },
    
  components:{
    AppLayout,
    JetTitleLabel, JetLabel, JetButton, JetModifyButton, JetDangerButton, JetDialogModal, RegisterModal , EditModal, ExcelModal, 
    RelationsModalDepartment, ExcelRelationsModalDepartment, RelationsModalCollege, ExcelRelationsModalCollege,RelationsModalCarreer, ExcelRelationsModalCarreer,
    JetEdit, JetShow, JetDelete, ModalShowIcon, ModalEditIcon, ModalDeleteIcon, JetImport, JetExport
  },

  watch: {
    'selectedModal.value'(val) {
    //console.log(this.selectedModal.value)
    if(val == 1){ this.openModalCreate()}
    else if(val == 2){ this.openModalRelationsDepartment()}
    else if(val == 3){ this.openModalExcelRelationDepartment()}        
    else if(val == 4){ this.openModalRelationsCollege()}        
    else if(val == 5){ this.openModalExcelRelationCollege()}
    else if(val == 6){ this.openModalRelationsCarreer()} 
    else if(val == 7){ this.openModalExcelRelationCarreer()} 
    }
  },

  methods:{
    openModalShow() {this.modalShow=true}, closeModalShow() {this.modalShow=false},
    openModalUpdate() {this.modalUpdate=true}, closeModalUpdate() {this.modalUpdate=false},
    openModalDelete() {this.modalDelete=true}, closeModalDelete() {this.modalDelete=false},
    openModalCreate() {this.modalCreate = true}, closeModalCreate() {this.modalCreate = false},
    openModalRelationsCollege() {this.modalRelationCollege = true}, closeModalRelationsCollege() {this.modalRelationCollege = false},
    openModalRelationsDepartment() {this.modalRelationDepartment = true}, closeModalRelationsDepartment() {this.modalRelationDepartment = false},
    openModalRelationsCarreer () {this.modalRelationCarreer = true}, closeModalRelationsCarreer () {this.modalRelationCarreer = false},
    openModalExcelRelationCollege() {this.modalExcelRelationCollege = true}, closeModalExcelRelationCollege() {this.modalExcelRelationCollege = false},
    openModalExcelRelationDepartment() {this.modalExcelRelationDepartment = true}, closeModalExcelRelationDepartment() {this.modalExcelRelationDepartment = false},
    openModalExcelRelationCarreer() {this.modalExcelRelationCarreer = true}, closeModalExcelRelationCarreer() {this.modalExcelRelationCarreer = false},
    openModalExcel() {this.modalExcel = true}, closeModalExcel() {this.modalExcel = false},
    openModalEdit(){this.modalEdit = true}, closeModalEdit() {this.modalEdit = false},
      
    submit: function(){ this.form.get(route("faculties.index"))},
    exportExcel: function(){Inertia.get(route('faculties.export'))} ,
    deleteFaculty: function(){Inertia.delete(route("faculties.destroy", { faculty: this.selectedFaculty} )); this.closeModalDelete()},
    updateFaculty: function(){Inertia.get(route("faculties.edit", { faculty: this.selectedFaculty} )); this.closeModalUpdate()},
    showDepartmentsOf: function(){Inertia.get(route("faculties.show", {faculty: this.selectedFaculty} )); this.closeModalShow()}, 
  },
};
</script>