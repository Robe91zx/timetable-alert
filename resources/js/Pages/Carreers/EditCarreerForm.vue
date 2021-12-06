<template>
<app-layout title="Facultades">
   <template #header> 
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Modificar Datos: Carrera {{carreer.name}}</h2>
   </template>   
        <pre>{{this.form}}</pre>
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
                  <jet-label>Codigo</jet-label><jet-input v-model="form.code" />
                  <div class="italic" if="form.errors.name">{{form.errors.code}}</div>
                </div>
                <div class="md:col-span-5">
              <jet-label>Email</jet-label><jet-input v-model="form.email"/>
              <div class="italic" if="form.errors.email">{{form.errors.email}}</div>  
            </div>
            <div class="md:col-span-5">
              <jet-label>Fono:</jet-label><jet-input v-model="form.phone"/>
              <div class="italic" if="form.errors.phone">{{form.errors.phone}}</div>  
            </div>
                <div class="md:col-span-2">
                  <jet-label>Website</jet-label><jet-input v-model="form.website" />
                  <div class="italic" if="form.errors.name">{{form.errors.website}}</div>
                </div>
                
              </div> 
              <div class="inline-flex items-end py-8">
                  <jet-button @click="submit()"> Guardar </jet-button>
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
import AppLayout from "@/Layouts/AppLayout"
  import { useForm} from '@inertiajs/inertia-vue3';
import JetInputError from "@/Jetstream/InputError"
import JetLabel from "@/Jetstream/Label"
import JetInput from "@/Jetstream/Input"
import JetButton from "@/Jetstream/Button"
import JetModifyButton from "@/Jetstream/ModifyButton"
import JetButtonDanger from "@/Jetstream/ButtonDanger"


export default {
    
    components:{
        AppLayout, JetInputError,
        JetLabel, JetInput,
        JetButton, JetModifyButton, JetButtonDanger,
    },
    
    props:{ carreer: Object},
    
    data(){
        return{ 
            form: useForm({ name: this.$props.carreer.name, code: this.$props.carreer.code, phone: this.$props.carreer.phone, email: this.$props.carreer.email, website: this.$props.carreer.website}),   
            departments: Array,
        }
    },
    
    methods:{
        submit(){ this.form.put( route('carreers.update', this.$props.carreer.id) );
        },
    
    }
}
</script>