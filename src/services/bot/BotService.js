import Service from 'src/services/Service'
class BotService extends Service {
  static sugereDestino (assunto) {
    return this.get('bot/protocoloentrada/destino', {
      params: {
        assunto
      }
    })
  }
}
export default BotService
