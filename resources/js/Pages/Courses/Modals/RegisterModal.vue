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
          <jet-title> Registro de Cursos</jet-title>
          <exit-icon class="cursor-pointer" @click="close()" />
        </div>

        <div class="flex flex-col px-6 py-5 bg-gray-50">
          <form @submit.prevent="submit">
            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
              <div class="md:col-span-5">
                <p class="mb-2 font-semibold text-gray-700">Facultad</p>
                <select
                  @change="getActiveSubjects(faculty)"
                  v-model="faculty"
                  class="
                    w-full
                    p-3
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
                <div class="italic" if="form.errors.faculty">
                  {{ form.errors.faculty }}
                </div>
              </div>
              <div class="md:col-span-5">
                <p class="mb-2 font-semibold text-gray-700">Asignatura</p>
                <select
                  @change="setValues(subject)"
                  v-model="subject"
                  class="
                    w-full
                    p-3
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
                <div class="italic" if="form.errors.subject">
                  {{ form.errors.subject }}
                </div>
              </div>

              <div class="md:col-span-1">
                <jet-form-title>Grupo</jet-form-title>
                <jet-form-input v-model="form.group" />
              </div>
              <div class="md:col-span-1">
                <jet-form-title>Codigo</jet-form-title
                ><jet-form-input
                  v-model="form.code"
                  v-bind:value="subject.code"
                  disabled
                />
                <div class="italic" if="form.errors.code">
                  {{ form.errors.code }}
                </div>
              </div>
              <div class="md:col-span-4">
                <jet-form-title>Descripcion</jet-form-title
                ><jet-form-input v-model="form.description" />
                <div class="italic" if="form.errors.description">
                  {{ form.errors.description }}
                </div>
              </div>
              <div class="md:col-span-5">
                <jet-form-title>Semestre</jet-form-title>
                <select
                  v-model="form.semester"
                  class="
                    w-full
                    p-3
                    bg-white
                    border border-gray-200
                    rounded
                    shadow-sm
                    appearance-none
                  "
                >
                  <option
                    v-for="semester in 2"
                    :key="semester"
                    :value="semester"
                  >
                    {{ semester }} Semestre
                  </option>
                </select>
                <div class="italic" if="form.errors.semester">
                  {{ form.errors.semester }}
                </div>
              </div>
              <div class="md:col-span-5">
                <jet-form-title>Horas</jet-form-title>
                <jet-form-input
                  v-model="form.hours"
                  v-bind:value="subject.hours"
                  disabled
                />
                <div class="italic" if="form.errors.hours">
                  {{ form.errors.hours }}
                </div>
              </div>
              <div class="md:col-span-5">
                <jet-form-title>Subject Vcode</jet-form-title>
                <jet-form-input
                  v-model="form.subject_vcode"
                  v-bind:value="subject.vcode"
                />
                <div class="italic" if="form.errors.state">
                  {{ form.errors.state }}
                </div>
              </div>
            </div>
          </form>

          <div class="flex items-center mt-5 mb-3 space-x-4"></div>

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
                <p class="text-gray-400">
                  {{ $page.props.user.email }}
                </p>
              </div>
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
            border-t border-gray-200
            rounded-bl-lg rounded-br-lg
          "
        >
          <p
            class="font-semibold text-gray-600 cursor-pointer"
            @click="close()"
          >
            Regresar
          </p>
          <p
            class="font-semibold text-gray-600 cursor-pointer"
            @click="form.reset()"
          >
            Reestablecer
          </p>
          <jet-button @click="registerCourse()" :disabled="form.processing">
            Guardar</jet-button
          >
        </div>
      </div>
    </div>
  </modal>
</template>

<script>
import { defineComponent } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import Modal from "@/Jetstream/Modal.vue";
import JetTitle from "@/Jetstream/Title";
import JetFormTitle from "@/Jetstream/FormTitle";
import JetFormInput from "@/Jetstream/FormInput";
import JetButton from "@/Jetstream/Button";
import ExitIcon from "@/Jetstream/ExitIcon";

export default defineComponent({
  data() {
    return {
      form: useForm({
        vcode: Math.floor(Math.random() * 100000),
        code: null,
        group: null,
        description: null,
        semester: null,
        hours: "",
        subject_vcode: "",
        state: "1",
      }),
      faculty: Array,
      faculties: Array,
      subject: Array,
      subjects: Array,
    };
  },

  components: {
    Modal,
    JetTitle,
    JetFormTitle,
    JetFormInput,
    JetButton,
    ExitIcon,
  },

  props: {
    show: { default: false },
    maxWidth: { default: "2xl" },
    closeable: { default: true },
    curriculums: Array,
  },

  mounted() {
    axios.get(route("faculties.getFaculties")).then((response) => {
      this.faculties = response.data;
    });
  },

  methods: {
    close: function () {
      this.$parent.$parent.closeRegisterCourses();
    },
    registerCourse: function () {
      this.form.post(route("courses.store"), {
        preserveState: (page) => Object.keys(page.props.errors).length > 0,
      });
    },
    getActiveSubjects(data) {
      console.log(data);
      axios
        .get(route("faculties.getactiveSubjects"), {
          params: { faculty: data },
        })
        .then((response) => {
          this.subjects = response.data;
        });
    },
    setValues(data) {
      console.log(data);
      this.form.code = data.code;
      this.form.hours = data.hours;
      this.form.subject_vcode = data.vcode;
    },
  },
});
</script>
