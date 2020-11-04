<template>
    <div class="card">
        <div class="card-header bg-info">
            <h3 class="my-0">Categoría</h3>
            <div class="card-actions white-text">
                <button class="btn btn-outline-light btn-sm" type="button" @click.prevent="clickCreate()"><i class="fa fa-plus-circle"></i> Nuevo</button>
                <a href="#" class="card-action card-action-toggle text-white" data-card-toggle=""></a>
                <a href="#" class="card-action card-action-dismiss text-white" data-card-dismiss=""></a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th class="text-right">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(row, index) in records">
                        <td>{{ index + 1 }}</td>
                        <td>{{ row.code }}</td>
                        <td>{{ row.name }}</td>
                        <td class="text-right">
                            <button type="button" class="btn waves-effect waves-light btn-xs btn-info" @click.prevent="clickCreate(row.id)">Editar</button>
                            <template v-if="typeUser === 'admin'">
                                <button type="button" class="btn waves-effect waves-light btn-xs btn-danger"  @click.prevent="clickDelete(row.id)">Eliminar</button>
                            </template>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <currency-category-form :showDialog.sync="showDialog"
                            :recordId="recordId"></currency-category-form>
    </div>
</template>

<script>
    import CurrencyCategoryForm from './form.vue'
    import {deletable} from '../../../../../mixins/deletable'

    export default {
        mixins: [deletable],
        props: ['typeUser'],
        components: {CurrencyCategoryForm},
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
                this.$http.get(`/${this.resource}/category`)
                    .then(response => {
                        this.records = response.data.data
                    })
            },
            clickCreate(recordId = null) {
                this.recordId = recordId
                this.showDialog = true
            },
            clickDelete(id) {
                this.destroy(`/${this.resource}/category/${id}`).then(() =>
                    this.$eventHub.$emit('reloadData')
                )
            }
        }
    }
</script>