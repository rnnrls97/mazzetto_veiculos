<template>
    <VCard radius="large">
        <div class="columns is-multiline">
            <h2 class="title is-4 ">Lista de Setores Empresariais </h2>
            <div
                class="column is-12"
                style="display: flex; justify-content: flex-start"
            >
                <VButton
                    color="primary"
                    icon="fas fa-check"
                    elevated
                    @click="dialogNewBusinessSector= true"
                >
                    Adicionar Setor Empresarial
                </VButton>
            </div>
        </div>
        <table class="table is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th scope="col">ID</th>
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
                <tr v-for="businessSector in props.businessSectors">
                    <td>{{ businessSector.id }}</td>
                    <td>{{ businessSector.name }}</td>
                    <td class="is-end">
                        <div class="is-flex is-justify-content-flex-end">
                            <VIconButton
                                color="danger"
                                light
                                raised
                                circle
                                @click="deleteBusinessSectors(businessSector.id)"
                                icon="lucide:x"
                            />
                            <VIconButton
                                color="primary"
                                light
                                raised
                                circle
                                @click="editBusinessSector(businessSector.id)"
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
        :open="dialogNewBusinessSector"
        title="Novo Setor Empresarial"
        size="small"
        actions="center"
        cancel-label="Cancelar"
        @submit.prevent="saveBusinessSector"
        @close="dialogNewBusinessSector = false"
    >
        <template #content>
            <div class="fieldset">
                <div class="columns is-multiline">
                    <div class="column is-12">
                        <label>Nome Setor Empresarial</label>
                        <VField>
                            <VControl >
                                <VInput
                                    v-model="form.name"
                                    type="text"
                                    placeholder="Nome Setor Empresarial"
                                    autocomplete="businessSector-name"
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
        :open="modelEditBusinessSector.show"
        title="Editar Setor Empresarial"
        size="small"
        actions="center"
        cancel-label="Cancelar"
        @submit.prevent="saveEditionBusinessSector"
        @close="modelEditBusinessSector.show = false"
    >
        <template #content>
            <div class="fieldset">
                <div class="columns is-multiline">
                    <div class="column is-12">
                        <label>Nome Setor Empresarial</label>
                        <VField>
                            <VControl >
                                <VInput
                                    v-model="formEdit.name"
                                    type="text"
                                    placeholder="Nome Setor Empresarial"
                                    autocomplete="businessSector-name"
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
import { Notyf } from "notyf";

const props = defineProps({
    businessSectors: Array,
});

const notyf       = new Notyf();
const isUploading = ref(false)
const isLoading   = ref(false)

const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
// Estado do CSRF Token
// Configuração do servidor

const modelBusinessSector = reactive({
    show: false,
    id: null,
});

const modelEditBusinessSector = reactive({
    show: false,
    id: null,
});


const { y } = useWindowScroll();

const dialogNewBusinessSector = ref(false);
const loading = ref(false);

// Estado do CSRF Token
const csrfToken = ref('');

// Configuração do servidor

const form = useForm({
    name: "",
});

const formEdit = useForm({
    name: "",
});

const saveBusinessSector = () => {
    console.log(form.value);
    form.clearErrors();
    form.post(route("businessSectors.store"), {
        preserveScroll: true,
        onSuccess: () => {
            notyf.success("Setor adicionada com sucesso!");
            dialogNewBusinessSector.value = false;
            form.reset();
            router.reload({ only: ["businessSectors"] });
        },
        onFinish: () => {},
    });
};

const deleteBusinessSectors = (id) => {
    loading.value = true;
    form.delete(route("businessSectors.destroy", id), {
        preserveScroll: true,
        onSuccess: () => {
            notyf.success("Setor removida com sucesso!");
            router.reload({ only: ["businessSectors"] });
            modelBusinessSector.show = false;
        },
        onFinish: () => {
            loading.value = false;
        },
    });
};

const saveEditionBusinessSector = () => {
    loading.value = true;
    formEdit.clearErrors();
    formEdit.put(route("businessSectors.update", modelEditBusinessSector.id), {
        preserveScroll: true,
        onSuccess: () => {
            notyf.success("Setor editada com sucesso!");
            modelEditBusinessSector.show = false;
            router.reload({ only: ["businessSectors"] });
        },
        onFinish: () => {
            loading.value = false;
        },
    });
};

const editBusinessSector = (id) => {
    modelEditBusinessSector.show = true;
    formEdit.name = props.businessSectors.find((businessSector) => businessSector.id === id).name;
    modelEditBusinessSector.id = id;
};



</script>

