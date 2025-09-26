<script setup>
// Nenhuma lógica de busca de dados aqui!
</script>

<template>
  <v-app>
    <v-app-bar app color="primary" dark>
      <router-link to="/" style="text-decoration: none; color: inherit;">
        <v-toolbar-title class="font-weight-bold">
          ifware - Painel de Projetos
        </v-toolbar-title>
      </router-link>
      <v-spacer></v-spacer>
      <v-btn icon="mdi-account-circle"></v-btn>
    </v-app-bar>

    <v-main style="background-color: #f5f5f5;">
      <router-view></router-view>
    </v-main>
  </v-app>
</template>

<style>
/* Estilos globais podem vir aqui, se necessário */
</style>