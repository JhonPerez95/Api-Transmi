<template>
  <div>
    <div class="my-2">
      <ValidationObserver ref="observer" v-slot="{ handleSubmit }">
        <form ref="form" @submit.prevent="handleSubmit(dataSubmit)" @reset="onReset" v-if="show">
          <b-button type="submit" variant="primary">Generar</b-button>
          <b-button v-on:click="exportReportOfAbandonedBicycles()" class="btn btn-success">Exportar</b-button>
        </form>
      </ValidationObserver>
    </div>

    <div id="tableReportOfAbandonedBicycles">
      <vue-good-table
        :columns="columns"
        :rows="rows"
        :search-options="{ enabled: true }"
        :pagination-options="{ enabled: true }"
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


</template>

<script>

import toastr from "toastr";
import 'vue-select/dist/vue-select.css';
import XLSX from "xlsx";
import FileSaver from 'file-saver' //Importante para exportar

export default {
  data() {
    return {
        show: true,
        form : {
            start: new Date().toISOString(),
            end: new Date().toISOString(),
            biker_document: null,
        },
        rows : [],
        parkingsData : [],
        columns : [

            {
            label : "Bici Estación",
            field : "parking_name",
            },
            {
            label : "Cédula",
            field : "biker_document",
            },
            {
            label : "Visita No.",
            field : "visit_num",
            },
            {
            label : "Fecha ingreso",
            field : "date_input",
            },
            {
            label : "Dias en abandono",
            field : "duration",
            }
        ]
    };
  },
  methods: {
    dataSubmit(event) {
      this.$api.get(`/web/data/reports/visits/abandonedBicies`)
          .then((res) => {
              if (res.status == 200) {
                  //console.log(res.data.response.data);
                this.rows = res.data.response.data;
                if(!this.rows.length){
                    toastr.info('No existen registros actualmente.')
                }
              }else{
                //console.warn({res});
                toastr.success("Error en la petición.");
              }
          }).finally(function() {
              let element = document.getElementById("tableReportOfAbandonedBicycles");
              let wb = XLSX.utils.table_to_book(element);
              localStorage.setItem("tableReportOfAbandonedBicycles", JSON.stringify(wb));
          });
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
    exportReportOfAbandonedBicycles(){
        let wb =  JSON.parse(localStorage.getItem('tableReportOfAbandonedBicycles'));
        let wopts = {
            bookType: 'xlsx',
            bookSST: false,
            type: 'binary'
        };
        let wbout = XLSX.write(wb, wopts);
        FileSaver.saveAs(new Blob([this.s2ab(wbout)], {
            type: "application/octet-stream;charset=utf-8"
        }), "tableReportOfAbandonedBicycles.xlsx");
    },
    s2ab(s) {
      if (typeof ArrayBuffer !== 'undefind') {
          var buf = new ArrayBuffer(s.length);
          var view = new Uint8Array(buf);
          for (var i = 0; i != s.length; ++i) view[i] = s.charCodeAt(i) & 0xFF;
          return buf;
      } else {
          var buf = new Array(s.length);
          for (var i = 0; i != s.length; ++i) buf[i] = s.charCodeAt(i) & 0xFF;
          return buf;
      }
    },
  }
};
</script>
