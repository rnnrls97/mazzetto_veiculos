<template>
    <VCard radius="large">
        <div class="columns is-multiline">
            <h2 class="title is-4">Lista de Marcas</h2>
            <div
                class="column is-12"
                style="display: flex; justify-content: flex-start"
            >
                <VButton
                    color="primary"
                    icon="fas fa-check"
                    elevated
                    @click="dialogNewBrand = true"
                >
                    Adicionar Marcas
                </VButton>
            </div>
        </div>
        <table class="table is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Logo</th>
                    <th scope="col">Nome</th>
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
                <tr v-for="brand in props.brands" :key="brand.id">
                    <td>{{ brand.id }}</td>
                    <td><VAvatar :picture="brand.image_url" /></td>
                    <td>{{ brand.name }}</td>
                    <td class="is-end">
                        <div class="is-flex is-justify-content-flex-end">
                            <VIconButton
                                color="danger"
                                light
                                raised
                                circle
                                @click="deleteBrand(brand.id)"
                                icon="lucide:x"
                            />
                            <VIconButton
                                color="primary"
                                light
                                raised
                                circle
                                @click="editBrand(brand)"
                                icon="lucide:pencil"
                            />
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </VCard>
    <!-- ------------------------------------------------------------------------------------------- MODAL NOVO -->
    <VModal
        is="form"
        :open="dialogNewBrand"
        title="Nova Marca"
        size="small"
        actions="center"
        cancel-label="Cancelar"
        @submit.prevent="saveBrand"
        @close="dialogNewBrand = false"
    >
        <template #content>
            <div class="fieldset">
                <div class="columns is-multiline">
                    <div class="column is-12">
                        <label>Nome Marca</label>
                        <VField>
                            <VControl icon="lucide:flag">
                                <VInput
                                    v-model="form.name"
                                    type="text"
                                    placeholder="Nome Marca"
                                    autocomplete="brand-name"
                                    maxlength="255"
                                />
                                <p
                                    class="help has-text-danger"
                                    v-if="form.errors?.name"
                                >
                                    {{ form.errors.name }}
                                </p>
                            </VControl>
                        </VField>
                    </div>
                    <div class="column is-12">
                        <label>Imagem URL</label>
                        <VField>
                            <VControl icon="lucide:chevron-right">
                                <VInput
                                    v-model="form.image_url"
                                    type="text"
                                    class="input"
                                    placeholder="Imagem URL"
                                />
                                <p
                                    class="help has-text-danger"
                                    v-if="form.errors?.image_url"
                                >
                                    {{ form.errors.image_url }}
                                </p>
                            </VControl>
                        </VField>
                    </div>
                </div>
            </div>
        </template>
        <template #action>
            <VButton type="submit" color="primary" raised> Salvar </VButton>
        </template>
    </VModal>
    <!-- ------------------------------------------------------------------------------------------- MODAL EDITAR -->
    <VModal
        is="form"
        :open="modelEditBrand.show"
        title="Editar Marca"
        size="small"
        actions="center"
        cancel-label="Cancelar"
        @submit.prevent="saveEditBrand"
        @close="modelEditBrand.show = false"
    >
        <template #content>
            <div class="fieldset">
                <div class="columns is-multiline">
                    <div class="column is-12">
                        <label>Nome Marca</label>
                        <VField>
                            <VControl icon="lucide:flag">
                                <VInput
                                    v-model="formEdit.name"
                                    type="text"
                                    placeholder="Nome Marca"
                                    autocomplete="brand-name"
                                    maxlength="255"
                                />
                                <p
                                    class="help has-text-danger"
                                    v-if="formEdit.errors?.name"
                                >
                                    {{ formEdit.errors.name }}
                                </p>
                            </VControl>
                        </VField>
                    </div>
                    <div class="column is-12">
                        <VField>
                            <VControl class="align-center">
                                <VFilePond
                                    class="profile-filepond"
                                    name="profile_filepond"
                                    :chunk-retry-delays="[500, 1000, 3000]"
                                    label-idle="<i class='lnil lnil-cloud-upload'></i>"
                                    :accepted-file-types="['image/png', 'image/jpeg', 'image/gif', 'image/webp']"
                                    :image-preview-height="140"
                                    :image-resize-target-width="140"
                                    :image-resize-target-height="140"
                                    image-crop-aspect-ratio="1:1"
                                    style-panel-layout="compact circle"
                                    style-load-indicator-position="center bottom"
                                    style-progress-indicator-position="right bottom"
                                    style-button-remove-item-position="left bottom"
                                    style-button-process-item-position="right bottom"
                                    ref="filepondInput"
                                />
                            </VControl>
                        </VField>
                    </div>
                </div>
            </div>
        </template>
        <template #action>
            <VButton type="submit" color="primary" raised> Salvar </VButton>
        </template>
    </VModal>
    
</template>

<script setup>
import { router, useForm } from "@inertiajs/vue3";
import { reactive, ref } from "vue";
import { useNotyf } from "@/composables/notyf";

const props = defineProps({
    brands: Array,
});

const notyf = useNotyf();

const filepondInput = ref(null);

const modelBrand = reactive({
    show: false,
    id: null,
});

const modelEditBrand = reactive({
    show: false,
    id: null,
});


const { y } = useWindowScroll();

const dialogNewBrand = ref(false);
const loading = ref(false);

const form = useForm({
    name: "",
    logo: null,
    
});

const formEdit = useForm({
    name: "",
    logo: null,
   
});

const saveBrand = () => {
    console.log(form.value);
    form.clearErrors();
    form.post(route("brands.store"), {
        preserveScroll: true,
        onSuccess: () => {
            notyf?.success("Marca adicionada com sucesso!");
            dialogNewBrand.value = false;
            form.reset();
            router.reload({ only: ["brands"] });
        },
        onFinish: () => {},
    });
};

const deleteBrand = (id) => {
    loading.value = true;
    form.delete(route("brands.destroy", id), {
        preserveScroll: true,
        onSuccess: () => {
            notyf?.success("Marca removida com sucesso!");
            router.reload({ only: ["brands"] });
            modelBrand.show = false;
        },
        onFinish: () => {
            loading.value = false;
        },
    });
};

const saveEditBrand = () => {
    const file = filepondInput.value.pond.getFile()

    if(file){
        formEdit.logo = file.file
    }

    loading.value = true;
    formEdit.clearErrors();
    formEdit.put(route("brands.update", {brand: modelEditBrand.id}), {
        preserveScroll: true,
        onSuccess: () => {
            notyf?.success("Marca editada com sucesso!");
            modelEditBrand.show = false;
        },
        onFinish: () => {
            saveLogo();
            loading.value = false;
        },
    });
};

const saveLogo = () => {
    formEdit.post(route("brands.store-logo", { brand: modelEditBrand.id }), {
        preserveScroll: true,
        onSuccess: () => {
            notyf?.success("Logo adicionada com sucesso!");
        },
        onFinish: () => {
            router.reload({ only: ["brands"] });
        },
    });
}

const editBrand = (brand) => {
    modelEditBrand.show = true;
    formEdit.name = brand.name;
    formEdit.image_url = brand.image_url;
    modelEditBrand.id = brand.id;

};



</script>

<style scoped>
   .align-center {
        text-align: center !important;
    }
</style>