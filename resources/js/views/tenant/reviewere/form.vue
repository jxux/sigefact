<template>
    <el-dialog width="50%" :title="titleDialog" :visible="showDialog" :close-on-click-modal="false" @close="close" @open="create" append-to-body top="7vh">
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                    <div class="col">
                        <div class="form-group" :class="{'has-danger': errors.date}">
                            <label class="control-label">Fecha <span class="text-danger">*</span></label>
                            <el-date-picker format="dd/MM/yyyy" v-model="form.date" type="date" value-format="yyyy-MM-dd" :clearable="false"></el-date-picker>
                            <small class="form-control-feedback" v-if="errors.date" v-text="errors.date[0]"></small>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label class="control-label">Hora de inicio: </label>
                            <p>{{form.start_time}}</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label class="control-label">Hora de fin: </label>
                            <p>{{form.end_time}}</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="control-label">Cliente: </label>
                            <p>{{form.client}}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label class="control-label">Categoria (Cuenta): </label>
                        <p>{{form.category}}</p>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label class="control-label">Servicio (Centro de Costo): </label>
                        <p>{{form.service}}</p>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label class="control-label">Periodo: </label>
                        <p>{{form.period}}</p>
                        <small class="form-control-feedback" v-if="errors.period" v-text="errors.period[0]"></small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label">Descripción: </label>
                        <p>{{form.description}}</p>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group" >
                        <label class="control-label">Estado: </label>
                        <span v-if="form.status === 0" class="badge bg-danger text-white">{{ form.status }} %</span>
                        <span v-else-if="form.status === 25" class="badge bg-danger text-white">{{ form.status }} %</span>
                        <span v-else-if="form.status === 50" class="badge bg-warning text-white">{{ form.status }} %</span>
                        <span v-else-if="form.status === 75" class="badge bg-warning text-white">{{ form.status }} %</span>
                        <span v-else-if="form.status === 100" class="badge bg-success text-white">Terminado</span>
                    </div>
                </div>
            </div>

            <div class="form-actions text-right pt-2">
                <el-button @click.prevent="close()">Cancelar</el-button>
                <el-button type="primary" native-type="submit" :loading="loading_submit">Guardar</el-button>
            </div>
        </form>

    </el-dialog>
</template>

<script>
    // import PercentagePerception from './partials/percentage_perception.vue'
    // import LotsForm from './partials/lots.vue'

    export default {
        props: ['showDialog', 'recordId', 'external'],
        // components: {LotsForm},

        data() {
            return {
                resource: 'reviewers',
                errors: {},
                form: {},
                formRe: {},
                // all_clients: [],
                clients: [],
                services: [],
                categorys: [],
                titleDialog: null,
                eventNewId: null,
                hora1: null,
                hora2: null
            }
        },
        async created() {
            await this.initForm()
            await this.$http.get(`/${this.resource}/tables`)
                .then(response => {
                    this.clients = response.data.clients
                    this.services = response.data.services
                    this.categorys = response.data.categorys

                    this.selectClient()
                    this.selectCategory()
                    this.selectService()

                })

            this.$eventHub.$on('reloadDataPersons', (client_id) => {
                this.reloadDataClients(client_id)
           })

            // await this.setDefaultConfiguration()

        },

        methods: {

            setDefaultConfiguration(){
                this.form.sale_affectation_igv_type_id = (this.configuration) ? this.configuration.affectation_igv_type_id : '10'

                this.$http.get(`/configurations/record`) .then(response => {
                    this.form.has_igv = response.data.data.include_igv
                    this.form.purchase_has_igv = response.data.data.include_igv
                })
            },

            selectClient(){
                let clients = _.find(this.clients, {'id': this.aux_client_id})
                this.form.client_id = (clients) ? clients.id : null
                this.aux_client_id = null
            },

            selectCategory(){
                let categorys = _.find(this.categorys, {'id': this.aux_category_id})
                this.form.category_id = (categorys) ? categorys.id : null
                this.aux_category_id = null
            },

            selectService(){
                let services = _.find(this.services, {'id': this.aux_service_id})
                this.form.service_id = (services) ? services.id : null
                this.aux_service_id = null
            },

            clickDelete(id) {

                this.$http.delete(`/${this.resource}/item-unit-type/${id}`)
                        .then(res => {
                            if(res.data.success) {
                                this.loadRecord()
                                this.$message.success('Se eliminó correctamente el registro')
                            }
                        })
                        .catch(error => {
                            if (error.response.status === 500) {
                                this.$message.error('Error al intentar eliminar');
                            } else {
                                console.log(error.response.data.message)
                            }
                        })

            },

            clickCancel(index) {
                this.form.item_unit_types.splice(index, 1)
                // this.initDocumentTypes()
                // this.showAddButton = true
            },
            initForm() {
                this.loading_submit = false,
                this.errors = {}
                this.form = {
                    aux_client_id:null,
                    aux_category_id:null,
                    aux_service_id:null,
                    date: moment().format('YYYY-MM-DD'),
                    start_time: null,//moment().format('YYYY-MM-DD HH:mm:ss'),
                    end_time: null,//moment().format('YYYY-MM-DD HH:mm:ss'),
                    hour: null,//moment(fecha2.diff(fecha1)).utc().format("hh:mm"),
                    client_id: null,
                    category_id:null,
                    service_id:null,
                    period:null,
                    description:null,
                    status:0,
                }
                this.formRe = {
                    status_Re: 50,
                    date_Re_Ve: '2020-10-30',
                    description_Re: 'sadsad',
                }

            },

            calHora(){
                var hora1 = moment(this.form.start_time)//moment('2020-06-01 10:00:00');//
                var hora2 = moment(this.form.end_time)//moment('2020-06-01 13:30:00');//
                this.form.hour = moment(hora2.diff(hora1)).utc().format("hh:mm:ss")
            },

            resetForm(){
                this.initForm()
            },

            create(){
                this.titleDialog = (this.recordId)? 'Agregar observaciones al evento':'Nuevo Evento'
                if (this.recordId) {
                    this.$http.get(`/${this.resource}/record/${this.recordId}`)
                        .then(response => {
                            this.form = response.data.data
                        })
                }
            },

            loadRecord(){
                if (this.recordId) {
                    this.$http.get(`/${this.resource}/record/${this.recordId}`)
                        .then(response => {
                            this.form = response.data.data
                        })
                }
            },

            async submit() {
                this.calHora()
                this.loading_submit = true
                await this.$http.post(`/${this.resource}`, this.formRe)
                    .then(response => {
                        if (response.data.success) {
                            // this.resetForm()
                            this.$message.success(response.data.message)
                             if (this.external) {
                                this.$eventHub.$emit('reloadDataItems', response.data.id)
                            } else {
                                this.$eventHub.$emit('reloadData')
                            }
                            this.close()
                        } else {
                            this.$message.error(response.data.message)
                        }
                    })
                    .catch(error => {
                        if (error.response.status === 422) {
                            this.errors = error.response.data
                        } else {
                            this.$message.error(error.response.data.message)
                        }
                    })
                    .then(() => {
                        this.loading_submit = false
                    })
            },

            close() {
                this.$emit('update:showDialog', false)
                this.resetForm()
            },
            reloadDataClients(client_id) {
                this.$http.get(`/${this.resource}/table/clients`).then((response) => {
                    this.aux_client_id = client_id
                    this.all_clients = response.data
                    this.selectClient()
                })
            },
        }
    }
</script>
