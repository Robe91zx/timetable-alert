<template>
<modal :show="show" :max-width="maxWidth" :closeable="closeable" @close="close">

<div class="flex justify-center h-11/12 items-center bg-gray-200 antialiased">
<div class="flex flex-col w-full mx-auto rounded-lg border border-gray-300 shadow-xl">
  <div class="flex flex-row justify-between p-6 bg-white border-b border-gray-200 rounded-tl-lg rounded-tr-lg">
    <jet-title> Registro de Facultades</jet-title>
    <exit-icon class="cursor-pointer" @click="close()" />
  </div>
  <div class="flex flex-col px-6 py-5 bg-gray-50">
    <form @submit.prevent="submit">
      <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
        <div class="md:col-span-1">
          <jet-form-title>Codigo</jet-form-title><jet-form-input v-model="form.code" />
          <div class="italic" if="form.errors.code">{{form.errors.code}}</div>  
        </div>
        <div class="md:col-span-4">
          <jet-form-title>Nombre</jet-form-title><jet-form-input v-model="form.name" />
          <div class="italic" if="form.errors.name">{{form.errors.name}}</div>  
        </div>
        <div class="md:col-span-5">
          <jet-form-title>Email</jet-form-title><jet-form-input v-model="form.email"/>
          <div class="italic" if="form.errors.email">{{form.errors.email}}</div>  
        </div>
        <div class="md:col-span-5">
          <jet-form-title>Fono:</jet-form-title><jet-form-input v-model="form.phone"/>
          <div class="italic" if="form.errors.phone">{{form.errors.phone}}</div>  
        </div>
        <div class="md:col-span-5">
          <jet-form-title>Website</jet-form-title><jet-form-input v-model="form.website"/>
          <div class="italic" if="form.errors.website">{{form.errors.website}}</div>  
        </div>
      </div>
    </form>

    <div class="flex items-center mt-5 mb-3 space-x-4"></div>

    <div class="flex flex-row items-center justify-between p-5 bg-white border border-gray-200 rounded shadow-sm">
      <div class="flex flex-row items-center">
        <img class="w-10 h-10 mr-3 rounded-full" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name"/>
          <div class="flex flex-col">
            <p class="font-semibold text-gray-800">{{ $page.props.user.name }}</p>
            <p class="text-gray-400">{{ $page.props.user.email }}</p>
          </div>
      </div>
    </div>
  </div>

  <div class="flex flex-row items-center justify-between p-5 bg-white border-t border-gray-200 rounded-bl-lg rounded-br-lg">
    <p class="font-semibold text-gray-600 cursor-pointer" @click="close()"> Regresar</p>
    <p class="font-semibold text-gray-600 cursor-pointer" @click="form.reset()"> Reestablecer</p>
    <jet-button @click="registerFaculty()" :disabled="form.processing"> Guardar</jet-button>
  </div>
</div>
</div>

</modal>
</template>

<script>
  import {defineComponent } from 'vue';
  import {useForm} from '@inertiajs/inertia-vue3';
  import Modal from '@/Jetstream/Modal.vue';
  import JetTitle from "@/Jetstream/Title";
  import JetFormTitle from "@/Jetstream/FormTitle";
  import JetFormInput from "@/Jetstream/FormInput";
  import JetButton from "@/Jetstream/Button";
  import ExitIcon from "@/Jetstream/ExitIcon";

  export default defineComponent({
    data(){
      return{ form : useForm({ vcode: Math.floor(Math.random() * 100000), code: null, name: null, phone: null,  website:null, email: ''})
      };
    },   
           
    components: { Modal, JetTitle, JetFormTitle, JetFormInput, JetButton, ExitIcon },

    props: { show: { default: false}, maxWidth: { default: '2xl'}, closeable: { default: true} },

    methods: {
      close: function(){this.$parent.$parent.closeRegisterFaculty()},
      registerFaculty: function(){ this.form.post(route('faculties.store'), {
        preserveState: (page) => Object.keys(page.props.errors).length > 0,
      })} ,
    },
    

  })
</script>
