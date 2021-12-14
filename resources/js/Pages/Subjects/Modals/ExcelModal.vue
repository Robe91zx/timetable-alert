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
          <jet-title> Registro de Asignaturas</jet-title>
          <exit-icon @click="close()" />
        </div>

        <div class="flex flex-col px-6 py-5 bg-gray-50">
          <label
            class="
              flex flex-col
              w-full
              h-32
              border-4 border-blue-200 border-dashed
              hover:bg-gray-100 hover:border-gray-300
            "
          >
            <div class="flex flex-col items-center justify-center pt-7">
              <upload-icon />
              <p
                class="
                  pt-1
                  text-sm
                  tracking-wider
                  text-gray-400
                  group-hover:text-gray-600
                "
                v-if="form.file"
              >
                {{ form.file.name }}
              </p>
              <p
                class="
                  pt-1
                  text-sm
                  tracking-wider
                  text-gray-400
                  group-hover:text-gray-600
                "
                v-else
              >
                Haz Click para buscar tu Archivo
              </p>
            </div>
            <form @submit.prevent="submit">
              <input
                type="file"
                class="opacity-0"
                @input="form.file = $event.target.files[0]"
              />
            </form>
          </label>

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
          <p class="font-semibold text-gray-600" @click="close()">Regresar</p>
          <jet-button @click="registerMasive()"> Guardar</jet-button>
        </div>
      </div>
    </div>
  </modal>
</template>

<script>
import { defineComponent } from "vue";
import { Inertia } from "@inertiajs/inertia";
import Modal from "@/Jetstream/Modal.vue";
import JetTitle from "@/Jetstream/Title";
import JetButton from "@/Jetstream/Button";
import ExitIcon from "@/Jetstream/ExitIcon";
import UploadIcon from "@/Jetstream/UploadIcon";

export default defineComponent({
  data() {
    return { form: { file: null } };
  },

  components: { Modal, JetTitle, ExitIcon, UploadIcon, JetButton },

  props: {
    show: { default: false },
    maxWidth: { default: "2xl" },
    closeable: { default: true },
  },

  methods: {
    close: function () {
      this.$parent.$parent.closeExcelRegister();
    },
    registerMasive: function () {
      Inertia.post(route("subjects.import"), {
        _method: "get",
        file: this.form.file,
      });
      this.$parent.$parent.closeExcelRegister();
    },
  },
});
</script>
