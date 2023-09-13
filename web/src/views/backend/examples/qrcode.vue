<template>
    <div class="default-main">
        <el-form class="form-box" label-width="50px" label-position="right" ref="formRef" :rules="rules" :model="ruleForm">
            <div class="qrcode">
                <img :src="data.url" alt="" />
            </div>
            <FormItem
                label="参数"
                type="string"
                v-model="ruleForm.data"
                prop="data"
                :input-attr="{ clearable: true }"
                placeholder="要存储的参数..."
            />
            <el-row>
                <el-col :span="12">
                    <FormItem label="大小" type="number" v-model="ruleForm.size" prop="size" :input-attr="{ clearable: true }" placeholder="大小" />
                </el-col>
                <el-col :span="12">
                    <FormItem
                        label="内边距"
                        label-width="80px"
                        type="number"
                        v-model="ruleForm.margin"
                        prop="margin"
                        :input-attr="{ clearable: true }"
                        placeholder="内边距"
                    />
                </el-col>
            </el-row>
            <el-row v-show="false">
                <el-col :span="12" >
                    <FormItem
                        label-width="80px"
                        label="显示logo"
                        type="radio"
                        v-model="ruleForm.show_logo"
                        prop="show_logo"
                        :data="{ content: { 0: '否', 1: '是' } }"
                    />
                </el-col>
                <el-col :span="12">
                    <FormItem
                        label="logo大小"
                        label-width="80px"
                        type="number"
                        v-model="ruleForm.logo_size"
                        prop="logo_size"
                        :input-attr="{ clearable: true }"
                        placeholder="内边距"
                    />
                </el-col>
            </el-row>
            <el-row v-show="false">
                <el-col :span="12" >
                    <FormItem
                        label-width="80px"
                        label="显示标签"
                        type="radio"
                        v-model="ruleForm.show_tag"
                        prop="show_tag"
                        :data="{ content: { 0: '否', 1: '是' } }"
                    />
                </el-col>
                <el-col :span="12">
                    <FormItem
                        label="标签大小"
                        label-width="80px"
                        type="number"
                        v-model="ruleForm.tag_size"
                        prop="tag_size"
                        :input-attr="{ clearable: true }"
                        placeholder="标签大小"
                    />
                </el-col>
            </el-row>
            <el-row>
                <el-col :span="12">
                    <FormItem label="标签" type="string" v-model="ruleForm.tag" prop="tag" :input-attr="{ clearable: true }" placeholder="标签内容" />
                </el-col>
                <el-col :span="12">
                    <FormItem
                        label="字体"
                        label-width="80px"
                        type="select"
                        v-model="ruleForm.font"
                        prop="font"
                        :input-attr="{ clearable: false }"
                        placeholder="字体"
                        :data="{ content: { '0': 'noto_sans.otf', '1': 'open_sans.ttf' } }"
                    />
                </el-col>
            </el-row>
            <el-row>
                <el-col :span="12">
                    <FormItem
                        label="容错级别"
                        label-width="80px"
                        type="select"
                        v-model="ruleForm.error_level"
                        prop="error_level"
                        :input-attr="{ clearable: false }"
                        placeholder="容错级别"
                        :data="{ content: { low: '低', medium: '中等', quartile: '高', high: '超高' } }"
                    />
                </el-col>
                <el-col :span="12">
                    <FormItem
                        label="对齐"
                        label-width="80px"
                        type="select"
                        v-model="ruleForm.alignment"
                        prop="alignment"
                        :input-attr="{ clearable: false }"
                        placeholder="标签对齐"
                        :data="{ content: { center: '居中', left: '左对齐', right: '右对齐' } }"
                    />
                </el-col>
            </el-row>
            <el-row>
                <el-col :span="6">
                    <FormItem
                        label-width="75px"
                        label="偏移-上"
                        type="number"
                        v-model="ruleForm.t"
                        :input-attr="{ clearable: false }"
                        placeholder="偏移量 上"
                    />
                </el-col>
                <el-col :span="6">
                    <FormItem
                        label-width="75px"
                        label="偏移-下"
                        type="number"
                        v-model="ruleForm.b"
                        :input-attr="{ clearable: false }"
                        placeholder="偏移量 下"
                    />
                </el-col>
                <el-col :span="6">
                    <FormItem
                        label-width="75px"
                        label="偏移-左"
                        type="number"
                        v-model="ruleForm.l"
                        :input-attr="{ clearable: false }"
                        placeholder="偏移量 左"
                    />
                </el-col>
                <el-col :span="6">
                    <FormItem
                        label-width="75px"
                        label="偏移-右"
                        type="number"
                        v-model="ruleForm.r"
                        :input-attr="{ clearable: false }"
                        placeholder="偏移量 右"
                    />
                </el-col>
            </el-row>
            <el-row>
                <el-col :span="11">
                    <FormItem
                        label="前景色"
                        label-width="75px"
                        type="string"
                        v-model="ruleForm.fore_color"
                        :input-attr="{ clearable: false }"
                        placeholder="前景色"
                    />
                </el-col>
                <el-col :span="1"><el-color-picker v-model="ruleForm.fore_color" show-alpha /></el-col>
                <el-col :span="11">
                    <FormItem
                        label="背景色"
                        label-width="75px"
                        type="string"
                        v-model="ruleForm.back_color"
                        :input-attr="{ clearable: false }"
                        placeholder="背景色"
                    />
                </el-col>
                <el-col :span="1"><el-color-picker v-model="ruleForm.back_color" show-alpha /></el-col>
            </el-row>
            <div class="sub-buttons">
                <el-button type="primary" :loading="ruleForm.loading" @click="onSubmit(formRef)">提交</el-button>
                <el-button @click="onResetForm(formRef)">重置</el-button>
            </div>
        </el-form>
    </div>
</template>

<script setup lang="ts">
import { reactive, ref } from 'vue'
import FormItem from '/@/components/formItem/index.vue'
import type { FormInstance, FormRules } from 'element-plus'
import { buildValidatorData } from '/@/utils/validate'
import { onResetForm } from '/@/utils/common'
import createAxios from '/@/utils/axios'

const formRef = ref<FormInstance>()

const ruleForm = reactive({
    loading: false,
    data: '',
    size: 200,
    margin: 10,
    show_logo: 0,
    logo_size: 50,
    show_tag: 0,
    tag_size: 16,
    tag: '',
    font: '0',
    alignment: 'center',
    error_level: 'quartile',
    t: 0,
    r: 10,
    b: 10,
    l: 10,
    fore_color: ref('rgba(0, 0, 0, 0)'),
    back_color: ref('rgba(255, 255, 255, 0)'),
})

let data = reactive({
    url: '',
})

const rules = reactive<FormRules>({
    data: [buildValidatorData({ name: 'required', message: '请输入参数...' })],
})

const onSubmit = (formEl: FormInstance | undefined) => {
    if (!formEl) return
    formEl.validate((valid) => {
        if (valid) {
            ruleForm.loading = true
            createAxios({
                url: '/admin/examples.QrCode/create',
                method: 'post',
                data: ruleForm,
            }).then((res) => {
                data.url = res.data.url
                ruleForm.loading = false
            }).catch(()=>{
                ruleForm.loading = false
            })
        }
    })
}
</script>

<style scoped lang="scss">
.qrcode {
    text-align: center;
    margin: 10px 0px;
}

.default-main {
    padding: 20px;
    border-radius: var(--el-border-radius-base);
    background-color: var(--ba-bg-color-overlay);
}
.form-box {
    width: 600px;
    margin: 0px auto;
}
.sub-buttons {
    display: flex;
    justify-content: center;
}
</style>
