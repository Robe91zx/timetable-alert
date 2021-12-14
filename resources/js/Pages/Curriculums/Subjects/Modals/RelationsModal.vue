<template>
  <modal
    :show="show"
    :max-width="maxWidth"
    :closeable="closeable"
    @close="close"
  >
    <div
      class="flex justify-center h-11/12 items-center bg-gray-200 antialiased"
    >
      <div
        class="
          flex flex-col
          w-full
          mx-auto
          rounded-lg
          border border-gray-300
          shadow-xl
        "
      >
        <div
          class="
            flex flex-row
            justify-between
            p-6
            bg-white
            border-b border-gray-200
            rounded-tl-lg rounded-tr-lg
          "
        >
          {{ this.form }}
          <jet-title> Relacion Mallas - Asignaturas </jet-title>
          <exit-icon @click="close()" />
        </div>
        <form @submit.prevent="submit">
          <div class="flex flex-col px-6 py-5 bg-gray-50">
            <div
              class="flex flex-col sm:flex-row items-center mb-5 sm:space-x-5"
            >
              <div class="w-full sm:w-1/2">
                <p class="mb-2 font-semibold text-gray-700">Facultades</p>
                <select
                  v-model="faculty_forcarreers"
                  class="
                    w-full
                    p-5
                    bg-white
                    border border-gray-200
                    rounded
                    shadow-sm
                    appearance-none
                  "
                >
                  <option
                    v-for="faculty in faculties"
                    v-bind:key="faculty.vcode"
                    v-bind:value="faculty.vcode"
                  >
                    {{ faculty.name }}
                  </option>
                </select>
              </div>
              <div class="w-full sm:w-1/2">
                <p class="mb-2 font-semibold text-gray-700">Carreras</p>
                <select
                  @click="getCarreers(faculty_forcarreers)"
                  v-model="carreer_forcurriculums"
                  class="
                    w-full
                    p-5
                    bg-white
                    border border-gray-200
                    rounded
                    shadow-sm
                    appearance-none
                  "
                >
                  <option
                    v-for="carreer in carreers"
                    v-bind:key="carreer.vcode"
                    v-bind:value="carreer.vcode"
                  >
                    {{ carreer.name }}
                  </option>
                </select>
              </div>
              <div class="w-full sm:w-1/2">
                <p class="mb-2 font-semibold text-gray-700">Mallas</p>
                <select
                  v-model="form.curriculum_id"
                  @click="getCurriculums(carreer_forcurriculums)"
                  class="
                    w-full
                    p-5
                    bg-white
                    border border-gray-200
                    rounded
                    shadow-sm
                    appearance-none
                  "
                >
                  <option
                    v-for="curriculum in curriculums"
                    v-bind:key="curriculum.vcode"
                    v-bind:value="curriculum"
                  >
                    {{ curriculum.name }}
                  </option>
                </select>
                <div class="italic" if="form.errors.curriculum_id">
                  {{ form.errors.curriculum_id }}
                </div>
              </div>
            </div>
            <hr />
          </div>

          <div class="flex flex-col px-6 py-5 bg-gray-50">
            <div
              class="flex flex-col sm:flex-row items-center mb-5 sm:space-x-5"
            >
              <div class="w-full sm:w-1/2">
                {{ faculty_forsubjects }}
                <p class="mb-2 font-semibold text-gray-700">Facultades</p>

                <select
                  v-model="faculty_forsubjects"
                  class="
                    w-full
                    p-5
                    bg-white
                    border border-gray-200
                    rounded
                    shadow-sm
                    appearance-none
                  "
                >
                  <option
                    v-for="faculty in faculties"
                    v-bind:key="faculty.vcode"
                    v-bind:value="faculty.vcode"
                  >
                    {{ faculty.name }}
                  </option>
                </select>
              </div>
              <div class="w-full sm:w-1/2 mt-2 sm:mt-0">
                <p class="mb-2 font-semibold text-gray-700">Asignturas</p>
                <select
                  v-model="form.subject_id"
                  @click="getFacultySubjects(faculty_forsubjects)"
                  class="
                    w-full
                    p-5
                    bg-white
                    border border-gray-200
                    rounded
                    shadow-sm
                    appearance-none
                  "
                >
                  <option
                    v-for="subject in subjects"
                    v-bind:key="subject.vcode"
                    v-bind:value="subject"
                  >
                    {{ subject.code }}-{{ subject.name }}
                  </option>
                </select>
                <div class="italic" if="form.errors.subject_id">
                  {{ form.errors.subject_id }}
                </div>
              </div>
            </div>

            <div
              class="
                flex flex-row
                items-center
                justify-between
                p-5
                bg-white
                border border-gray-200
                rounded
                shadow-sm
              "
            >
              <div class="flex flex-row items-center">
                <img
                  class="w-10 h-10 mr-3 rounded-full"
                  :src="$page.props.user.profile_photo_url"
                  :alt="$page.props.user.name"
                />
                <div class="flex flex-col">
                  <p class="font-semibold text-gray-800">
                    {{ $page.props.user.name }}
                  </p>
                  <p class="text-gray-400">{{ $page.props.user.email }}</p>
                </div>
              </div>
            </div>
          </div>
        </form>

        <div
          class="
            flex flex-row
            items-center
            justify-between
            p-5
            bg-white
            border-t border-gray-200
            rounded-bl-lg rounded-br-lg
          "
        >
          <p class="font-semibold text-gray-600" @click="close()">Regresar</p>
          <p class="font-semibold text-gray-600" @click="form.reset()">
            Restablecer
          </p>
          <button
            class="px-4 py-2 text-white font-semibold bg-blue-500 rounded"
            @click="submit()"
            :disabled="form.processing"
          >
            Guardar
          </button>
        </div>
      </div>
    </div>
  </modal>
</template>

<script>
import { defineComponent } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import JetTitle from "@/Jetstream/Title";
import ExitIcon from "@/Jetstream/ExitIcon";
import Modal from "@/Jetstream/Modal.vue";
import JetLabel from "@/Jetstream/Label";
import JetButton from "@/Jetstream/Button";
import JetModifyButton from "@/Jetstream/ModifyButton";

export default defineComponent({
  data() {
    return {
      form: useForm({ curriculum_id: null, subject_id: null }),
      faculty_forcarreers: [],
      faculty_forsubjects: [],
      carreer_forcurriculums: [],
      faculties: Array,
      carreers: Array,
      curriculums: Array,
      subjects: Array,
    };
  },

  mounted() {
    axios.get(route("faculties.getFaculties")).then((response) => {
      this.faculties = response.data;
    });
  },

  components: {
    Modal,
    JetLabel,
    JetButton,
    JetModifyButton,
    JetTitle,
    ExitIcon,
  },

  props: {
    show: { default: false },
    maxWidth: { default: "2xl" },
    closeable: { default: true },
  },

  methods: {
    close: function () {
      this.$parent.$parent.closeCurriculumHasSubjects();
    },
    submit() {
      this.form.post(route("curriculumsandsubjects.store"), {
        preserveState: (page) => Object.keys(page.props.errors).length > 0,
      });
    },
    getCarreers(data) {
      axios
        .get(route("carreers.getCarreers"), {
          params: { faculty: data },
        })
        .then((response) => {
          this.carreers = response.data;
        });
    },
    getCurriculums(data) {
      axios
        .get(route("curriculums.getCurriculums"), {
          params: { carreer: data },
        })
        .then((response) => {
          this.curriculums = response.data;
        });
    },
    getFacultySubjects(data) {
      axios
        .get(route("faculties.getFacultySubjects"), {
          params: { faculty: data },
        })
        .then((response) => {
          this.subjects = response.data;
        });
    },
  },
});
</script>
