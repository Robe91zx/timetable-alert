<template>
   <modal :show="show" :max-width="maxWidth" :closeable="closeable" @close="close">
      <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
              <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                  <h3 class="text-lg">
                      <div class="border-b p-2 pb-3 pt-0 mb-4">
                          <div class="flex justify-between items-center">Crear Permiso</div>
                      </div>
                  </h3>
       
                  <form @submit.prevent="submit">
                      <div class="lg:col-span-2">
                          <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                             <div class="md:col-span-5">
                                  <jet-label>Nombre</jet-label><p>jajaja potooo</p>
                                  <input v-model="form.name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"/>
                                  <jet-label>Descripcion del Rol</jet-label>
                                  <input v-model="form.description" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"/>
                              </div>                  
                          </div>     
                      </div> 
                  </form>
              </div>
          </div>
      </div>
      <div class="px-6 py-4 bg-gray-100 text-right">
          <jet-button @click="createPermission()"> Guardar </jet-button>
          <jet-modify-button @click="close()">Cerrar</jet-modify-button>
      </div>
  </modal>
</template>

<script>
    import { defineComponent } from 'vue';
    import {Inertia} from '@inertiajs/inertia';
    import Modal from '@/Jetstream/Modal.vue';
    import JetLabel from "@/Jetstream/Label";
    import JetButton from "@/Jetstream/Button";
    import JetModifyButton from "@/Jetstream/ModifyButton";

    export default defineComponent({
        emits: ['close'],

        data(){
            return{
                form:{ name: null, description: null}
            }
        },   
           
        components: {
            Modal, JetLabel, JetButton, JetModifyButton
        },

        props: {
            show: { default: false}, maxWidth: { default: '2xl'}, closeable: { default: true},
        },

        methods: {
            close: function(){this.$emit('close')},

            createPermission: function(){ Inertia.post(route('permissions.store'), this.form);} ,
        }
    
    })
</script>
