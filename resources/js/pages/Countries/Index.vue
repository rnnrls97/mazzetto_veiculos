<template>
    <VCard radius="large">
        <div class="columns is-multiline">
            <h2 class="title is-4">Lista de Países</h2>

            <div
                class="column is-12"
                style="display: flex; justify-content: flex-end"
            >
                <VButton
                    color="primary"
                    icon="fas fa-check"
                    elevated
                    @click="dialogNewCountry = true"
                >
                    Adicionar País
                </VButton>
            </div>
        </div>

        <table class="table is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Pais</th>
                    <th scope="col">Sigla</th>
                    <th scope="col">DDi</th>
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
                <tr v-for="country in props.countries">
                    <td>{{ country.id }}</td>
                    <td>{{ country.nome_pais }}</td>
                    <td>{{ country.sigla }}</td>
                    <td>{{ country.ddi }}</td>
                    <td
                        class="is-end"
                        @click="loadEditCountry(country)"
                        icon="lucide:x"
                    >
                        <div class="is-flex is-justify-content-flex-end">
                            <FlexTableDropdown />
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </VCard>
    <!-- ------------------------------------------------------------------------------------------- MODAL NOVO -->
    <VModal
        is="form"
        :open="dialogNewCountry"
        title="Novo País"
        size="small"
        actions="center"
        cancel-label="Cancelar"
        @submit.prevent="saveCountry"
        @close="form.clearErrors(), (dialogNewCountry = false)"
    >
        <template #content>
            <!--Fieldset-->
            <div class="fieldset">
                <div class="columns is-multiline">
                    <!-- Nome do País -->
                    <div class="column is-12">
                        <label>Nome País</label>
                        <VField>
                            <VControl icon="lucide:flag">
                                <VInput
                                    v-model="form.nome_pais"
                                    type="text"
                                    placeholder="Nome País"
                                    autocomplete="country-name"
                                    maxlength="255"
                                />
                                <p
                                    class="help has-text-danger"
                                    v-if="form.errors?.nome_pais"
                                >
                                    {{ form.errors.nome_pais }}
                                </p>
                            </VControl>
                        </VField>
                    </div>
                    <!-- Sigla & DDi -->
                    <!-- Sigla -->
                    <div class="column is-6">
                        <label>Sigla País</label>
                        <VField>
                            <VControl icon="lucide:chevron-right">
                                <VInput
                                    v-model="form.sigla"
                                    type="text"
                                    placeholder="Sigla"
                                    autocomplete="country-sigla"
                                    maxlength="4"
                                />
                                <p
                                    class="help has-text-danger"
                                    v-if="form.errors?.sigla"
                                >
                                    {{ form.errors.sigla }}
                                </p>
                            </VControl>
                        </VField>
                    </div>
                    <!-- DDi -->
                    <div class="column is-6">
                        <label>DDi</label>
                        <VField>
                            <VControl icon="lucide:plus">
                                <VInput
                                    v-model="form.ddi"
                                    type="number"
                                    placeholder="DDi"
                                    autocomplete="country-DDi"
                                    maxlength="4"
                                />
                                <p
                                    class="help has-text-danger"
                                    v-if="form.errors?.ddi"
                                >
                                    {{ form.errors.ddi }}
                                </p>
                            </VControl>
                        </VField>
                    </div>
                    <!-- SisComex & Código Speed -->
                    <!-- Sigla -->
                    <div class="column is-6">
                        <label>SisComex</label>
                        <VField>
                            <VControl icon="lucide:chevron-right">
                                <VInput
                                    v-model="form.sisComex"
                                    type="text"
                                    placeholder="SisComex"
                                    autocomplete="country-sisComex"
                                    maxlength="10"
                                />
                            </VControl>
                        </VField>
                    </div>
                    <!-- Código Speed -->
                    <div class="column is-6">
                        <label>Código Speed</label>
                        <VField>
                            <VControl icon="lucide:chevron-right">
                                <VInput
                                    v-model="form.cod_sped"
                                    type="text"
                                    placeholder="Código Speed"
                                    autocomplete="country-cod_sped"
                                    maxlength="10"
                                />
                            </VControl>
                        </VField>
                    </div>
                </div>

                <label>Bandeira do País</label>

                <div class="fieldset">
                    <VAvatar size="xl" class="profile-v-avatar">
                        <template #avatar>
                            <img
                                v-if="!isUploading"
                                class="avatar"
                                src="/images/avatars/svg/images.jpg"
                                alt=""
                                @error.once="onceError($event, 150)"
                            />
                            <VFilePond
                                v-model="form.img_bandeira"
                                v-else
                                class="profile-filepond"
                                name="profile_filepond"
                                :chunk-retry-delays="[500, 1000, 3000]"
                                label-idle="<i class='lnil lnil-cloud-upload'></i>"
                                :accepted-file-types="[
                                    'image/png',
                                    'image/jpeg',
                                    'image/gif',
                                ]"
                                :image-preview-height="140"
                                :image-resize-target-width="140"
                                :image-resize-target-height="140"
                                image-crop-aspect-ratio="1:1"
                                style-panel-layout="compact circle"
                                style-load-indicator-position="center bottom"
                                style-progress-indicator-position="right bottom"
                                style-button-remove-item-position="left bottom"
                                style-button-process-item-position="right bottom"
                                @addfile="onAddFile"
                                @removefile="onRemoveFile"
                            />
                            <VIconButton
                                v-if="!isUploading"
                                icon="lucide:edit-2"
                                class="edit-button is-edit"
                                circle
                                tabindex="0"
                                @keydown.enter.prevent="isUploading = true"
                                @click="isUploading = true"
                            />
                            <VIconButton
                                v-else
                                icon="lucide:arrow-left"
                                class="edit-button is-back"
                                circle
                                tabindex="0"
                                @keydown.enter.prevent="isUploading = false"
                                @click="isUploading = false"
                            />
                        </template>
                    </VAvatar>
                </div>
            </div>
        </template>
        <template #action>
            <VButton type="submit" color="primary" raised> Salvar </VButton>
        </template>
    </VModal>

    <!-- ------------------------------------------------------------------------------------------- MODAL EDITAR -->
    <VModal
        :open="modelEditCountry.show"
        cancel-label="Cancelar"
        actions="center"
        title="AlterarPaís"
        @close="modelEditCountry.show = false"
    >
        <template #content>
            <!--Fieldset-->
            <div class="fieldset">
                <div class="columns is-multiline">
                    <!-- Nome do País -->
                    <div class="column is-12">
                        <label>Nome País</label>
                        <VField>
                            <VControl icon="lucide:flag">
                                <VInput
                                    v-model="formEdit.nome_pais"
                                    type="text"
                                    placeholder="Nome País"
                                    autocomplete="country-name"
                                    maxlength="255"
                                />
                                <p
                                    class="help has-text-danger"
                                    v-if="formEdit.errors?.nome_pais"
                                >
                                    {{ formEdit.errors.nome_pais }}
                                </p>
                            </VControl>
                        </VField>
                    </div>
                    <!-- Sigla & DDi -->
                    <!-- Sigla -->
                    <div class="column is-6">
                        <label>Sigla País</label>
                        <VField>
                            <VControl icon="lucide:chevron-right">
                                <VInput
                                    v-model="formEdit.sigla"
                                    type="text"
                                    placeholder="Sigla"
                                    autocomplete="country-sigla"
                                    maxlength="4"
                                />
                                <p
                                    class="help has-text-danger"
                                    v-if="formEdit.errors?.sigla"
                                >
                                    {{ formEdit.errors.sigla }}
                                </p>
                            </VControl>
                        </VField>
                    </div>
                    <!-- DDi -->
                    <div class="column is-6">
                        <label>DDi</label>
                        <VField>
                            <VControl icon="lucide:plus">
                                <VInput
                                    v-model="formEdit.ddi"
                                    type="number"
                                    placeholder="DDi"
                                    autocomplete="country-DDi"
                                    maxlength="4"
                                />
                                <p
                                    class="help has-text-danger"
                                    v-if="formEdit.errors?.ddi"
                                >
                                    {{ formEdit.errors.ddi }}
                                </p>
                            </VControl>
                        </VField>
                    </div>
                    <!-- SisComex & Código Speed -->
                    <!-- Sigla -->
                    <div class="column is-6">
                        <label>SisComex</label>
                        <VField>
                            <VControl icon="lucide:chevron-right">
                                <VInput
                                    v-model="formEdit.sisComex"
                                    type="text"
                                    placeholder="SisComex"
                                    autocomplete="country-sisComex"
                                    maxlength="10"
                                />
                            </VControl>
                        </VField>
                    </div>
                    <!-- Código Speed -->
                    <div class="column is-6">
                        <label>Código Speed</label>
                        <VField>
                            <VControl icon="lucide:chevron-right">
                                <VInput
                                    v-model="formEdit.cod_sped"
                                    type="text"
                                    placeholder="Código Speed"
                                    autocomplete="country-cod_sped"
                                    maxlength="10"
                                />
                            </VControl>
                        </VField>
                    </div>
                </div>

                <label>Bandeira do País</label>

                <div class="fieldset">
                    <VAvatar size="xl" class="profile-v-avatar">
                        <template #avatar>
                            <img
                                v-if="!isUploading"
                                class="avatar"
                                :src="formEdit.img_bandeira"
                                alt=""
                                @error.once="onceError($event, 150)"
                            />
                            <VFilePond
                                v-model="formEdit.img_bandeira"
                                v-else
                                class="profile-filepond"
                                name="profile_filepond"
                                :chunk-retry-delays="[500, 1000, 3000]"
                                label-idle="<i class='lnil lnil-cloud-upload'></i>"
                                :accepted-file-types="[
                                    'image/png',
                                    'image/jpeg',
                                    'image/gif',
                                ]"
                                :image-preview-height="140"
                                :image-resize-target-width="140"
                                :image-resize-target-height="140"
                                image-crop-aspect-ratio="1:1"
                                style-panel-layout="compact circle"
                                style-load-indicator-position="center bottom"
                                style-progress-indicator-position="right bottom"
                                style-button-remove-item-position="left bottom"
                                style-button-process-item-position="right bottom"
                                @addfile="onAddFile"
                                @removefile="onRemoveFile"
                            />
                            <VIconButton
                                v-if="!isUploading"
                                icon="lucide:edit-2"
                                class="edit-button is-edit"
                                circle
                                tabindex="0"
                                @keydown.enter.prevent="isUploading = true"
                                @click="isUploading = true"
                            />
                            <VIconButton
                                v-else
                                icon="lucide:arrow-left"
                                class="edit-button is-back"
                                circle
                                tabindex="0"
                                @keydown.enter.prevent="isUploading = false"
                                @click="isUploading = false"
                            />
                        </template>
                    </VAvatar>
                </div>
            </div>
        </template>
        <template #action>
            <VButton
                type="submit"
                color="primary"
                raised
                @click="editCountry()"
            >
                Salvar
            </VButton>
        </template>
    </VModal>

    <!-- ------------------------------------------------------------------------------------------- MODAL DELETE -->
    <VModal
        :open="modelCountry.show"
        cancel-label="Cancelar"
        actions="center"
        @close="modelCountry.show = false"
    >
        <template #content>
            <VPlaceholderSection
                title="Cadastro de Países"
                subtitle="Deseja realmente excluir esse País? Esta ação não pode ser desfeita!"
            />
        </template>

        <template #action>
            <VButton
                color="danger"
                raised
                :loading="loading"
                @click="deleteCountry()"
            >
                Excluir
            </VButton>
        </template>
    </VModal>
</template>

<script setup>
import sleep from "@/utils/sleep";
import { router, useForm } from "@inertiajs/vue3";
import { reactive, ref } from "vue";
import { Notyf } from "notyf";

// Import Vue FilePond
import vueFilePond from "vue-filepond";

// Import FilePond styles
import "filepond/dist/filepond.min.css";

// Import image preview plugin styles
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";

// Import image preview and file type validation plugins
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import FilePondPluginFileValidateSize from "filepond-plugin-file-validate-size";


const props = defineProps({
    countries: Array,
});

const notyf       = new Notyf();
const isUploading = ref(false)
const isLoading   = ref(false)

const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
// Estado do CSRF Token
// Configuração do servidor

const modelCountry = reactive({
    show: false,
    id: null,
});

const modelEditCountry = reactive({
    show: false,
    id: null,
});

const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview,
    FilePondPluginFileValidateSize
);


const onAddFile = (error, fileInfo) => {
    console.log(fileInfo.file);
  if (error) {
    console.error(error)
    return
  }

  const _file = fileInfo.file
  if (_file) {
    formEdit.file = _file
  }
}

const onRemoveFile = (error, fileInfo) => {
  if (error) {
    console.error(error)
    return
  }

  formEdit.file = null
}

const { y } = useWindowScroll();

const dialogNewCountry = ref(false);
const loading = ref(false);
const { onceError } = useImageError();
const fileEdit = ref([]);

// Estado do CSRF Token
const csrfToken = ref('');

// Configuração do servidor

const form = useForm({
    nome_pais: "",
    sigla: "",
    ddi: "",
    sisComex: "",
    cod_sped: "",
    img_bandeira: "",
});

const formEdit = useForm({
    nome_pais: "",
    sigla: "",
    ddi: "",
    sisComex: "",
    cod_sped: "",
    img_bandeira: "",
    file: null
});

const saveCountry = () => {
    console.log(form.value);
    form.clearErrors();

    form.post(route("countries.store"), {
        preserveScroll: true,
        onSuccess: () => {
            notyf.success("País adicionado com sucesso!");
            dialogNewCountry.value = false;
            form.reset();
            router.reload({ only: ["countries"] });
        },
        onFinish: () => {},
    });
};

const editCountry = () => {
    router.post(route("countries.update", formEdit.id), {
        _method: 'put',
        preserveScroll: true,
        ...formEdit,
        onSuccess: () => {
            console.log('ANDRE SUCESSO');
            notyf.success("País atualizado com sucesso!");
            modelEditCountry.show = false; // Fecha o modal
            formEdit.reset(); // Reseta o formulário
            router.reload({ only: ["countries"] }); // Recarrega os dados de países
        },
        onFinish: () => {
            console.log('ANDRE1');
        },
    });
};


const deleteCountry = () => {
    loading.value = true;
    form.delete(route("countries.destroy", modelCountry.id), {
        preserveScroll: true,
        onSuccess: () => {
            notyf.success("País removido com sucesso!");
            router.reload({ only: ["countries"] });
            modelCountry.show = false;
        },
        onFinish: () => {
            loading.value = false;
        },
    });
};

const loadEditCountry = (countries) => {
    modelEditCountry.show = true;

    (formEdit.id = countries.id),
        (formEdit.nome_pais = countries.nome_pais),
        (formEdit.sigla = countries.sigla),
        (formEdit.ddi = countries.ddi),
        (formEdit.sisComex = countries.sisComex),
        (formEdit.cod_sped = countries.cod_sped),
        (formEdit.img_bandeira = countries.img_bandeira);
};


const serverConfig = {
  process: {
    url: '/images/avatars/svg',
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': csrfToken,
    },
    withCredentials: false,
    onload: (response) => {
      console.log('Arquivo enviado com sucesso', response);
    },
    onerror: (response) => {
      console.error('Erro ao enviar o arquivo', response);
    }
  },
  revert: '/revert',
};
</script>

