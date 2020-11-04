<template>
    <div class="card">
        <div class="card-header bg-info">
            <h3 class="my-0">Servicios</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Categoría</th>
                        <th>Código</th>
                        <th>Descripción</th>
                        <!-- <th>Símbolo</th> -->
                        <!-- <th class="text-center">Activo</th> -->
                        <th class="text-right">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(row, index) in records">
                        <td>{{ index + 1 }}</td>
                        <td>{{ row.category_id }}</td>
                        <td>{{ row.code }}</td>
                        <td>{{ row.name }}</td>
                        <!-- <td>{{ row.symbol }}</td> -->
                        <!-- <td class="text-center">{{ row.active }}</td> -->
                        <td class="text-right">
                            <button type="button" class="btn waves-effect waves-light btn-xs btn-info" @click.prevent="clickCreate(row.id)">Editar</button>
                            <!--<button type="button" class="btn waves-effect waves-light btn-xs btn-danger"  @click.prevent="clickDelete(row.id)">Eliminar</button>-->
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <currency-service-form :showDialog.sync="showDialog"
                            :recordId="recordId"></currency-service-form>
    </div>
</template>

<script>
    import CurrencyTypesForm from './form.vue'
    import {deletable} from '../../../../mixins/deletable'

    export default {
        mixins: [deletable],
        props: ['typeUser'],
        components: {CurrencyTypesForm},
        data() {
            return {
                showDialog: false,
                resource: 'binnacles',
                recordId: null,
                records: [],
            }
        },
        created() {
            this.$eventHub.$on('reloadData', () => {
                this.getData()
            })
            this.getData()
        },
        methods: {
            getData() {
                this.$http.get(`/${this.resource}/service`)
                    .then(response => {
                        this.records = response.data.data
                    })
            },
            clickCreate(recordId = null) {
                this.recordId = recordId
                this.showDialog = true
            },
            clickDelete(id) {
                this.destroy(`/${this.resource}/${id}`).then(() =>
                    this.$eventHub.$emit('reloadData')
                )
            }
        }
    }
</script>