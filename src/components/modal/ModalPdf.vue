<template>
  <q-dialog
    @hide="escondeModal"
    v-model="dialog"
    maximized
    persistent
    transition-show="slide-up"
    transition-hide="slide-down"
  >
    <q-layout view="Lhh lpR fff" container class="bg-white">
      <q-header class="bg-primary">
        <q-toolbar>
          <q-toolbar-title>{{tituloRelatorio}}</q-toolbar-title>
          <q-btn flat v-close-popup round dense icon="close" />
        </q-toolbar>
      </q-header>

      <q-page-container>
        <q-page :style-fn="myTweak">
            <!-- <object :data="link" type="application/pdf" class="fit">
              <embed :src="link" type="application/pdf" class="fit"/>
            </object> -->
            <div class="iframe-container">
              <iframe :src="linkPdf" type="application/pdf" frameborder="0" allowfullscreen class="fit"></iframe>
              <!-- <iframe src="//www.youtube.com/embed/KMYrIi_Mt8A" allowfullscreen></iframe> -->
            </div>
        </q-page>
      </q-page-container>
    </q-layout>
  </q-dialog>
</template>

<script>
export default {
  name: 'ModalPdf',
  components: {
  },
  props: [
    'showModal',
    'link',
    'tituloRelatorio'
  ],
  data () {
    return {
      api: process.env.API,
      urlPdfViewer: '/pdfjs/web/viewer.html?file=',
      dialog: this.showModal,
      maximizedToggle: true
    }
  },
  computed: {
    linkPdf () {
      // return this.api + this.urlPdfViewer + this.link
      return this.link
    }
  },
  methods: {
    escondeModal () {
      this.$emit('hide')
    },
    myTweak (offset) {
      // "offset" is a Number (pixels) that refers to the total
      // height of header + footer that occupies on screen,
      // based on the QLayout "view" prop configuration

      // this is actually what the default style-fn does in Quasar
      return { minHeight: offset ? `calc(100vh - ${offset}px)` : '100vh' }
    }
  },
  watch: {
    showModal: function (modal) {
      this.dialog = modal
    }
  }
}
</script>
<style scoped>
.iframe-container {
  overflow: hidden;
  padding-top: 56.25%;
}

.iframe-container iframe {
  border: 0;
  height: 100%;
  left: 0;
  position: absolute;
  top: 0;
  width: 100%;
}

/* 4x3 Aspect Ratio */
.iframe-container-4x3 {
  padding-top: 75%;
}
</style>
