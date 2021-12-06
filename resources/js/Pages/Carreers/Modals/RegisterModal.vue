<template>
<modal :show="show" :max-width="maxWidth" :closeable="closeable" @close="close">

  <div class="flex justify-center h-11/12 items-center bg-gray-200 antialiased">
  <div class="flex flex-col w-full mx-auto rounded-lg border border-gray-300 shadow-xl">
    <div class="flex flex-row justify-between p-6 bg-white border-b border-gray-200 rounded-tl-lg rounded-tr-lg">
      <jet-title> Registro de Carreras</jet-title>
      <exit-icon class="cursor-pointer" @click="close()" />
    </div>

    <div class="flex flex-col px-6 py-5 bg-gray-50">
                {{this.form}}
      <form @submit.prevent="submit">
        <div class="lg:col-span-2">
          <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
            <div class="md:col-span-5">
              <jet-label>Codigo</jet-label><jet-form-input v-model="form.code" />
              <div class="italic" if="form.errors.code">{{form.errors.code}}</div>
            </div>
            <div class="md:col-span-5">
              <jet-label>Nombre</jet-label><jet-form-input v-model="form.name" />
              <div class="italic" if="form.errors.name">{{form.errors.name}}</div>
            </div>                  
            <div class="md:col-span-5">
              <jet-label>Telefono</jet-label><jet-form-input v-model="form.phone" />
              <div class="italic" if="form.errors.phone">{{form.errors.phone}}</div>
            </div>
            <div class="md:col-span-5">
              <jet-label>Email</jet-label><jet-form-input v-model="form.email" />
              <div class="italic" if="form.error.email">{{form.errors.email}}</div>
            </div>
            <div class="md:col-span-5">
              <jet-label>Website</jet-label><jet-form-input v-model="form.website" />
              <div class="italic" if="form.errors.website">{{form.errors.website}}</div>
            </div>
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

        <div class="flex flex-row items-center justify-between p-5 bg-white border-t border-gray-200 rounded-bl-lg rounded-br-lg">
          <p class="font-semibold text-gray-600 cursor-pointer" @click="close()"> Regresar</p>
          <p class="font-semibold text-gray-600 cursor-pointer" @click="form.reset()"> Reestablecer</p>
          <jet-button @click="registerCarreer()" :disabled="form.processing"> Guardar</jet-button>
        </div>
    
    </div>
  </div>
  </div>
  
</modal>
</template>

<script>
    import { defineComponent } from 'vue';
  import { useForm} from '@inertiajs/inertia-vue3';

    import {Inertia} from '@inertiajs/inertia';
    import Modal from '@/Jetstream/Modal.vue';
    import JetLabel from "@/Jetstream/Label";
    import JetTitle from "@/Jetstream/Title";
  import JetFormInput from "@/Jetstream/FormInput";
    import JetButton from "@/Jetstream/Button";
    import ExitIcon from "@/Jetstream/ExitIcon";


    export default defineComponent({

        data(){
            return{
                form: useForm({ name: null, code: null, vcode: Math.floor(Math.random() * 100000), email:null, phone: null, website:null}),
                departments: Array
            }
        },   
           
        components: {
            Modal, JetLabel, JetTitle, JetFormInput, JetButton, ExitIcon
        },

        props: {
            show: { default: false}, maxWidth: { default: '2xl'}, closeable: { default: true},
        },

        methods: {
            close: function(){this.$parent.$parent.closeModalCreate()},

            registerCarreer: function(){ Inertia.post(route('carreers.store'), this.form, {
                preserveState: (page) => Object.keys(page.props.errors).length > 0,
            })
            } ,
        }
    
    })
</script>
