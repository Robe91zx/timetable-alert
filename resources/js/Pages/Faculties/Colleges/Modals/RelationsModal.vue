<template>
<modal :show="show" :max-width="maxWidth" :closeable="closeable" @close="close">
<div class="flex justify-center h-11/12 items-center bg-gray-200 antialiased">
<div class="flex flex-col w-full mx-auto rounded-lg border border-gray-300 shadow-xl">
  <div class="flex flex-row justify-between p-6 bg-white border-b border-gray-200 rounded-tl-lg rounded-tr-lg">
    <jet-title> Relacion Facultad - Escuela </jet-title>
    <exit-icon @click="close()" />
  </div>

  <div class="flex flex-col px-6 py-5 bg-gray-50">
    <form @submit.prevent="submit">
      <div class="flex flex-col sm:flex-row items-center mb-5 sm:space-x-5">
        <div class="w-full sm:w-1/2">
          <p class="mb-2 font-semibold text-gray-700">Facultades</p>
          <select v-model="form.faculty_id" class="w-full p-5 bg-white border border-gray-200 rounded shadow-sm appearance-none">
            <option v-for="faculty in faculties" v-bind:key="faculty.vcode" v-bind:value="faculty">{{faculty.name}}</option>
          </select>
          <div class="italic" if="form.errors.faculty">{{form.errors.faculty_id}}</div>  
        </div>
        <div class="w-full sm:w-1/2 mt-2 sm:mt-0"> 
          <p class="mb-2 font-semibold text-gray-700">Escuela</p>
          <select v-model="form.college_id" class="w-full p-5 bg-white border border-gray-200 rounded shadow-sm appearance-none">
            <option v-for="college in colleges" v-bind:key="college.vcode" v-bind:value="college">{{college.name}}</option>
          </select>
          <div class="italic" if="form.errors.college">{{form.errors.college_id}}</div>  
        </div>
      </div>
    </form>  

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
    <p class="font-semibold text-gray-600" @click="close()">  Regresar</p>
    <button class="px-4 py-2 text-white font-semibold bg-blue-500 rounded" @click="submit()" :disabled="form.processing"> Guardar</button>
  </div>
</div>
</div>

</modal>
</template>

<script>
import { defineComponent } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3'
import JetTitle from "@/Jetstream/Title";
import ExitIcon from "@/Jetstream/ExitIcon";
import Modal from '@/Jetstream/Modal.vue';
import JetLabel from "@/Jetstream/Label";
import JetButton from "@/Jetstream/Button";
import JetModifyButton from "@/Jetstream/ModifyButton";

export default defineComponent({
  data(){
    return{ form: useForm({ faculty_id: null, college_id: null}) }
  },   
        
  mounted() {
    axios.get(route('facultiesandcolleges.create')).then((response)=>{ this.faculties = response.data[0]; this.colleges = response.data[1]; });
  },  

  components: { JetTitle, ExitIcon, Modal, JetLabel, JetButton, JetModifyButton },

  props: { show: { default: false}, maxWidth: { default: '2xl'}, closeable: { default: true} },

  methods: {
    close: function(){this.$parent.$parent.closeFacultyHasCollege()},
    submit(){ this.form.post(route('facultiesandcolleges.store'), {
      preserveState: (page) => Object.keys(page.props.errors).length > 0,
    });},
  }
})
</script>
