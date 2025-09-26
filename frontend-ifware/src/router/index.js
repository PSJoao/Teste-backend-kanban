import { createRouter, createWebHistory } from 'vue-router';
import ProjectList from '../components/ProjectList.vue';
import KanbanBoard from '../components/KanbanBoard.vue';

const routes = [
  {
    path: '/',
    name: 'ProjectList',
    component: ProjectList,
  },
  {
    path: '/projects/:projectId',
    name: 'KanbanBoard',
    component: KanbanBoard,
    props: true,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;