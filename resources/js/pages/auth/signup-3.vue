<script setup>
import { useForm } from '@inertiajs/vue3';

const router = useRouter()
const notyf = useNotyf()
const isLoading = ref(false)

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
})

const handleSignup = async () => {
    form.post(route('register.store'), {
        onStart() {
            isLoading.value = true
        },
        onSuccess() {
            //notyf.dismissAll()
            //notyf.success(`Welcome, ${form.name}!`)
            router.visit(route('home'))
        },
        onError(errors) {
            //notyf.dismissAll()
            //notyf.error('There was an error with your submission. Please check your form.')
            console.log(errors)
        },
        onFinish() {
            isLoading.value = false
        },
    })
}

useHead({
    title: 'Auth Signup 3 - Vuero',
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
                    <h2>Join Us Now.</h2>
                    <p>Start by creating your account</p>
                    <RouterLink to="/auth/login-3">
                        I already have an account
                    </RouterLink>
                </div>

                <!--Form-->
                <div class="form-card">
                    <form method="post" novalidate @submit.prevent="handleSignup">
                        <div class="login-form">
                            <!-- Input -->
                            <VField>
                                <VControl icon="lucide:user">
                                    <VInput type="text" placeholder="Name" autocomplete="name" v-model="form.name"/>
                                </VControl>
                            </VField>
                            <!-- Input -->
                            <VField>
                                <VControl icon="lucide:mail">
                                    <VInput type="text" placeholder="Email Address" autocomplete="email"  v-model="form.email" />
                                </VControl>
                            </VField>
                            <!-- Input -->
                            <VField>
                                <VControl icon="lucide:lock">
                                    <VInput type="password" placeholder="Password" autocomplete="new-password" v-model="form.password"/>
                                </VControl>
                            </VField>
                            <!-- Input -->
                            <VField>
                                <VControl icon="lucide:lock">
                                    <VInput type="password" placeholder="Repeat Password" v-model="form.password_confirmation" />
                                </VControl>
                            </VField>

                            <!-- Submit -->
                            <div class="login">
                                <VButton color="primary" type="submit" bold fullwidth raised>
                                    Sign Up
                                </VButton>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
