import Service from 'src/services/Service'
class ToolsService extends Service {
  static listaQuantidades () {
    return this.get('tools/quantidades')
  }

  static listaConfiguracoes () {
    return this.get('tools/config')
  }
}
export default ToolsService
