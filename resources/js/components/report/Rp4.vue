<template>
  <div>
    <div class="my-2">
      <ValidationObserver ref="observer" v-slot="{ handleSubmit }">
        <form
          ref="form"
          @submit.prevent="handleSubmit(dataSubmit)"
          @reset="onReset"
          v-if="show"
        >
          <div class="row">
            <div class="form-group col">
              <b-form-group label="Fecha Incial" label-for="start-input">
                <ValidationProvider
                  name="Fecha Inicial"
                  rules="required"
                  v-slot="{ errors }"
                >
                  <datepicker
                    ref="startInput"
                    id="start-input"
                    :bootstrap-styling="true"
                    :language="es"
                    :calendar-button="true"
                    calendar-button-icon="fa fa-calendar"
                    format="yyyy MMM dd"
                    :full-month-name="true"
                    required
                    v-model="form.start"
                    :input-class=" errors[0] ? 'form-control-user form-control is-invalid' : 'form-control-user form-control'"
                  />
                  <span class="form-text text-danger">{{ errors[0] }}</span>
                </ValidationProvider>
              </b-form-group>
            </div>

            <div class="form-group col">
              <b-form-group label="Fecha Final" label-for="end-input">
                <ValidationProvider
                  name="Fecha Final"
                  rules="required"
                  v-slot="{ errors }"
                >
                  <datepicker
                    ref="endtInput"
                    id="end-input"
                    :bootstrap-styling="true"
                    :language="es"
                    :calendar-button="true"
                    calendar-button-icon="fa fa-calendar"
                    format="yyyy MMM dd"
                    :full-month-name="true"
                    required
                    v-model="form.end"
                    :input-class="
                      errors[0]
                        ? 'form-control-user form-control is-invalid'
                        : 'form-control-user form-control'
                    "
                  />
                  <span class="form-text text-danger">{{ errors[0] }}</span>
                </ValidationProvider>
              </b-form-group>
            </div>
            <div class="form-group col">
              <b-form-group label="Cicloparqueadero">
                <ValidationProvider name="cicloparqueadero" v-slot="{ errors }">
                  <v-select
                    multiple
                    v-model="form.biker_document"
                    :options="parkingsData"
                    :reduce="(biker) => biker.id"
                    label="name"
                  />

                  <span class="form-text text-danger">{{ errors[0] }}</span>
                </ValidationProvider>
              </b-form-group>
            </div>
          </div>

          <b-button type="submit" variant="primary">Generar</b-button>
          <b-button type="reset" variant="danger">Reset</b-button>
          <b-button v-on:click="exportDailyIncomeAndOutputReportByCPPerHour()" class="btn btn-success">Exportar</b-button>
        </form>
      </ValidationObserver>
    </div>

    <div id="tableDailyIncomeAndOutputReportByCPPerHour">
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
import "vue-select/dist/vue-select.css";
import Datepicker from "vuejs-datepicker";
import { en, es } from "vuejs-datepicker/dist/locale";
import XLSX from "xlsx";
import FileSaver from 'file-saver' //Importante para exportar

export default {
  components: {
    Datepicker,
  },
  data() {
    return {
      show: true,
      es,
      form: {
        start: new Date().toISOString(),
        end: new Date().toISOString(),
        biker_document: null,
      },
      rows: [],
      parkingsData: [],
      columns: [
        {
          label: "Ciclo Parqueadero",
          field: "parking_name",
        },
        {
          label: "Fecha",
          field: "date_input",
        },
        {
          label: "Hora",
          field: "time_input",
        },
        {
          label: "Numero de Ingresos",
          field: "in",
        },
        {
          label: "Numero de Salidas",
          field: "out",
        },
      ],
    };
  },
  methods: {
    dataSubmit(event) {
      let date_input;
      if (typeof this.form.start == "object") {
        date_input = this.form.start;
        date_input.setDate(date_input.getDate());
        date_input = date_input.toISOString();
        date_input = date_input.split("T")[0];
      } else {
        date_input = this.form.start.split("T")[0];
      }

      let date_output;
      if (typeof this.form.end == "object") {
        date_output = this.form.end;
        date_output.setDate(date_output.getDate());
        date_output = date_output.toISOString();
        date_output = date_output.split("T")[0];
      } else {
        date_output = this.form.end.split("T")[0];
      }

      let dateStart = new Date(date_input).getTime();
      let dateEnd = new Date(date_output).getTime();

      if (dateStart > dateEnd) {
        return toastr.error(
          "La fecha final no puede ser menor a la fecha inicial"
        );
      }
      const bikerDocument = this.form.biker_document ? `&parkings_id=${this.form.biker_document}` : "";

      this.$api.get(`/web/data/reports/visits/hourlyByDays?begining_date=${date_input}&end_date=${date_output}${bikerDocument}`)
        .then((res) => {
          if (res.status == 200) {
            this.rows = res.data.response.data.map((el) => {
              const parking = this.parkingsData.find(
                (_el) => _el.id == el.parking_id
              );
              el.parking_name = parking ? parking.name : `Error : Bici Estación(${el.parking_id}) no encontrado.`;
              return el;
            });
          } else {
            //console.warn({ res });
            toastr.success("Error en la petición.");
          }
        }).finally(function() {
          let element = document.getElementById("tableDailyIncomeAndOutputReportByCPPerHour");
          let wb = XLSX.utils.table_to_book(element);
          localStorage.setItem("tableDailyIncomeAndOutputReportByCPPerHour", JSON.stringify(wb));
        });
    },
    noLess(date) {
      let p1 = new Date(date);
      p1.setDate(p1.getDate() - 1);
      p1 = p1.toISOString();
      const _date = p1.split("T")[0];

      let date_input;
      if (typeof this.form.start == "object") {
        date_input = this.form.start;
        date_input.setDate(date_input.getDate() - 1);
        date_input = date_input.toISOString();
        date_input = date_input.split("T")[0];
      } else {
        date_input = this.form.start.split("T")[0];
        date_input = new Date(date_input);
        date_input.setDate(date_input.getDate() - 1);
        date_input = date_input.toISOString();
        date_input = date_input.split("T")[0];
      }

      console.log(_date, date_input);
      return _date < date_input;
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
    getData() {
      this.$api.get("web/data/parking").then((res) => {
        if (res.status == 200) {
          this.parkingsData = res.data.response.parkings.map((el) => {
            return el;
          });
        }
      });
    },
    exportDailyIncomeAndOutputReportByCPPerHour(){
        let wb =  JSON.parse(localStorage.getItem('tableDailyIncomeAndOutputReportByCPPerHour'));
        let wopts = {
            bookType: 'xlsx',
            bookSST: false,
            type: 'binary'
        };
        let wbout = XLSX.write(wb, wopts);
        FileSaver.saveAs(new Blob([this.s2ab(wbout)], {
            type: "application/octet-stream;charset=utf-8"
        }), "tableDailyIncomeAndOutputReportByCPPerHour.xlsx");
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
  },
  created: function () {
    this.getData();
  },
};
</script>
