<template>
  <app-layout title="Cursos">
    <template #header>
      <div v-for="subject in CoursesOf" v-bind:key="subject.id">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Asignatura {{ subject.name }}
        </h2>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                    <th
                      scope="col"
                      v-for="column in columns"
                      :key="column.name"
                    >
                      <jet-title-label>{{ column }}</jet-title-label>
                    </th>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <template
                      v-for="subject in CoursesOf"
                      v-bind:key="subject.id"
                    >
                      <tr v-for="course in subject.courses" :key="course.id">
                        <td class="px-6 py-4 text-center">
                          <jet-label>{{ course.code }}</jet-label>
                        </td>
                        <td class="px-6 py-4 text-center">
                          <div class="text-sm text-gray-500"></div>
                          <jet-label>{{ course.name }}</jet-label>
                        </td>
                        <td class="px-6 py-4 text-center">
                          <jet-label>{{ course.email }}</jet-label>
                        </td>
                        <td class="px-6 py-4 text-center">
                          <jet-label>{{ course.phone }}</jet-label>
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
                              openModalInfo();
                              selectedDepartment = department;
                            "
                          >
                            <jet-show />
                          </jet-button>
                          <jet-button
                            @click="
                              openModalUpdate();
                              selectedDepartment = department;
                            "
                          >
                            <jet-edit />
                          </jet-button>
                          <jet-modify-button
                            @click="
                              openModalDelete();
                              selectedDepartment = department;
                            "
                          >
                            <jet-delete />
                          </jet-modify-button>
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

    <jet-dialog-modal :show="modalInfo">
      <template v-slot:content>
        <modal-show-icon />
        <template v-if="selectedDepartment">
          <h2 class="text-xl font-bold py-4">
            <strong> Departamento de {{ selectedDepartment.name }}</strong>
          </h2>
          <p class="text-sm text-gray-500 px-8">
            ¿Estas seguro de querer redirigir a la interfaz de Departamentos?
          </p>
        </template>
        <template v-if="selectedCollege">
          <h2 class="text-xl font-bold py-4">
            <strong> Escuela de {{ selectedCollege.name }}</strong>
          </h2>
          <p class="text-sm text-gray-500 px-8">
            ¿Estas seguro de querer redirigir a la interfaz de Escuelas ?
          </p>
        </template>
      </template>
      <template v-slot:footer class="p-3 mt-2 text-center space-x-4 md:block">
        <template v-if="selectedDepartment">
          <jet-modify-button
            @click="
              closeModalInfo();
              selectedDepartment = '';
            "
            >Cerrar</jet-modify-button
          >
          <jet-button @click="showCarreersOfDepartment()"
            >Ir a Carreras</jet-button
          >
          <jet-button @click="InfoDepartment()">Ir a Website</jet-button>
        </template>
        <template v-if="selectedCollege">
          <jet-modify-button
            @click="
              closeModalInfo();
              selectedCollege = '';
            "
            >Cerrar</jet-modify-button
          >
          <jet-button @click="showCarreersOfCollege()"
            >Ir a Carreras</jet-button
          >
          <jet-button @click="InfoCollege()">Ir a Website</jet-button>
        </template>
      </template>
    </jet-dialog-modal>

    <jet-dialog-modal :show="modalDelete">
      <template v-slot:content>
        <modal-delete-icon />
        <template v-if="selectedDepartment">
          <h2 class="text-xl font-bold py-4" v-if="selectedDepartment">
            <strong> Departamento de {{ selectedDepartment.name }}</strong>
          </h2>
          <p class="text-sm text-gray-500 px-8">
            ¿Estas seguro de querer quitar {{ selectedDepartment.name }} de la
            Facultad de {{ CoursesOf[0].name }}?
          </p>
        </template>
        <template v-if="selectedCollege">
          <h2 class="text-xl font-bold py-4" v-if="selectedCollege">
            <strong> Escuela de {{ selectedCollege.name }}</strong>
          </h2>
          <p class="text-sm text-gray-500 px-8">
            ¿Estas seguro de querer quitar {{ selectedCollege.name }} de la
            Facultad de {{ CoursesOf[0].name }}?
          </p>
        </template>
      </template>
      <template v-slot:footer class="p-3 mt-2 text-center space-x-4 md:block">
        <template v-if="selectedDepartment">
          <jet-modify-button
            @click="
              closeModalDelete();
              selectedDepartment = '';
            "
            >Cerrar</jet-modify-button
          >
          <jet-danger-button @click="deleteDepartmentOf()"
            >Borrar</jet-danger-button
          >
        </template>
        <template v-if="selectedCollege">
          <jet-modify-button
            @click="
              closeModalDelete();
              selectedCollege = '';
            "
            >Cerrar</jet-modify-button
          >
          <jet-danger-button @click="deleteCollegeOf()"
            >Borrar</jet-danger-button
          >
        </template>
      </template>
    </jet-dialog-modal>

    <jet-dialog-modal :show="modalUpdate">
      <template v-slot:content>
        <modal-edit-icon />
        <template v-if="selectedDepartment">
          <h2 class="text-xl font-bold py-4" v-if="selectedDepartment">
            <strong> Departamento de {{ selectedDepartment.name }}</strong>
          </h2>
        </template>
        <template v-if="selectedCollege">
          <h2 class="text-xl font-bold py-4" v-if="selectedCollege">
            <strong> Escuela de {{ selectedCollege.name }}</strong>
          </h2>
        </template>
        <p class="text-sm text-gray-500 px-8">
          ¿Estas seguro de querer Actualizar este elemento?
        </p>
      </template>
      <template v-slot:footer class="p-3 mt-2 text-center space-x-4 md:block">
        <template v-if="selectedDepartment">
          <jet-modify-button
            @click="
              closeModalUpdate();
              selectedDepartment = '';
            "
            >Cerrar</jet-modify-button
          >
          <jet-danger-button @click="updateDepartment()">
            Modificar</jet-danger-button
          >
        </template>
        <template v-if="selectedCollege">
          <jet-modify-button
            @click="
              closeModalUpdate();
              selectedCollege = '';
            "
            >Cerrar</jet-modify-button
          >
          <jet-danger-button @click="updateCollege()">
            Modificar</jet-danger-button
          >
        </template>
      </template>
    </jet-dialog-modal>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import { Inertia } from "@inertiajs/inertia";
import JetInputError from "@/Jetstream/InputError";
import JetLabel from "@/Jetstream/Label";
import JetTitleLabel from "@/Jetstream/TitleLabel";
import JetButton from "@/Jetstream/Button";
import JetModifyButton from "@/Jetstream/ModifyButton";
import JetDangerButton from "@/Jetstream/DangerButton";
import JetDialogModal from "@/Jetstream/DialogModal";
import JetEdit from "@/Jetstream/EditLogo";
import JetShow from "@/Jetstream/ShowLogo";
import JetDelete from "@/Jetstream/DeleteLogo";
import ModalShowIcon from "@/Jetstream/modalShowIcon";
import ModalEditIcon from "@/Jetstream/modalEditIcon";
import ModalDeleteIcon from "@/Jetstream/modalDeleteIcon";

export default {
  components: {
    AppLayout,
    JetDialogModal,
    JetInputError,
    JetTitleLabel,
    JetLabel,
    JetButton,
    JetModifyButton,
    JetDangerButton,
    JetEdit,
    JetShow,
    JetDelete,
    ModalShowIcon,
    ModalEditIcon,
    ModalDeleteIcon,
  },

  props: {
    CoursesOf: Object,
    columns: Array,
    selectedDepartment: Object,
    selectedCollege: Object,
  },

  data() {
    return { modalUpdate: false, modalDelete: false, modalInfo: false };
  },

  methods: {
    showCarreersOfDepartment: function () {
      Inertia.get(
        route("departments.show", { department: this.selectedDepartment })
      );
      this.closeModalInfo();
    },
    showCarreersOfCollege: function () {
      Inertia.get(route("colleges.show", { college: this.selectedCollege }));
      this.closeModalInfo();
    },
    updateDepartment: function () {
      Inertia.get(
        route("departments.edit", { department: this.selectedDepartment })
      );
    },
    updateCollege: function () {
      Inertia.get(route("colleges.edit", { college: this.selectedCollege }));
    },

    //////////////////NO FUNCIONAN ////////////////////
    InfoDepartment: function () {
      //Corregir para que cargue, segun la facultad o departamento que solicitan. Esto es solo testing
      let url = "'https://'{DepartmentsOf[0].website}";
      this.modalInfo = false;
      window.open(url);
    },
    InfoCollege: function () {
      //Corregir para que cargue, segun la facultad o departamento que solicitan. Esto es solo testing
      let url = "'https://'{DepartmentsOf[0].website}";
      this.modalInfo = false;
      window.open(url);
    },
    deleteDepartmentOf: function () {
      let facultiesanddepartment = this.selectedDepartment.pivot;
      console.log(facultiesanddepartment);
      Inertia.delete(
        route("facultiesanddepartments.destroy", {
          facultiesanddepartment: this.selectedDepartment.pivot,
        })
      );
    },
    deleteCollegeOf: function () {
      let facultiesanddepartment = this.selectedDepartment.pivot;
      console.log(facultiesanddepartment);
      Inertia.delete(
        route("facultiesanddepartments.destroy", {
          facultiesanddepartment: this.selectedDepartment.pivot,
        })
      );
    },
    /////////////////////////////////////////////////////////////////
    openModalInfo() {
      this.modalInfo = true;
    },
    closeModalInfo() {
      this.modalInfo = false;
    },
    openModalUpdate() {
      this.modalUpdate = true;
    },
    closeModalUpdate() {
      this.modalUpdate = false;
    },
    openModalDelete() {
      this.modalDelete = true;
    },
    closeModalDelete() {
      this.modalDelete = false;
    },
  },
};
</script>