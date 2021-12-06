<template>
   <modal :show="show" :max-width="maxWidth" :closeable="closeable" @close="close">
      <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
              <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                  <h3 class="text-lg">
                      <div class="border-b p-2 pb-3 pt-0 mb-4">
                          <div class="flex justify-between items-center"><jet-label>Registro de Facultades</jet-label></div>
                      </div>
                  </h3>
       
    <form @submit.prevent="submit">
        <div class="container max-w-screen-lg mx-auto">
            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                        <div class="md:col-span-5">                                
                            <jet-label>Facultad</jet-label>
                            <select v-model="form.faculty_id" class="w-full my-2 px-3 py-1 border rounded-lg text-xs text-gray-700 focus:outline-none">
                                <option class="py-1" disabled selected>Facultad</option>                                                                    
                                <option class="py-1" v-for="faculty in faculties" v-bind:key="faculty.id" v-bind:value="faculty.id">{{faculty.name}}</option>  
                            </select>
                        </div>                                    
                        <div class="md:col-span-2">
                            <jet-label>Departamento</jet-label>
                            <select v-model="form.department_id" class="w-full my-2 px-3 py-1 border rounded-lg text-xs text-gray-700 focus:outline-none">
                                <option class="py-1" disabled selected>Departamento</option>
                                <option class="py-1" v-for="department in departments" v-bind:key="department.id" v-bind:value="department.id">{{department.name}}</option>
                            </select>
                        </div>               
                        <div class="md:col-span-5 text-right">                                        
                            <jet-button @click="submit()">Guardar</jet-button>
                            <jet-modify-button>Cerrar</jet-modify-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>         
              </div>
          </div>
      </div>
  </modal>
</template>

<script>
    import { defineComponent } from 'vue';
    import Modal from '@/Jetstream/Modal.vue';
    import JetLabel from "@/Jetstream/Label";
    import JetButton from "@/Jetstream/Button";
    import JetModifyButton from "@/Jetstream/ModifyButton";


    export default{
        emits: ['close'],

        data(){
            return{
                form:{ faculty_id:null, department_id:null}
            }
        },   
           
        components: {
            Modal, JetLabel, JetButton, JetModifyButton
        },

        props: {
            ["faculties"]: Array, ["departments"]: Array, errors: Object,
            show: { default: false}, maxWidth: { default: '2xl'}, closeable: { default: true} 
        },

        methods: {
            close: function(){this.$emit('close')},
            submit(){ this.$inertia.post(route('facultiesanddepartments.store'),this.form);},
        }
    }
</script>
