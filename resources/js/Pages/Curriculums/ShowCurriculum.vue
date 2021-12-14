<template>
  <app-layout title="Mallas">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Mallas</h2>
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
                placeholder="Busqueda de Mallas por Carrera"
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
                    <template v-for="carreer in curriculums" :key="carreer.id">
                      <tr
                        v-for="curriculum in carreer.curriculums"
                        :key="curriculum.id"
                      >
                        <td class="px-6 py-4 text-center">
                          <jet-label> {{ curriculum.code }}</jet-label>
                        </td>
                        <td class="px-6 py-4 text-center">
                          <jet-label> {{ carreer.name }}</jet-label>
                        </td>
                        <td class="px-6 py-4 text-center">
                          <jet-label>
                            {{ curriculum.name }} -
                            {{ curriculum.description }}</jet-label
                          >
                        </td>
                        <td class="px-6 py-4 text-center">
                          <jet-label v-if="curriculum.state == 1">
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
                              this.modalShow = true;
                              selectedCurriculum = curriculum;
                            "
                          >
                            <jet-show
                          /></jet-button>
                          <jet-button
                            @click="
                              this.modalUpdate = true;
                              selectedCurriculum = curriculum;
                            "
                          >
                            <jet-edit
                          /></jet-button>
                          <jet-modify-button
                            @click="
                              this.modalDelete = true;
                              selectedCurriculum = curriculum;
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
        <h2 class="text-xl font-bold py-4" v-if="selectedCurriculum">
          <strong> Malla: {{ selectedCurriculum.name }}</strong>
        </h2>
        <p class="text-sm text-gray-500 px-8">
          ¿Estas seguro de querer ir a ver sus Datos?
        </p>
      </template>
      <template v-slot:footer>
        <jet-modify-button @click="this.modalShow = false"
          >Cerrar</jet-modify-button
        >
        <jet-danger-button @click="showSubjectsOf()"
          >Ir a Asignaturas</jet-danger-button
        >
      </template>
    </jet-dialog-modal>

    <jet-dialog-modal :show="modalUpdate">
      <template v-slot:content>
        <modal-edit-icon />
        <h2 class="text-xl font-bold py-4" v-if="selectedCurriculum">
          <strong> Malla: {{ selectedCurriculum.name }}</strong>
        </h2>
        <p class="text-sm text-gray-500 px-8">
          ¿Estas seguro de querer Actualizar este elemento?
        </p>
      </template>
      <template v-slot:footer>
        <jet-modify-button @click="this.modalUpdate = false"
          >Cerrar</jet-modify-button
        >
        <jet-danger-button @click="updateCurriculum()">
          Modificar</jet-danger-button
        >
      </template>
    </jet-dialog-modal>

    <jet-dialog-modal :show="modalDelete">
      <template v-slot:content>
        <modal-delete-icon />
        <h2 class="text-xl font-bold py-4" v-if="selectedCurriculum">
          <strong> Malla: {{ selectedCurriculum.name }}</strong>
        </h2>
        <p class="text-sm text-gray-500 px-8">
          ¿Estas seguro de querer eliminar este elemento?
        </p>
      </template>
      <template v-slot:footer>
        <jet-modify-button @click="this.modalDelete = false"
          >Cerrar</jet-modify-button
        >
        <jet-danger-button
          v-if="selectedCurriculum.state == 1"
          @click="deactivateCurriculum()"
          >Dehabilitar</jet-danger-button
        >
        <jet-danger-button v-else @click="activateCurriculum()">
          Activar</jet-danger-button
        >
        <jet-danger-button @click="deleteCurriculum()"
          >Eliminar</jet-danger-button
        >
      </template>
    </jet-dialog-modal>

    <!--Modal Components-->
    <register-curriculum :show="modalRegisterCurriculum"></register-curriculum>
    <excel-register :show="modalExcelRegister"></excel-register>

    <curriculum-has-subjects
      :show="modalRelationCSubject"
    ></curriculum-has-subjects>
    <excel-curriculum-has-subjects
      :show="modalExcelRelationCSubject"
    ></excel-curriculum-has-subjects>
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

import RegisterCurriculum from "@/Pages/Curriculums/Modals/RegisterModal";
import ExcelRegister from "@/Pages/Curriculums/Modals/ExcelModal";

import CurriculumHasSubjects from "@/Pages/Curriculums/Subjects/Modals/RelationsModal";
import ExcelCurriculumHasSubjects from "@/Pages/Curriculums/Subjects/Modals/ExcelModalRelation";

export default {
  props: { curriculums: Array, columns: Array, options: Object },

  data() {
    return {
      modalShow: false,
      modalUpdate: false,
      modalDelete: false,
      modalRegisterCurriculum: false,
      modalExcelRegister: false,
      modalRelationCSubject: false,
      modalExcelRelationCSubject: false,
      selectedCurriculum: Object,

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
    RegisterCurriculum,
    ExcelRegister,
    CurriculumHasSubjects,
    ExcelCurriculumHasSubjects,
  },

  watch: {
    "selectedModal.value"(val) {
      if (val == 1) {
        this.openRegisterCurriculum();
      } else if (val == 2) {
        this.openCurriculumHasSubjects();
      } else if (val == 3) {
        this.openExcelCurriculumHasSubjects();
      }
    },
  },

  methods: {
    submit: function () {
      this.form.get(route("curriculums.index"));
    },
    exportExcel: function () {
      Inertia.get(route("curriculums.export"));
    },
    deleteCurriculum: function () {
      Inertia.delete(
        route("curriculums.destroy", { curriculum: this.selectedCurriculum })
      );
      this.modalDelete = false;
    },
    updateCurriculum: function () {
      Inertia.get(
        route("curriculums.edit", { curriculum: this.selectedCurriculum })
      );
      this.modalUpdate = false;
    },
    showSubjectsOf: function () {
      Inertia.get(
        route("curriculums.showSubjects", {
          curriculum: this.selectedCurriculum,
        })
      );
      this.closemodalUpdate = false;
    },

    //Dont Work////////////////////////////////////
    deactivateCurriculum: function () {
      axios
        .put(route("curriculums.deactivate"), {
          curriculum: this.selectedCurriculum,
        })
        .then((response) => {
          console.log(response.data);
        });
    },

    activateCurriculum() {
      console.log(this.selectedCurriculum);
      axios
        .put(route("curriculums.activate"), {
          params: { curriculum: this.selectedCurriculum },
        })
        .then((response) => {
          console.log(response.data);
        });
    },
    ////////////////////////
    openRegisterCurriculum() {
      this.modalRegisterCurriculum = true;
    },
    closeRegisterCurriculum() {
      this.modalRegisterCurriculum = false;
    },
    openExcelRegister() {
      this.modalExcelRegister = true;
    },
    closeExcelRegister() {
      this.modalExcelRegister = false;
    },
    openCurriculumHasSubjects() {
      this.modalRelationCSubject = true;
    },
    closeCurriculumHasSubjects() {
      this.modalRelationCSubject = false;
    },
    openExcelCurriculumHasSubjects() {
      this.modalExcelRelationCSubject = true;
    },
    closeExcelCurriculumHasSubjects() {
      this.modalExcelRelationCSubject = false;
    },
  },
};
</script>