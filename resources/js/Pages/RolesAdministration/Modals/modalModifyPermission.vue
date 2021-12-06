<template>
   <modal :show="show" :max-width="maxWidth" :closeable="closeable" @close="close">
      <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
              <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                  <h3 class="text-lg">
                      <div class="border-b p-2 pb-3 pt-0 mb-4">
                          <div class="flex justify-between items-center"><jet-label>Crear Rol</jet-label></div>
                      </div>
                  </h3>

                  <form @submit.prevent="submit">
                      <div class="lg:col-span-2">
                          <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                             <div class="md:col-span-5">
                                <jet-label>Rol</jet-label>
                                <select v-model="selectedRole" @change="onChange(this.value)" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50">  
                                  <option value="" disabled>Seleccione un Rol</option>
                                  <option v-for="role in roles" :key="role.id" v-bind:value="role" >{{role.name}}</option>
                                </select>
                             </div>                  
                          </div>
                          
                          <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5 py-3">
                             <div class="md:col-span-5">
                                    <jet-label>Permisos</jet-label>
                                    <div v-for="permission in permissions" :key="permission.id" >    
                                        <input @change="addpermissions()" type="checkbox" v-bind:value="permission.id" v-model="form.cpermissions"/>
                                        <jet-label class="px-3" v-bind:for="permission.id">{{permission.description}}</jet-label>
                                    </div>    
                              </div>                  
                          </div>    
                      </div> 
                  </form>
              </div>
          </div>
      </div>

      <div class="px-6 py-4 bg-gray-100 text-right">
          <jet-button @click="createRoleandPermissions()"> Guardar </jet-button>
          <jet-button @click="close()" >Cerrar</jet-button>
      </div>
  </modal>
</template>

<script>
    import { defineComponent } from 'vue';
    import {Inertia} from '@inertiajs/inertia';
    import Modal from '@/Jetstream/Modal.vue';
    import JetLabel from "@/Jetstream/Label";
    import JetButton from "@/Jetstream/Button";
    import JetModifyButton from "@/Jetstream/ModifyButton";

    export default defineComponent({
        emits: ['close'],
        
        mounted(){
            axios.get(route('roles.getRoles')).then((response) =>{ this.roles = response.data;});
            axios.get(route('permissions.getPermissions')).then((response) =>{ this.permissions = response.data;});
        },

        data(){
             
            return{
                form: { name: null, cpermissions: [] }, permission: Array, selectedRole: Object,
            }
        },   
           
        components: {
            Modal, JetLabel, JetButton, JetModifyButton
        },

        props: {
            show: { default: false}, maxWidth: { default: '2xl'}, closeable: { default: true},
        },

        methods: {
            close: function(){this.$emit('close')},

            loadPermissions: function(data){
                 console.log(this.selectedRole);
                axios.get(route('rolesandpermissions.getRolePermissions', {params:{role: this.selectedRole} })).then((response) =>{
                  this.permissions = response.data
                  console.log(response.data);})
                },

            addpermissions: function(){ this.form.cpermissions.push(); console.log(this.form.cpermissions)},
            onChange: function(event){console.log(this.selectedRole);
             axios.get(route('rolesandpermissions.getRolePermissions', {params:{role: this.selectedRole} })).then((response) =>{
                  this.permissions = response.data
                  console.log(response.data)})},
            createRoleandPermissions: function(){ Inertia.post(route('rolesandpermissions.store'), this.form);} ,

        },
    
    })
</script>
