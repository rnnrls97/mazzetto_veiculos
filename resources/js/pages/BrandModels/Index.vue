<template>
    <VCard radius="large">
        <h2 class="title is-4">Lista de Modelos</h2>
        <VButton
            color="primary"
            icon="fas fa-plus"
            elevated
            @click="dialogNewBrandModel = true"
            class="mb-4"
        >
            Adicionar
        </VButton>
        <table class="table is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Modelo</th>
                    <th scope="col">Marca</th>
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
                <tr v-for="brandModel in props.brandModels" :key="brandModel.id">
                    <td>{{ brandModel.id }}</td>
                    <td>{{ brandModel.name }}</td>
                    <td>{{getBrandName(brandModel.brand_id)}}</td>
                    <td class="is-end">
                        <div class="is-flex is-justify-content-flex-end">
                            <VIconButton
                                color="danger"
                                light
                                raised
                                circle
                                @click="deleteBrandModels(brandModel.id)"
                                icon="lucide:x"
                            />
                            <VIconButton
                                color="primary"
                                light
                                raised
                                circle
                                @click="editBrandModel(brandModel)"
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
        :open="dialogNewBrandModel"
        title="Cadastrar Modelo"
        actions="center"
        @submit.prevent="saveBrandModels"
        @close="dialogNewBrandModel = false"
    >
        <template #content>
            <div class="modal-form">
                <div class="field">
                    <label>Nome Modelo</label>
                    <div class="control">
                        <input
                            v-model="form.name"
                            type="text"
                            class="input"
                            placeholder="Nome Modelo"
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
                    <label>Categoria ID</label>
                    <VControl>
                        <Multiselect
                            v-model="form.brand_id"
                            label="name"
                            value-prop="id"
                            :options="props.brands"
                            placeholder="Selecione a Marca"
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
        :open="modalEditBrandModels.show"
        title="Editar Modelo"
        actions="center"
        @submit.prevent="saveEditBrandModel"
        @close="modalEditBrandModels = false"
        >
        <template #content>
            <div class="modal-form">
                <div class="field">
                    <label>Nome Modelo</label>
                    <div class="control">
                        <input
                            v-model="formEdit.name"
                            type="text"
                            class="input"
                            placeholder="Nome Modelo"
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
                    <label>Categoria ID</label>
                    <VControl>
                        <Multiselect
                            v-model="formEdit.brand_id"
                            label="name"
                            value-prop="id"
                            :options="props.brands"
                            placeholder="Selecione a categoria"
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
    brandModels: Array,
    brands: Array,
});

const dialogNewBrandModel = ref(false);
const form = useForm({
    name: "",
    brand_id: "",
});

const formEdit = useForm({
    name: "",
    brand_id: "",
});

const modalEditBrandModels = reactive({
    show: false,
    id: null,
});

const getBrandName = (brandId) => {
    const brand = props.brands.find(b => b.id === brandId);
    return brand ? brand.name : 'Desconhecido';
};

const saveBrandModels = () => {
    console.log(form.value);
    
    form.clearErrors();
    form.post(route("brandModels.store"), {
        preserveScroll: true,
        onSuccess: () => {
            dialogNewBrandModel.value = false;
            form.reset();
            router.reload({ only: ["brandModels"] });
        },
        onFinish: () => {},
    });
};

const deleteBrandModels = (id) => {
    console.log(id);
    form.delete(route("brandModels.destroy", id), {
        preserveScroll: true,
        onSuccess: () => {
            router.reload({ only: ["brandModels"] });
        },
    });
};

const saveEditBrandModel = () => {
    formEdit.clearErrors();
    formEdit.put(route("brandModels.update", modalEditBrandModels.id), {
        preserveScroll: true,
        onSuccess: () => {
            modalEditBrandModels.show = false;
            formEdit.reset();
            router.reload({ only: ["brandModels"] });
        },
        onFinish: () => {},
    });
};

const editBrandModel = (BrandModel) => {
    console.log(BrandModel);
    
    modalEditBrandModels.show = true;
    modalEditBrandModels.id = BrandModel.id;
    formEdit.name = BrandModel.name;
    formEdit.brand_id = BrandModel.brand_id;
};
</script>
