// import http from 'src/plugins/axios'
export const CepService = {
  // usado para a lista de registros
  procura (cep) {
    return fetch(`https://viacep.com.br/ws/${cep}/json/`, {
      method: 'get'
    }).then(response => response.json())
      .then(result => result)
      .catch(err => {
        console.error('Failed retrieving information', err)
      })
  }
}

export default CepService
