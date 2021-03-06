<template>
  <app-layout title="Facultades">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Facultades
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex mb-4">
          <div class="w-3/5 h-12">
            <form method="get" @submit.prevent="submit">
              <input
                v-model="form.name"
                :disabled="form.processing"
                name="name"
                placeholder="Busqueda de Facultades"
                type="text"
                class="
                  w-3/4
                  my-2
                  px-3
                  py-1
                  border
                  rounded-lg
                  text-xs text-gray-700
                  focus:outline-none
                "
              />
            </form>
          </div>
          <div class="w-2/5 h-12">
            <select
              v-model="selectedModal.value"
              class="
                float-right
                my-2
                px-3
                py-1
                border
                rounded-lg
                text-xs text-gray-700
                focus:outline-none
              "
            >
              <option class="py-1" value="" disabled>
                Seleccione una Funcionalidad
              </option>
              <option
                class="py-1"
                v-for="(option, index) in options"
                :key="index"
                v-bind:value="index"
              >
                {{ option }}
              </option>
            </select>
            <button class="my-2 px-3 py-1 float-right" @click="exportExcel()">
              <jet-export />
            </button>
            <button
              class="my-2 px-3 py-1 float-right"
              @click="openExcelRegister()"
            >
              <jet-import />
            </button>
          </div>
        </div>

        <div class="flex flex-col mt-8">
          <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div
              class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8"
            >
              <div
                class="
                  shadow
                  overflow-hidden
                  border-b border-gray-200
                  sm:rounded-lg
                "
              >
                <table class="min-w-full divide-y divide-gray-200">
                  <thead>
                    <tr>
                      <th
                        scope="col"
                        v-for="column in columns"
                        :key="column.name"
                      >
                        <jet-title-label>{{ column }}</jet-title-label>
                      </th>
                    </tr>
                  </thead>

                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="faculty in faculties" :key="faculty.id">
                      <td class="px-6 py-4 text-center">
                        <jet-label>{{ faculty.code }}</jet-label>
                      </td>
                      <td class="px-6 py-4 text-center">
                        <jet-label>{{ faculty.name }}</jet-label>
                      </td>
                      <td class="px-6 py-4 text-center">
                        <jet-label>{{ faculty.email }}</jet-label>
                      </td>
                      <td class="px-6 py-4 text-center">
                        <jet-label>{{ faculty.phone }}</jet-label>
                      </td>

                      <td
                        class="
                          px-6
                          py-4
                          whitespace-nowrap
                          text-right text-sm
                          font-medium
                        "
                      >
                        <jet-button
                          @click="
                            this.modalShow = true;
                            selectedFaculty = faculty;
                          "
                        >
                          <jet-show
                        /></jet-button>
                        <jet-button
                          @click="
                            this.modalUpdate = true;
                            selectedFaculty = faculty;
                          "
                        >
                          <jet-edit
                        /></jet-button>
                        <jet-modify-button
                          @click="
                            this.modalDelete = true;
                            selectedFaculty = faculty;
                          "
                        >
                          <jet-delete
                        /></jet-modify-button>
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
        <modal-show-icon />
        <h2 class="text-xl font-bold py-4" v-if="selectedFaculty">
          <strong> Facultad de {{ selectedFaculty.name }}</strong>
        </h2>
        <p class="text-sm text-gray-500 px-8">
          ¿Estas seguro de querer ir a ver sus departamentos?
        </p>
      </template>
      <template v-slot:footer>
        <jet-modify-button @click="this.modalShow = false"
          >Cerrar</jet-modify-button
        >
        <jet-button @click="showDepartmentsOf()">Ir a Deptos</jet-button>
        <jet-button @click="showCarreersOf()">Ir a Carreras</jet-button>
        <jet-button @click="showSubjectsOf()">Ir a Asignaturas</jet-button>
      </template>
    </jet-dialog-modal>

    <jet-dialog-modal :show="modalUpdate">
      <template v-slot:content>
        <modal-edit-icon />
        <h2 class="text-xl font-bold py-4" v-if="selectedFaculty">
          <strong> Facultad de {{ selectedFaculty.name }}</strong>
        </h2>
        <p class="text-sm text-gray-500 px-8">
          ¿Estas seguro de querer Actualizar este elemento?
        </p>
      </template>
      <template v-slot:footer class="p-3 mt-2 text-center space-x-4 md:block">
        <jet-modify-button @click="this.modalUpdate = false"
          >Cerrar</jet-modify-button
        >
        <jet-button @click="updateFaculty()"> Actualizar</jet-button>
      </template>
    </jet-dialog-modal>

    <jet-dialog-modal :show="modalDelete">
      <template v-slot:content>
        <modal-delete-icon />
        <h2 class="text-xl font-bold py-4" v-if="selectedFaculty">
          <strong> Facultad de {{ selectedFaculty.name }}</strong>
        </h2>
        <p class="text-sm text-gray-500 px-8">
          ¿Estas seguro de querer eliminar este elemento?
        </p>
      </template>
      <template v-slot:footer>
        <jet-modify-button @click="this.modalDelete = false"
          >Cerrar</jet-modify-button
        >
        <jet-danger-button @click="deleteFaculty()">Eliminar</jet-danger-button>
      </template>
    </jet-dialog-modal>

    <!--Modals Component-->
    <register-faculty :show="modalRegisterFaculty"></register-faculty>
    <edit-faculties :show="modalEditFaculties"></edit-faculties>
    <excel-register :show="modalExcelRegister"></excel-register>

    <faculty-has-department
      :show="modalRelationFDepartment"
    ></faculty-has-department>
    <excel-faculty-has-department
      :show="modalExcelRelationFDepartment"
    ></excel-faculty-has-department>
    <faculty-has-college :show="modalRelationFCollege"></faculty-has-college>
    <excel-faculty-has-college
      :show="modalExcelRelationFCollege"
    ></excel-faculty-has-college>
    <faculty-has-carreer :show="modalRelationFCarreer"></faculty-has-carreer>
    <excel-faculty-has-carreer
      :show="modalExcelRelationFCarreer"
    ></excel-faculty-has-carreer>
    <!--<faculty-has-subject :show="modalRelationFSubject"></faculty-has-subject>
  <excel-faculty-has-subject :show="modalExcelRelationFSubject"></excel-faculty-has-subject>
  -->
  </app-layout>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";
import { useForm } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout";
import JetDialogModal from "@/Jetstream/DialogModal";
import JetLabel from "@/Jetstream/Label";
import JetTitleLabel from "@/Jetstream/TitleLabel";
import JetButton from "@/Jetstream/Button";
import JetModifyButton from "@/Jetstream/ModifyButton";
import JetDangerButton from "@/Jetstream/ButtonDanger";
import JetShow from "@/Jetstream/ShowLogo";
import JetEdit from "@/Jetstream/EditLogo";
import JetDelete from "@/Jetstream/DeleteLogo";
import JetImport from "@/Jetstream/ImportLogo";
import JetExport from "@/Jetstream/ExportLogo";
import ModalShowIcon from "@/Jetstream/modalShowIcon";
import ModalEditIcon from "@/Jetstream/modalEditIcon";
import ModalDeleteIcon from "@/Jetstream/modalDeleteIcon";

import RegisterFaculty from "@/Pages/Faculties/Modals/RegisterModal";
//EditModal hay que trabajarlo- no funciona-
import EditFaculties from "@/Pages/Faculties/Modals/testing-EditModal";
import ExcelRegister from "@/Pages/Faculties/Modals/ExcelModal";

import FacultyHasDepartment from "@/Pages/Faculties/Departments/Modals/RelationsModal";
import ExcelFacultyHasDepartment from "@/Pages/Faculties/Departments/Modals/ExcelModalRelation";
import FacultyHasCollege from "@/Pages/Faculties/Colleges/Modals/RelationsModal";
import ExcelFacultyHasCollege from "@/Pages/Faculties/Colleges/Modals/ExcelModalRelation";
import FacultyHasCarreer from "@/Pages/Faculties/Carreers/Modals/RelationsModal";
import ExcelFacultyHasCarreer from "@/Pages/Faculties/Carreers/Modals/ExcelModalRelation";
import FacultyHasSubject from "@/Pages/Faculties/Subjects/Modals/RelationsModal";
import ExcelFacultyHasSubject from "@/Pages/Faculties/Subjects/Modals/ExcelModalRelation";

export default {
  props: { faculties: Array, columns: Array, options: Object },

  data() {
    return {
      modalShow: false,
      modalUpdate: false,
      modalDelete: false,
      modalRegisterFaculty: false,
      modalEditFaculties: false,
      modalExcelRegister: false,
      modalRelationFDepartment: false,
      modalExcelRelationFDepartment: false,
      modalRelationFCollege: false,
      modalExcelRelationFCollege: false,
      modalRelationFCarreer: false,
      modalExcelRelationFCarreer: false,
      modalRelationFSubject: false,
      modalExcelRelationSubject: false,
      selectedFaculty: Object,

      selectedModal: { value: "" },
      form: useForm({ name: null }),
    };
  },

  components: {
    AppLayout,
    JetDialogModal,
    JetLabel,
    JetTitleLabel,
    JetButton,
    JetModifyButton,
    JetDangerButton,
    JetShow,
    JetEdit,
    JetDelete,
    JetImport,
    JetExport,
    ModalShowIcon,
    ModalEditIcon,
    ModalDeleteIcon,
    RegisterFaculty,
    EditFaculties,
    ExcelRegister,
    FacultyHasDepartment,
    ExcelFacultyHasDepartment,
    FacultyHasCollege,
    ExcelFacultyHasCollege,
    FacultyHasCarreer,
    ExcelFacultyHasCarreer,
    FacultyHasSubject,
    ExcelFacultyHasSubject,
  },

  watch: {
    "selectedModal.value"(val) {
      //console.log(this.selectedModal.value)
      if (val == 1) {
        this.openRegisterFaculty();
      } else if (val == 2) {
        this.openFacultyHasDepartment();
      } else if (val == 3) {
        this.openExcelFacultyHasDepartments();
      } else if (val == 4) {
        this.openFacultyHasCollege();
      } else if (val == 5) {
        this.openExcelFacultyHasColleges();
      } else if (val == 6) {
        this.openFacultyHasCarreer();
      } else if (val == 7) {
        this.openExcelFacultyHasCarreers();
      } else if (val == 8) {
        this.openFacultyHasSubject();
      } else if (val == 9) {
        this.openExcelFacultyHasSubjects();
      } else if (val == 10) {
        this.openEditFaculties();
      }
    },
  },

  methods: {
    submit: function () {
      this.form.get(route("faculties.index"));
    },
    exportExcel: function () {
      Inertia.get(route("faculties.export"));
    },
    deleteFaculty: function () {
      Inertia.delete(
        route("faculties.destroy", { faculty: this.selectedFaculty })
      );
      this.modalDelete = false;
    },
    updateFaculty: function () {
      Inertia.get(route("faculties.edit", { faculty: this.selectedFaculty }));
      this.modalUpdate = false;
    },
    showDepartmentsOf: function () {
      Inertia.get(
        route("faculties.showDepartmentsandColleges", {
          faculty: this.selectedFaculty,
        })
      );
      this.modalShow = false;
    },
    showCarreersOf: function () {
      Inertia.get(
        route("faculties.showCarreers", { faculty: this.selectedFaculty })
      );
      this.modalShow = false;
    },
    showSubjectsOf: function () {
      Inertia.get(
        route("faculties.showSubjects", { faculty: this.selectedFaculty })
      );
      this.modalShow = false;
    },

    openRegisterFaculty() {
      this.modalRegisterFaculty = true;
    },
    closeRegisterFaculty() {
      this.modalRegisterFaculty = false;
    },
    openEditFaculties() {
      this.modalEditFaculties = true;
    },
    closeEditFaculties() {
      this.modalEditFaculties = false;
    },
    openExcelRegister() {
      this.modalExcelRegister = true;
    },
    closeExcelRegister() {
      this.modalExcelRegister = false;
    },
    openFacultyHasDepartment() {
      this.modalRelationFDepartment = true;
    },
    closeFacultyHasDepartment() {
      this.modalRelationFDepartment = false;
    },
    openExcelFacultyHasDepartments() {
      this.modalExcelRelationFDepartment = true;
    },
    closeExcelFacultyHasDepartments() {
      this.modalExcelRelationFDepartment = false;
    },
    openFacultyHasCollege() {
      this.modalRelationFCollege = true;
    },
    closeFacultyHasCollege() {
      this.modalRelationFCollege = false;
    },
    openExcelFacultyHasColleges() {
      this.modalExcelRelationFCollege = true;
    },
    closeExcelFacultyHasColleges() {
      this.modalExcelRelationFCollege = false;
    },
    openFacultyHasCarreer() {
      this.modalRelationFCarreer = true;
    },
    closeFacultyHasCarreer() {
      this.modalRelationFCarreer = false;
    },
    openExcelFacultyHasCarreers() {
      this.modalExcelRelationFCarreer = true;
    },
    closeExcelFacultyHasCarreers() {
      this.modalExcelRelationFCarreer = false;
    },
    openFacultyHasSubject() {
      this.modalRelationFSubject = true;
    },
    closeFacultyHasSubject() {
      this.modalRelationFSubject = false;
    },
    openExcelFacultyHasSubjects() {
      this.modalExcelRelationFSubject = true;
    },
    closeExcelFacultyHasSubjects() {
      this.modalExcelRelationFSubject = false;
    },
  },
};
</script>