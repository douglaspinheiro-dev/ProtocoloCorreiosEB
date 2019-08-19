<template>
  <q-layout>
    <q-page-container>
      <q-page>
        <!-- page content -->
        <q-toolbar >
          <q-toolbar-title class="text-center">
            <img :src="imageSrc" alt="">
            <span slot="subtitle">
              <div class="q-headline">
                SISPROT - SISTEMA DE PROTOCOLO DA 1ª REGIÃO MILITAR
              </div>
            </span>
          </q-toolbar-title>
        </q-toolbar>
        <consulta-correspondencia></consulta-correspondencia>
      </q-page>
    </q-page-container>
    <q-layout-footer>
      <q-toolbar >
        <q-toolbar-title class="text-center">
          Copyright &copy; 2019 - Exército Brasileiro - 1ª Região Militar.
          <span slot="subtitle">
            <div class="q-subheading">
              Desenvolvido por ST Moreira
            </div>
          </span>
        </q-toolbar-title>
      </q-toolbar>
    </q-layout-footer>
  </q-layout>

</template>

<script>
// import {
//   required,
//   sameAs,
//   minLength
// } from 'vuelidate/lib/validators'
import consultaCorrespondencia from './BuscaPublicaCorrespondencia'
export default {
  name: 'ConsultaCorrespondencia',
  components: {
    consultaCorrespondencia
  },
  data () {
    return {
      imageSrc: 'statics/logo.png',
      loadingVisible: false
    }
  },
  validations: {
  },
  methods: {
  },
  computed: {
  }
}
</script>
<style scoped>
.input {
  margin-top: 20px;
}
</style>
