import { Dialog } from 'quasar'

const Dialogs = {

  formInvalido: () => {
    Dialog.create({
      title: 'Atenção',
      message: 'Alguns campos precisam ser corrigidos.',
      buttons: [
        'OK'
      ]
    })
  },
  erroServidor: (erro) => {
    Dialog.create({
      title: 'Atenção',
      message: 'O servidor respondeu erro interno, contate o suporte e informe o erro:' + erro,
      buttons: [
        'Certo'
      ]
    })
  },
  atencao: (msg) => {
    Dialog.create({
      title: 'Atenção',
      message: msg,
      buttons: [
        'OK'
      ]
    })
  },
  confirmaExcluir: () =>
    Dialog.create({
      title: 'Tem certeza?',
      message: 'Ao confirmar esta operação, não poderá desfazer.',
      ok: 'Sim, excluir',
      cancel: 'Cancelar'
    })

}

export default Dialogs
