<template>
    <app-layout title="Facultades y Departamentos">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Crear Relacion Facultad-Departamento</h2>
        </template>    

    <form @submit.prevent="submit">
        <div class="min-h-screen p-6 bg-gray-100 flex items-center justify-center">
            <div class="container max-w-screen-lg mx-auto">
                <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
                    <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                        <div class="text-gray-600">
                            <p class="font-medium text-lg">Detalle de la Asignatura</p>
                            <p>Por favor, llene todos los campos solicitados.</p>
                        </div>
                        <div class="lg:col-span-2">
                            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                                <div class="md:col-span-5">                                
                                    <jet-label>Facultad</jet-label>
                                    <select v-model="form.faculty_id" class="appearance-none h-10 border mt-1 rounded px-4 w-full bg-gray-50">
                                        <option class="appearance-none h-10 border mt-1 rounded px-4 w-full bg-gray-50" disabled selected>Facultad</option>                                                                    
                                        <option class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                        v-for="faculty in faculties" 
                                        v-bind:key="faculty.id" 
                                        v-bind:value="faculty.id"
                                        >{{faculty.name}}
                                        </option>  
                                    </select>
                                </div>                                    
                                <div class="md:col-span-2">
                                    <label for="total_hour">Departamento</label>
                                    <select v-model="form.department_id" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50">
                                        <option class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" disabled selected>Departamento</option>
                                        <option class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                        v-for="department in departments" 
                                        v-bind:key="department.id" 
                                        v-bind:value="department.id"
                                        >{{department.name}}
                                        </option>
                                    </select>
                                </div>   
                                    
                                <div class="md:col-span-5 text-right">                                        
                                    <button
                                    @click="submit()"
                                    class="float-right m-px bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Guardar
                                    </button>
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
import {Link} from '@inertiajs/inertia-vue3'
import AppLayout from "@/Layouts/AppLayout"
import JetInputError from "@/Jetstream/InputError"
import JetLabel from "@/Jetstream/Label";


export default {
    components:{
        AppLayout,
        JetInputError,
        JetLabel,
        Link
    },
    props:{ faculties: Array, departments: Array, errors: Object},

    data(){
        return{ 
            form:{ faculty_id:null, department_id:null}   
        }
    },

    methods:{
        submit(){ this.$inertia.post(route('facultiesanddepartments.store'), this.form);},
    }
}
</script>