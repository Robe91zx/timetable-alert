<template>
    <app-layout>
        <template #header>
            <h2>Modificar Curso</h2>
        </template>    

    <form @submit.prevent="submit">
        {{this.form}}
        <div class="min-h-screen p-6 bg-gray-100 flex items-center justify-center">
            <div class="container max-w-screen-lg mx-auto">
                <div>
                    <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
                        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                            <div class="text-gray-600">
                                <p class="font-medium text-lg">Actualizar Curso</p>
                                <p>Por favor, llene todos los campos solicitados.</p>
                            </div>

                            <div class="lg:col-span-2">
                                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                                    <div class="md:col-span-5">
                                    <label for="semester">Semestre</label>
                                    <select
                                    class="appearance-none h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                    v-model="form.semester"
                                    >
                                        <option class="appearance-none h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="1">Primer Semestre</option>
                                        <option class="appearance-none h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="2">Segundo Semestre</option>
                                        </select>
                                    
                                    </div>

                                    <div class="md:col-span-5">
                                    <label for="description">Profesor Encargado</label>
                                    <input 
                                    v-model= "form.description"
                                    class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                    placeholder="Ingrese la Descripcion"
                                    />
                                    </div>
                              

                                    <div class="md:col-span-5">
                                    <label for="subject_id">Asignatura</label>
                                    <select
                                    class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                    v-model="form.subject_id"
                                    >
                                    <option class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="0">Sin Asignatura Equivalente</option>
                                    <!--<option class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" v-for="subject in subjects" v-bind:key="subject.id" v-bind:value="subject.id">{{subject.name}}</option>
                                    --></select>
                                    </div>

                                    <div class="md:col-span-5">
                                    <label for="group">Grupo</label>
                                    <input 
                                    v-model= "form.group" 
                                    class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                    />
                                    </div>
                                
                                    <div class="md:col-span-5 text-right">
                                    <div class="inline-flex items-end">
                                        <Link
                                            :href="route('courses.index')"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                            type="button">
                                            Cancelar
                                        </Link>
                                        <button
                                            type="submit"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                            Guardar
                                        </button>
                                    </div>
                                    </div>
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



export default {
    components:{
        AppLayout,
        Link
    },
    props: ["course"],
    data(){
        return{    
            form:{
                state: this.$props.course.state,
                semester: this.$props.course.semester,
                hours: this.$props.course.hours,
                description: this.$props.course.description,
                group : this.$props.course.group,
                subject_id: this.$props.course.subject_id,
                } ,
        };
    },
    methods:{
        submit(){
            this.$inertia.put(
                route('courses.update', this.$props.course.id),
                this.form
            );
        },
    },
};
</script>