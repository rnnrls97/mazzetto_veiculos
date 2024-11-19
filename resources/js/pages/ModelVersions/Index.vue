<template>
    <VCard radius="large">
        <h2 class="title is-4">Lista de Versão Modelos</h2>
        <VButton
            color="primary"
            icon="fas fa-plus"
            elevated
            @click="dialogNewBrandModelVersion = true"
            class="mb-4"
        >
            Adicionar Vesão 
        </VButton>
        <table class="table is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Versão</th>
                    <th scope="col">Modelo</th>
                    <th scope="col" class="is-end">
                        <div
                            class="dark-inverted is-flex is-justify-content-flex-end mr-5"
                        >
                            Acoes
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="brandModelVersion in props.modelVersions" :key="brandModelVersion.id">
                    <td>{{ brandModelVersion.id }}</td>
                    <td>{{ brandModelVersion.name }}</td>
                    <td>{{getBrandModelName(brandModelVersion.brand_model_id)}}</td>
                    <td class="is-end">
                        <div class="is-flex is-justify-content-flex-end">
                            <VIconButton
                                color="danger"
                                light
                                raised
                                circle
                                @click="deleteBrandModelsVersion(brandModelVersion.id)"
                                icon="lucide:x"
                            />
                            <VIconButton
                                color="primary"
                                light
                                raised
                                circle
                                @click="editBrandModel(brandModelVersion)"
                                icon="lucide:pencil"
                            />
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </VCard>

    <VModal
        is="form"
        :open="dialogNewBrandModelVersion"
        title="Cadastrar Versão Modelo"
        actions="center"
        @submit.prevent="saveBrandModelsVersion"
        @close="dialogNewBrandModelVersion = false"
    >
        <template #content>
            <div class="modal-form">
                <div class="field">
                    <label>Nome Versão Modelo</label>
                    <div class="control">
                        <input
                            v-model="form.name"
                            type="text"
                            class="input"
                            placeholder="Nome versão"
                        />
                        <p
                            class="help has-text-danger"
                            v-if="form.errors?.name"
                        >
                            {{ form.errors.name }}
                        </p>
                    </div>
                </div>
                <div class="field">
                    <label>Modelo</label>
                    <VControl>
                        <Multiselect
                            v-model="form.brand_model_id"
                            label="name"
                            value-prop="id"
                            :options="props.brandModels"
                            placeholder="Selecione o Modelo"
                        />
                    </VControl>
                </div>
            </div>
        </template>
        <template #action>
            <VButton type="submit" color="primary" raised> Salvar </VButton>
        </template>
    </VModal>

    <VModal
        is="form"
        :open="modalEditBrandModelsVersion.show"
        title="Editar Versão Modelo"
        actions="center"
        @submit.prevent="saveEditBrandModelVersion"
        @close="modalEditBrandModelsVersion = false"
        >
        <template #content>
            <div class="modal-form">
                <div class="field">
                    <label>Nome Versão Modelo</label>
                    <div class="control">
                        <input
                            v-model="formEdit.name"
                            type="text"
                            class="input"
                            placeholder="Nome Versão"
                        />
                        <p
                            class="help has-text-danger"
                            v-if="form.errors?.name"
                        >
                            {{ form.errors.name }}
                        </p>
                    </div>
                </div>
                <div class="field">
                    <label>Modelo</label>
                    <VControl>
                        <Multiselect
                            v-model="formEdit.brand_model_id"
                            label="name"
                            value-prop="id"
                            :options="props.brandModels"
                            placeholder="Selecione o Modelo"
                        />
                    </VControl>
                </div>
            </div>
            </template>
            <template #action>
                <VButton type="submit" color="primary" raised> Salvar </VButton>
            </template>
        </VModal>
</template>

<script setup>
import VIcon from "@/components/base/VIcon.vue";
import { router, useForm } from "@inertiajs/vue3";
import { reactive, ref } from "vue";

const props = defineProps({
    modelVersions: Array,
    brandModels: Array,
});

const dialogNewBrandModelVersion = ref(false);
const form = useForm({
    name: "",
    brand_model_id: "",
});

const formEdit = useForm({
    name: "",
    brand_model_id: "",
});

const modalEditBrandModelsVersion = reactive({
    show: false,
    id: null,
});

const getBrandModelName = (brandId) => {
    const brandModel = props.brandModels.find((brandModel) => brandModel.id === brandId);
    return brandModel ? brandModel.name : "";
};

const saveBrandModelsVersion = () => {
    form.clearErrors();
    form.post(route("modelVersions.store"), {
        preserveScroll: true,
        onSuccess: () => {
            dialogNewBrandModelVersion.value = false;
            form.reset();
            router.reload({ only: ["modelVersions"] });
        },
        onFinish: () => {},
    });
};

const deleteBrandModelsVersion = (id) => {
    console.log(id);
    form.delete(route("modelVersions.destroy", id), {
        preserveScroll: true,
        onSuccess: () => {
            router.reload({ only: ["modelVersions"] });
        },
    });
};

const saveEditBrandModelVersion = () => {
    formEdit.clearErrors();
    formEdit.put(route("modelVersions.update", modalEditBrandModelsVersion.id), {
        preserveScroll: true,
        onSuccess: () => {
            modalEditBrandModelsVersion.show = false;
            formEdit.reset();
            router.reload({ only: ["modelVersions"] });
        },
        onFinish: () => {},
    });
};

const editBrandModel = (BrandModel) => {
    console.log(BrandModel);
    
    modalEditBrandModelsVersion.show = true;
    modalEditBrandModelsVersion.id = BrandModel.id;
    formEdit.name = BrandModel.name;
    formEdit.brand_model_id = BrandModel.brand_model_id;
};
</script>
