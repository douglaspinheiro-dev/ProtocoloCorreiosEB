<template>
  <q-layout
    ref="layout"
    view="lHr lpR lFr"
    class="full-height"

  >
    <!--<root-header />-->
    <menu-left></menu-left>
    <!--<menu-right v-if="mostraMenuRight"></menu-right>-->

    <q-page-container>
      <!-- page content -->
      <q-page>

        <router-view />
      </q-page>

    </q-page-container>
    <!-- <q-resize-observer @resize="onResize" /> -->
    <modal-pdf :link="storeModalPdf.link" :showModal="storeModalPdf.ativo" @hide="$store.commit('modalPdf/setAtivo', false)" :tituloRelatorio="storeModalPdf.titulo"></modal-pdf>

  </q-layout>
</template>

<script>
// import rootHeader from 'src/components/rootHeader'
import menuLeft from 'src/components/MenuLeft'
import { mapGetters } from 'vuex'
import ModalPdf from 'src/components/modal/ModalPdf'

export default {
  name: 'LayoutRoot',
  components: {
    // rootHeader,
    menuLeft,
    ModalPdf
  },
  data () {
    return {
      mostraBotaoMenuRight: true,
      timer: null,
      isConnected: false,
      socketMessage: '',
      modalRelatorio: false,
      linkRelatorio: '',
      tituloRelatorio: ''
    }
  },
  computed: {
    mostraMenuRight: {
      get () {
        return this.$store.state.menuRight.mostraMenuRight
      },
      set (val) {
        this.$store.commit('menuRight/setMostraMenuRight', val)
      }
    },
    ...mapGetters({
      getUserId: 'login/getUserId',
      storeModalPdf: 'modalPdf/getModalPdf'
    })
  },
  sockets: {
    connect () {
      // Fired when the socket connects.
      this.isConnected = true
    },

    disconnect () {
      this.isConnected = false
    },

    // Fired when the server sends something on the "messageChannel" channel.
    messageChannel (data) {
      // console.log(data)
    },
    relatorioGerado (data) {
      console.log(data)
      if (this.getUserId === data.usuarioLogado) {
        this.$q.dialog({
          title: `O relatório: ${data.tituloRelatorio} esta pronto!`,
          message: 'Deseja abrir agora? Enviamos uma cópia para o email informado.',
          ok: {
          },
          cancel: {
          },
          persistent: true
        }).onOk(() => {
          this.linkRelatorio = process.env.API + data.linkRelatorio
          this.tituloRelatorio = data.tituloRelatorio
          this.modalRelatorio = true
        })
      }
    }
  },
  methods: {
    pingServer () {
      // Send the "pingServer" event to the server.
      this.$socket.emit('pingServer', 'PING!')
    }
    // onResize (size) {
    //   clearTimeout(this.timer)
    //   this.timer = setTimeout(() => {
    //     if (size.width < 599) {
    //       this.$root.$emit('controlaMenuLeft', false)
    //     } else if (size.width >= 1439) {
    //       this.$root.$emit('controlaMenuLeft', true)
    //     }
    //   }, 1000)
    // }
  },
  created () {
    // this.$socket.emit('pingServer', 'PING!')
  }
}
</script>
<style>
/* styles globais
*/
.form-input {
  margin: 10px;
}
</style>
