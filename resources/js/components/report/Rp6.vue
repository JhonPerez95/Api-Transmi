<template>
  <div>
    <div class="btn btn-warning my-2" @click="stopRefreshing()">Detener refrescado</div>
    <b-button v-on:click="exportWebMapService()" class="btn btn-success">Exportar</b-button>
    <div class="row">
      <div class="col-4">

        <table class="table table-striped">
          <thead>
            <th>Bici Estación</th>
            <th>Código Alfa</th>
            <th>Código Numérico</th>
          </thead>
          <tbody class="table-info">
            <tr v-for="(parking, index) of parkingsData" :key="index" :id="'parking'+parking.code" class="button" @click="dataSubmit(parking.id,parking.code)">
              <td>{{parking.name}}</td>
              <td>{{parking.code}}</td>
              <td>{{parking.id}}</td>
            </tr>
          </tbody>
        </table>

      </div>

      <div class="col-8" id="tableWebMapService">
        <span class="my-2 alert alert-info">Cupos disponibles {{parkingVacancy}}</span>

        <vue-good-table
          :columns="columns"
          :rows="rows"
          :search-options="{ enabled: true }"
          :pagination-options="{
            enabled: true,
            mode: 'records',
            perPage: 100,
            position: 'top',
            perPageDropdown: [100, 500, 1000],
          }"
          :line-numbers="true"
        >
          <div slot="table-actions"></div>
          <template slot="table-row" slot-scope="props">
            <span>
              {{ props.formattedRow[props.column.field] }}
            </span>
          </template>
        </vue-good-table>
      </div>
    </div>
  </div>


</template>

<script>

import toastr from "toastr";
import 'vue-select/dist/vue-select.css';
import XLSX from "xlsx";
import FileSaver from 'file-saver'; //Importante para exportar

export default {
  data() {
    return {
        show: true,
        parkingVacancy : '---',
        timeout : null,
        rows : [],
        parkingsData : [],
        columns : [
            {
            label : "Visita",
            field : "visit_num",
            },
            {
            label : "Cédula",
            field : "biker_document",
            },
            {
            label : "Fecha y hora de ingreso",
            field : "full_date_input",
            },
            {
            label : "Fecha y hora de salida",
            field : "full_date_output",
            },
            {
            label : "Estado",
            field : "status",
            },
            {
            label : "Duración visita",
            field : "duration",
            },
        ]
    };
  },
  methods: {
    stopRefreshing(){
      window.clearTimeout(this.timeout);
      toastr.clear();
      toastr.info('El refrescado se ha detenido.');
    },
    dataSubmit(id, parkingCode) {
      window.clearTimeout(this.timeout);
      this.timeout = setTimeout(() => {
        toastr.clear();
        toastr.info('Refrescando información');
        this.dataSubmit(id, parkingCode);
      }, 15*1000);

      //? Apply selected style
      const elm = document.querySelector(`#parking${parkingCode}`),
        parentElm = elm.parentElement,
        childrenElms = parentElm.children;
      for(let i  = 0; i < childrenElms.length ; i++){
        childrenElms[i].classList.remove('bg-info');
      }
      elm.classList.add('bg-info');

      this.$api.get(`/web/data/reports/visits/webMapService?parkings_id=${id}`).then((res) => {
              //console.log(res);
              if (res.status == 200) {
                this.rows = res.data.response.data.map(el => {
                  el.full_date_input = `${el.date_input} ${el.time_input}`;
                  el.full_date_output = (el.date_output)? `${el.date_output} ${el.time_output}` : '';
                  el.status = el.date_output ?  'Cerrada' : 'Activa';
                  return el;
                });
                this.parkingVacancy = res.data.response.vacancy;
                if(!this.rows.length){
                    toastr.info('No existen registros actualmente.')
                }
              } else {
                //console.warn({res});
                toastr.success("Error en la petición.");
              }
          }).finally(function() { });
    },
    noLess(ymd, date){
      const p1 = date.toISOString(),
        _date = p1.split('T')[0];
      return _date < this.form.start;
    },
    onReset(event) {
      event.preventDefault();
      // Reset our form values
        this.form.start = new Date().toISOString();
        this.form.end = new Date().toISOString();
      // Trick to reset/clear native browser form validation state
      this.show = false;
      this.$nextTick(() => {
        this.show = true;
      });

    },
    getData(){
        this.$api.get("web/data/parking").then((res) => {
        if(res.status == 200){
            this.parkingsData = res.data.response.parkings.map(el => { return el; } );
        }
      });
    },
    exportWebMapService(){
        var table_elt = document.getElementById("tableWebMapService");
        var workbook = XLSX.utils.table_to_book(table_elt);
        var worksheet = workbook.Sheets["Sheet1"];
        XLSX.writeFile(workbook, "tableWebMapService.xlsx");
    },
  },
  created :function(){
      this.getData();
  }
};

</script>
