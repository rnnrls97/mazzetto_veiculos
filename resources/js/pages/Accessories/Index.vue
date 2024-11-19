<template>
    <VCard radius="large">
        <div class="columns is-multiline">
            <h2 class="title is-4 ">Lista de Acessórios </h2>
            <div
                class="column is-12"
                style="display: flex; justify-content: flex-start"
            >
                <VButton
                    color="primary"
                    icon="fas fa-check"
                    elevated
                    @click="dialogNewAccessory= true"
                >
                    Adicionar Acessórios
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
                <tr v-for="accessory in props.accessories">
                    <td>{{ accessory.id }}</td>
                    <td>{{ accessory.name }}</td>
                    <td class="is-end">
                        <div class="is-flex is-justify-content-flex-end">
                            <VIconButton
                                color="danger"
                                light
                                raised
                                circle
                                @click="deleteAccessory(accessory.id)"
                                icon="lucide:x"
                            />
                            <VIconButton
                                color="primary"
                                light
                                raised
                                circle
                                @click="editAccessory(accessory)"
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
        :open="dialogNewAccessory"
        title="Novo Acessório"
        size="small"
        actions="center"
        cancel-label="Cancelar"
        @submit.prevent="saveAccessory"
        @close="dialogNewAccessory = false"
    >
        <template #content>
            <!--Fieldset-->
            <div class="fieldset">
                <div class="columns is-multiline">
                    <!-- Nome do País -->
                    <div class="column is-12">
                        <label>Nome Acessório</label>
                        <VField>
                            <VControl >
                                <VInput
                                    v-model="form.name"
                                    type="text"
                                    placeholder="Nome Acessório"
                                    autocomplete="accessory-name"
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
        :open="modelEditAccessory.show"
        title="Editar Acessório"
        size="small"
        actions="center"
        cancel-label="Cancelar"
        @submit.prevent="saveEditAccessory"
        @close="modelEditAccessory.show = false"
    >
        <template #content>
            <div class="fieldset">
                <div class="columns is-multiline">
                    <div class="column is-12">
                        <label>Nome Acessório</label>
                        <VField>
                            <VControl >
                                <VInput
                                    v-model="formEdit.name"
                                    type="text"
                                    placeholder="Nome Acessório"
                                    autocomplete="accessory-name"
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
    accessories: Array,
});

const notyf       = new Notyf();

const modelAccessory = reactive({
    show: false,
    id: null,
});

const modelEditAccessory = reactive({
    show: false,
    id: null,
});

const dialogNewAccessory = ref(false);
const loading = ref(false);

const form = useForm({
    name: "",
});

const formEdit = useForm({
    name: "",
});

const saveAccessory = () => {
    console.log(form.value);
    form.clearErrors();
    form.post(route("accessories.store"), {
        preserveScroll: true,
        onSuccess: () => {
            notyf.success("Acessório adicionada com sucesso!");
            dialogNewAccessory.value = false;
            form.reset();
            router.reload({ only: ["accessories"] });
        },
        onFinish: () => {},
    });
};

const deleteAccessory = (id) => {
    loading.value = true;
    form.delete(route("accessories.destroy", id), {
        preserveScroll: true,
        onSuccess: () => {
            notyf.success("Categoria removida com sucesso!");
            router.reload({ only: ["accessories"] });
            modelAccessory.show = false;
        },
        onFinish: () => {
            loading.value = false;
        },
    });
};

const saveEditAccessory = () => {
    formEdit.clearErrors();

    formEdit.put(route("accessories.update", modelEditAccessory.id), {
        preserveScroll: true,
        onSuccess: () => {
            modelEditAccessory.show = false;
            formEdit.reset();
            router.reload({ only: ["accessories"] });
        },
        onFinish: () => {},
    });
};

const editAccessory = (accessory) => {
    modelEditAccessory.show = true;
    modelEditAccessory.id = accessory.id;
    formEdit.name = accessory.name;
};
</script>

