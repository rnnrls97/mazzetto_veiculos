<template>
    <VCard radius="large">
        <div class="columns is-multiline">
            <h2 class="title is-4 ">Lista de Categoria</h2>
            <div
                class="column is-12"
                style="display: flex; justify-content: flex-start"
            >
                <VButton
                    color="primary"
                    icon="fas fa-check"
                    elevated
                    @click="dialogNewCategory = true"
                >
                    Adicionar Categoria
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
                <tr v-for="category in props.categories" :key="category.id">
                    <td>{{ category.id }}</td>
                    <td>{{ category.name }}</td>
                    <td class="is-end">
                        <div class="is-flex is-justify-content-flex-end">
                            <VIconButton
                                color="danger"
                                light
                                raised
                                circle
                                @click="deleteCategory(category.id)"
                                icon="lucide:x"
                            />
                            <VIconButton
                                color="primary"
                                light
                                raised
                                circle
                                @click="editCategory(category)"
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
        :open="dialogNewCategory"
        title="Nova Categoria"
        size="small"
        actions="center"
        cancel-label="Cancelar"
        @submit.prevent="saveCategory"
        @close="dialogNewCategory = false"
    >
        <template #content>
            <!--Fieldset-->
            <div class="fieldset">
                <div class="columns is-multiline">
                    <!-- Nome do País -->
                    <div class="column is-12">
                        <label>Nome Categoria</label>
                        <VField>
                            <VControl >
                                <VInput
                                    v-model="form.name"
                                    type="text"
                                    placeholder="Nome Categoria"
                                    autocomplete="category-name"
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
        :open="modelEditCategory.show"
        title="Editar Categoria"
        size="small"
        actions="center"
        cancel-label="Cancelar"
        @submit.prevent="updateCategory"
        @close="modelEditCategory.show = false"
    >
        <template #content>
            <div class="fieldset">
                <div class="columns is-multiline">
                    <div class="column is-12">
                        <label>Nome Categoria</label>
                        <VField>
                            <VControl >
                                <VInput
                                    v-model="formEdit.name"
                                    type="text"
                                    placeholder="Nome Categoria"
                                    autocomplete="category-name"
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
    categories: Array,
});

const notyf       = new Notyf();
const isUploading = ref(false)
const isLoading   = ref(false)

const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
// Estado do CSRF Token
// Configuração do servidor

const modelCategory = reactive({
    show: false,
    id: null,
});

const modelEditCategory = reactive({
    show: false,
    id: null,
});


const { y } = useWindowScroll();

const dialogNewCategory = ref(false);
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

const saveCategory = () => {
    console.log(form.value);
    form.clearErrors();
    form.post(route("categories.store"), {
        preserveScroll: true,
        onSuccess: () => {
            notyf.success("Categoria adicionada com sucesso!");
            dialogNewCategory.value = false;
            form.reset();
            router.reload({ only: ["categories"] });
        },
        onFinish: () => {},
    });
};

const deleteCategory = (id) => {
    loading.value = true;
    form.delete(route("categories.destroy", id), {
        preserveScroll: true,
        onSuccess: () => {
            notyf.success("Categoria removida com sucesso!");
            router.reload({ only: ["categories"] });
            modelCategory.show = false;
        },
        onFinish: () => {
            loading.value = false;
        },
    });
};

const editCategory = (category) => {
    modelEditCategory.show = true;
    formEdit.id = category.id;
    formEdit.name = category.name;
};

const updateCategory = () => {
    loading.value = true;
    formEdit.clearErrors();
    formEdit.put(route("categories.update", formEdit.id), {
        preserveScroll: true,
        onSuccess: () => {
            notyf.success("Categoria atualizada com sucesso!");
            modelEditCategory.show = false;
            router.reload({ only: ["categories"] });
        },
        onFinish: () => {
            loading.value = false;
        },
    });
};


</script>

