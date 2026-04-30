<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { store } from '@/routes/login';
import { request } from '@/routes/password';

defineOptions({
    layout: {
        title: 'Bienvenido de nuevo',
        description:
            'Ingrese sus credenciales para acceder al sistema académico',
    },
});

defineProps<{
    status?: string;
    canResetPassword: boolean;
    canRegister: boolean;
}>();
</script>

<template>
    <Head title="Iniciar sesión" />

    <div
        v-if="status"
        class="mb-4 rounded-xl border border-emerald-300/70 bg-emerald-500/90 px-4 py-3 text-center text-sm font-medium text-white shadow-sm"
    >
        {{ status }}
    </div>

    <Form
        v-bind="store.form()"
        :reset-on-success="['password']"
        v-slot="{ errors, processing }"
        class="flex flex-col gap-6"
    >
        <div class="grid gap-5">
            <!-- Correo -->
            <div class="grid gap-2">
                <Label for="email" class="text-sm font-medium text-white">
                    Cédula o Correo electrónico
                </Label>

                <Input
                    id="email"
                    type="text"
                    name="email"
                    required
                    autofocus
                    :tabindex="1"
                    autocomplete="email"
                    placeholder="1712345678 o nombre@institucion.edu.ec"
                    class="h-11 rounded-xl border-white/25 bg-white/10 text-white placeholder:text-white/60 focus:border-cyan-300 focus:ring-2 focus:ring-cyan-300/30"
                />

                <InputError :message="errors.email" />
            </div>

            <!-- Contraseña -->
            <div class="grid gap-2">
                <div class="flex items-center justify-between">
                    <Label
                        for="password"
                        class="text-sm font-medium text-white"
                    >
                        Contraseña
                    </Label>

                    <TextLink
                        v-if="canResetPassword"
                        :href="request()"
                        class="text-sm font-medium text-white/80 transition hover:text-white"
                        :tabindex="5"
                    >
                        ¿Olvidó su contraseña?
                    </TextLink>
                </div>

                <PasswordInput
                    id="password"
                    name="password"
                    required
                    :tabindex="2"
                    autocomplete="current-password"
                    placeholder="Ingrese su contraseña"
                    class="h-11 rounded-xl border-white/25 bg-white/10 text-white placeholder:text-white/60 focus:border-cyan-300 focus:ring-2 focus:ring-cyan-300/30"
                />

                <InputError :message="errors.password" />
            </div>

            <!-- Recordarme -->
            <div class="flex items-center justify-between">
                <Label
                    for="remember"
                    class="flex items-center gap-3 text-sm text-white/80"
                >
                    <Checkbox id="remember" name="remember" :tabindex="3" />
                    <span>Recordarme</span>
                </Label>
            </div>

            <!-- Botón -->
            <Button
                type="submit"
                class="mt-2 h-11 w-full rounded-xl bg-gradient-to-r from-[#D6A842] via-[#D6A842] to-[#D6A842] text-white shadow-lg shadow-slate-900/30 transition hover:from-[#2B216B] hover:via-[#36308C] hover:to-[#4B48C2]"
                :tabindex="4"
                :disabled="processing"
                data-test="login-button"
            >
                <Spinner v-if="processing" class="mr-2" />
                {{ processing ? 'Ingresando...' : 'Iniciar sesión' }}
            </Button>
        </div>

        <!-- Si más adelante habilitas el registro -->
        <!--
        <div
            class="text-center text-sm text-white/70"
            v-if="canRegister"
        >
            ¿No tiene una cuenta?
            <TextLink :href="register()" :tabindex="6" class="font-medium text-white hover:underline">
                Regístrese
            </TextLink>
        </div>
        -->
    </Form>
</template>
