<template>
<modal :show="show" :max-width="maxWidth" :closeable="closeable" @close="close">
  <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
    <div class="sm:flex sm:items-start">
      <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
        <div class="border-b p-2 pb-3 pt-0 mb-4"><jet-label class="text-lg "> Editar Facultades</jet-label></div>    

        <jet-label>Facultad</jet-label>
        
        <select @change="getFaculties()" v-model="faculties" class="float-right my-2 px-3 py-1 border rounded-lg text-xs text-gray-700 focus:outline-none">
             <option class="py-1" value="" disabled> Elige una Facultad </option>
             <option class="py-1" v-for="faculty in faculties" :key="faculty">{{faculty.name}}  </option>  
        </select>

        <form @submit.prevent="submit">
          <div class="lg:col-span-2">
            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
              <div class="md:col-span-5">
                <jet-label>Nombre</jet-label><jet-input v-model="form.name"/>
                <div class="italic" if="form.errors.name">{{form.errors.name}}</div>  
              </div>                  
              <div class="md:col-span-2">
                <jet-label>Codigo Facultad</jet-label><jet-input v-model="form.code"/>
                <div class="italic" if="form.errors.code">{{form.errors.code}}</div>  
              </div>
              <div class="md:col-span-3">
                <jet-label>Email</jet-label><jet-input v-model="form.email"/>
                <div class="italic" if="form.errors.email">{{form.errors.email}}</div>  
              </div>
              <div class="md:col-span-2">
                <jet-label>Fono:</jet-label><jet-input v-model="form.phone"/>
                <div class="italic" if="form.errors.phone">{{form.errors.phone}}</div>  
              </div>
              <div class="md:col-span-3">
                <jet-label>Website</jet-label><jet-input v-model="form.website"/>
                <div class="italic" if="form.errors.website">{{form.errors.website}}</div>  
              </div>
            </div>     
          </div> 
        </form>            
      </div>
    </div>
  </div>
  
  <div class="px-6 py-4 bg-gray-100 text-right">
    <jet-button @click="registerFaculty()"> Guardar </jet-button>
    <p class="font-semibold text-gray-600 cursor-pointer" @click="form.reset()"> Reestablecer</p>
    <p class="font-semibold text-gray-600 cursor-pointer" @click="close()" :disabled="form.processing" >Cerrar</p>
  </div>

</modal>
</template>

<script>
    import { defineComponent } from 'vue';
    import { useForm } from '@inertiajs/inertia-vue3'
    import JetInputError from "@/Jetstream/InputError"
    import JetInput from "@/Jetstream/Input"
    import Modal from '@/Jetstream/Modal.vue';
    import JetLabel from "@/Jetstream/Label";
    import JetButton from "@/Jetstream/Button";
    import JetModifyButton from "@/Jetstream/ModifyButton";

    export default defineComponent({
        data(){
            return{
                form: useForm({ code: null, name: null, phone: null,  website:null, email: ''}), faculties: Array, selectedFaculty: Object
            }
        },   
        mounted (){
            axios.get(route('faculties.getFaculties')).then((response) =>{ this.faculties = response.data;});

        },

        components: {
            Modal, JetInput, JetInputError, JetLabel, JetButton, JetModifyButton     
        },

        props: { 
            show: { default: false}, maxWidth: { default: '2xl'}, closeable: { default: true},
        },

        methods: {
            close: function(){this.$parent.$parent.closeModalEdit()},
  alerta: function(data){
    console.log(data)
  },

          //  loadFaculty: function(){ console.log(this.selectedFaculty); axios.get(route('faculties.getFaculty'),{params:{ faculty: this.selectedFaculty}})
           // .then((response) =>{ console.log(response.data)}) },
            
            async getFaculties() {
              try {
                const response = await axios.get(route('faculties.getFaculties'));
                console.log(response);
              } catch (error) {
                console.error(error);
              }
            },
            editFaculty: function(){ this.form.post(route('faculties.store'))} ,
        }
    
    })
</script>
