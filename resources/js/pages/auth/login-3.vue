<script setup>
import { useForm } from '@inertiajs/vue3'

const isLoading = ref(false)

const token = useUserToken()

const form = useForm({
    email: '',
    password: '',
})

const handleLogin = async () => {
    form.post(route('login'), {
        onStart() {
            isLoading.value = true
        },
        onSuccess() {
            token.value = 'logged-in'

            route.visit(route('home'))
        },
        onError(errors) {
            console.log(errors)
        },
        onFinish() {
            isLoading.value = false
        },
    })

}

useHead({
    title: 'Auth Login 3 - Vuero',
})
</script>

<template>
    <div class="auth-wrapper-inner is-single">
        <LandingGrids class="is-contrasted" />
        <!--Fake navigation-->
        <div class="auth-nav">
            <div class="left" />
            <div class="center">
                <RouterLink to="/" class="header-item">
                    <AnimatedLogo width="38px" height="38px" />
                </RouterLink>
            </div>
            <div class="right">
                <VDarkmodeToggle />
            </div>
        </div>

        <!--Single Centered Form-->
        <div class="single-form-wrap is-relative">
            <div class="inner-wrap">
                <!--Form Title-->
                <div class="auth-head">
                    <h2>Bem-vindo</h2>
                </div>

                <!--Form-->
                <div class="form-card">
                    <form method="post" novalidate @submit.prevent="handleLogin">
                        <div class="login-form">
                            <VField>
                                <VControl icon="lucide:user">
                                    <VInput type="email" placeholder="Email" autocomplete="username" v-model="form.email" />
                                </VControl>
                            </VField>
                            <VField>
                                <VControl icon="lucide:lock">
                                    <VInput type="password" placeholder="Senha" autocomplete="current-password" v-model="form.password" />
                                </VControl>
                            </VField>

                            <!-- Switch -->
                            <VField>
                                <VControl class="setting-item">
                                    <VCheckbox label="Lembrar-me" color="primary" paddingless />
                                </VControl>
                            </VField>

                            <!-- Submit -->
                            <div class="login">
                                <VButton :loading="isLoading" type="submit" color="primary" bold fullwidth raised>
                                    Entrar
                                </VButton>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="forgot-link has-text-centered">
                    <a>Esqueceu a senha?</a>
                </div>
            </div>
        </div>
    </div>
</template>
