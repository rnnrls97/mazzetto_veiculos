<template>
    <VCard radius="large">
        <h2 class="title is-4">Lista de Usuários</h2>
        <VButton
            color="primary"
            icon="fas fa-plus"
            elevated
            @click="dialogNewUser = true"
            class="mb-4"
        >
            Adicionar
        </VButton>
        <table class="table is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome Completo</th>
                    <th scope="col">Email</th>
                    <th scope="col" class="is-end">
                        <div
                            class="dark-inverted is-flex is-justify-content-flex-end"
                        >
                            Acoes
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in props.users">
                    <td>{{ user.id }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td class="is-end">
                        <div class="is-flex is-justify-content-flex-end">
                            <VIconButton
                                color="danger"
                                light
                                raised
                                circle
                                @click="deleteUser(user.id)"
                                icon="lucide:x"
                            />
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </VCard>

    <VModal
        is="form"
        :open="dialogNewUser"
        title="Cadastrar Usuário"
        size="small"
        actions="center"
        @submit.prevent="saveUser"
        @close="dialogNewUser = false"
    >
        <template #content>
            <div class="modal-form">
                <div class="field">
                    <label>Nome completo</label>
                    <div class="control">
                        <input
                            v-model="form.name"
                            type="text"
                            class="input"
                            placeholder="Nome Completo"
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
                    <label>Email *</label>
                    <div class="control">
                        <input
                            v-model="form.email"
                            type="text"
                            class="input"
                            placeholder="Email"
                        />
                        <p
                            class="help has-text-danger"
                            v-if="form.errors?.email"
                        >
                            {{ form.errors.email }}
                        </p>
                    </div>
                </div>
                <div class="field">
                    <label>Senha</label>
                    <div class="control">
                        <input
                            v-model="form.password"
                            type="text"
                            class="input"
                            placeholder="Senha"
                        />
                        <p
                            class="help has-text-danger"
                            v-if="form.errors?.password"
                        >
                            {{ form.errors.password }}
                        </p>
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
import { ref } from "vue";

const props = defineProps({
    users: Array,
});
const dialogNewUser = ref(false);
const form = useForm({
    name: "",
    email: "",
    password: "",
});

const saveUser = () => {
    form.clearErrors();

    form.post(route("users.store"), {
        preserveScroll: true,
        onSuccess: () => {
            dialogNewUser.value = false;
            form.reset();
            router.reload({ only: ["users"] });
        },
        onFinish: () => {},
    });
};

const deleteUser = (id) => {
    form.delete(route("users.destroy", id), {
        preserveScroll: true,
        onSuccess: () => {
            router.reload({ only: ["users"] });
        },
    });
};
</script>
