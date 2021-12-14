<template>
  <app-layout title="Asignaturas">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Modificar Datos: Asignatura {{ subject.name }}
      </h2>
    </template>

    <form @submit.prevent="submit">
      <div
        class="min-50-screen p-6 bg-gray-100 flex items-center justify-center"
      >
        <div class="container max-w-screen-lg mx-auto">
          <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
              <div class="text-gray-600">
                <p class="font-medium text-lg">Actualizar Asignatura</p>
                <p>Por favor, llene todos los campos solicitados.</p>
              </div>
              <div class="lg:col-span-2">
                <div
                  class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5"
                >
                  <div class="md:col-span-5">
                    <jet-form-title>Facultad</jet-form-title>
                    <select
                      v-model="form.faculty_vcode"
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
                      <option value="" disabled>
                        ¿A que Facultad pertenece la asignatura?
                      </option>
                      <option
                        v-for="faculty in faculties"
                        :key="faculty.id"
                        v-bind:value="faculty.vcode"
                      >
                        {{ faculty.name }}
                      </option>
                    </select>
                    <div class="italic" if="form.errors.faculty_vcode">
                      {{ form.errors.faculty_vcode }}
                    </div>
                  </div>
                  <div class="md:col-span-1">
                    <jet-form-title>Codigo</jet-form-title
                    ><jet-form-input v-model="form.code" />
                    <div class="italic" if="form.errors.code">
                      {{ form.errors.code }}
                    </div>
                  </div>
                  <div class="md:col-span-4">
                    <jet-form-title>Nombre</jet-form-title
                    ><jet-form-input v-model="form.name" />
                    <div class="italic" if="form.errors.name">
                      {{ form.errors.name }}
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
                      <option value="" disabled>
                        Selecciona el Semestre en que se dicta
                      </option>
                      <option
                        v-for="semester in 13"
                        :key="semester"
                        :value="semester - 1"
                      >
                        {{ semester - 1 }}
                      </option>
                    </select>
                    <div class="italic" if="form.errors.semester">
                      {{ form.errors.semester }}
                    </div>
                  </div>
                  <div class="md:col-span-5">
                    <jet-form-title>Horas</jet-form-title>
                    <select
                      v-model="form.hours"
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
                      <option value="" disabled>
                        Selecciona el tiempo que utiliza la Asignatura
                      </option>
                      <option
                        v-for="hours in 13"
                        :key="hours"
                        :value="hours - 1"
                      >
                        {{ hours - 1 }}
                      </option>
                    </select>
                    <div class="italic" if="form.errors.hours">
                      {{ form.errors.hours }}
                    </div>
                  </div>
                  <div class="md:col-span-5">
                    <jet-form-title>Estado</jet-form-title>
                    <select
                      v-model="form.state"
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
                      <option value="0">No Activa</option>
                      <option value="1">Activa</option>
                    </select>
                    <div class="italic" if="form.errors.state">
                      {{ form.errors.state }}
                    </div>
                  </div>
                  <div class="inline-flex items-end py-8">
                    <jet-button @click="submit()" :disabled="form.processing">
                      Guardar
                    </jet-button>
                    <p
                      class="font-semibold text-gray-600 cursor-pointer"
                      @click="this.form.reset()"
                    >
                      Restablecer
                    </p>
                    <p class="font-semibold text-gray-600 cursor-pointer">
                      <Link :href="route('subjects.index')"> Regresar</Link>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </app-layout>
</template>

<script>
import { useForm } from "@inertiajs/inertia-vue3";
import { Link } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout";
import JetFormTitle from "@/Jetstream/FormTitle";
import JetFormInput from "@/Jetstream/FormInput";
import JetButton from "@/Jetstream/Button";
import JetModifyButton from "@/Jetstream/ModifyButton";

export default {
  components: {
    Link,
    AppLayout,
    JetFormTitle,
    JetFormInput,
    JetButton,
    JetModifyButton,
  },
  props: {
    subject: Object,
  },
  data() {
    return {
      faculties: Array,

      form: useForm({
        vcode: this.$props.subject.vcode,
        code: this.$props.subject.code,
        name: this.$props.subject.name,
        semester: this.$props.subject.semester,
        requisite: this.$props.subject.requisite,
        hours: this.$props.subject.hours,
        faculty_vcode: this.$props.subject.faculty_vcode,
        state: this.$props.subject.state,
      }),
    };
  },

  mounted() {
    axios.get(route("faculties.getFaculties")).then((response) => {
      this.faculties = response.data;
    });
  },
  methods: {
    submit() {
      this.form.put(route("subjects.update", this.$props.subject.id));
    },
  },
};
</script>