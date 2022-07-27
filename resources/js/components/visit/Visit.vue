<template>
  <div id="tableVisit">
    <!-- DATATABLE -->
    <vue-good-table
      :columns="columns"
      :rows="rows"
      :search-options="{ enabled: true }"
      :pagination-options="{
          enabled: true,
          mode: 'records',
          position: 'top',
          perPageDropdown: [100, 500, 1000],
      }"
      :line-numbers="true"
    >
      <div slot="table-actions">
        <button v-on:click="addData()" class="btn btn-primary">
          A&ntilde;adir
        </button>
        <button v-on:click="exportVisit()" class="btn btn-success">
          Exportar
        </button>
      </div>
      <template slot="table-row" slot-scope="props">
        <span v-if="props.column.field === 'delete'">
          <button v-on:click="editData(props.row.id)" class="btn btn-warning">
            Editar
          </button>
          <button v-on:click="deleteData(props.row.id)" class="btn btn-danger">
            Eliminar
          </button>
        </span>
        <span v-else class="px-1">
          {{ props.formattedRow[props.column.field] }}
        </span>
      </template>
    </vue-good-table>
    <!-- MODAL -->

    <b-modal
      hide-footer
      id="modal-visit"
      ref="modal"
      size="lg"
      title="Visita"
      @show="resetModal"
      @hidden="resetModal"
      @ok="handleOk"
    >
      <ValidationObserver ref="observer" v-slot="{ handleSubmit }">
        <form ref="form" @submit.prevent="handleSubmit(dataSubmit)">

          <div class="row">
            <div class="form-group col" data-content="Cicloparqueadero">
              <label for="name">Bici Estación</label>
              <ValidationProvider
                name="cicloparqueadero"
                rules="required"
                v-slot="{ errors }"
              >
                <b-form-select
                  :options="parkingData"
                  v-model="form.parkings_id"
                  class="form-control-user form-control"
                  @change="getParkingVisitsConsecutive()"
                  :class="errors[0] ? 'is-invalid' : ''"
                >
                </b-form-select>
                <span class="form-text text-danger">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
            <div class="form-group col" data-content="Numero de Visita">
              <label for="number">Numero de Visita</label>
              <ValidationProvider
                name="numero_visita"
                rules="required"
                v-slot="{ errors }"
              >
                <input
                  readonly
                  id="number"
                  v-model="form.number"
                  type="text"
                  class="form-control-user form-control"
                />
              <span class="form-text text-danger">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
          </div>
          <div class="row">
            <div class="form-group col" data-content="Documento">
              <label for="bikersData">Documento Ciclista</label>
              <ValidationProvider
                name="documento"
                rules="required|min:5|max:20|numeric"
                v-slot="{ errors }"
              >
                <b-form-input name="documento" list="my-bikers-list-id" @input="updateBicies()" v-model="form.document"></b-form-input>
                <datalist id="my-bikers-list-id">
                  <option v-for="(biker,value) in bikersData" :key="value" :value="biker.value">{{ biker.text }}</option>
                </datalist>

                <span class="form-text text-danger">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
            <div class="form-group col" data-content="Bicicleta">
              <label for="bikersData">Bicicleta</label>
              <ValidationProvider
                name="código de bicicleta"
                rules="required"
                v-slot="{ errors }"
              >
                <b-form-input name="código de bicicleta" list="my-bike-list-id" v-model="form.bicies_code"></b-form-input>
                <datalist id="my-bike-list-id">
                  <option v-for="(bike,value) in bikesData" :key="value" :value="bike.value">{{ bike.text }}</option>
                </datalist>

                <span class="form-text text-danger">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
          </div>

          <div class="row">
            <div class="form-group col" data-content="Fecha de Entrada">
              <label for="name">Fecha de Entrada</label>
              <ValidationProvider
                name="fecha de entrada"
                rules="required"
                v-slot="{ errors }"
              >
                <datepicker
                  :bootstrap-styling="true"
                  :language="es"
                  :calendar-button="true"
                  calendar-button-icon="fa fa-calendar"
                  format="yyyy MMM dd"
                  :disabled="!!form.id"
                  :full-month-name="true"
                  v-model="form.date_input"
                  :input-class="
                    errors[0]
                      ? 'form-control-user form-control is-invalid'
                      : 'form-control-user form-control'
                  "
                />
                <span class="form-text text-danger">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
            <div class="form-group col" data-content="Hora de Entrada">
              <label for="name">Hora de Entrada</label>
              <ValidationProvider
                name="hora de entrada"
                rules="required"
                v-slot="{ errors }"
              >
                <b-form-input
                  v-model="form.time_input"
                  class="form-control-user form-control"
                  :class="errors[0] ? 'is-invalid' : ''"
                  @blur="checkIfTimeWorks()"
                  :readonly="!!form.id"
                  type="time"
                ></b-form-input>
                <span class="form-text text-danger">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>

            <div class="form-group col" v-if="form.id" data-content="Fecha de Salida">
              <label for="name">Fecha de Salida</label>
              <ValidationProvider
                name="fecha de salida"
                rules="required"
                v-slot="{ errors }"
              >
                <datepicker
                  :bootstrap-styling="true"
                  :language="es"
                  :calendar-button="true"
                  :disabledDates="{ to: new Date(Date.parse(form.date_input) - 8640000) }"
                  calendar-button-icon="fa fa-calendar"
                  format="yyyy MMM dd"
                  :full-month-name="true"
                  v-model="form.date_output"
                  :input-class="
                    errors[0]
                      ? 'form-control-user form-control is-invalid'
                      : 'form-control-user form-control'
                  "
                />
                <span class="form-text text-danger">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
            <div class="form-group col" v-if="form.id" data-content="Hora de Salida">
              <label for="name">Hora de Salida</label>
              <ValidationProvider
                name="hora de salida"
                rules="required"
                v-slot="{ errors }"
              >
                <b-form-input
                  v-model="form.time_output"
                  class="form-control-user form-control"
                  :class="errors[0] ? 'is-invalid' : ''"
                  @blur="checkIfTimeWorks()"
                  type="time"
                ></b-form-input>

                <span class="form-text text-danger">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
          </div>
          <div class="row">
            <div class="form-group col" data-content="Estado de Visita">
              <label for="name">Estado de Visita</label>
              <ValidationProvider
                name="estado de visita"
                rules="required"
                v-slot="{ errors }"
              >
                <b-form-select
                  :options="statusData"
                  v-model="form.visit_statuses_id"
                  class="form-control-user form-control"
                  :class="errors[0] ? 'is-invalid' : ''"
                >
                </b-form-select>
                <span class="form-text text-danger">{{ errors[0] }}</span>
              </ValidationProvider>
            </div>
          </div>
          <div>
            <button class="btn btn-primary btn-block my-3" type="submit">
              Guardar
            </button>
          </div>
        </form>
      </ValidationObserver>
    </b-modal>
  </div>
</template>

<script>
import toastr from "toastr";
import Swal from "sweetalert2";
import Datepicker from "vuejs-datepicker";
import XLSX from 'xlsx';
import FileSaver from 'file-saver';
import { en, es } from "vuejs-datepicker/dist/locale";
export default {
  components: {
    Datepicker,
  },
  data() {
    return {
      es: es,
      parkingData: [{ value: null, text: "Selecciona una opción" }],
      statusData: [{ value: null, text: "Selecciona una opción" }],
      bikesData: [{ value: null, text: "Selecciona una opción" }],
      form: {
        id: "",
        parkings_id: null,
        parking: null,
        number: "",
        document: "",
        bicy: "",
        bicies_code: "",
        date_input: new Date().toLocaleDateString("en-CA"),
        date_output: new Date().toLocaleDateString("en-CA"),
        time_input: "",
        time_output: "",
        status: null,
        timeOutput: null,
        dateOutput: null,
        timeinput: null,
        dateinput: null,
        visit_statuses_id: null,
      },
      columns: [
        {
          label: "Bici Estación",
          field: "parking",
        },
        {
          label: "Visita No.",
          field: "number",
        },
        {
          label: "Ciclista",
          field: "biker",
        },
        {
          label: "Bicicleta",
          field: "bicyCode",
        },
        {
          label: "Fecha Ingreso",
          field: "date_input",
        },
        {
          label: "Hora Ingreso",
          field: "time_input",
        },
        {
          label: "Fecha Salida",
          field: "date_output",
        },
        {
          label: "Hora Salida",
          field: "time_output",
        },
        {
          label: "Estado",
          field: "status",
        },
        {
          label: "Acciones",
          field: "delete",
        },
      ],
      rows: [],
    };
  },
  methods: {
    addData() {
      this.resetModal();
      this.$bvModal.show("modal-visit");
    },
    handleOk(bvModalEvt) {
      // Prevent modal from closing
      bvModalEvt.preventDefault();
      // Trigger submit handler
      this.dataSubmit();
    },
    dataSubmit() {

      if(typeof this.form.date_input == 'object'){
        let date_input = this.form.date_input;
        date_input.setDate(date_input.getDate());
        date_input = date_input.toISOString();
        date_input = date_input.split('T')[0];
        this.form.dateInput = date_input;
      }else{
        this.form.dateInput = this.form.date_input;
      }
      if(typeof this.form.date_output == 'object'){
        let date_output = this.form.date_output;
        date_output.setDate(date_output.getDate());
        date_output = date_output.toISOString();
        date_output = date_output.split('T')[0];
        this.form.dateOutput = date_output;
      }else{
        this.form.dateOutput = this.form.date_output;
      }

      let bicy = this.bikesData.filter(el => el.value == this.form.bicies_code);
      if(!bicy.length){
        toastr.error('No se ha conseguido procesar la bicicleta.');
        this.form.bicies_code = null; return;
      }
      this.form.bicy = bicy[0].id

      this.form.parking = this.form.parkings_id;
      this.form.status = this.form.visit_statuses_id;
      this.form.timeOutput = this.form.time_output.substring(0,5);

      this.form.timeInput = this.form.time_input.substring(0,5);

      // console.log(this.form); return;
      if (this.form.id) {
        this.$api.put("web/data/visit/" + this.form.id, this.form).then((res) => {
            if (res.status == 200) {
              this.getData();
              toastr.success("Dato Actualizado");
              this.$bvModal.hide("modal-visit");
            }
          });
      } else {
        this.$api.post("web/data/visit", this.form).then((res) => {
          if (res.status == 201) {
            console.log(res);
            this.getData();
            toastr.success("Dato Guardado");
            this.$bvModal.hide("modal-visit");
          }
        });
      }
    },
    resetModal() {
      var dateCurrent = new Date();
      console.log({dateCurrent})
      toastr.clear();
      this.form.id = "";
      this.form.parkings_id = null;
      this.form.number = "";
      this.form.date_input = dateCurrent.toISOString().split('T')[0] + ' 00:00';
      this.form.time_input =
        (dateCurrent.getHours() < 10 ? "0" : "") +
        dateCurrent.getHours() +
        ":" +
        (dateCurrent.getMinutes() < 10 ? "0" : "") +
        dateCurrent.getMinutes();
      this.form.date_output = dateCurrent.toISOString().split('T')[0] + ' 00:00';
      this.form.time_output =
        (dateCurrent.getHours() < 10 ? "0" : "") +
        dateCurrent.getHours() +
        ":" +
        (dateCurrent.getMinutes() < 10 ? "0" : "") +
        dateCurrent.getMinutes();
      this.form.document = "";
      this.form.bicies_code = "";
      this.form.new = "";
      this.form.visit_statuses_id = null;
    },
    deleteData(id) {
      const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: "btn btn-success",
          cancelButton: "btn btn-danger",
        },
        buttonsStyling: false,
      });

      swalWithBootstrapButtons
        .fire({
          title: "Estas Seguro De Eliminar Este Dato?",
          text: "Esta opción no se puede reversar",
          icon: "warning",
          showCancelButton: false,
          confirmButtonText: "Eliminar",
          timer: 5000,
          timerProgressBar: true,
        })
        .then((result) => {
          if (result.isConfirmed) {
            this.$api.delete("web/data/visit/" + id).then((res) => {
              if (res.status == 200) {
                this.getData();
                toastr.success("Dato Eliminado");
                this.$bvModal.hide("modal-visit");
              }
            });
          }
        });
    },
    editData(id) {
      this.$api.get("web/data/visit/" + id + "/edit").then((res) => {
        const data  = res.data.response.data;
        let dateInput = new Date(`${data.date_input} 00:00`);
        let dateOutput = new Date(`${data.date_output} 00:00`);

        data.date_input = dateInput
        data.date_output = dateOutput

        this.bikesData = res.data.response.indexes.bicies.map((el)=>{ return {value : el.code, text : el.code, id : el.id}});

        this.form = data;
      });
      this.$bvModal.show("modal-visit");
    },
    getData() {

      this.parkingData = [{ value: null, text: "Selecciona una opción" }];
      this.statusData = [{ value: null, text: "Selecciona una opción" }];
      this.bikesData = [{ value: null, text: "Selecciona una opción" }];

      this.$api.get("web/data/biker").then((res) => {
        if(res.status == 200){
          this.bikersData = res.data.response.users.map((el)=>{ return {value : el.document, text : `${el.name} ${el.last_name}`, id : el.id}});
        }
      });

      this.$api.get("web/data/visit").then((res) => {
          //console.log(res.data.response.data);
        this.rows = res.data.response.data;
        res.data.response.indexes.status.forEach((element) => {
          this.statusData.push(element);
        });
        res.data.response.indexes.parking.forEach((element) => {
          this.parkingData.push(element);
        });
      });
    },
    getParkingVisitsConsecutive(){
      if(!this.form.parkings_id){
        this.form.number ="";
        return;
      }
        this.$api.get("web/data/visit/create?parkings_id=" + this.form.parkings_id).then((res) => {
          console.log(res.data.response.data.consecutive);
          this.form.number = res.data.response.data.consecutive;
        });
    },
    checkIfTimeWorks(){

      let date_input = this.form.date_input;
       if(typeof date_input == 'object'){
        // date_input.setDate(date_input.getDate() - 1);
        date_input = date_input.toISOString();
        date_input = date_input.split('T')[0];
      }

      let date_output = this.form.date_output;
       if(typeof date_output == 'object'){
        // date_output.setDate(date_output.getDate() - 1);
        date_output = date_output.toISOString();
        date_output = date_output.split('T')[0];
      }

      console.log(date_input, date_output,  date_input == date_output);
      if(date_input == date_output){
        console.log(this.form.time_input, this.form.time_output,  this.form.time_input == this.form.time_output);
        if(this.form.time_input > this.form.time_output){
          this.form.time_output = this.form.time_input;
        }
      }
    },
    updateBicies(){
      let biker = this.bikersData.filter(el => el.value == this.form.document);
      if(!biker.length){
        toastr.error('No se ha conseguido procesar el ciclista.');
        console.log(this.form.document, this.bikersData);
        this.bikesData = []; return;
      }
        this.$api.get("web/data/biker/"+biker[0].id).then((res) => {
        if(res.status == 200){
          this.bikesData = res.data.response.bicies.map((el)=>{ return {value : el.code, text : el.code, id : el.id}});
        }
      });
    },
    exportVisit(){
        // Acquire Data (reference to the HTML table)
        var table_elt = document.getElementById("tableVisit", {raw : true});

        // Extract Data (create a workbook object from the table)
        var workbook = XLSX.utils.table_to_book(table_elt);

        // Process Data (add a new row)
        var worksheet = workbook.Sheets["Sheet1"];

        //console.log(JSON.stringify(worksheet));
        // Package and Release Data (`writeFile` tries to write and save an XLSB file)
        XLSX.writeFile(workbook, "Visit.xlsx");
    },
  },
  created: function () {
    this.getData();
  },
};
</script>
