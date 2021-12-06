<template>
<app-layout title="Departamentos">
  <template #header> 
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Modificar Datos: Departamento de {{department.name}}</h2>
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
                  <jet-label>Nombre</jet-label><jet-input v-model="form.name" />
                <div class="italic" if="form.errors.name">{{form.errors.name}}</div>
                </div>                  
                <div class="md:col-span-2">
                  <jet-label>Codigo Facultad</jet-label><jet-input v-model="form.code" />
                  <div class="italic" if="form.errors.code">{{form.errors.code}}</div>
                </div>
                <div class="md:col-span-3">
                  <jet-label>Email</jet-label><jet-input v-model="form.email" />
                  <div class="italic" if="form.errors.email">{{form.errors.email}}</div>
                </div>
                <div class="md:col-span-2">
                  <jet-label>Fono:</jet-label><jet-input v-model="form.phone" />
                  <div class="italic" if="form.errors.phone">{{form.errors.phone}}</div>
                </div>
                <div class="md:col-span-3">
                  <jet-label>Website</jet-label><jet-input v-model="form.website" />
                  <div class="italic" if="form.errors.website">{{form.errors.website}}</div>
                </div>
              </div>  
              <div class="inline-flex items-end py-8">
                <jet-button class="m-1" @click="submit()" :disabled="form.processing"> Guardar </jet-button>
                <p class="font-semibold text-gray-600 cursor-pointer" @click="form.reset()"> Reestablecer</p>
                <p class="font-semibold text-gray-600 cursor-pointer"> <Link :href="route('departments.index')"> Regresar</Link> </p>
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
    AppLayout, Link, JetLabel, JetInput,
    JetButton, JetModifyButton,
  },

  props:{ department: Object, errors: Object },
    
  data(){
    return{ 
      form: useForm({ name: this.$props.department.name, vcode: this.$props.department.vcode, code: this.$props.department.code, email: this.$props.department.email,
             phone: this.$props.department.phone, website: this.$props.department.website
      }) 
    }
  },
  
  methods:{
    submit(){ this.form.put(route('departments.update', this.$props.department));},
  }
}
</script>