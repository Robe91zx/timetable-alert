<template>
<modal :show="show" :max-width="maxWidth" :closeable="closeable" @close="close">
  <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
    <div class="sm:flex sm:items-start">
      <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
        <div class="border-b p-2 pb-3 pt-0 mb-4"><jet-label class="text-lg">Registro de Carreras </jet-label></div>

                    {{this.form}}

        <form @submit.prevent="submit">
          <div class="lg:col-span-2">
            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
              <div class="md:col-span-5">
                <jet-label>Nombre</jet-label><jet-input v-model="form.name" />
                <div class="italic" if="$page.props.errors.name">{{$page.props.errors.name}}</div>
              </div>                  
              <div class="md:col-span-2">
                <jet-label>Codigo</jet-label><jet-input v-model="form.code" />
                <div class="italic" if="$page.props.errors.name">{{$page.props.errors.code}}</div>
              </div>
              <div class="md:col-span-3">
                <jet-label>Codigo de Departamento</jet-label>
                <select v-model="form.department_vcode">
                    <option class="py-1" v-for="department in departments" v-bind:key="department.id" v-bind:value="department.vcode">{{department.name}}</option>
                </select>
              </div>
              <div class="md:col-span-2">
                <jet-label>Website</jet-label><jet-input v-model="form.website" />
                <div class="italic" if="$page.props.errors.name">{{$page.props.errors.website}}</div>
              </div>
            </div>     
          </div> 
        </form>
                    
      </div>
    </div>
  </div>
 
  <div class="px-6 py-4 bg-gray-100 text-right">
    <jet-button @click="registerCarreer()"> Guardar </jet-button>
    <jet-modify-button @click="close()">Cerrar</jet-modify-button>
  </div>
</modal>
</template>

<script>
    import { defineComponent } from 'vue';
    import {Inertia} from '@inertiajs/inertia';
    import Modal from '@/Jetstream/Modal.vue';
    import JetLabel from "@/Jetstream/Label";
    import JetInput from "@/Jetstream/Input";
    import JetButton from "@/Jetstream/Button";
    import JetModifyButton from "@/Jetstream/ModifyButton";

    export default defineComponent({

        data(){
            return{
                form:{ name: null, code: null, vcode: Math.floor(Math.random() * 100000), department_vcode: null, website:null},
                departments: Array
            }
        },   
           
        components: {
            Modal, JetLabel, JetInput, JetButton, JetModifyButton
        },

        props: {
            show: { default: false}, maxWidth: { default: '2xl'}, closeable: { default: true},
        },

        mounted(){
            axios.get(route('departments.getDepartments')).then((response) =>{ this.departments = response.data});
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
