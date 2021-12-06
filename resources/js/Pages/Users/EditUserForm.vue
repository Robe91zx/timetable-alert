<template>
    <app-layout title="Facultades">
        <template #header> 
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Modificar Datos: Facultad de {{faculty.name}}</h2>
        </template>   
        
    <form @submit.prevent="submit">
        <div class="min-h-50 p-6 bg-gray-100 flex items-center justify-center">
           <div class="container max-w-screen-lg mx-auto">
                <div> 
                    <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
                        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                            <div class="text-gray-600">
                            <p class="font-medium text-lg">Detalle</p>
                            <p>Por favor, actualice los campos necesarios.</p>
                            </div>
                            <div class="lg:col-span-2">
                                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                                    <div class="md:col-span-5">
                                    <jet-label>Nombre</jet-label>
                                    <input v-model="form.name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"/>
                                    </div>                  
                                
                                    <div class="md:col-span-2">
                                    <jet-label>Codigo Facultad</jet-label>
                                    <input v-model="form.code" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"/>
                                    </div>
                                
                                    <div class="md:col-span-3">
                                    <jet-label>Email</jet-label>
                                    <input v-model="form.email_contact" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"/>
                                    </div>
                                
                                    <div class="md:col-span-2">
                                    <jet-label>Fono:</jet-label>
                                    <input v-model="form.phone" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"/>
                                    </div>
                                
                                    <div class="md:col-span-3">
                                    <jet-label>Website</jet-label>
                                    <input v-model="form.website"
                                    class="h-10 border mt-1 rounded px-4 w-full bg-gray-50"/>
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
        </div>
    </form>
    </app-layout>
</template>
 

<script>
import AppLayout from "@/Layouts/AppLayout"
import JetInputError from "@/Jetstream/InputError"
import JetLabel from "@/Jetstream/Label"
import JetButton from "@/Jetstream/Button"
import JetModifyButton from "@/Jetstream/ModifyButton"
import JetButtonDanger from "@/Jetstream/ButtonDanger"


export default {
    components:{
        AppLayout,
        JetInputError,
        JetLabel,
        JetButton,
        JetModifyButton,
        JetButtonDanger,
    },
    props:{
        faculty: Object,
        errors: Object,
    },
    data(){
        return{ 
            form:{
                name: this.$props.faculty.name,
                code: this.$props.faculty.code,
                email_contact : this.$props.faculty.email_contact,
                phone: this.$props.faculty.phone,
                website: this.$props.faculty.website
                }   
        }
        
    },
    methods:{
        submit(){
            this.$inertia.put(
                route('faculties.update', this.$props.faculty.id),
                this.form
            );
        },
        clearForm: function(){
            this.form.name = null,
            this.form.code = null,
            this.form.email_contact = null,
            this.form.phone = null,
            this.form.website = null
        },
        
    }
}
</script>