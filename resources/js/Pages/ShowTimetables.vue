<template>
  <app-layout title="Dashboard">
        <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Prototipos de Horarios
        </h2>
        </template>

 <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <table class="table table-bordered text-center min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Recursos</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Elementos</th>
                </tr>
            </thead>  
            <tbody>     
                <tr>
                    <td class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Cursos</td>
                    <draggable class="list-group" v-model="courses" group="items" item-key="id" @change="log">
                        <template #item="{element, index}"> 
                        <td class="p-2 pl-5 pr-5 bg-transparent border-2 border-blue-500 text-gray-500 text-sm rounded-lg hover:bg-blue-500 hover:text-gray-100 focus:border-4 focus:border-blue-300"> {{index}} - {{element.subjects.name}} </td>
                        </template>
                    </draggable>
                    
                </tr>
                <tr>
                    <td class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Ayudantias</td>    
                    <draggable class="list-group" v-model="workshops" group="items" item-key="id" @change="log">
                        <template #item="{element, index}">
                        <td class="p-2 pl-5 pr-5 bg-transparent border-2 border-green-500 text-gray-500 text-sm rounded-lg hover:bg-green-500 hover:text-gray-100 focus:border-4 focus:border-green-300"> {{index}} - {{element.name}} </td>
                        </template>
                    </draggable>
                </tr>
                <tr>    
                    <td class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Laboratorios</td>
                    <draggable class="list-group" v-model="laboratories" group="items" item-key="id" @change="log">
                        <template #item="{element, index}">
                        <td class="p-2 pl-5 pr-5 bg-transparent border-2 border-yellow-500 text-gray-500 text-sm rounded-lg hover:bg-yellow-500 hover:text-gray-100 focus:border-4 focus:border-yellow-300"> {{index}} - {{element.name}} </td>
                        </template>
                    </draggable>
                </tr>     
            </tbody>
        </table>

     <div class="container">
        <div class="table-responsive">
            <table class="table table-bordered text-center min-w-full divide-y divide-gray-200">
                <thead class="grid-cols-7 bg-gray-50">
                    <tr class="bg-light-gray">
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                        v-for="day in weekdays" :key="day.name">   {{day}}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="align-middle">1-2</td>
                        <td>
                            <draggable class="list-group" :list="list1" group="items" @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                        <td>
                            <draggable class="list-group" :list="list2" group="items" @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                        <td>
                            <draggable class="list-group" :list="list3" group="items" @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                        <td>
                            <draggable class="list-group" :list="list4" group="items" @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                        <td>
                            <draggable class="list-group" :list="list5" group="items" @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                        <td>
                            <draggable class="list-group" :list="list6" group="items" @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                    </tr>    
                    <tr><td class="align-middle">3-4</td> 
                        <td>
                            <draggable class="list-group" :list="list7" group="items" @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                        <td>
                            <draggable class="list-group" :list="list8" group="items" @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                        <td>
                            <draggable class="list-group" :list="list9" group="items" @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                        <td>
                            <draggable class="list-group" :list="list10" group="items"  @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                        <td>
                            <draggable class="list-group" :list="list11" group="items"  @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                        <td>
                            <draggable class="list-group" :list="list12" group="items"  @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                    </tr>
                    <tr><td class="align-middle">5-6</td>
                        <td>
                            <draggable class="list-group" :list="list13" group="items"  @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                        <td>
                            <draggable class="list-group" :list="list14" group="items"  @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                        <td>
                            <draggable class="list-group" :list="list15" group="items"  @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                        <td>
                            <draggable class="list-group" :list="list16" group="items"  @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                        <td>
                            <draggable class="list-group" :list="list17" group="items"  @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                        <td>
                            <draggable class="list-group" :list="list18" group="items"  @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                    </tr>
                    <tr><td class="align-middle">7-8</td>
                        <td>
                            <draggable class="list-group" :list="list19" group="items"  @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                        <td>
                            <draggable class="list-group" :list="list20" group="items"  @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                        <td>
                            <draggable class="list-group" :list="list21" group="items"  @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                        <td>
                            <draggable class="list-group" :list="list22" group="items"  @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                        <td>
                            <draggable class="list-group" :list="list23" group="items"  @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                        <td>
                            <draggable class="list-group" :list="list24" group="items"  @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                    </tr>
                    <tr><td class="align-middle">9-10</td>
                        <td>
                            <draggable class="list-group" :list="list25" group="items"  @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                        <td>
                            <draggable class="list-group" :list="list26" group="items"  @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                        <td>
                            <draggable class="list-group" :list="list27" group="items"  @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                        <td>
                            <draggable class="list-group" :list="list28" group="items"  @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                        <td>
                            <draggable class="list-group" :list="list29" group="items"  @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                        <td>
                            <draggable class="list-group" :list="list30" group="items"  @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                    </tr>
                    <tr><td class="align-middle">11-12</td>
                        <td>
                            <draggable class="list-group" :list="list31" group="items"  @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                        <td>
                            <draggable class="list-group" :list="list32" group="items"  @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                        <td>
                            <draggable class="list-group" :list="list33" group="items"  @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                        <td>
                            <draggable class="list-group" :list="list34" group="items"  @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                        <td>
                            <draggable class="list-group" :list="list35" group="items"  @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                        <td>
                            <draggable class="list-group" :list="list36" group="items"  @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                    </tr>
                    <tr><td class="align-middle">13-14</td>
                        <td>
                            <draggable class="list-group" :list="list37" group="items"  @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                        <td>
                            <draggable class="list-group" :list="list38" group="items"  @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                        <td>
                            <draggable class="list-group" :list="list39" group="items"  @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                        <td>
                            <draggable class="list-group" :list="list40" group="items"  @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                        <td>
                            <draggable class="list-group" :list="list41" group="items" @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                        <td>
                            <draggable class="list-group" :list="list42" group="items"  @change="log" itemKey="name">
                            <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                            </template>
                            </draggable>
                        </td>
                    </tr>
                    
                </tbody>
            </table>    
        </div>
    </div>
      </div>
    </div>
  </app-layout>
</template>

<script>

import draggable from "vuedraggable";
import AppLayout from "@/Layouts/AppLayout";

export default {
  name: "table-column-example",
  display: "Table Column",
  order: 9,
  components: {
    draggable,
    AppLayout
  },
  props:{
    courses: Array,
    laboratories: Array,
    workshops: Array,
    weekdays: Array
  },
  data() {
    return {
      list1:[], list2:[], list3:[], list4:[],
      list5:[], list6:[], list7:[], list8:[],
      list9:[], list10:[], list11:[], list12:[],
      list13:[], list14:[], list15:[], list16:[],
      list17:[], list18:[], list19:[], list20:[],
      list21:[], list22:[], list23:[], list24:[],
      list25:[], list26:[], list27:[], list28:[],
      list29:[], list30:[], list31:[], list32:[],
      list33:[], list34:[], list35:[], list36:[],
      list37:[], list38:[], list39:[], list40:[],
      list41:[], list42: [],
      dragging: false
    };
    
  },
  methods: {
    add: function() {
      this.list.push({ name: "Juan" });
    },
    replace: function() {
      this.list = [{ name: "Edgard" }];
    },
    clone: function(el) {
      return {
        name: el.name + " cloned"
      };
    },
    log: function(evt) { 
      window.console.log(evt);
    }
  }
};
</script>
<style scoped>
.buttons {
  margin-top: 35px;
}

body{
    margin-top:20px;
}
.bg-light-gray {
    background-color: #f7f7f7;
}
.table-bordered thead td, .table-bordered thead th {
    border-bottom-width: 2px;
}
.table thead th {
    vertical-align: bottom;
    border-bottom: 2px solid #dee2e6;
}
.table-bordered td, .table-bordered th {
    border: 1px solid #dee2e6;
}


.bg-sky.box-shadow {
    box-shadow: 0px 5px 0px 0px #00a2a7
}

.bg-orange.box-shadow {
    box-shadow: 0px 5px 0px 0px #af4305
}

.bg-green.box-shadow {
    box-shadow: 0px 5px 0px 0px #4ca520
}

.bg-yellow.box-shadow {
    box-shadow: 0px 5px 0px 0px #dcbf02
}

.bg-pink.box-shadow {
    box-shadow: 0px 5px 0px 0px #e82d8b
}

.bg-purple.box-shadow {
    box-shadow: 0px 5px 0px 0px #8343e8
}

.bg-lightred.box-shadow {
    box-shadow: 0px 5px 0px 0px #d84213
}


.bg-sky {
    background-color: #02c2c7
}

.bg-orange {
    background-color: #e95601
}

.bg-green {
    background-color: #5bbd2a
}

.bg-yellow {
    background-color: #f0d001
}

.bg-pink {
    background-color: #ff48a4
}

.bg-purple {
    background-color: #9d60ff
}

.bg-lightred {
    background-color: #ff5722
}

.padding-15px-lr {
    padding-left: 15px;
    padding-right: 15px;
}
.padding-5px-tb {
    padding-top: 5px;
    padding-bottom: 5px;
}
.margin-10px-bottom {
    margin-bottom: 10px;
}
.border-radius-5 {
    border-radius: 5px;
}

.margin-10px-top {
    margin-top: 10px;
}
.font-size14 {
    font-size: 14px;
}

.text-light-gray {
    color: #d6d5d5;
}
.font-size13 {
    font-size: 13px;
}

.table-bordered td, .table-bordered th {
    border: 1px solid #dee2e6;
}
.table td, .table th {
    padding: .75rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}
</style>