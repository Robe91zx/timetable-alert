<template>
  <app-layout title="Asignaturas">
    <template #header>
      <div v-for="curriculum in subjectsOf" v-bind:key="curriculum.id">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Malla {{ curriculum.name }}
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
                      v-for="curriculum in subjectsOf"
                      v-bind:key="curriculum.id"
                    >
                      <tr
                        v-for="subject in curriculum.subjects"
                        :key="subject.id"
                      >
                        <td class="px-6 py-4 text-center">
                          <jet-label>{{ subject.code }}</jet-label>
                        </td>
                        <td class="px-6 py-4 text-center">
                          <jet-label>{{ subject.name }}</jet-label>
                        </td>
                        <td class="px-6 py-4 text-center">
                          <jet-label>{{ subject.hours }} Hrs</jet-label>
                        </td>
                        <td class="px-6 py-4 text-center">
                          <jet-label v-if="subject.state == 1"
                            >Dictandose</jet-label
                          >
                          <jet-label v-else>No Disponible</jet-label>
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
                              openModalInfoSubject();
                              selectedSubject = subject;
                            "
                          >
                            <jet-show />
                          </jet-button>
                          <jet-button
                            @click="
                              openModalUpdate();
                              selectedSubject = subject;
                            "
                          >
                            <jet-edit />
                          </jet-button>
                          <jet-modify-button
                            @click="
                              openModalDelete();
                              selectedSubject = subject;
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

    <!--Modals-->
    <jet-dialog-modal :show="modalInfoSubject">
      <template v-slot:content>
        <modal-show-icon />
        <h2 class="text-xl font-bold py-4" v-if="selectedSubject">
          <strong> Asignatura {{ selectedSubject.name }}</strong>
        </h2>
        <p class="text-sm text-gray-500 px-8">
          ¿Estas seguro de querer redirigir a la interfase de Asignaturas?
        </p>
      </template>
      <template v-slot:footer>
        <jet-modify-button @click="modalInfoSubject = false"
          >Cerrar</jet-modify-button
        >
        <jet-button @click="showCoursesOf()">Ir a Cursos</jet-button>
      </template>
    </jet-dialog-modal>

    <jet-dialog-modal :show="modalDelete">
      <template v-slot:content>
        <modal-delete-icon />
        <h2 class="text-xl font-bold py-4" v-if="selectedSubject">
          <strong> Asignatura {{ selectedSubject.name }}</strong>
        </h2>
        <p class="text-sm text-gray-500 px-8">
          ¿Estas seguro de querer quitar la Asignatura
          {{ selectedSubject.name }} de la Malla?
        </p>
      </template>
      <template v-slot:footer>
        <jet-modify-button @click="closeModalDelete()"
          >Cerrar</jet-modify-button
        >
        <jet-danger-button @click="deleteSubjectOf()">Borrar</jet-danger-button>
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
      <template v-slot:footer>
        <jet-modify-button @click="modalUpdate = false"
          >Cerrar</jet-modify-button
        >
        <jet-danger-button @click="updateSubject()">
          Modificar</jet-danger-button
        >
      </template>
    </jet-dialog-modal>
  </app-layout>
</template>
 
<script>
import { Inertia } from "@inertiajs/inertia";
import AppLayout from "@/Layouts/AppLayout";
import JetDialogModal from "@/Jetstream/DialogModal";
import JetLabel from "@/Jetstream/Label";
import JetTitleLabel from "@/Jetstream/TitleLabel";
import JetButton from "@/Jetstream/Button";
import JetModifyButton from "@/Jetstream/ModifyButton";
import JetDangerButton from "@/Jetstream/DangerButton";
import JetShow from "@/Jetstream/ShowLogo";
import JetEdit from "@/Jetstream/EditLogo";
import JetDelete from "@/Jetstream/DeleteLogo";
import ModalShowIcon from "@/Jetstream/modalShowIcon";
import ModalEditIcon from "@/Jetstream/modalEditIcon";
import ModalDeleteIcon from "@/Jetstream/modalDeleteIcon";

export default {
  props: { subjectsOf: Array, columns: Array, selectedSubject: Object },

  data() {
    return { modalUpdate: false, modalDelete: false, modalInfoSubject: false };
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
    ModalShowIcon,
    ModalEditIcon,
    ModalDeleteIcon,
  },

  methods: {
    openModalInfoSubject() {
      this.modalInfoSubject = true;
    },
    closeModalInfoSubject() {
      this.modalInfoSubject = false;
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

    showCoursesOf: function () {
      Inertia.get(
        route("subjects.showCourses", { subject: this.selectedSubject })
      );
    },
    updateSubject: function () {
      Inertia.get(route("subjects.edit", { subject: this.selectedSubject }));
    },

    ////////////////DONT WORKING///////////////////
    InfoCarreer: function () {
      let url = "https://www.uta.cl/index.php/portada-facultad-de-ciencias/";
      this.modalInfoDepartment = false;
      window.open(url);
    },

    deleteSubjectOf: function () {
      let facultiesanddepartment = this.selectedDepartment.pivot;
      console.log(facultiesanddepartment);
      Inertia.delete(
        route("facultiesanddepartments.destroy", {
          facultiesanddepartment: this.selectedDepartment.pivot,
        })
      );
    },
  },
};
</script>