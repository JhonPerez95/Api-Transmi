<template>
    <div id="ServiceSupport" class="my-2">
        <div>

        </div>

        <div>
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
                    <span v-if="props.column.field === 'status'">
                        <select class="form-control-user form-control" v-on:change="selectdataAnswer($event, props.row.service_supports_id)">
                           <option value="1">Recibido</option>
                           <option value="2">En Proceso</option>
                           <option value="3">Solucionado</option>
                           <option value="4">Rechazado</option>
                        </select>
<!--                        {{props.row.status}}-->

<!--                        <select>-->
<!--                           <option v-for="(item , index) in categories" v-bind:key="index" :selected= "item.id == 30" >-->
<!--                                {{item.title}}-->
<!--                           </option>-->
<!--                        </select>-->
                    </span>

                    <span v-else-if="props.column.field === 'boton'">
                        <button v-on:click="descriptionData(props.row.service_supports_id)" class="btn btn-primary">
                            Respuesta
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
                id="modal-answer"
                ref="modal"
                title="Respuesta"
            >
                <ValidationObserver ref="observer" v-slot="{ handleSubmit }">
                    <form ref="form" @submit.prevent="handleSubmit(dataAnswer)">
                        <div class="form-group">
                            <label for="name">Responder</label>
                            <ValidationProvider
                                name="answer"
                                rules="required|min:6"
                                v-slot="{ errors }"
                            >
                                <textarea
                                    id="answer"
                                    v-model="form.answer"
                                    class="form-control"
                                    :class="errors[0] ? 'is-invalid' : ''"
                                />
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
            <!---MODAL -->

        </div>

    </div>

</template>

<script>

import toastr from "toastr";
import { en, es } from "vuejs-datepicker/dist/locale";

export default {

    data() {
        return {
            es,
            show: true,
            form: {
                id: "",
                answer: "",
            },
            rows: [],
            columns: [
                {
                    label: "Fecha",
                    field: "created_at",
                },
                {
                    label: "Hora",
                    field: "time",
                },
                {
                    label: "Bici Estación",
                    field: "parking_name",
                },
                {
                    label: "Vigilante",
                    field: "user_name",
                },
                {
                    label: "Novedad",
                    field: "title",
                },
                {
                    label: "Descripción",
                    field: "description",
                },
                {
                    label: "Estado",
                    field: "status",
                },
                {
                    label: "Respuesta",
                    field: "answer",
                },
                {
                    label: "Acción",
                    field: "boton",
                },
            ],
        };
    },
    methods :{
        getData() {
            this.$api.get(`web/data/servicesupport`).then((res) => {
                console.log(res);
                this.rows = res.data.response.data;
                //console.log(this.rows);
            });
        },
        descriptionData(id) {
            this.$api.get("web/data/servicesupport/" + id + "/edit").then( (res) => {
               if(res.status == 200) {
                   console.log(res);
                   this.form = res.data;
               }
            });
            this.$bvModal.show("modal-answer");
        },
        selectdataAnswer(event, id){

            let status = event.target.value;
            if (status) {
                this.$api.put("web/data/servicesupport/updateSelect/" + id + "/" + status).then( (res) => {
                    //console.log(res.data.response.data);
                    toastr.success(res.data.response.data);
                });
            }
            this.getData();
        },
        dataAnswer() {
            if (this.form.id) {
                this.$api.put("web/data/servicesupport/" + this.form.id, this.form ).then( (res) => {
                    //console.log(res.data.response.data);
                    toastr.success(res.data.response.data);
                });
            }
            this.getData();
            this.$bvModal.hide("modal-answer");
        },
    },
    created: function () {
        this.getData();
    },

}
</script>
