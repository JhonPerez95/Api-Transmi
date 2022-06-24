<template>
  <div id="parkingTable">
    <!-- DATATABLE -->
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
      <div slot="table-actions">
        <button v-on:click="addData()" class="btn btn-primary">
          A&ntilde;adir
        </button>
        <label for="file-upload" class="btn btn-success my-auto">
          Importar
        </label>
        <button v-on:click="exportParking()" class="btn btn-success">
              Exportar
        </button>
        <input id="file-upload" class="d-none" type="file" />
      </div>
      <template slot="table-row" slot-scope="props">
        <span v-if="props.column.field === 'active'">
          <div v-if="props.row.active == 1">Activo</div>
          <div v-else>Inactivo</div>
        </span>
        <span v-else-if="props.column.field === 'delete'">
          <button v-on:click="editData(props.row.id)" class="btn btn-warning">
            Editar
          </button>
          <button v-on:click="deleteData(props.row.id)" class="btn btn-danger">
            Eliminar
          </button>
        </span>
        <span v-else>
          {{ props.formattedRow[props.column.field] }}
        </span>
      </template>
    </vue-good-table>
    <!-- MODAL -->
    <b-modal
      hide-footer
      id="modal-parking"
      ref="modal"
      title="Cicloparqueadero"
      @show="resetModal"
      @hidden="resetModal"
      @ok="handleOk"
    >
      <ValidationObserver ref="observer" v-slot="{ handleSubmit }">
        <form ref="form" @submit.prevent="handleSubmit(dataSubmit)">
          <div class="form-group">
            <label for="name">Nombre</label>
            <ValidationProvider
              name="nombre"
              rules="required|min:6|max:100"
              v-slot="{ errors }"
            >
              <input
                id="name"
                v-model="form.name"
                type="text"
                class="form-control-user form-control"
                :class="errors[0] ? 'is-invalid' : ''"
              />
              <span class="form-text text-danger">{{ errors[0] }}</span>
            </ValidationProvider>
          </div>
          <div class="form-group">
            <label for="code">Código</label>
            <ValidationProvider
              name="codigo"
              rules="required|min:2|max:10"
              v-slot="{ errors }"
            >
              <input
                id="code"
                v-model="form.code"
                type="text"
                class="form-control-user form-control"
                :class="errors[0] ? 'is-invalid' : ''"
              />
              <span class="form-text text-danger">{{ errors[0] }}</span>
            </ValidationProvider>
          </div>
          <div class="form-group">
            <label for="capacity">Capacidad</label>
            <ValidationProvider
              name="capacidad"
              rules="required|min:2|max:10|numeric"
              v-slot="{ errors }"
            >
              <input
                id="capacity"
                v-model="form.capacity"
                type="number"
                class="form-control-user form-control"
                :class="errors[0] ? 'is-invalid' : ''"
              />
              <span class="form-text text-danger">{{ errors[0] }}</span>
            </ValidationProvider>
          </div>
          <div class="form-group">
            <label for="type">Tipo</label>
            <ValidationProvider
              name="tipo"
              rules="required"
              v-slot="{ errors }"
            >
              <b-form-select
                :options="typeData"
                v-model="form.type_parkings_id"
                class="form-control-user form-control"
                :class="errors[0] ? 'is-invalid' : ''"
              >
              </b-form-select>
              <span class="form-text text-danger">{{ errors[0] }}</span>
            </ValidationProvider>
          </div>
          <div class="form-group">
            <label for="station">Troncal</label>
            <ValidationProvider
              name="troncal"
              rules="required"
              v-slot="{ errors }"
            >
              <b-form-select
                :options="stationData"
                v-model="form.stations_id"
                class="form-control-user form-control"
                :class="errors[0] ? 'is-invalid' : ''"
              >
              </b-form-select>
              <span class="form-text text-danger">{{ errors[0] }}</span>
            </ValidationProvider>
          </div>
          <div class="form-group">
            <label for="active">Estado</label>
            <ValidationProvider
              rules="required"
              name="Estado"
              v-slot="{ errors }"
            >
              <select
                id="active"
                v-model="form.active"
                class="form-control-user form-control"
                :class="errors[0] ? 'is-invalid' : ''"
              >
                <option :value="null">Seleccione una opción</option>
                <option value="1">Activo</option>
                <option value="2">Inactivo</option>
              </select>
              <span class="form-text text-danger">{{ errors[0] }}</span>
            </ValidationProvider>
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
import XLSX from "xlsx";


export default {
  data() {
    return {
      typeData: [{ value: null, text: "Selecciona una opción" }],
      stationData: [{ value: null, text: "Selecciona una opción" }],
      form: {
        id: "",
        name: "",
        code: "",
        capacity: "",
        type_parkings_id: null,
        stations_id: null,
        active: null,
      },
      columns: [
        {
          label: "Nombre",
          field: "name",
        },
        {
          label: "Código",
          field: "code",
        },
        {
          label: "Capacidad",
          field: "capacity",
        },
        {
          label: "Tipo",
          field: "type",
        },
        {
          label: "Troncal",
          field: "station",
        },
        {
          label: "Estado",
          field: "active",
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
      this.$bvModal.show("modal-parking");
    },
    handleOk(bvModalEvt) {
      bvModalEvt.preventDefault();
      this.dataSubmit();
    },
    dataSubmit() {
      if (this.form.id) {
        this.$api
          .put("web/data/parking/" + this.form.id, this.form)
          .then((res) => {
            if (res.status == 200) {
              this.getData();
              toastr.success("Dato Actualizado");
              this.$bvModal.hide("modal-parking");
            }
          });
      } else {
        this.$api.post("web/data/parking", this.form).then((res) => {
          if (res.status == 201) {
            this.getData();
            toastr.success("Dato Guardado");
            this.$bvModal.hide("modal-parking");
          }
        });
      }
    },
    resetModal() {
      toastr.clear();
      this.form.id = "";
      this.form.name = "";
      this.form.code = "";
      this.form.capacity = "";
      this.form.type_parkings_id = null;
      this.form.stations_id = null;
      this.form.active = null;
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
            this.$api.delete("web/data/parking/" + id).then((res) => {
              if (res.status == 200) {
                this.getData();
                toastr.success("Dato Eliminado");
                this.$bvModal.hide("modal-parking");
              }
            });
          }
        });
    },
    editData(id) {
      this.$api.get("web/data/parking/" + id + "/edit").then((res) => {
        if (res.status == 200) {
          console.log(res);
          this.form = res.data;
        }
      });
      this.$bvModal.show("modal-parking");
    },
    getData() {
      this.$api.get("web/data/parking").then((res) => {
        this.rows = res.data.response.parkings;
        res.data.response.indexes.type.forEach((element) => {
          this.typeData.push(element);
        });
        res.data.response.indexes.station.forEach((element) => {
          this.stationData.push(element);
        });
      });
    },
    exportParking() {

          // Acquire Data (reference to the HTML table)
          var table_elt = document.getElementById("parkingTable");

          // Extract Data (create a workbook object from the table)
          var workbook = XLSX.utils.table_to_book(table_elt);

          // Process Data (add a new row)
          var worksheet = workbook.Sheets["Sheet1"];

          // Package and Release Data (`writeFile` tries to write and save an XLSB file)
          XLSX.writeFile(workbook, "Parkings.xlsx");
      },
  },

  created: function () {
    this.getData();
  },
};
</script>
