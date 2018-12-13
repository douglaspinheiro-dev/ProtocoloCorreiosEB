import { Dialog, Loading } from 'quasar'
const MsgDialog = function (res, local) {
  Loading.hide()
  console.log('Erro', res)
  let message = ``
  if (res.data.status === 'validacao') { message = 'Alguns campos precisam ser corrigidos.' } else if (res.status === 401) { message = 'Dados de acesso inválidos, Login ou senha incorretos' } else if (res.status === 403) { message = 'Seu grupo de usuário não tem permissão para esta operação' }

  Dialog.create({
    title: 'Atenção',
    message: message,
    buttons: [
      'Certo'
    ]
  })
}
export default MsgDialog
