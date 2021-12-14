<template>
  <app-layout title="Facultades">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Cursos</h2>
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
                placeholder="Busqueda de Cursos"
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
                    <template v-for="subject in subjects" :key="subject.vcode">
                      <tr v-for="course in subject.courses" :key="course.vcode">
                        <td class="px-6 py-4 text-center">
                          <jet-label>{{ subject.code }}</jet-label>
                        </td>
                        <td class="px-6 py-4 text-center">
                          <jet-label>{{ subject.name }}</jet-label>
                        </td>
                        <td class="px-6 py-4 text-center">
                          <jet-label>{{ course.group }}</jet-label>
                        </td>
                        <td class="px-6 py-4 text-center">
                          <div
                            v-if="course.semester == 1"
                            class="text-sm text-gray-500"
                          >
                            Dictandose el 1er Semestre
                          </div>
                          <div v-else class="text-sm text-gray-500">
                            Dictandose el 2do Semestre
                          </div>
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
                              selectedSubject = subject;
                              selectedCourse = course;
                            "
                          >
                            <jet-show
                          /></jet-button>
                          <jet-button
                            @click="
                              this.modalUpdate = true;
                              selectedSubject = subject;
                              selectedCourse = course;
                            "
                          >
                            <jet-edit
                          /></jet-button>
                          <jet-modify-button
                            @click="
                              this.modalDelete = true;
                              selectedSubject = subject;
                              selectedCourse = course;
                            "
                          >
                            <jet-delete
                          /></jet-modify-button>
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
        <modal-show-icon />
        <h2 class="text-xl font-bold py-4" v-if="selectedCourse">
          <strong>
            Asignatura {{ selectedSubject.name }} Grupo
            {{ selectedCourse.group }}
          </strong>
        </h2>
        <p class="text-sm text-gray-500 px-8">
          ¿Esta Asignatura dispone de Laraboratorio, Ayudantia y Taller?
        </p>
      </template>
      <template v-slot:footer>
        <jet-modify-button @click="this.modalShow = false"
          >Cerrar</jet-modify-button
        >
        <jet-button @click="createWorkshop()">Habilitar Taller</jet-button>
        <jet-button @click="createLaboratory()"
          >Habilitar Laboratorio</jet-button
        >
        <jet-button @click="createassistant()">Habilitar Ayudantia</jet-button>
      </template>
    </jet-dialog-modal>

    <jet-dialog-modal :show="modalUpdate">
      <template v-slot:content>
        <modal-edit-icon />
        <h2 class="text-xl font-bold py-4" v-if="selectedCourse">
          <strong> Facultad de {{ selectedCourse.name }}</strong>
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
        <h2 class="text-xl font-bold py-4" v-if="selectedCourse">
          <strong> Facultad de {{ selectedCourse.name }}</strong>
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
    <register-courses :show="modalRegisterCourses"></register-courses>
    <excel-register :show="modalExcelRegister"></excel-register>

    <course-has-workshop :show="modalRelationCWorkshop"></course-has-workshop>
    <excel-course-has-workshop
      :show="modalExcelRelationCWorkshop"
    ></excel-course-has-workshop>
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

import RegisterCourses from "@/Pages/Courses/Modals/RegisterModal";
import ExcelRegister from "@/Pages/Courses/Modals/ExcelModal";

import CourseHasWorkshop from "@/Pages/Courses/Workshop/Modals/RelationsModal";
import ExcelCourseHasWorkshop from "@/Pages/Courses/Workshop/Modals/ExcelModalRelation";

export default {
  props: { subjects: Array, columns: Array, options: Object },

  data() {
    return {
      modalShow: false,
      modalUpdate: false,
      modalDelete: false,
      modalRegisterCourses: true,
      modalExcelRegister: false,
      modalRelationCWorkshop: false,
      modalExcelRelationCWorkshop: false,
      selectedSubject: Object,
      selectedCourse: Object,

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
    RegisterCourses,
    ExcelRegister,
    CourseHasWorkshop,
    ExcelCourseHasWorkshop,
  },

  watch: {
    "selectedModal.value"(val) {
      //console.log(this.selectedModal.value)
      if (val == 1) {
        this.openRegisterCourses();
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
      Inertia.get(route("courses.index"), this.form);
    },
    createWorkshop: function () {
      const workshop = reactive({
        name: "Ayudantia desde cursos",
        description: "descripcion",
        hours: "2",
        course_id: this.selectedCourse.id,
      });

      Inertia.post(route("workshops.store", workshop));
      this.modalWorkshopLab = false;
    },
    createLaboratory: function () {
      const laboratory = reactive({
        name: "Laboratorio desde cursos",
        description: "descripcion",
        hours: "2",
        course_id: this.selectedCourse.id,
      });

      Inertia.post(route("laboratories.store", laboratory));
      this.modalWorkshopLab = false;
    },
    updateCourse: function () {
      Inertia.get(route("courses.edit", { course: this.selectedCourse }));
      this.modalUpdate = false;
    },
    deleteCourse: function () {
      Inertia.delete(route("courses.destroy", { course: this.selectedCourse }));
      this.modalDelete = false;
    },
    openRegisterCourses() {
      this.modalRegisterCourses = true;
    },
    closeRegisterCourses() {
      this.modalRegisterCourses = false;
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