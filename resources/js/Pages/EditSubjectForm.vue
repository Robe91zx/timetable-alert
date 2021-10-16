<template>
    <app-layout>
        <template #header>
            <h2>Crear Asignatura</h2>
        </template>    

    <form @submit.prevent="submit">
        {{this.form}}
        <!--{{errors}}-->

        <div class="min-h-screen p-6 bg-gray-100 flex items-center justify-center">
            <div class="container max-w-screen-lg mx-auto">
                <div>
                    <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
                        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                            <div class="text-gray-600">
                                <p class="font-medium text-lg">Actualizar Asignatura</p>
                                <p>Por favor, llene todos los campos solicitados.</p>
                            </div>

                            <div class="lg:col-span-2">
                                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                                    <div class="md:col-span-5">
                                    
                                    <label for="curriculum_id">Malla</label>
                                    <select
                                    @click="loadCurriculums();otherCurriculums();loadSubjects()"
                                    class="appearance-none h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                    v-model="form.curriculum_id"
                                    > Holi pechocho
                                    <option class="appearance-none h-10 border mt-1 rounded px-4 w-full bg-gray-50">¿A que malla pertenece la asignatura?</option>                                                                    
                                    <option 
                                    class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                    v-for="curriculum in curriculums" 
                                    v-bind:key="curriculum.id" 
                                    v-bind:value="curriculum.id"
                                    >{{curriculum.name}}
                                    </option>  

                                    </select>
                                    <!--<div v-if="errors.curriculum_id">{{errors.curriculum_id}}</div>-->
                                    <jet-input-error :message="errors.curriculum_id" />
                                    </div>                                    

                                    <div class="md:col-span-5">
                                    <label for="name">Nombre Asignatura</label>
                                    <input 
                                    id="name"
                                    v-model= "form.name"
                                    class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                    placeholder="Ingrese Nombre Asignatura"
                                    />
                                    <jet-input-error :message="errors.name" />
                                    </div>
                                    
                                    <div class="md:col-span-3">
                                    <label for="description">Descripcion</label>
                                    <input 
                                    id="description"
                                    v-model= "form.description"
                                    class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                    placeholder="Ingrese Descripcion"
                                    />
                                    <jet-input-error :message="errors.description" />
                                    </div>
                                    
                                    <div class="md:col-span-2">
                                    <label for="department">Departamento</label>
                                    <input 
                                    id="department"
                                    v-model= "form.department"
                                    class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                    placeholder="Ingrese Departamento "
                                    />
                                    <jet-input-error :message="errors.department" />
                                    </div>

                                    <div class="md:col-span-2">
                                    <label for="total_hour">Horas Academicas</label>
                                    <select
                                    class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                    v-model="form.total_hour"
                                    >
                                    <option class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="4">4 Hrs</option>
                                    <option class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="6">6 Hrs</option>
                                    </select>
                                    <jet-input-error :message="errors.total_hour" />
                                    </div>   

                                    <div class="md:col-span-3">
                                    <label>Pre Requisito</label>
                                    <select
                                    @change ="loadSubjects()"
                                    class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                    placeholder="requisite"
                                    v-model="form.requisite"
                                    >
                                    <option class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="0">Sin Prerequisito</option>
                                    <option class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" 
                                    v-for="subject in subjects" 
                                    v-bind:key="subject.id" 
                                    v-bind:value="subject.id">{{subject.name}}</option>
                                    </select>
                                    <jet-input-error :message="errors.requisite" />
                                    </div>

                                    <div class="md:col-span-1">
                                    <label for="workshop">Ayudantia</label>
                                    <select
                                    class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                    v-model="form.workshop"
                                    >
                                    <option class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="0">No</option>
                                    <option class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="1">Si</option>
                                    </select>
                                    <jet-input-error :message="errors.workshop" />
                                    </div>
                                    
                                    <div class="md:col-span-1">
                                    <label for="laboratory">Laboratorio</label>
                                    <select
                                    class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                    v-model="form.laboratory"
                                    >
                                    <option class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="0">No</option>
                                    <option class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="1">Si</option>
                                    </select>
                                    <jet-input-error :message="errors.laboratory" />
                                    </div>

                                    <div class="md:col-span-3">
                                    <label>Equivalencia</label>
                                    <select
                                    @change ="loadSubjects2()"
                                    class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                    placeholder="Malla"
                                    v-model="other_curriculums"
                                    >
                                    <option class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="0">Sin equivalencia</option>
                                    <option class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" 
                                    v-for="othercurriculum in othercurriculums" 
                                    v-bind:key="othercurriculum.id" 
                                    v-bind:value="othercurriculum.id">{{othercurriculum.name}}</option>
                                    </select>

                                    <select
                                    class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"
                                    v-model="form.equivalence"
                                    placeholder="Asignatura"
                                    >
                                    <option class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="0">Sin equivalencia</option>
                                    <option class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" 
                                    v-for="subject in subjects2" 
                                    v-bind:key="subject.id" v-bind:value="subject.id">{{subject.name}}</option>
                                    </select>
                                    <jet-input-error :message="errors.equivalence" />
                                    </div>
                                    
                                    <div class="md:col-span-5 text-right">
                                    <div>
                                    
                                    <Link
                                    class="float-left cursor-pointer m-px"
                                    @click="clearForm()"
                                    preverse-scroll
                                    >
                                    Restaurar
                                    </Link>

                                    <Link
                                    :href="route('subjects.index')"
                                    class="float-right m-px bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                    type="button">
                                    Cancelar
                                    </Link>
                                    
                                    <button
                                    type="submit"
                                    href="#"
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
            </div>
        </div>
    </form>

    </app-layout>
</template>

<script>
import {Link} from '@inertiajs/inertia-vue3'
import AppLayout from "@/Layouts/AppLayout"
import JetInputError from "@/Jetstream/InputError"


export default {
    components:{
        AppLayout,
        JetInputError,
        Link
    },
    props:{
        subject:Array,
        errors: Object,
    },
    data(){
        
        return{ 
            curriculums: Array,
            subjects: Array,
            subjects2: Array,
            othercurriculums: Array,

            form:{
                name: this.$props.subject.name,
                description: this.$props.subject.description,
                department : this.$props.subject.department,
                total_hour: this.$props.subject.total_hour,
                requisite: this.$props.subject.requisite,
                state: this.$props.subject.state,
                workshop: this.$props.subject.workshop,
                laboratory: this.$props.subject.laboratory,
                equivalence: this.$props.subject.equivalence,
                curriculum_id: this.$props.subject.curriculum_id
                }   
        }
        
    },
    methods:{
        submit(){
            this.$inertia.put(
                route('subjects.update', this.$props.subject.id),
                this.form
            );
        },
        clearForm: function(){
            this.form.name = null,
            this.form.description = null,
            this.form.department = null,
            this.form.total_hour = null,
            this.form.requisite = null,
            this.form.state = '1',
            this.form.workshop = null,
            this.form.laboratory = null,
            this.form.equivalence = null,
            this.form.curriculum_id = null
        },
        loadCurriculums(){
            axios.get(route('curriculums.getCurriculums')).then((response) =>{
                this.curriculums = response.data;
                console.log("load curriculums"); 
            });  
        },
        otherCurriculums(){
            axios.get(route('curriculums.otherCurriculums'),{params:{curriculum_id: this.form.curriculum_id} }).then((response) =>{
                this.othercurriculums = response.data;
                //console.log(this.form.curriculum_id)
                //console.log(this.othercurriculums)
                console.log("other curriculums");
            });
        },
        loadSubjects(){
            axios.get(route('subjects.getSubjects'),{params:{curriculum_id: this.form.curriculum_id} }).then((response) =>{
                this.subjects = response.data;
                console.log("load subjects");
            });  
        },
        loadSubjects2(){
            axios.get(route('subjects.getSubjects'),{params:{curriculum_id: this.other_curriculums} }).then((response) =>{
                this.subjects2 = response.data;
                console.log("load subjects 2");
            });
            
        }
        
    }
}
</script>