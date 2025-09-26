<script setup>
import { ref, onMounted, computed } from 'vue';

// Estado para armazenar os dados e filtros
const projectsByClient = ref({});
const projectTypes = ref([]); // Para o combobox de filtro
const loading = ref(true);
const error = ref(null);

// Filtros reativos
const searchTerm = ref('');
const selectedProjectType = ref(null);

// Função para buscar os dados da nossa nova API
async function fetchProjects() {
  loading.value = true;
  error.value = null;
  try {
    // Constrói a URL com os filtros
    const params = new URLSearchParams();
    if (searchTerm.value) {
      params.append('search', searchTerm.value);
    }
    if (selectedProjectType.value) {
      params.append('tipoProjetoId', selectedProjectType.value);
    }

    const response = await fetch(`http://127.0.0.1:8000/api/v1/projects?${params.toString()}`);
    if (!response.ok) throw new Error('Falha ao buscar projetos.');

    projectsByClient.value = await response.json();
  } catch (e) {
    error.value = e.message;
  } finally {
    loading.value = false;
  }
}

// TODO: Criar um endpoint no backend para buscar os tipos de projeto
function fetchProjectTypes() {
    // Por enquanto, vamos mockar. No futuro, isso viria da API.
    projectTypes.value = [
        { id: 1, nomeTipoProjeto: 'Desenvolvimento' },
        { id: 2, nomeTipoProjeto: 'Suporte' }
    ];
}

// Busca os dados iniciais quando o componente é montado
onMounted(() => {
    fetchProjects();
    fetchProjectTypes();
});
</script>

<template>
  <v-container>
    <v-row class="mb-4">
      <v-col cols="12" md="8">
        <v-text-field
          v-model="searchTerm"
          label="Pesquisar por projeto ou cliente..."
          prepend-inner-icon="mdi-magnify"
          variant="outlined"
          density="compact"
          hide-details
          @input="fetchProjects"
        ></v-text-field>
      </v-col>
      <v-col cols="12" md="4">
        <v-select
          v-model="selectedProjectType"
          :items="projectTypes"
          item-title="nomeTipoProjeto"
          item-value="id"
          label="Filtrar por tipo"
          variant="outlined"
          density="compact"
          hide-details
          clearable
          @update:modelValue="fetchProjects"
        ></v-select>
      </v-col>
    </v-row>

    <div v-if="loading" class="text-center">
      <v-progress-circular indeterminate color="primary" size="64"></v-progress-circular>
    </div>
    <div v-else-if="error" class="text-center">
      <v-alert type="error" :text="error"></v-alert>
    </div>

    <div v-else>
        <div v-for="(projects, clientName) in projectsByClient" :key="clientName" class="client-group mb-8">
            <h2 class="text-h5 font-weight-bold mb-4 border-b-sm pb-2">{{ clientName }}</h2>
            <v-row>
                <v-col v-for="project in projects" :key="project.id" cols="12" sm="6" md="4">
                    <v-card hover>
                        <v-card-item>
                            <v-card-title>{{ project.nomeProjeto }}</v-card-title>
                            <v-card-subtitle>{{ project.project_type.nomeTipoProjeto }}</v-card-subtitle>
                        </v-card-item>
                        <v-card-text>
                            {{ project.descricaoProjeto || 'Este projeto não possui descrição.' }}
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="primary" variant="tonal">Ver Projeto</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
        </div>
         <div v-if="Object.keys(projectsByClient).length === 0" class="text-center text-grey">
            <p>Nenhum projeto encontrado com os filtros selecionados.</p>
        </div>
    </div>

  </v-container>
</template>

<style scoped>
.client-group {
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 24px;
    background-color: #fafafa;
}
</style>