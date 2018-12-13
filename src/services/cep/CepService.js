import http from 'src/plugins/axios'
export const CepService = {
  // usado para a lista de registros
  procura (cep) {
    return http.get(`cep/${cep}`)
  }
}

export default CepService
