<script setup>
import { ref, onMounted, computed } from 'vue';

// O router nos passa o projectId como uma prop
const props = defineProps({
  projectId: {
    type: [String, Number],
    required: true,
  },
});

const project = ref(null);
const loading = ref(true);
const error = ref(null);

// Filtra as tarefas em colunas baseadas no status
const tasksToDo = computed(() => project.value?.tasks.filter(t => t.status === 'A Fazer') || []);
const tasksDoing = computed(() => project.value?.tasks.filter(t => t.status === 'Em Andamento') || []);
const tasksDone = computed(() => project.value?.tasks.filter(t => t.status === 'Concluído') || []);

onMounted(async () => {
  try {
    const response = await fetch(`http://127.0.0.1:8000/api/v1/projects/${props.projectId}`);
    if (!response.ok) throw new Error('Falha ao buscar os detalhes do projeto.');
    project.value = await response.json();
  } catch (e) {
    error.value = e.message;
  } finally {
    loading.value = false;
  }
});
</script>

<template>
  <v-container fluid>
    <div v-if="loading" class="text-center">
        <v-progress-circular indeterminate color="primary" size="64"></v-progress-circular>
    </div>
    <div v-else-if="error">
        <v-alert type="error" :text="error"></v-alert>
    </div>
    <div v-else-if="project">
        <div class="mb-6">
            <h1 class="text-h4 font-weight-bold">{{ project.nomeProjeto }}</h1>
            <p class="text-subtitle-1 text-grey-darken-1">{{ project.client.nomeCliente }} - {{ project.project_type.nomeTipoProjeto }}</p>
        </div>

        <div class="kanban-board">
            <div class="kanban-column">
                <h3 class="text-h6 mb-4">A Fazer</h3>
                <div v-for="task in tasksToDo" :key="task.id" class="task-card">
                    <v-card>
                        <v-card-title>{{ task.tituloTask }}</v-card-title>
                        <v-card-subtitle>{{ task.assignedUsers.map(u => u.name).join(', ') }}</v-card-subtitle>
                    </v-card>
                </div>
            </div>

            <div class="kanban-column">
                <h3 class="text-h6 mb-4">Em Andamento</h3>
                 <div v-for="task in tasksDoing" :key="task.id" class="task-card">
                    <v-card>
                        <v-card-title>{{ task.tituloTask }}</v-card-title>
                        <v-card-subtitle>{{ task.assignedUsers.map(u => u.name).join(', ') }}</v-card-subtitle>
                    </v-card>
                </div>
            </div>

            <div class="kanban-column">
                <h3 class="text-h6 mb-4">Concluído</h3>
                 <div v-for="task in tasksDone" :key="task.id" class="task-card">
                    <v-card>
                        <v-card-title>{{ task.tituloTask }}</v-card-title>
                        <v-card-subtitle>{{ task.assignedUsers.map(u => u.name).join(', ') }}</v-card-subtitle>
                    </v-card>
                </div>
            </div>
        </div>
    </div>
  </v-container>
</template>

<style scoped>
.kanban-board {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 16px;
}

.kanban-column {
  background-color: #eceff1;
  border-radius: 8px;
  padding: 16px;
  min-height: 400px;
}

.task-card {
    margin-bottom: 16px;
}
</style>