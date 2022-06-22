<template>
    <div>
        <div class="my-2">
            <ValidationObserver ref="observer" v-slot="{ handleSubmit }">

                <form
                    ref="formPernoctas"
                    @submit.prevent="handleSubmit(dataSubmit)"

                    @reset="onReset"
                    v-if="show"
                >
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <b-form-group label="Mes" label-for="start-input">
                                <ValidationProvider
                                    name="Mes"
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
                                        :disabledDates="{ from: new Date() }"
                                        format="yyyy-MM"
                                        :full-month-name="true"
                                        required
                                        v-model="formPernoctas.start"
                                        :input-class=" errors[0] ? 'form-control-user form-control is-invalid' : 'form-control-user form-control'"
                                    />

                                    <span class="form-text text-danger">{{ errors[0] }}</span>
                                </ValidationProvider>
                            </b-form-group>
                        </div>
                    </div>

                    <b-button type="submit" variant="primary">Generar</b-button>
                    <b-button type="reset" variant="danger">Reset</b-button>
                    <b-button v-on:click="exportPernoctas()" class="btn btn-success">Exportar</b-button>
                </form>

            </ValidationObserver>
        </div>

        <div id="tablePernoctas"> <!-- Nombre de la tabla para poder obtener la informacióin y exportarla -->
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

</template>

<script>

import toastr from "toastr";
import Datepicker from "vuejs-datepicker";
import { en, es } from "vuejs-datepicker/dist/locale";
import XLSX from "xlsx";
import FileSaver from 'file-saver'; //Importante para exportar

export default {
    components: {
        //Para mostrar el calendario
        Datepicker,
    },
    //Información a mostrar en la tabla
    data() {
        return {
            es,
            show: true,
            formPernoctas: {
                start: new Date().toISOString(),
                end: new Date().toISOString(),
            },
            rows: [],
            columns: [
                {
                    label: "Bici Estación",
                    field: "parking_name",
                },
                {
                    label: "dia 1",
                    field: "1",
                },
                {
                    label: "dia 2",
                    field: "2",
                },
                {
                    label: "dia 3",
                    field: "3",
                },
                {
                    label: "dia 4",
                    field: "4",
                },
                {
                    label: "dia 5",
                    field: "5",
                },
                {
                    label: "dia 6",
                    field: "6",
                },
                {
                    label: "dia 7",
                    field: "7",
                },
                {
                    label: "dia 8",
                    field: "8",
                },
                {
                    label: "dia 9",
                    field: "9",
                },
                {
                    label: "dia 10",
                    field: "10",
                },
                {
                    label: "dia 11",
                    field: "11",
                },
                {
                    label: "dia 12",
                    field: "12",
                },
                {
                    label: "dia 13",
                    field: "13",
                },
                {
                    label: "dia 14",
                    field: "14",
                },{
                    label: "dia 15",
                    field: "15",
                },{
                    label: "dia 16",
                    field: "16",
                },{
                    label: "dia 17",
                    field: "17",
                },{
                    label: "dia 18",
                    field: "18",
                },
                {
                    label: "dia 19",
                    field: "19",
                },
                {
                    label: "dia 20",
                    field: "20",
                },
                {
                    label: "dia 21",
                    field: "21",
                },
                {
                    label: "dia 22",
                    field: "22",
                },
                {
                    label: "dia 23",
                    field: "23",
                },
                {
                    label: "dia 24",
                    field: "24",
                },
                {
                    label: "dia 25",
                    field: "25",
                },
                {
                    label: "dia 26",
                    field: "26",
                },
                {
                    label: "dia 27",
                    field: "27",
                },
                {
                    label: "dia 28",
                    field: "28",
                },
                {
                    label: "dia 29",
                    field: "29",
                },
                {
                    label: "dia 30",
                    field: "30",
                },
                {
                    label: "dia 31",
                    field: "31",
                },
            ],
        };
    },
    //Metodos para el proceso de consulta y reinio del formulario
    methods: {
        dataSubmit(event) {
            let date_input;
            let date_output;

            if (typeof this.formPernoctas.start == "object") {
                date_input = this.formPernoctas.start;
                date_input.setDate(date_input.getDate());
                date_input = date_input.toISOString();
                date_input = date_input.split("T")[0];
            } else {
                date_input = this.formPernoctas.start.split("T")[0];
            }

            let date_month = date_input.substr(5, 2);
            let end_day;

            date_input = date_input.substr(0, 8);
            let date_in = date_input + '01';

            if(date_month == 1 || date_month == 3 || date_month == 5 || date_month == 7 || date_month == 8 || date_month == 10 || date_month == 12 ) {
                date_output = date_input + '31';
                end_day = 31;
            } else if(date_month == 2){
                date_output = date_input + '28';
                end_day = 28;
            } else {
                date_output = date_input + '30';
                end_day = 30;
            }

            this.$api.get(`/web/data/reports/visits/pernoctas?begining_date=${date_in}&end_date=${date_output}&end_day=${end_day}`)
                .then( (res) => {
                    if (res.status == 200) {
                        console.log(res.data);
                        this.rows = res.data.response.data;
                          if(!this.rows.length){
                              toastr.info('No existen pernoctas para la fecha seleccionada.')
                          } else {
                              toastr.info('Organizando la información.')
                              this.rows = res.data.response.data;
                          }
                    } else {
                         console.warn({res});
                         toastr.success("Error en la petición.");
                    }
                }).finally(function() { });
        },
        onReset(event) {
            event.preventDefault();
            // Reset our form values
            this.formPernoctas.start = new Date().toISOString();
            this.formPernoctas.end = new Date().toISOString();
            // Trick to reset/clear native browser form validation state
            this.show = false;
            this.$nextTick(() => {
                this.show = true;
            });
        },
        //Exportar información
        exportPernoctas(){
            var table_elt = document.getElementById("tablePernoctas");
            var workbook = XLSX.utils.table_to_book(table_elt);
            var worksheet = workbook.Sheets["Sheet1"];
            XLSX.writeFile(workbook, "Pernoctas.xlsx");
        },
    }
}

</script>


