<template>
<div>  
<table class="min-w-full divide-y divide-gray-200">
  <thead>
    <tr>
      <th scope="col" v-for="column in table_Columns" :key="column.name"><jet-title-label>{{column}}</jet-title-label></th>
   </tr>
  </thead>
  <tbody class="bg-white divide-y divide-gray-200">                      
    <tr v-for="faculty in faculties" :key="faculty.id"> 
      <td class="px-6 py-4 text-center"><jet-label>{{faculty.code}}</jet-label></td>
      <td class="px-6 py-4 text-center"><jet-label>{{faculty.name}}</jet-label></td>
      <td class="px-6 py-4 text-center"><jet-label>{{faculty.email_contact}}</jet-label></td>
      <td class="px-6 py-4 text-center"><jet-label>{{faculty.phone}}</jet-label></td>

      <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
        <jet-button @click="modalShow=true;selectedFaculty=faculty">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M12 19C10.3599 19.0204 8.7367 18.6664 7.254 17.965C6.10469 17.4042 5.07265 16.6297 4.213 15.683C3.30243 14.7041 2.58547 13.5616 2.1 12.316L2 12L2.105 11.684C2.59082 10.4394 3.30624 9.29725 4.214 8.31698C5.07334 7.37029 6.10504 6.59584 7.254 6.03498C8.73671 5.33357 10.3599 4.97959 12 4.99998C13.6401 4.97963 15.2633 5.3336 16.746 6.03498C17.8953 6.59571 18.9274 7.37017 19.787 8.31698C20.6993 9.29453 21.4165 10.4373 21.9 11.684L22 12L21.895 12.316C20.3262 16.3998 16.3742 19.0693 12 19ZM12 6.99998C8.59587 6.89331 5.47142 8.87507 4.117 12C5.4712 15.1251 8.59579 17.1069 12 17C15.4041 17.1064 18.5284 15.1247 19.883 12C18.5304 8.87356 15.4047 6.89106 12 6.99998ZM12 15C10.5573 15.0095 9.30937 13.9973 9.02097 12.5838C8.73256 11.1702 9.48427 9.75 10.8154 9.19364C12.1465 8.63728 13.6852 9.10011 14.4885 10.2985C15.2919 11.4969 15.1354 13.0961 14.115 14.116C13.5563 14.6812 12.7948 14.9995 12 15Z" fill="#E5E7EB"></path>
          </svg>
        </jet-button>
        <jet-button @click="modalUpdate=true;selectedFaculty=faculty">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M4.41999 20.579C4.13948 20.5785 3.87206 20.4603 3.68299 20.253C3.49044 20.0475 3.39476 19.7695 3.41999 19.489L3.66499 16.795L14.983 5.48103L18.52 9.01703L7.20499 20.33L4.51099 20.575C4.47999 20.578 4.44899 20.579 4.41999 20.579ZM19.226 8.31003L15.69 4.77403L17.811 2.65303C17.9986 2.46525 18.2531 2.35974 18.5185 2.35974C18.7839 2.35974 19.0384 2.46525 19.226 2.65303L21.347 4.77403C21.5348 4.9616 21.6403 5.21612 21.6403 5.48153C21.6403 5.74694 21.5348 6.00146 21.347 6.18903L19.227 8.30903L19.226 8.31003Z" fill="#E5E7EB"></path>
          </svg>
        </jet-button>
        <jet-modify-button @click="modalDelete=true;selectedFaculty=faculty">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M17 22H7C5.89543 22 5 21.1046 5 20V7H3V5H7V4C7 2.89543 7.89543 2 9 2H15C16.1046 2 17 2.89543 17 4V5H21V7H19V20C19 21.1046 18.1046 22 17 22ZM7 7V20H17V7H7ZM9 4V5H15V4H9ZM15 18H13V9H15V18ZM11 18H9V9H11V18Z" fill="#E5E7EB"></path>
          </svg>
        </jet-modify-button>
      </td>
    </tr>
  </tbody>
</table>
</div>

<jet-dialog-modal :show="modalShow">
      <template v-slot:content>
        <div class="text-center p-5 flex-auto justify-center">
          <svg class="w-16 h-16 flex items-center text-blue-500 mx-auto" viewBox="0 0 24 24" fill="none">
            <path d="M20 21H4C3.44772 21 3 20.5523 3 20V12.7C3 12.4119 3.12432 12.1378 3.341 11.948L5 10.5V4C5 3.44772 5.44772 3 6 3H20C20.5523 3 21 3.44772 21 4V20C21 20.5523 20.5523 21 20 21ZM9 7.329C9.24212 7.32928 9.47592 7.4174 9.658 7.577L14.658 11.952C14.874 12.1407 14.9986 12.4132 15 12.7V19H19V5H7V8.75L8.341 7.576C8.52348 7.41654 8.75766 7.32876 9 7.329ZM8 16H10V19H13V13.157L9 9.657L5 13.157V19H8V16Z" fill="#2E3A59"></path>
          </svg>

          <h2 class="text-xl font-bold py-4" v-if="selectedFaculty"><strong> Facultad de {{selectedFaculty.name}}</strong></h2>
          <p class="text-sm text-gray-500 px-8"> ¿Estas seguro de querer ir a ver sus departamentos?</p>   

        </div>
      </template>
      <template v-slot:footer class="p-3  mt-2 text-center space-x-4 md:block">
        <jet-modify-button @click="modalShow=false">Cerrar</jet-modify-button>
        <jet-danger-button @click="showFacultyDepartments()">Ir a Deptos</jet-danger-button>    
      </template>
    </jet-dialog-modal>

    <jet-dialog-modal :show="modalDelete">
      <template v-slot:content>
        <div class="text-center p-5 flex-auto justify-center">
          <svg class="w-4 h-4 -m-1 flex items-center text-blue-500 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          <svg class="w-16 h-16 flex items-center text-blue-500 mx-auto" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
          </svg>
          <h2 class="text-xl font-bold py-4" v-if="selectedFaculty"><strong> Facultad de {{selectedFaculty.name}}</strong></h2>
          <p class="text-sm text-gray-500 px-8">¿Estas seguro de querer eliminar este elemento?</p>    
        </div>
      </template>
      <template v-slot:footer class="p-3  mt-2 text-center space-x-4 md:block">
        <jet-modify-button @click="modalDelete=false">Cerrar</jet-modify-button>
        <jet-danger-button @click="deleteFaculty()">Dehabilitar</jet-danger-button>    
      </template>
    </jet-dialog-modal>

    <jet-dialog-modal :show="modalUpdate">
      <template v-slot:content>
        <div class="text-center p-5 flex-auto justify-center">
          <svg class="w-4 h-4 -m-1 flex items-center text-blue-500 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          <svg class="w-16 h-16 flex items-center text-blue-500 mx-auto" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
          </svg>
          <h2 class="text-xl font-bold py-4" v-if="selectedFaculty"><strong> Facultad de {{selectedFaculty.name}}</strong></h2>
          <p class="text-sm text-gray-500 px-8">¿Estas seguro de querer Actualizar este elemento?</p>    
        </div>
      </template>
      <template v-slot:footer class="p-3  mt-2 text-center space-x-4 md:block">
        <jet-modify-button @click="modalUpdate=false">Cerrar</jet-modify-button>
        <jet-danger-button @click="updateFaculty()"> Modificar</jet-danger-button>   
      </template>
    </jet-dialog-modal>

</template>

<script>
import JetInput from "@/Jetstream/Input";
import JetLabel from "@/Jetstream/Label";
import JetButton from "@/Jetstream/Button";
import JetModifyButton from "@/Jetstream/ModifyButton";
import JetDangerButton from "@/Jetstream/ButtonDanger";
import JetTitleLabel from "@/Jetstream/TitleLabel";
import JetDialogModal from "@/Jetstream/DialogModal";

import { defineComponent } from 'vue'


export default defineComponent({

  props:{faculties: Array, table_Columns: Array,  },

  data(){
    return{ modalShow: false, modalDelete: false, modalUpdate: false,

    }
    
  },

  components:{ JetInput, JetLabel, JetTitleLabel, JetDialogModal,
               JetButton, JetModifyButton, JetDangerButton
  }

})
</script>