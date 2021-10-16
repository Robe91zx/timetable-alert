<template>
    <app-layout>
        <template #header>
            <h2>Modificar Malla</h2>
        </template>    

    <form @submit.prevent="submit">
        {{this.form}}
        <div class="min-h-screen p-6 bg-gray-100 flex items-center justify-center">
            <div class="container max-w-screen-lg mx-auto">
                <div>
                    <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
                        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                            <div class="text-gray-600">
                                <p class="font-medium text-lg">Personal Details</p>
                                <p>Please fill out all the fields.</p>
                            </div>

                            <div class="lg:col-span-2">
                                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">

                                    <div class="md:col-span-5">
                                    <label for="name">Nombre</label>
                                    <input 
                                    v-model= "form.name"
                                    class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                    />
                                    </div>
                              
                                    <div class="md:col-span-3">
                                    <label for="faculty">Facultad</label>
                                    <select
                                    class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                    v-model="form.faculty"
                                    >
                                        <option class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="0">ICCI</option>
                                    </select>
                                    </div>

                                    <div class="md:col-span-2">
                                    <label for="carreer_at">Carrera</label>
                                    <select
                                    class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                    v-model="form.carreer_at"
                                    >
                                        <option class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="0">Ingenieria Civil en Computacion e Informatica</option>
                                        <option class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="1">Ingenieria Ejecucion en Computacion e Informatica</option>
                                    </select>
                                    </div>

                                    <div class="md:col-span-2">
                                    <label for="total_hour">Horas Totales</label>
                                    <input 
                                    v-model= "form.total_hour"
                                    class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                    />
                                    </div>

                                    <div class="md:col-span-3">
                                    <label for="state">Estado</label>
                                    <select
                                    class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                    v-model="form.state"
                                    >
                                        <option class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="0">No Activa</option>
                                        <option class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 " value="1">Activa</option>
                                    </select>
                                    </div>
                                
                                    <div class="md:col-span-5 text-right">
                                    <div class="inline-flex items-end">
                                        <Link
                                            :href="route('curriculums.index')"
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
    props: ["curriculum"],
    data(){
        return{    
            form:{
                name: this.$props.curriculum.name,
                faculty: this.$props.curriculum.faculty,
                total_hour: this.$props.curriculum.total_hour,
                carreer_at: this.$props.curriculum.carreer_at,
                state: this.$props.curriculum.state,
                } ,
        };
    },
    methods:{
        submit(){
            this.$inertia.put(
                route('curriculums.update', this.$props.curriculum.id),
                this.form
            );
        },
    },
};
</script>