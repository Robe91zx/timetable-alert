<template>
  <app-layout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Asignaturas
      </h2>
    </template>

    <div  v-if="$page.props.flash.message" class="alert flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3" role="alert">
      <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
      <div>{{ $page.props.flash.message }}</div>
    </div>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex mb-4">
          <div class="w-3/4 h-12">
            <form method="get" @submit.prevent="submit">
              <label for="search"></label>
              <input 
              v-model="form.name"
              name="name"
              class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 w-10/12 text-sm font-medium text-gray-900"
              placeholder="Busqueda"
              type="text"
              /> 
              <button type="submit" class="mx2 p-px"><svg class="fill-current w-4 h-4 ml-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M13 8h-8v-1h8v1zm0 2h-8v-1h8v1zm-3 2h-5v-1h5v1zm11.172 12l-7.387-7.387c-1.388.874-3.024 1.387-4.785 1.387-4.971 0-9-4.029-9-9s4.029-9 9-9 9 4.029 9 9c0 1.761-.514 3.398-1.387 4.785l7.387 7.387-2.828 2.828zm-12.172-8c3.859 0 7-3.14 7-7s-3.141-7-7-7-7 3.14-7 7 3.141 7 7 7z"/></svg></button>
            </form>    
          </div>
          
          <div class="w-1/4 h-12">                                                                                    
            <Link
            :href="route('subjects.create')" 
            class="float-right text-sm font-medium text-gray-900 mx-2 inline-flex items-center h-10 px-5 text-indigo-100 transition-colors duration-150 bg-blue-500 rounded-lg focus:shadow-outline hover:bg-blue-600 active:bg-blue-700 focus:ring-blue-300"
            type="button"> 
            <svg class="float-left fill-current w-4 h-4 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"/></svg>
            Asignatura
            </Link>
            <button
            class="float-right text-sm font-medium text-gray-900 mx-2 inline-flex items-center h-10 px-5 text-indigo-100 transition-colors duration-150 bg-blue-500 rounded-lg focus:shadow-outline hover:bg-blue-600 active:bg-blue-700 focus:ring-blue-300"
            @click="modalMasive=true">
            <svg class="float-left fill-current w-4 h-4 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"/></svg>
            Masiva
            </button>
           
            
            
          </div>
        </div>   

          <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
              <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                  <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                      <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asignatura</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Disponibilidad</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prerequisito</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Malla</th>
                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">Editar</span></th>
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                      <tr v-for="subject in subjects" :key="subject.id">
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="flex items-center">
                            <div class="ml-4">
                              <div class="text-sm font-medium text-gray-900">{{subject.name}}</div>
                              <div class="text-sm text-gray-500">{{subject.department}}</div>
                            </div>
                          </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="text-sm text-gray-900">{{subject.total_hour}} Hrs</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="text-sm text-gray-900"  v-if="subject.requisite=='0'"> Sin Prerequisito</div>
                          <div v-for="subject2 in subjects"  :key="subject2.id">
                            <div class="text-sm text-gray-900"  v-if="subject.requisite == subject2.id">{{subject2.name}}</div>
                          </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="text-sm text-gray-900">{{subject.curriculums.name}}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button
                            class="m-px px-4 py-2 rounded-md text-sm font-medium border-0 focus:outline-none focus:ring transition text-white bg-blue-500 hover:bg-blue-600 active:bg-blue-700 focus:ring-blue-300"
                            @click="modalUpdate=true;selectedSubject=subject">
                            Modificar
                            </button>
                            <button
                            class="m-px px-4 py-2 rounded-md text-sm font-medium border-0 focus:outline-none focus:ring transition text-white bg-gray-500 hover:bg-gray-600 active:bg-gray-700 focus:ring-gray-300"
                            @click="modalDelete=true;selectedSubject=subject">
                            Deshabilitar
                            </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

      </div>
    </div> 

    <jet-dialog-modal :show="modalMasive">
      <template v-slot:title>
        <h1>Add Masive Subjects</h1>
      </template>
      <template v-slot:content>

         <a @click="save()" class="bg-blue-500">Export DataBase To xlsx</a>

          <label for="avatar">Choose a profile picture:</label>
        <form @submit.prevent="submit">
            <input type="file" @input="form2.file = $event.target.files[0]" /> 
            <button @click="submit2()">Submit</button>
            <button @click="exit()">Exit</button>
        </form>
        
      </template>
      <template v-slot:footer>
        
      </template>
    </jet-dialog-modal>

    <jet-dialog-modal :show="modalDelete">
      <template v-slot:title>
        <h1>Eliminar Usuario</h1>
      </template>
      <template v-slot:content>
        <h1 v-if="selectedSubject">¿Estas seguro de eliminar la asignatura <strong>{{selectedSubject.name}}</strong>?</h1>
      </template>
      <template v-slot:footer>
        <button
        @click="modalDelete=false" 
        class="px-4 py-2 rounded-md text-sm font-medium border-0 focus:outline-none focus:ring transition text-white bg-blue-500 hover:bg-blue-600 active:bg-blue-700 focus:ring-blue-300"
        >Cerrar
        </button>      
        <button
        @click="deleteSubject()"
        class="px-4 py-2 rounded-md text-sm font-medium border-0 focus:outline-none focus:ring transition text-white bg-gray-500 hover:bg-gray-600 active:bg-gray-700 focus:ring-gray-300"
        >
        Deshabilitar
        </button>
      </template>
    </jet-dialog-modal>

    <jet-dialog-modal :show="modalUpdate">
      <template v-slot:title>
        <h1>Actualizar Usuario</h1>
      </template>
      <template v-slot:content>
        <h1 v-if="selectedSubject">¿Estas seguro de eliminar la asignatura <strong>{{selectedSubject.name}}</strong>?</h1>
      </template>
      <template v-slot:footer>
        <button
        @click="modalUpdate=false" 
        class="px-4 py-2 rounded-md text-sm font-medium border-0 focus:outline-none focus:ring transition text-white bg-blue-500 hover:bg-blue-600 active:bg-blue-700 focus:ring-blue-300"
        >Cerrar
        </button>      
        <button
        @click="updateSubject()"
        class="px-4 py-2 rounded-md text-sm font-medium border-0 focus:outline-none focus:ring transition text-white bg-gray-500 hover:bg-gray-600 active:bg-gray-700 focus:ring-gray-300"
        >
        Actualizar
        </button>
      </template>
    </jet-dialog-modal>
  
  </app-layout>
</template>

<script>
import {Link} from '@inertiajs/inertia-vue3';
import {Inertia} from '@inertiajs/inertia';
import AppLayout from "@/Layouts/AppLayout";
import JetDialogModal from "@/Jetstream/DialogModal";
export default {
    props:{
        subjects: Array,
    },
    data(){
      
      return{
        modalDelete: false,
        modalUpdate: false,
        modalMasive:false,
        selectedSubject: Object,
        form:{
           name: null
        },
        form2:{
           file: null
        }
      }
    },
    components:{
        AppLayout,
        JetDialogModal,
        Link
    },
    methods:{
      submit: function(){
        Inertia.get(route("subjects.index"),this.form);
      },
      updateSubject: function(){
        Inertia.get(route("subjects.edit", {subject: this.selectedSubject} ));
        this.modalUpdate=false;
      },
      deleteSubject: function(){
      //  if(confirm("Seguro que quieres eliminar el usuario: "+ data.name +" ?")) return;
        Inertia.delete(route("subjects.destroy", {subject: this.selectedSubject} ));
        this.modalDelete=false;
      },
      
      exit: function(){
        this.modalMasive = false;
      },
      save: function(){
        Inertia.get(route("subjects.export"))
        this.modalMasive = false;
      },

      submit2: function() {
        
        Inertia.post(route('subjects.import'),{
        _method:'get',
        file: this.form2.file
        });
      },   
    }
};
</script>