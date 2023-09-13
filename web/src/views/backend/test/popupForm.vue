<template>
    <!-- 对话框表单 -->
    <!-- 建议使用 Prettier 格式化代码 -->
    <!-- el-form 内可以混用 el-form-item、FormItem、ba-input 等输入组件 -->
    <el-dialog
        class="ba-operate-dialog"
        :close-on-click-modal="false"
        :model-value="['Add', 'Edit'].includes(baTable.form.operate!)"
        @close="baTable.toggleForm"
        width="50%"
    >
        <template #header>
            <div class="title" v-drag="['.ba-operate-dialog', '.el-dialog__header']" v-zoom="'.ba-operate-dialog'">
                {{ baTable.form.operate ? t(baTable.form.operate) : '' }}
            </div>
        </template>
        <el-scrollbar v-loading="baTable.form.loading" class="ba-table-form-scrollbar">
            <div
                class="ba-operate-form"
                :class="'ba-' + baTable.form.operate + '-form'"
                :style="'width: calc(100% - ' + baTable.form.labelWidth! / 2 + 'px)'"
            >
                <el-form
                    v-if="!baTable.form.loading"
                    ref="formRef"
                    @submit.prevent=""
                    @keyup.enter="baTable.onSubmit(formRef)"
                    :model="baTable.form.items"
                    label-position="right"
                    :label-width="baTable.form.labelWidth + 'px'"
                    :rules="rules"
                >
                    <FormItem :label="t('test.status')" type="radio" v-model="baTable.form.items!.status" prop="status" :data="{ content: { '0': t('test.status 0'), '1': t('test.status 1') } }" :placeholder="t('Please select field', { field: t('test.status') })" />
                    <FormItem :label="t('test.admin_id')" type="remoteSelect" v-model="baTable.form.items!.admin_id" prop="admin_id" :input-attr="{ pk: 'ba_admin.id', field: 'username', 'remote-url': '/admin/auth.Admin/index' }" :placeholder="t('Please select field', { field: t('test.admin_id') })" />
                    <FormItem :label="t('test.city')" type="city" v-model="baTable.form.items!.city" prop="city" :placeholder="t('Please select field', { field: t('test.city') })" />
                    <FormItem :label="t('test.column1')" type="string" v-model="baTable.form.items!.column1" prop="column1" :placeholder="t('Please input field', { field: t('test.column1') })" />
                    <FormItem :label="t('test.column2')" type="string" v-model="baTable.form.items!.column2" prop="column2" :placeholder="t('Please input field', { field: t('test.column2') })" />
                    <FormItem :label="t('test.image')" type="image" v-model="baTable.form.items!.image" prop="image" />
                    <FormItem :label="t('test.datetime')" type="datetime" v-model="baTable.form.items!.datetime" prop="datetime" :placeholder="t('Please select field', { field: t('test.datetime') })" />
                    <FormItem :label="t('test.string')" type="string" v-model="baTable.form.items!.string" prop="string" :placeholder="t('Please input field', { field: t('test.string') })" />
                </el-form>
            </div>
        </el-scrollbar>
        <template #footer>
            <div :style="'width: calc(100% - ' + baTable.form.labelWidth! / 1.8 + 'px)'">
                <el-button @click="baTable.toggleForm()">{{ t('Cancel') }}</el-button>
                <el-button v-blur :loading="baTable.form.submitLoading" @click="baTable.onSubmit(formRef)" type="primary">
                    {{ baTable.form.operateIds && baTable.form.operateIds.length > 1 ? t('Save and edit next item') : t('Save') }}
                </el-button>
            </div>
        </template>
    </el-dialog>
</template>

<script setup lang="ts">
import { reactive, ref, inject } from 'vue'
import { useI18n } from 'vue-i18n'
import type baTableClass from '/@/utils/baTable'
import FormItem from '/@/components/formItem/index.vue'
import type { FormInstance, FormItemRule } from 'element-plus'
import { buildValidatorData } from '/@/utils/validate'

const formRef = ref<FormInstance>()
const baTable = inject('baTable') as baTableClass

const { t } = useI18n()

const rules: Partial<Record<string, FormItemRule[]>> = reactive({
    create_time: [buildValidatorData({ name: 'date', title: t('test.create_time') })],
    datetime: [buildValidatorData({ name: 'date', title: t('test.datetime') })],
})
</script>

<style scoped lang="scss"></style>
