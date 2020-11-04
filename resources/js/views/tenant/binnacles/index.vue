<template>
    <div>
        <div class="page-header pr-0">
            <h2><a href="/dashboard"><i class="fas fa-tachometer-alt"></i></a></h2>
            <ol class="breadcrumbs">
                <li class="active"><span>Bitácora</span></li>
            </ol>
            <div class="right-wrapper pull-right">
                <template v-if="typeUser === 'admin'">
                    <!-- <div class="btn-group flex-wrap"> -->
                    <button type="button" class="btn btn-custom btn-sm  mt-2 mr-2" @click.prevent="clickExport()" ><i class="fa fa-download"></i> Exportar <span class="caret"></span></button>
                        <!-- <div class="dropdown-menu" role="menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 42px, 0px);"> -->
                            <!-- <a class="dropdown-item text-1" href="#" @click.prevent="clickExport()">Listado</a> -->
                            <!-- <a class="dropdown-item text-1" href="#" @click.prevent="clickExportWp()">Woocommerce</a> -->
                        <!-- </div> -->
                    <!-- </div> -->
                </template>
                    <button type="button" class="btn btn-custom btn-sm  mt-2 mr-2" @click.prevent="clickCreate()"><i class="fa fa-plus-circle"></i> Nuevo</button>
            </div>
        </div>
        <div class="card mb-0">
            <div class="card-header bg-info">
                <h3 class="my-0">Listado de Eventos</h3>
            </div>
            <div class="card-body">
                <data-table :resource="resource" class="table-sm table-hover">
                    <tr slot="heading" width="100%">
                        <th>Fecha</th>
                        <th>H. Inicio</th>
                        <th>H. Fin</th>
                        <th>Horas</th>
                        <th>Cliente</th>
                        <th>Categoria(Cuenta)</th>
                        <th>Servicio(C. Costo)</th>
                        <th>Periodo</th>
                        <th>Descripción</th>
                        <th class="text-center">Estado</th>
                        <th>|</th>
                        <th class="text-center">Estado</th>
                        <th>Fecha</th>
                        <th>Descripción</th>

                        <!--<th v-if="typeUser != 'seller'" class="text-right">P.Unitario (Compra)</th> -->
                    <tr>
                    <tr slot-scope="{ row }" >
                        <td>{{ row.date }} </td>
                        <td>{{ row.start_time }}</td>
                        <td>{{ row.end_time }}</td>
                        <td>{{ row.hour }}</td>
                        <td>{{ row.client }}</td>
                        <td>{{ row.category }}</td>
                        <td>{{ row.service}}</td>
                        <td>{{ row.period }}</td>
                        <td>{{ row.description }}</td>
                        <td>
                            <span v-if="row.status === 0" class="badge bg-danger text-white">{{ row.status }} %</span>
                            <span v-else-if="row.status === 25" class="badge bg-danger text-white">{{ row.status }} %</span>
                            <span v-else-if="row.status === 50" class="badge bg-warning text-white">{{ row.status }} %</span>
                            <span v-else-if="row.status === 75" class="badge bg-warning text-white">{{ row.status }} %</span>
                            <span v-else-if="row.status === 100" class="badge bg-success text-white">Terminado</span>
                        </td>
                        <td>|</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right">
                            <button type="button" class="btn waves-effect waves-light btn-xs btn-info" @click.prevent="clickCreate(row.id)"><i class="el-icon-edit-outline"></i></button>
                            <button type="button" class="btn waves-effect waves-light btn-xs btn-danger" @click.prevent="clickDelete(row.id)"><i class="el-icon-delete"></i></button>
                        </td>
                        <!-- <td class="text-right">
                            <template v-if="typeUser === 'admin'">
                                <button type="button" class="btn waves-effect waves-light btn-xs btn-info" @click.prevent="clickCreate(row.id)">Editar</button>
                                <button type="button" class="btn waves-effect waves-light btn-xs btn-danger" @click.prevent="clickDelete(row.id)">Eliminar</button>
                                <button type="button" class="btn waves-effect waves-light btn-xs btn-warning" @click.prevent="duplicate(row.id)">Duplicar</button>

                                <button type="button" class="btn waves-effect waves-light btn-xs btn-danger" @click.prevent="clickDisable(row.id)" v-if="row.active">Inhabilitar</button>
                                <button type="button" class="btn waves-effect waves-light btn-xs btn-primary" @click.prevent="clickEnable(row.id)" v-else>Habilitar</button>

                                <button type="button" class="btn waves-effect waves-light btn-xs btn-primary" @click.prevent="clickBarcode(row)">Cod. Barras</button>

                            </template>
                        </td> -->
                    </tr>
                </data-table>
            </div>

            <binnacles-form :showDialog.sync="showDialog"
                        :recordId="recordId"></binnacles-form>
            <binnacles-export :showDialog.sync="showExportDialog"></binnacles-export>

        </div>
    </div>
</template>
<script>

    import BinnaclesForm from './form.vue'
    // import WarehousesDetail from './partials/warehouses.vue'
    // import ItemsImport from './import.vue'
    // import ItemsImportListPrice from './partials/import_list_price.vue'
    import BinnaclesExport from './partials/export.vue'
    // import ItemsExportWp from './partials/export_wp.vue'
    import DataTable from '../../../components/DataTable.vue'
    import {deletable} from '../../../mixins/deletable'

    export default {
        props:['typeUser'],
        mixins: [deletable],
        components: {
            BinnaclesForm,
            BinnaclesExport,
            DataTable
        },
        data() {
            return {
                showDialog: false,
                showImportDialog: false,
                showExportDialog: false,
                showExportWpDialog: false,
                showImportListPriceDialog: false,
                showWarehousesDetail: false,
                resource: 'binnacles',
                recordId: null,
                warehousesDetail:[],
                config: {}
            }
        },
        created() {
            this.$http.get(`/configurations/record`) .then(response => {
                this.config = response.data.data
            })
        },
        methods: {
            duplicate(id)
            {
                this.$http.post(`${this.resource}/duplicate`, {id})
                .then(response => {
                    if (response.data.success) {
                        this.$message.success('Se guardaron los cambios correctamente.')
                        this.$eventHub.$emit('reloadData')
                    } else {
                        this.$message.error('No se guardaron los cambios')
                    }
                })
                .catch(error => {

                })
                this.$eventHub.$emit('reloadData')
            },
            // clickWarehouseDetail(warehouses){
            //     this.warehousesDetail = warehouses
            //     this.showWarehousesDetail = true
            // },
            clickCreate(recordId = null) {
                this.recordId = recordId
                this.showDialog = true
            },
            // clickImport() {
            //     this.showImportDialog = true
            // },
            clickExport() {
                this.showExportDialog = true
            },
            // clickExportWp() {
            //     this.showExportWpDialog = true
            // },
            // clickImportListPrice() {
            //     this.showImportListPriceDialog = true
            // },
            clickDelete(id) {
                this.destroy(`/${this.resource}/${id}`).then(() =>
                    this.$eventHub.$emit('reloadData')
                )
            }
        }
    }
</script>
