<!-- EntradaSaidaEstoqueUsuario.vue -->
<template>
  <ChartComponent
    title="Entrada e Saída de Estoque por Usuário"
    :chartOptions="options"
    :series="series"
  />
</template>

<script>
import ChartComponent from './ChartComponent.vue';

export default {
  name: 'EntradaSaidaEstoqueUsuario',
  components: { ChartComponent },
  data() {
    return {
      series: [
        {
          name: 'Entrada',
          data: [30, 40, 45, 50, 49, 60, 70] // Dados exemplo
        },
        {
          name: 'Saída',
          data: [23, 12, 54, 61, 32, 56, 81] // Dados exemplo
        }
      ],
      options: {
        chart: {
          type: 'bar'
        },
        xaxis: {
          categories: ['Usuário 1', 'Usuário 2', 'Usuário 3', 'Usuário 4']
        }
      }
    };
  }
};
</script>
