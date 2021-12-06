<template>
<app-layout title="Mallas">
  <template #header>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Modificar Malla</h2>
  </template>    

  <form @submit.prevent="submit">
    <div class="min-h-50 p-6 bg-gray-100 flex items-center justify-center">
      <div class="container max-w-screen-lg mx-auto">
        <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
          <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
            <div class="text-gray-600">
              <p class="font-medium text-lg">Detalle</p>
              <p>Por favor, actualice los campos necesarios.</p>
            </div>
            <div class="lg:col-span-2">
              <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                <div class="md:col-span-5">
                  <jet-label>Codigo</jet-label><jet-input v-model= "form.code"/>
                  <div class="italic" if="form.errors.code">{{form.errors.code}}</div>
                </div> 
                <div class="md:col-span-5">
                  <jet-label>Nombre</jet-label><jet-input v-model= "form.name"/>
                  <div class="italic" if="form.errors.name">{{form.errors.name}}</div>
                </div>
                <div class="md:col-span-5">
                  <jet-label>Descripcion</jet-label><jet-input v-model= "form.description"/>
                  <div class="italic" if="form.errors.description">{{form.errors.description}}</div>
                </div>        
                <div class="md:col-span-5">
                  <jet-label>Carrera</jet-label>
                  <select v-model="form.carreer_vcode" class="w-full p-3 bg-white border border-gray-200 rounded shadow-sm appearance-none">
                    <option value="">Selecciona una Carrera</option>
                    <option v-for="carreer in carreers" :key="carreer.id" :value="carreer.vcode">{{carreer.name}}</option>
                  </select>
                  <div class="italic" if="form.errors.carreer_vcode">{{form.errors.carreer_vcode}}</div>
                </div>
                <div class="md:col-span-5">
                  <jet-label>Estado</jet-label>
                  <select v-model="form.state" class="w-full p-3 bg-white border border-gray-200 rounded shadow-sm appearance-none">                                 
                    <option value="0">No Activa</option>
                    <option value="1">Activa</option>
                  </select>
                  <div class="italic" if="form.errors.name">{{form.errors.name}}</div>
                </div>                
                
                <div class="inline-flex items-end py-8">
                  <jet-button @click="submit()" :disabled="form.processing"> Guardar </jet-button>
                  <p class="font-semibold text-gray-600 cursor-pointer" @click="this.form.reset()"> Restablecer </p>
                  <p class="font-semibold text-gray-600 cursor-pointer"> <Link :href="route('curriculums.index')"> Regresar</Link> </p>
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
import { useForm} from '@inertiajs/inertia-vue3';
import {Link} from '@inertiajs/inertia-vue3'
import AppLayout from "@/Layouts/AppLayout"
import JetLabel from "@/Jetstream/Label"
import JetInput from "@/Jetstream/Input"
import JetButton from "@/Jetstream/Button"
import JetModifyButton from "@/Jetstream/ModifyButton"

export default {
  components:{
    AppLayout, Link,
    JetInput, JetLabel, JetButton, JetModifyButton
  },
  
  props: {curriculum: Object },

  mounted(){
      axios.get(route('carreers.getCarreers')).then((response) =>{ this.carreers = response.data});
  },
  
  data(){
    return{    
      form: useForm({ code: this.$props.curriculum.code, name: this.$props.curriculum.name, description: this.$props.curriculum.description,
                duration: this.$props.curriculum.duration, carreer_vcode: this.$props.curriculum.carreer_vcode, state: this.$props.curriculum.state,
            }) , carreers: Array
        };
    },
    methods:{
      submit(){ this.form.put( route('curriculums.update', this.$props.curriculum)) },
    },
}
</script>