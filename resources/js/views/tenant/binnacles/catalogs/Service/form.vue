<template>
    <el-dialog :title="titleDialog" :visible="showDialog" @close="close" @open="create">
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-4">
                    <div class="form-group" :class="{'has-danger': errors.category_id}">
                        <label class="control-label">Categoria (Cuenta)</label>
                        <el-select v-model="form.category_id" filterable>
                            <el-option v-for="option in all_categorys" :key="option.id" :value="option.id" :label="option.name"></el-option>
                        </el-select>
                        <small class="form-control-feedback" v-if="errors.category_id" v-text="errors.category_id[0]"></small>
                    </div>
                </div>
                    <div class="col-md-4">
                        <div class="form-group" :class="{'has-danger': errors.code}">
                            <label class="control-label">Código</label>
                            <el-input v-model="form.code" ></el-input>
                            <small class="form-control-feedback" v-if="errors.code" v-text="errors.code[0]"></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" :class="{'has-danger': errors.name}">
                            <label class="control-label">Descripción</label>
                            <el-input v-model="form.name"></el-input>
                            <small class="form-control-feedback" v-if="errors.name" v-text="errors.name[0]"></small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions text-right mt-4">
                <el-button @click.prevent="close()">Cancelar</el-button>
                <el-button type="primary" native-type="submit" :loading="loading_submit">Guardar</el-button>
            </div>
        </form>
    </el-dialog>
</template>

<script>

    export default {
        props: ['showDialog', 'recordId'],
        data() {
            return {
                loading_submit: false,
                titleDialog: null,
                resource: 'binnacles',
                errors: {},
                form: {},
                options: [],
                all_categorys: [],
            }
        },

        async created() {
            this.initForm()
            await this.$http.get(`/${this.resource}/service/tables`)
                .then(response => {
                    this.all_categorys = response.data.category
                })

        },
        methods: {
            initForm() {
                this.errors = {}
                this.form = {
                    code: null,
                    name: null,
                    category_id:null,
                    aux_category_id:null,
                    // symbol: null,
                    active: true
                }
            },
            create() {
                this.titleDialog = (this.recordId)? 'Editar Servicio':'Nueva Servicio'
                if (this.recordId) {
                    this.$http.get(`/${this.resource}/service/record/${this.recordId}`)
                        .then(response => {
                            this.form = response.data.data
                        })
                }
            },
            submit() {
                this.loading_submit = true
                this.$http.post(`/${this.resource}/service`, this.form)
                    .then(response => {
                        if (response.data.success) {
                            this.$message.success(response.data.message)
                            this.$eventHub.$emit('reloadData')
                            this.close()
                        } else {
                            this.$message.error(response.data.message)
                        }
                    })
                    .catch(error => {
                        if (error.response.status === 422) {
                            this.errors = error.response.data
                        } else {
                            console.log(error)
                        }
                    })
                    .then(() => {
                        this.loading_submit = false
                    })
            },
            close() {
                this.$emit('update:showDialog', false)
                this.initForm()
            },
        }
    }
</script>