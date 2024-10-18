<!-- EntradaSaidaEstoqueProduto.vue -->
<template>
  <ChartComponent
    title="Entrada e Saída de Estoque por Produto"
    :chartOptions="options"
    :series="series"
  />
</template>

<script>
import ChartComponent from './ChartComponent.vue';

export default {
  name: 'EntradaSaidaEstoqueProduto',
  components: { ChartComponent },
  data() {
    return {
      series: [
        {
          name: 'Entrada',
          data: [80, 60, 75, 90, 85]
        },
        {
          name: 'Saída',
          data: [50, 70, 45, 80, 65]
        }
      ],
      options: {
        chart: {
          type: 'bar'
        },
        xaxis: {
          categories: ['Produto A', 'Produto B', 'Produto C', 'Produto D', 'Produto E']
        }
      }
    };
  }
};
</script>
