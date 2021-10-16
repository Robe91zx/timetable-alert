<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Mallas
            </h2>
        </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                       <Link
                        :href="route('curriculums.create')" 
                        class="float-right"
                        type="button">
                        Nueva Malla
                        </Link> 
                    </div>


  <!-- This example requires Tailwind CSS v2.0+ -->
  <div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Malla</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Facultad</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                <th scope="col" class="relative px-6 py-3"><span class="sr-only">Editar</span></th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="curriculum in curriculums" :key="curriculum.id">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">{{curriculum.name}}</div>
                      <div class="text-sm text-gray-500" v-if="curriculum.carreer_at == '0'"> Ingenieria Civil en Computacion e Informatica</div>
                      <div class="text-sm text-gray-900"  v-else> Ingenieria Ejecucion en Computacion e Informatica</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900"  v-if="curriculum.faculty == '0'"> ICCI</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800" v-if="curriculum.state == '0'"> No Activa</div>
                  <div class="text-sm text-gray-900 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"  v-else> Activa</div>
                </td>
                
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <Link
                          :href="route('curriculums.edit',curriculum.id)" 
                          class="px-4 py-2 rounded-md text-sm font-medium border-0 focus:outline-none focus:ring transition text-white bg-blue-500 hover:bg-blue-600 active:bg-blue-700 focus:ring-blue-300"
                          type="button">
                          Modificar
                    </Link>
                    <Link
                          method="delete"
                          :href="route('curriculums.destroy',curriculum.id)" 
                          class="px-4 py-2 rounded-md text-sm font-medium border-0 focus:outline-none focus:ring transition text-white bg-gray-500 hover:bg-gray-600 active:bg-gray-700 focus:ring-gray-300"
                          type="button">
                          Deshabilitar
                    </Link>  
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
    </app-layout>
</template>

<script>
import {Link} from '@inertiajs/inertia-vue3'
import AppLayout from "@/Layouts/AppLayout"

export default {
    props:{
        curriculums: Array
    },
    components:{
        AppLayout,
        Link
    }
};
</script>