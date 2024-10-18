<template lang="pug">
<q-page padding>
    <EntradaSaidaEstoqueUsuario />
    <EntradaSaidaEstoqueProduto />
    <TopProdutosMaisEstoque />
    <TopProdutosMenosEstoque />
    </q-page>
</template>

<script>
import EntradaSaidaEstoqueUsuario from 'components/EntradaSaidaEstoqueUsuario.vue';
import EntradaSaidaEstoqueProduto from 'components/EntradaSaidaEstoqueProduto.vue';
import TopProdutosMaisEstoque from 'components/TopProdutosMaisEstoque.vue';
import TopProdutosMenosEstoque from 'components/TopProdutosMaisEstoque.vue';

export default {
  components: {
    EntradaSaidaEstoqueUsuario,
    EntradaSaidaEstoqueProduto,
    TopProdutosMaisEstoque,
    TopProdutosMenosEstoque
  }
};
</script>

