<template>
  <app-layout title="Asignaturas">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Asignaturas
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
                placeholder="Busqueda"
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
                    <template v-for="faculty in subjects" :key="faculty.id">
                      <tr v-for="subject in faculty.subjects" :key="subject.id">
                        <td class="px-6 py-4 text-center">
                          <jet-label>{{ subject.code }}</jet-label>
                        </td>
                        <td class="px-6 py-4 text-center">
                          <jet-label>{{ subject.name }}</jet-label>
                          <div class="text-sm text-gray-500">
                            {{ faculty.name }}
                          </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                          <jet-label>PREREQUISITO</jet-label>
                        </td>
                        <td class="px-6 py-4 text-center">
                          <jet-label>{{ subject.hours }} Hrs</jet-label>
                        </td>
                        <td class="px-6 py-4 text-center">
                          <jet-label v-if="subject.state == 1">
                            Activo</jet-label
                          ><jet-label v-else> No Activo</jet-label>
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
                              selectedSubject = subject;
                              createCourse();
                            "
                          >
                            <jet-add
                          /></jet-button>
                          <jet-button
                            @click="
                              this.modalShow = true;
                              selectedSubject = subject;
                            "
                          >
                            <jet-show
                          /></jet-button>
                          <jet-button
                            @click="
                              this.modalUpdate = true;
                              selectedSubject = subject;
                            "
                          >
                            <jet-edit
                          /></jet-button>
                          <jet-modify-button
                            @click="
                              this.modalDelete = true;
                              selectedSubject = subject;
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
        <h2 class="text-xl font-bold py-4" v-if="selectedSubject">
          <strong> Asignatura {{ selectedSubject.name }}</strong>
        </h2>
        <p class="text-sm text-gray-500 px-8">
          ¿Estas seguro de querer ir a ver sus departamentos?
        </p>
      </template>
      <template v-slot:footer>
        <jet-modify-button @click="this.modalShow = false"
          >Cerrar</jet-modify-button
        >
        <jet-button @click="showCoursesOf()">Ir a Cursos</jet-button>
      </template>
    </jet-dialog-modal>

    <jet-dialog-modal :show="modalUpdate">
      <template v-slot:content>
        <modal-edit-icon />
        <h2 class="text-xl font-bold py-4" v-if="selectedSubject">
          <strong> Asignatura {{ selectedSubject.name }}</strong>
        </h2>
        <p class="text-sm text-gray-500 px-8">
          ¿Estas seguro de querer Actualizar este elemento?
        </p>
      </template>
      <template v-slot:footer class="p-3 mt-2 text-center space-x-4 md:block">
        <jet-modify-button @click="this.modalUpdate = false"
          >Cerrar</jet-modify-button
        >
        <jet-button @click="updateSubject()"> Modificar</jet-button>
      </template>
    </jet-dialog-modal>

    <jet-dialog-modal :show="modalDelete">
      <template v-slot:content>
        <modal-delete-icon />
        <h2 class="text-xl font-bold py-4" v-if="selectedSubject">
          <strong> Asignatura {{ selectedSubject.name }}</strong>
        </h2>
        <p class="text-sm text-gray-500 px-8">
          ¿Estas seguro de querer eliminar este elemento?
        </p>
      </template>
      <template v-slot:footer>
        <jet-modify-button @click="this.modalDelete = false"
          >Cerrar</jet-modify-button
        >
        <jet-danger-button @click="deleteSubject()"
          >Dehabilitar</jet-danger-button
        >
      </template>
    </jet-dialog-modal>

    <register-subject :show="modalRegisterSubject"></register-subject>
    <excel-register :show="modalExcelRegister"></excel-register>

    <subject-has-courses :show="modalRelationSCourse"></subject-has-courses>
    <excel-subject-has-courses
      :show="modalExcelRelationSCourse"
    ></excel-subject-has-courses>
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
import JetAdd from "@/Jetstream/AddIcon";
import JetShow from "@/Jetstream/ShowLogo";
import JetEdit from "@/Jetstream/EditLogo";
import JetDelete from "@/Jetstream/DeleteLogo";
import JetImport from "@/Jetstream/ImportLogo";
import JetExport from "@/Jetstream/ExportLogo";
import ModalShowIcon from "@/Jetstream/modalShowIcon";
import ModalEditIcon from "@/Jetstream/modalEditIcon";
import ModalDeleteIcon from "@/Jetstream/modalDeleteIcon";

import RegisterSubject from "@/Pages/Subjects/Modals/RegisterModal";
import ExcelRegister from "@/Pages/Subjects/Modals/ExcelModal";

import SubjectHasCourses from "@/Pages/Subjects/Courses/Modals/RelationsModal";
import ExcelSubjectHasCourses from "@/Pages/Subjects/Courses/Modals/ExcelModalRelation";

export default {
  props: { subjects: Array, columns: Object, options: Object },

  data() {
    return {
      modalShow: false,
      modalUpdate: false,
      modalDelete: false,
      modalRegisterSubject: false,
      modalExcelRegister: false,
      modalRelationSCourse: false,
      modalExcelRelationSCourse: false,
      selectedSubject: Object,

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
    JetAdd,
    JetShow,
    JetEdit,
    JetDelete,
    JetImport,
    JetExport,
    ModalShowIcon,
    ModalEditIcon,
    ModalDeleteIcon,
    RegisterSubject,
    ExcelRegister,
    SubjectHasCourses,
    ExcelSubjectHasCourses,
  },

  watch: {
    "selectedModal.value"(val) {
      if (val == 1) {
        this.openRegisterSubject();
      } else if (val == 2) {
        this.openSubjectHasCourses();
      } else if (val == 3) {
        this.openExcelSubjectHasCourses();
      }
    },
  },

  methods: {
    submit: function () {
      this.form.get(route("subjects.index"));
    },
    exportExcel: function () {
      Inertia.get(route("subjects.export"));
    },
    createCourse() {
      console.log(this.selectedSubject);
      const Course = {
        vcode: Math.floor(Math.random() * 100000),
        code: this.selectedSubject.code,
        group: 1,
        description: "Curso Creado desde Asignaturas",
        semester: this.selectedSubject.semester,
        hours: this.selectedSubject.hours,
        subject_vcode: this.selectedSubject.vcode,
        state: "1",
      };

      Inertia.post(route("courses.store", Course));
    },
    updateSubject: function () {
      Inertia.get(route("subjects.edit", { subject: this.selectedSubject }));
      this.modalUpdate = false;
    },
    deleteSubject: function () {
      Inertia.delete(
        route("subjects.destroy", { subject: this.selectedSubject })
      );
      this.modalDelete = false;
    },
    showCoursesOf: function () {
      Inertia.get(route("subjects.showCourses"), {
        subject: this.selectedSubject,
      });
    },

    openRegisterSubject() {
      this.modalRegisterSubject = true;
    },
    closeRegisterSubject() {
      this.modalRegisterSubject = false;
    },
    openExcelRegister() {
      this.modalExcelRegister = true;
    },
    closeExcelRegister() {
      this.modalExcelRegister = false;
    },
    openSubjectHasCourses() {
      this.modalRelationSCourse = true;
    },
    closeSubjectHasCourses() {
      this.modalRelationSCourse = false;
    },
    openExcelSubjectHasCourses() {
      this.modalExcelRelationSCourse = true;
    },
    closeExcelSubjectHasCourses() {
      this.modalExcelRelationSCourse = false;
    },
  },
};
</script>