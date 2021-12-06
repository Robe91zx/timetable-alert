<template>
<modal :show="show" :max-width="maxWidth" :closeable="closeable" @close="close">
  
  <div class="flex justify-center h-11/12 items-center bg-gray-200 antialiased">
    <div class="flex flex-col w-full mx-auto rounded-lg border border-gray-300 shadow-xl">
      
      <div class="flex flex-row justify-between p-6 bg-white border-b border-gray-200 rounded-tl-lg rounded-tr-lg">
        <jet-title> Registro de Curriculums</jet-title>
        <exit-icon class="cursor-pointer" @click="close()" />
      </div>
<pre>{{this.form}}</pre>
      <div class="flex flex-col px-6 py-5 bg-gray-50">
        <form @submit.prevent="submit">
          <div class="lg:col-span-2">
            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
              <div class="md:col-span-5">
                <jet-label>Facultad</jet-label>
                <select v-model="form.faculty_vcode" class="w-full p-3 bg-white border border-gray-200 rounded shadow-sm appearance-none">
                  <option value="" disabled>¿A que malla pertenece la asignatura?</option>                                                                    
                  <option v-for="faculty in faculties" :key="faculty.id" v-bind:value="faculty.vcode">{{faculty.name}}</option>  
                </select>
              <div class="italic" if="form.errors.faculty_vcode">{{form.errors.faculty_vcode}}</div>
              </div> 
              <div class="md:col-span-1">
                <jet-label>Codigo</jet-label><jet-input v-model= "form.code"/>
                <div class="italic" if="form.errors.code">{{form.errors.code}}</div>
              </div>   
              <div class="md:col-span-4">
                <jet-label>Nombre</jet-label><jet-input v-model= "form.name"/>
                <div class="italic" if="form.errors.name">{{form.errors.name}}</div>
              </div>
              <div class="md:col-span-5">
                <jet-label>Semestre</jet-label>
                <select v-model="form.semester" class="w-full p-3 bg-white border border-gray-200 rounded shadow-sm appearance-none">                                 
                  <option value="" disabled>Selecciona el Semestre en que se dicta</option>
                  <option v-for="semester in 13" :key="semester" :value="semester-1">{{semester-1}}</option>
                </select>
                <div class="italic" if="form.errors.semester">{{form.errors.semester}}</div>
              </div>  
              <div class="md:col-span-5">
                <jet-label>Horas</jet-label>
                <select v-model="form.hours" class="w-full p-3 bg-white border border-gray-200 rounded shadow-sm appearance-none">                                 
                  <option value="" disabled>Selecciona el tiempo que utiliza la Asignatura</option>
                  <option v-for="hours in 13" :key="hours" :value="hours-1">{{hours-1}}</option>
                </select>
                <div class="italic" if="form.errors.hours">{{form.errors.hours}}</div>
              </div>
              <div class="md:col-span-5">
                <jet-label>Estado</jet-label>
                <select v-model="form.state" class="w-full p-3 bg-white border border-gray-200 rounded shadow-sm appearance-none">                                 
                  <option value="0">No Activa</option>
                  <option value="1">Activa</option>
                </select>
                <div class="italic" if="form.errors.state">{{form.errors.state}}</div>
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
      </div>

      <div class="flex flex-row items-center justify-between p-5 bg-white border-t border-gray-200 rounded-bl-lg rounded-br-lg">
        <p class="font-semibold text-gray-600 cursor-pointer" @click="close()"> Regresar</p>
        <p class="font-semibold text-gray-600 cursor-pointer" @click="form.reset()"> Reestablecer</p>
        <jet-button @click="registerSubject()" :disabled="form.processing"> Guardar</jet-button>
      </div>
    </div>
  </div>

</modal>
</template>

<script>
  import { defineComponent } from 'vue';
import { useForm} from '@inertiajs/inertia-vue3';
  import Modal from '@/Jetstream/Modal.vue';
  import JetLabel from "@/Jetstream/Label";
  import ExitIcon from "@/Jetstream/ExitIcon";
  import JetTitle from "@/Jetstream/Title";
  import {Link} from '@inertiajs/inertia-vue3'
  import JetInput from "@/Jetstream/Input";
  import JetButton from "@/Jetstream/Button";
  import JetModifyButton from "@/Jetstream/ModifyButton";


  export default defineComponent({
    data(){
      return{
        form: useForm({ code: null, name: null, semester: null, hours: '', vcode: Math.floor(Math.random() * 100000), faculty_vcode: '', state:'1'}),
        faculties: Array
      }
    },   
           
  components: {
    Modal, JetLabel, JetInput, JetButton, JetModifyButton, Link, JetTitle, ExitIcon
  },

  props: {
    show: { default: false}, maxWidth: { default: '2xl'}, closeable: { default: true}, curriculums: Array,
  },

  mounted(){
    axios.get(route('faculties.getFaculties')).then((response) =>{ this.faculties = response.data});
  },

  methods: {
    close: function(){this.$parent.$parent.closeModalCreate()},
    registerSubject: function(){ this.form.post(route('subjects.store'), {
      preserveState: (page) => Object.keys(page.props.errors).length > 0,
      })
    },
  }
})
</script>
