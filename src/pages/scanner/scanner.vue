<template>
  <div>
    <bodyTabs titulo="Cadastro de Scanners">
      <template slot="tabHeader">
        <q-tab default slot="title" name="tab-1" icon="folder_shared" label="Cadastro" />
      </template>
      <template slot="tabPanel">
        <q-tab-panel name="tab-1">
          <form @submit.prevent="salvarAlterar">
            <div class="row barraBotoes">
              <div class="col-md-6 linhaBotoes">
                <q-btn small type="reset" @click="reset" icon="add" >Novo</q-btn>
                <q-btn small type="reset" @click="capturaFoto" icon="add" >Capturar</q-btn>
                <q-btn small type="submit" icon="save" >Enviar</q-btn>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-6">
                <webcan
                  ref="camera"
                  autoplay
                  :selectFirstDevice="true"
                  :resolution="resolucao"
                  :deviceId="null"
                  playsinline
                />
              </div>
              <div class="col-6">
                <q-input class="form-input" label="Descrição" :error="$v.scanner.descricao.$error"
                  error-message="Obrigatório" hint="Obrigatório" autocomplete="off" type="text" v-model="scanner.descricao"
                  name="descricao" @input="$v.scanner.descricao.$touch()" />
              </div>
            </div>

          </form>
        </q-tab-panel>
      </template>
    </bodyTabs>
  </div>
</template>

<script>
import BodyTabs from 'src/components/body/BodyTabs'
import {
  required
} from 'vuelidate/lib/validators'
import Scanner from './scanner'
// import scannerService from './scannerService.js'
import { WebCam } from 'vue-web-cam'

export default {
  name: 'Scanner',
  components: {
    BodyTabs,
    webcan: WebCam
  },
  data () {
    return {
      scanner: new Scanner(),
      optionsLoading: false,
      timer: '',
      resolucao: {
        width: 595,
        height: 842
      }
    }
  },
  validations: {
    scanner: {
      descricao: {
        required
      }
    }
  },
  methods: {
    capturaFoto () {
      this.scanner.foto = this.$refs.camera.capture()
      this.$refs.camera.pause()
    },

    reset () {
      this.$v.scanner.$reset()
      this.scanner = new Scanner()
      this.$refs.camera.resume()
    },
    salvarAlterar () {
      this.$v.scanner.$touch()
      // if (this.$v.scanner.$invalid) return tools.Dialogs.formInvalido()
      // tools.Loadings.processando()

      clearTimeout(this.timer)
      this.timer = setTimeout(() => {
        const dados = {
          scanner: Scanner.setTypes(this.scanner)
        }
        // preparando a imagem
        if (this.myCroppa.hasImage()) {
          dados.scanner.imagemCodificada = this.myCroppa.generateDataUrl('image/jpeg', 0.8)
        }

        // scannerService.grava(dados)
        //   .then(result => {
        //     console.log('scanner criado com sucesso')
        //     this.scanner.scanner = result.scanner
        //     this.$router.push({ name: 'alterarScanner', params: { id: result.scanner } })
        //     tools.Notify.positive('Scanner criado com sucesso.')
        //     this.$store.commit('listaDeRegistros/adicionaRegistroNaLista', this.scanner)
        //     this.confereAlterarExcluir()
        // })
      }, 2000)
    }
  }
}

</script>
